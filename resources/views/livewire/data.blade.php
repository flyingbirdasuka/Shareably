<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('datapage.title') }}
        </h2>
</x-slot>
<div class="m-6 flex justify-center items-center lg:justify-start">
  <i class="fa-regular fa-calendar-days mr-2"></i>
  <input type="text" name="daterange" value="01/01/2023 - 12/31/2023"/>
</div>
<div class="flex flex-col pb-4 mb-6">
  <!-- all  -->
  <h4 class="text-center mb-6 font-bold">{{ __('datapage.all') }}</h4>
  <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
    <!-- practice -->
    <div class="flex rounded-xl items-center p-4 shadow-lg">
      <div class="flex h-12 w-12 items-center justify-center rounded-full border border-blue-100 bg-blue-50">
        <i class="fa-regular fa-heart"></i>
      </div>

      <div class="ml-4">
        <p class="mt-2 text-sm text-gray-500">{{ __('datapage.most_fav_practice') }} </p>
        <h4 class="font-semibold">{{ $practice_most_favorited }}</h4>
        <p class="mt-2 text-sm text-gray-500">{{ $practice_most_favorited_count }} {{ __('datapage.times') }}</p>
      </div>
    </div>
    <!-- session -->
    <div class="flex rounded-xl items-center p-4 shadow-lg">
      <div class="flex h-12 w-12 items-center justify-center rounded-full border border-orange-100 bg-orange-50">
        <i class="fa-regular fa-user"></i>
      </div>

      <div class="ml-4">
        <p class="mt-2 text-sm text-gray-500">{{ __('datapage.most_fav_practice') }}</p>
        <h4 class="font-semibold">{{ $most_used_session_user}} <br>
        {{  $most_used_session_time  }} {{ __('datapage.minutes') }}</h4>
        <p class="mt-2 text-sm text-gray-500">{{ __('datapage.average') }}: {{ $average_settion_time}} {{ __('datapage.minutes') }}</p>
      </div>
    </div>
    <!-- page -->
    <div class="flex rounded-xl items-center p-4 shadow-lg">
      <div class="flex h-12 w-12 items-center justify-center rounded-full border border-red-100 bg-red-50">
        <i class="fa-regular fa-file-lines"></i>
      </div>

      <div class="ml-4">
        <p class="mt-2 text-sm text-gray-500">{{ __('datapage.most_viewed_page') }}</p>
        <h4 class="font-semibold">{{ $most_viewed_page }} </h4>
        <p class="mt-2 text-sm text-gray-500">{{ $most_viewd_page_count }} {{ __('datapage.times') }}</p>
      </div>
    </div>
    <!-- language -->
    <div class="flex rounded-xl items-center p-4 shadow-lg">
      <div class="flex h-12 w-12 items-center justify-center rounded-full border border-indigo-100 bg-indigo-50">
      <img src="{{ asset('general/language.png')}}" width="60px" />
      </div>

      <div class="ml-4">
      <p class="mt-2 text-sm text-gray-500">{{ __('datapage.most_used_language') }}</p>
        <h4 class="font-semibold">{{ $most_used_language }}</h4>
        <p class="mt-2 text-sm text-gray-500">{{ $most_used_language_count }} {{ __('datapage.times') }}</p>
      </div>
    </div>
  </div>
  <!-- this week -->
  <h4 class="text-center m-8 font-bold">{{ __('datapage.this_week') }}</h4>
  <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
    <!-- practice -->
    <div class="flex items-center  rounded-xl p-4 shadow-lg">
      <div class="flex h-12 w-12 items-center justify-center rounded-full border border-blue-100 bg-blue-50">
        <i class="fa-regular fa-heart"></i>
      </div>

      <div class="ml-4">
      <p class="mt-2 text-sm text-gray-500">{{ __('datapage.most_fav_practice') }}</p>
        <h4 class="font-semibold">{{  $practice_most_favorited_this_week }}</h4>
        <p class="mt-2 text-sm text-gray-500">{{ $practice_most_favorited_this_week_count }} {{ __('datapage.times') }}</p>
      </div>
    </div>
    <!-- session -->
    <div class="flex items-center rounded-xl p-4 shadow-lg">
      <div class="flex h-12 w-12 items-center justify-center rounded-full border border-orange-100 bg-orange-50">
        <i class="fa-regular fa-user"></i>
      </div>
      <div class="ml-4">
        <p class="mt-2 text-sm text-gray-500">{{ __('datapage.most_used_user') }}</p>
        <h4 class="font-semibold">{{ $most_used_session_user_this_week}} <br>
        {{ $most_used_session_time_this_week}} {{ __('datapage.minutes') }}</h4>
        <p class="mt-2 text-sm text-gray-500">{{ __('datapage.average') }}: {{ $average_settion_time_this_week }} {{ __('datapage.minutes') }}</p>
      </div>
    </div>
    <!-- page -->
    <div class="flex items-center rounded-xl p-4 shadow-lg">
      <div class="flex h-12 w-12 items-center justify-center rounded-full border border-red-100 bg-red-50">
        <i class="fa-regular fa-file-lines"></i>
      </div>
      <div class="ml-4">
        <p class="mt-2 text-sm text-gray-500">{{ __('datapage.most_viewed_page') }}</p>
        <h4 class="font-semibold">{{ $most_viewed_page_this_week}}</h4>
        <p class="mt-2 text-sm text-gray-500">{{ $most_viewed_page_this_week_count}} {{ __('datapage.times') }}</p>
      </div>
    </div>
    <!-- language -->
    <div class="flex items-center rounded-xl p-4 shadow-lg">
      <div class="flex h-12 w-12 items-center justify-center rounded-full border border-indigo-100 bg-indigo-50">
      <img src="{{ asset('general/language.png')}}" width="60px" />
      </div>
      <div class="ml-4">
        <p class="mt-2 text-sm text-gray-500">{{ __('datapage.most_used_language') }}</p>
        <h4 class="font-semibold">{{ $most_used_language_this_week}}</h4>
        <p class="mt-2 text-sm text-gray-500">{{ $most_used_language_this_week_count}} {{ __('datapage.times') }}</p>
      </div>
    </div>
  </div>
  <!-- this month -->
  <h4 class="text-center m-8 font-bold">{{ __('datapage.this_month') }}</h4>
  <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
    <!-- practice -->
    <div class="flex items-center rounded-xl p-4 shadow-lg">
      <div class="flex h-12 w-12 items-center justify-center rounded-full border border-blue-100 bg-blue-50">
        <i class="fa-regular fa-heart"></i>
      </div>
      <div class="ml-4">
        <p class="mt-2 text-sm text-gray-500">{{ __('datapage.most_fav_practice') }}</p>
        <h4 class="font-semibold">{{ $practice_most_favorited_this_month }}</h4>
        <p class="mt-2 text-sm text-gray-500">{{  $practice_most_favorited_this_month_count }} {{ __('datapage.times') }}</p>
      </div>
    </div>
    <!-- session -->
    <div class="flex items-center rounded-xl p-4 shadow-lg">
      <div class="flex h-12 w-12 items-center justify-center rounded-full border border-orange-100 bg-orange-50">
        <i class="fa-regular fa-user"></i>
      </div>

      <div class="ml-4">
        <p class="mt-2 text-sm text-gray-500">{{ __('datapage.most_used_user') }}</p>
        <h4 class="font-semibold">{{ $most_used_session_user_this_month}}<br>
        {{ $most_used_session_time_this_month}} {{ __('datapage.minutes') }}</h4>
        <p class="mt-2 text-sm text-gray-500">{{ __('datapage.average') }}: {{ $average_settion_time_this_month }} {{ __('datapage.minutes') }}</p>
      </div>
    </div>
    <!-- page -->
    <div class="flex items-center rounded-xl p-4 shadow-lg">
      <div class="flex h-12 w-12 items-center justify-center rounded-full border border-red-100 bg-red-50">
        <i class="fa-regular fa-file-lines"></i>
      </div>

      <div class="ml-4">
        <p class="mt-2 text-sm text-gray-500">{{ __('datapage.most_viewed_page') }}</p>
        <h4 class="font-semibold">{{ $most_viewed_page_this_month}}</h4>
        <p class="mt-2 text-sm text-gray-500">{{ $most_viewed_page_this_month_count }} {{ __('datapage.times') }}</p>
      </div>
    </div>
    <!-- language -->
    <div class="flex items-center rounded-xl p-4 shadow-lg">
      <div class="flex h-12 w-12 items-center justify-center rounded-full border border-indigo-100 bg-indigo-50">
      <img src="{{ asset('general/language.png')}}" width="60px" />
      </div>

      <div class="ml-4">
        <p class="mt-2 text-sm text-gray-500">{{ __('datapage.most_used_language') }}</p>
        <h4 class="font-semibold">{{ $most_used_language_this_month}}</h4>
        <p class="mt-2 text-sm text-gray-500">{{ $most_used_language_this_month_count}} {{ __('datapage.times') }}</p>
      </div>
    </div>
  </div>
  <!-- range -->
  <div class="range_tiles">
    <h4 class="range_period text-center m-8 font-bold"></h4>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
      <!-- practice -->
      <div class="flex items-center rounded-xl p-4 shadow-lg">
        <div class="flex h-12 w-12 items-center justify-center rounded-full border border-blue-100 bg-blue-50">
          <i class="fa-regular fa-heart"></i>
        </div>

        <div class="ml-4">
          <p class="mt-2 text-sm text-gray-500">{{ __('datapage.most_fav_practice') }}</p>
          <h4 class="font-semibold"><p class="range_data"></p></h4>
          <p class="mt-2 text-sm text-gray-500"><span class="range_data"></span> {{ __('datapage.times') }}</p>
        </div>
      </div>
      <!-- session -->
      <div class="flex items-center rounded-xl p-4 shadow-lg">
        <div class="flex h-12 w-12 items-center justify-center rounded-full border border-orange-100 bg-orange-50">
          <i class="fa-regular fa-user"></i>
        </div>

        <div class="ml-4">
          <p class="mt-2 text-sm text-gray-500">{{ __('datapage.most_used_user') }}</p>
          <h4 class="font-semibold"><span class="range_data"></span><br>
          <span class="range_data"></span>  {{ __('datapage.minutes') }}</h4>
          <p class="mt-2 text-sm text-gray-500">{{ __('datapage.average') }}: <span class="range_data"></span>  {{ __('datapage.minutes') }}</p>
        </div>
      </div>
      <!-- page -->
      <div class="flex items-center rounded-xl p-4 shadow-lg">
        <div class="flex h-12 w-12 items-center justify-center rounded-full border border-red-100 bg-red-50">
          <i class="fa-regular fa-file-lines"></i>
        </div>
        <div class="ml-4">
          <p class="mt-2 text-sm text-gray-500">{{ __('datapage.most_viewed_page') }}</p>
          <h4 class="font-semibold"><span class="range_data"></span></h4>
          <p class="mt-2 text-sm text-gray-500"><span class="range_data"></span>  {{ __('datapage.times') }} </p>
        </div>
      </div>
      <!-- language -->
      <div class="flex items-center rounded-xl p-4 shadow-lg">
        <div class="flex h-12 w-12 items-center justify-center rounded-full border border-indigo-100 bg-indigo-50">
        <img src="{{ asset('general/language.png')}}" width="60px" />
        </div>
        <div class="ml-4">
          <p class="mt-2 text-sm text-gray-500">{{ __('datapage.most_used_language') }}</p>
          <h4 class="font-semibold"><span class="range_data"></span></h4>
          <p class="mt-2 text-sm text-gray-500"> <span class="range_data"></span> {{ __('datapage.times') }}</p>
        </div>
      </div>
    </div>
  </div>

