<div class="">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="flex justify-between h-8">
                <div class="flex">
                    <div class="space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link href="{{ route('categories') }}" :active="request()->routeIs('categories')">
                            {{ __('navigationsection.category') }}
                        </x-nav-link>
                    </div>
                    <div class="space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link href="{{ route('practices') }}" :active="request()->routeIs('practices')">
                            {{ __('navigationsection.practice') }}
                        </x-nav-link>
                    </div>
                    <div class="space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link href="{{ route('upload') }}" :active="request()->routeIs('upload')">
                            {{ __('navigationsection.upload') }}
                        </x-nav-link>
                    </div>
                </div>

            </div>
        </div>
</div>