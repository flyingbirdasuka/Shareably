<?php

namespace App\Http\Livewire\Practice;


use Livewire\Component;
use App\Models\Practice;
use App\Models\Category;
use App\Models\MusicSheet;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewPractice;
use Google\Client;
use Google\Service\Drive;
use DB;

class PracticeUpload extends Component
{
    use WithFileUploads;

    public $title;
    public $description;
    public $video_id;
    public $video_type;
    public $file;
    public $music;
    public $all_categories = [];
    public $add_categories = [];
    public $showDropdown = false;


    public function mount()
    {
        $this->all_categories = Category::orderBy('title')->get();
    }

    /*
     *  Real time validation of the chosen file to be uploaded, users don't have to click submit.
     */
    public function updatedFile()
    {
        $this->validate([
            'file' => 'file|mimes:pdf|max:1024',
        ]);
    }

    /*
     *  Real time validation of the chosen music file to be uploaded, users don't have to click submit.
     */
    public function updatedMusic()
    {
        $this->validate([
            'music' => 'max:10000',
        ]);
    }

    public function add()
    {

        $this->validate([
                'title' => 'required|unique:practices',
                'add_categories' => 'required',
                'file' => 'required|mimes:pdf|max:1024',
            ],
            [
                'title.required' => 'The Title cannot be empty.',
                'file.required' => 'The file needs to be uploaded. Only PDFs smaller than 1mb can be uploaded.',
            ],
        );

        if($this->video_id != ''){
            $this->validate([
                'video_type' => 'required',
            ]);
        }
        $practice = Practice::create([
            'title' => $this->title,
            'description' => $this->description,
            'video_id' => $this->video_id,
            'video_type' => $this->video_type,
        ]);

        // PDF file
        $filename = $this->file->getClientOriginalName();
        $unique_name = uniqid().'-'.$filename;
        $practice->musicsheets()->create([
            'title' => $this->title,
            'filename' => $unique_name
        ]);

        $this->file->storeAs('/', $unique_name, $disk = 'practice');

        // music file
        if($this->music){
            $music_file = $this->music->getClientOriginalName();
            $music_unique_name = uniqid().'-'.$music_file;
            $practice->musics()->create([
                'title' => $this->title,
                'filename' => $music_unique_name
            ]);

            $this->music->storeAs('/', $music_unique_name, $disk = 'practice');
        }

        // to attach to the new practice upload notification email
        $url = url("/practices/{$practice->id}");

        $all_users = []; // get all the users which are subscribed to the attatched categories
        foreach ($this->add_categories as $category_id){

            $practice->categories()->attach($category_id); // practice_categories relationship
            $users = Category::find($category_id)->users()->get();

            $driveService = $this->googleSetup();
            foreach($users as $user){
                // if the user has email notification turned on, send an email
                (!$user->is_admin && $user->user_settings->email_subscription) && array_push($all_users,['id'=> $user->id, 'email'=> $user->email,'name' => $user->name]);

                // if the practice has a google drive video (video_type is 1)
                if($this->video_type == 1){
                    // then give the user a permission.

                    $permission = new Drive\Permission([ // Set up the new permission settings
                        'type' => 'user',
                        'role' => 'reader', // Choose the appropriate role (reader, writer, etc.)
                        'emailAddress' => $user->email,
                    ]);

                    // check if there's expiration date
                    $expirationDate =  DB::table('user_categories')->where('user_id', $user->id)->value('expiration_date');
                    if ($expirationDate) {
                        $permission->setExpirationTime($expirationDate);
                    }
                    try {
                        $driveService->permissions->create($this->video_id, $permission);
                        // Permission changed successfully
                        // dd('worked', $permission);
                    } catch (\Exception $e) {
                        // An error occurred
                        // dd('not worked', $permission, $e);
                    }
                }
            }
        }

        // to avoid sending multiple times to the same user (when user are subscribed to the multiple categories)
        $unique_users = array_map("unserialize",array_unique(array_map("serialize", $all_users)));
        foreach(array_unique($unique_users) as $user){
            $name = $user['name'];
            $unsubscribe = url("/email-setting/{$user['id']}");
            Mail::to($user['email'])->send(new NewPractice($practice, $url, $name, $unsubscribe));
        }
        return redirect()->to('/practices');
    }

    public function googleSetup(){
        // Set up the Google API client
        $client = new Client();
        $client->setAuthConfig(config_path('googleaccess.json'));
        $client->setAccessType('offline'); // This ensures we get a refresh token for long-term access
        $client->setApprovalPrompt('force');
        $client->setAccessToken($client->fetchAccessTokenWithRefreshToken(env('GOOGLE_DRIVE_REFRESH_TOKEN')));

        // If the access token has expired, refresh it
        if ($client->isAccessTokenExpired()) {
            $client->setAccessToken($client->fetchAccessTokenWithRefreshToken(env('GOOGLE_DRIVE_REFRESH_TOKEN')));
        }

        // Create the Drive service
        $driveService = new Drive($client);
        return $driveService;
    }

    public function render()
    {
        return view('livewire.practice.practice-upload');
    }
}