</div>

<div class="hidden m-12 md:block lg:block">
  <canvas id="userChart" height="40px"></canvas>
  <canvas id="emailChart" height="40px"></canvas>
  <canvas id="categoryChart" height="40px"></canvas>
  <canvas id="practiceChart" height="40px"></canvas>
</div>



<!-- chart.js libraries -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<!-- date range picker libraries -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script type="text/javascript">
  const language = document.getElementsByTagName("html")[0].getAttribute("lang");
  let all_element = ['user', 'email', 'category', 'practice'],
    all_labels =[],
    charts_labels = [];

  if(language == 'nl'){
    all_labels = ['nieuwe gebruiker', 'email inschrijvingspercentage (%)', 'nieuwe categorie', 'nieuwe oefening'];
    charts_labels = ['alle', 'deze week','deze maand'];
  } else if (language == 'jp'){
    all_labels = ['新しいユーザー', 'メール　サブスクリプション率 (%)', '新しいカテゴリー', '新しいプラクティス'];
    charts_labels = ['全て', '今週', '今月'];
  } else {
    all_labels = ['new user', 'email subscription rate (%)', 'new category', 'new practice'];
    charts_labels = ['all', 'this week','this month'];
  }
  const all_data = [ @js($user_data), @js($email_data), @js($category_data),@js($practice_data)];


  var dataSet = [];

  all_element.forEach((element, index) => {
    dataSet[index] = makeChart(all_element[index], all_labels[index],all_data[index]);
  });

  // create the charts by using chart.js
  function makeChart($element, $label, $data){
    const ctx = document.getElementById(`${$element}Chart`);
    const chart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: charts_labels,
        datasets: [{
          label: $label,
          backgroundColor: '#6366F1',
          data: $data,
          borderWidth: 1
        }]
      }
    });
    return chart;
  }


  // date range picker
  $(function() {
    $('input[name="daterange"]').daterangepicker({
      opens: 'left'
    }, function(start, end, label) { // send the selected date range to livewire
      Livewire.emit('getDateRange', [start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD')]);
    });
  });

  // adding and updating the chart after selecting on the date picker
  window.addEventListener('chart-update', event => {
    for (let i=0; i< dataSet.length; i++){ // when it is already range data, refresh
      if(dataSet[i].data['labels'].length > 3 ){
        dataSet[i].data['labels'].pop();
        dataSet[i].data['datasets'][0].data.pop();
      }
      dataSet[i].data['labels'].push(event.detail[0]);
      dataSet[i].data['datasets'][0].data.push(event.detail[`${i+1}`]);
      dataSet[i].update();
      }

  });

  // adding and updating the tiles after selecting on the date picker
  window.addEventListener('tiles-update', event => {
    document.querySelectorAll('.range_data').forEach((element, index)=>{
      element.innerText = event.detail[index+1];
    });
    $('.range_tiles').css('display', 'block'); // show the tiles with the selected date range data
    $('.range_period').text(event.detail[0]);
  });

</script>