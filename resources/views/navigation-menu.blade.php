<nav x-data="{ open: false }" class="bg-gray-900 border-b border-gray-100 sticky top-0 z-10">
    <!-- Primary Navigation Menu -->
    <div class="">
        <div class="flex justify-between h-16 px-4">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('general/logo.png')}}" width="60px" />
                    </a>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex items-center">
                        <x-nav-link href="{{ route('categories') }}" :active="request()->is('categories*') ? 'active' : '' ">
                            {{ __('navigationsection.category') }}
                        </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex items-center">
                    <x-nav-link href="{{ route('practices') }}" :active="request()->is('practices*') ? 'active' : '' ">
                        {{ __('navigationsection.practice') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex items-center">
                    <x-nav-link href="{{ route('analytics-dashboard') }}" :active="request()->is('analytics-dashboard') ? 'active' : '' ">
                        {{ __('navigationsection.analytics') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Language -->
                <div class="ml-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                {{ __('navigationsection.language') }}
                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                            </span>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Language -->
                            <x-dropdown-link href="/language/en" :active="Session::get('locale') == 'en' && 'active' ">
                                {{ __('navigationsection.english') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="/language/jp" :active="Session::get('locale') == 'jp' && 'active' ">
                            {{ __('navigationsection.japanese') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="/language/nl" :active="Session::get('locale') == 'nl' && 'active' ">
                            {{ __('navigationsection.dutch') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())

                    <div class="ml-3 relative">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->currentTeam->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    @if(Auth::user()->is_admin)

                                        <!-- All Users -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('navigationsection.all_users') }}
                                        </div>
                                        <x-dropdown-link href="{{ route('users-all') }}" :active="request()->is('users-all') ? 'active' : '' ">
                                            {{ __('navigationsection.all_users') }}
                                        </x-dropdown-link>

                                        <div class="border-t border-gray-200"></div>

                                        <!-- All Teams -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('navigationsection.all_teams') }}
                                        </div>
                                        <x-dropdown-link href="{{ route('teams-all') }}" :active="request()->is('teams-all') ? 'active' : '' ">
                                            {{ __('navigationsection.all_teams') }}
                                        </x-dropdown-link>

                                    <div class="border-t border-gray-200"></div>

                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('navigationsection.manage_team') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')" >
                                        {{ __('navigationsection.team_settings') }}
                                    </x-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-dropdown-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')" >
                                            {{ __('navigationsection.create_new_team') }}
                                        </x-dropdown-link>
                                    @endcan
                                    @endif
                                    <div class="border-t border-gray-200"></div>

                                    <!-- Team Switcher -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('navigationsection.switch_teams') }}
                                    </div>

                                    @foreach (Auth::user()->allTeams() as $team)
                                        <x-switchable-team :team="$team" />
                                    @endforeach
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                    @endif


                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('navigationsection.manage_account') }}
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('navigationsection.profile') }}
                            </x-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('navigationsection.api_tokens') }}
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-200"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}"
                                         @click.prevent="$root.submit();">
                                    {{ __('navigationsection.log_out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('categories') }}" :active="request()->is('categories*') ? 'active' : '' ">
                {{ __('navigationsection.category') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('practices') }}" :active="request()->is('practices*') ? 'active' : '' ">
                {{ __('navigationsection.practice') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('analytics-dashboard') }}" ::active="request()->is('analytics-dashboard') ? 'active' : '' ">
                {{ __('navigationsection.analytics') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-white">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('navigationsection.profile') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('navigationsection.api_tokens') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}"
                                   @click.prevent="$root.submit();">
                        {{ __('navigationsection.log_out') }}
                    </x-responsive-nav-link>
                </form>
                <!-- Language -->
                <div class="border-t border-gray-200"></div>
                    <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('navigationsection.language') }}
                    </div>
                    <x-responsive-nav-link href="/language/en" :active="Session::get('locale') == 'en' && 'active' ">
                    {{ __('navigationsection.english') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="/language/jp" :active="Session::get('locale') == 'jp' && 'active' ">
                    {{ __('navigationsection.japanese') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="/language/nl" :active="Session::get('locale') == 'nl' && 'active' ">
                    {{ __('navigationsection.dutch') }}
                    </x-responsive-nav-link>
                @if(Auth::user()->is_admin)
                    <!-- All Users -->
                    <div class="border-t border-gray-200"></div>
                    <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('navigationsection.all_users') }}
                    </div>

                    <x-responsive-nav-link href="{{ route('users-all') }}" :active="request()->is('users-all') ? 'active' : '' ">
                        {{ __('navigationsection.all_users') }}
                    </x-responsive-nav-link>

                    <!-- All Teams -->
                    <div class="border-t border-gray-200"></div>
                    <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('navigationsection.all_teams') }}
                    </div>

                    <x-responsive-nav-link href="{{ route('teams-all') }}" :active="request()->is('teams-all') ? 'active' : '' ">
                        {{ __('navigationsection.all_teams') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    @if(Auth::user()->is_admin)
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('navigationsection.manage_team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                        {{ __('navigationsection.team_settings') }}
                    </x-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('navigationsection.create_new_team') }}
                        </x-responsive-nav-link>
                    @endcan

                    <div class="border-t border-gray-200"></div>
                    @endif
                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('navigationsection.switch_teams') }}
                    </div>

                    @foreach (Auth::user()->allTeams() as $team)
                        <x-switchable-team :team="$team" component="responsive-nav-link" />
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</nav>
