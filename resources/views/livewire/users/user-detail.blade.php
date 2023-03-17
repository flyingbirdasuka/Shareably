<div class="bg-gray-100">
    <div class="mx-auto my-5 p-5 lg:flex no-wrap md:-mx-2 ">
            <!-- Left Side -->
            <div class="w-full lg:w-3/12 md:mx-2">

                <div class="bg-white p-3 border-t-4 border-green-400">
                    <h1 class="text-gray-900 font-bold text-xl leading-8 my-1">{{ $user->name }}</h1>
                    <p class="text-sm text-gray-500 hover:text-gray-600 leading-6">{{__('userdetailpage.description')}}</p>
                    <ul
                        class="bg-gray-100 text-gray-600 hover:text-gray-700 hover:shadow py-2 px-3 mt-3 divide-y rounded shadow-sm">
                        <li class="flex items-center py-3">
                            <span>{{__('userdetailpage.status')}}</span>
                            <span class="ml-auto"><span
                                    class="bg-green-500 py-1 px-2 rounded text-white text-sm">{{__('userdetailpage.active')}}</span></span>
                        </li>
                        <li class="flex items-center py-3">
                            <span>{{__('userdetailpage.member_since')}}</span>
                            <span class="ml-auto">{{ date('d-m-Y', strtotime($user->created_at))}}</span>
                        </li>
                    </ul>
                </div>
                <div class="my-4"></div>

                <div class="bg-white p-3 hover:shadow">
                    <div class="flex items-center space-x-3 font-semibold text-gray-900 text-xl leading-8">
                        <span class="text-green-500">
                            <i class="fa-solid fa-people-group"></i>
                        </span>
                        <span>{{__('userdetailpage.teams')}}</span>
                    </div>
                    <ul
                        class="bg-gray-100 text-gray-600 hover:text-gray-700 hover:shadow py-2 px-3 mt-3 divide-y rounded shadow-sm">
                        @foreach($teams as $team)
                        <li class="flex items-center py-3">
                            <span><a href="/teams/{{$team->id}}/details">{{ $team->name }}</a></span>
                        </li>
                        @endforeach 
                    </ul>
                </div>
            </div>
            <!-- Right Side -->
            <div class="w-full lg:w-9/12 md:mx-2">
                <div class="bg-white p-3 shadow-sm rounded-sm">
                    <div class="flex items-center space-x-2 font-semibold text-gray-900 leading-8">
                        <i class="fa-regular fa-user"></i>
                        </span>
                        <span>{{__('userdetailpage.about')}}</span>
                    </div>
                    <div class="text-gray-700">
                        <div class="flex flex-col md:flex-row">
                            <div class="flex flex-row mx-4">
                                <div class="px-4 py-2 font-semibold">{{__('userdetailpage.name')}}</div>
                                <div class="px-4 py-2">{{ $user->name }}</div>
                            </div>
                            <div class="flex flex-row mx-4">
                                <div class="px-4 py-2 font-semibold">{{__('userdetailpage.email')}}</div>
                                <div class="px-4 py-2">
                                    <a class="text-blue-800" href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="my-4"></div>

                
                <div class="bg-white p-3 shadow-sm rounded-sm">

                    <div class="grid grid-cols-2">
                        <div>
                            <div class="flex flex-col items-baseline md:flex-row items-center space-x-2 font-semibold text-gray-900 leading-8 mb-3">
                                <div>
                                    <i class="fa-solid fa-folder"></i>
                                    <span class="tracking-wide">{{__('userdetailpage.category')}}</span>
                                </div>
                                <button wire:click="$emit('openModal', 'users.add-category', {{ json_encode(['user' => $user, 'categories' => $categories ]) }})" class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded items-center focus:outline-none transition ease-in-out duration-150">{{ __('categorypage.add_category') }}</button>
                            </div>
                            <ul class="list-inside space-y-2">
                                @foreach($categories as $category)
                                <li>
                                    <div class="text-teal-600"><a href="/categories/{{$category->id}}">{{ $category->title }}</a></div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div>
                            <div class="flex items-center space-x-2 font-semibold text-gray-900 leading-8 mb-3">
                                    <i class="fa-solid fa-heart"></i>
                                <span class="tracking-wide">{{__('userdetailpage.favorite')}}</span>
                            </div>
                            <ul class="list-inside space-y-2">
                                @foreach($practices as $practice)
                                <li>
                                    <div class="text-teal-600"><a href="/practices/{{$practice->id}}">{{ $practice->title}}</a></div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>