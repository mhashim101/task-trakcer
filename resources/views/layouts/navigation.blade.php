<nav x-data="{ open: false, openSections: {} }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
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
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-gray-800">
        <div class="pt-2 pb-3 space-y-1">
            <!-- Dashboard -->
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" class="text-white hover:bg-gray-700">
                <div class="flex items-center">
                    <x-icons.dashboard class="flex-shrink-0 h-5 w-5" />
                    <span class="ml-3">Dashboard</span>
                </div>
            </x-responsive-nav-link>

            @auth
                @if (auth()->user()->role_id == 1)
                    <!-- Admin Section -->
                    <div class="px-2">
                        <button @click="openSections.admin = !openSections.admin"
                            class="w-full flex items-center px-2 py-2 text-sm font-medium text-white hover:bg-gray-700 rounded-md">
                            <x-icons.admin class="flex-shrink-0 h-5 w-5" />
                            <span class="ml-3">Admin</span>
                            <svg class="ml-auto h-5 w-5 transform transition-transform" :class="{ 'rotate-180': openSections.admin }" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="openSections.admin" class="space-y-1 ml-4 pl-4">
                            <x-responsive-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')" class="text-gray-300 hover:bg-gray-700">
                                <span>Admin Dashboard</span>
                            </x-responsive-nav-link>
                            <x-responsive-nav-link href="{{ route('teams.index') }}" :active="request()->routeIs('teams.*')" class="text-gray-300 hover:bg-gray-700">
                                <span>Manage Teams</span>
                            </x-responsive-nav-link>
                            <x-responsive-nav-link href="{{ route('admin.member-analytics') }}" :active="request()->routeIs('admin.member-analytics')" class="text-gray-300 hover:bg-gray-700">
                                <span>Member Analytics</span>
                            </x-responsive-nav-link>

                            <!-- User Management -->
                            <button @click="openSections.users = !openSections.users"
                                class="w-full flex items-center px-2 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 rounded-md">
                                <x-icons.user class="flex-shrink-0 h-5 w-5" />
                                <span class="ml-3">User Management</span>
                                <svg class="ml-auto h-5 w-5 transform transition-transform" :class="{ 'rotate-180': openSections.users }" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div x-show="openSections.users" class="space-y-1 ml-4 pl-4">
                                <x-responsive-nav-link href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.users.index')" class="text-gray-300 hover:bg-gray-700">
                                    <span>All Users</span>
                                </x-responsive-nav-link>
                                <x-responsive-nav-link href="{{ route('admin.users.create') }}" :active="request()->routeIs('admin.users.create')" class="text-gray-300 hover:bg-gray-700">
                                    <span>Add New User</span>
                                </x-responsive-nav-link>
                            </div>
                        </div>
                    </div>
                @endif

                @if (auth()->user()->role_id == 2)
                    <!-- Team Lead Section -->
                    <div class="px-2">
                        <button @click="openSections.lead = !openSections.lead"
                            class="w-full flex items-center px-2 py-2 text-sm font-medium text-white hover:bg-gray-700 rounded-md">
                            <x-icons.lead class="flex-shrink-0 h-5 w-5" />
                            <span class="ml-3">Team Lead</span>
                            <svg class="ml-auto h-5 w-5 transform transition-transform" :class="{ 'rotate-180': openSections.lead }" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="openSections.lead" class="space-y-1 ml-4 pl-4">
                            <x-responsive-nav-link href="{{ route('team-lead.dashboard') }}" :active="request()->routeIs('team-lead.dashboard')" class="text-gray-300 hover:bg-gray-700">
                                <span>Team Dashboard</span>
                            </x-responsive-nav-link>
                            <x-responsive-nav-link href="{{ route('tasks.index') }}" :active="request()->routeIs('tasks.*')" class="text-gray-300 hover:bg-gray-700">
                                <span>Manage Tasks</span>
                            </x-responsive-nav-link>
                            <x-responsive-nav-link href="{{ route('team-lead.member-analytics') }}" :active="request()->routeIs('team-lead.member-analytics')" class="text-gray-300 hover:bg-gray-700">
                                <span>Team Analytics</span>
                            </x-responsive-nav-link>
                            <x-responsive-nav-link href="{{ route('attendance.team') }}" :active="request()->routeIs('attendance.team')" class="text-gray-300 hover:bg-gray-700">
                                <span>Team Attendance</span>
                            </x-responsive-nav-link>
                        </div>
                    </div>
                @endif

                <!-- Tasks -->
                @if (auth()->user()->role_id == 2)
                    <div class="px-2">
                        <button @click="openSections.tasks = !openSections.tasks"
                            class="w-full flex items-center px-2 py-2 text-sm font-medium text-white hover:bg-gray-700 rounded-md">
                            <x-icons.task class="flex-shrink-0 h-5 w-5" />
                            <span class="ml-3">Tasks</span>
                            <svg class="ml-auto h-5 w-5 transform transition-transform" :class="{ 'rotate-180': openSections.tasks }" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="openSections.tasks" class="space-y-1 ml-4 pl-4">
                            <x-responsive-nav-link href="{{ route('tasks.create') }}" :active="request()->routeIs('tasks.create')" class="text-gray-300 hover:bg-gray-700">
                                <span>Create Task</span>
                            </x-responsive-nav-link>
                            <x-responsive-nav-link href="{{ route('tasks.index') }}" :active="request()->routeIs('tasks.index')" class="text-gray-300 hover:bg-gray-700">
                                <span>My Tasks</span>
                            </x-responsive-nav-link>
                        </div>
                    </div>
                @endif

                <!-- Attendance -->
                <div class="px-2">
                    <button @click="openSections.attendance = !openSections.attendance"
                        class="w-full flex items-center px-2 py-2 text-sm font-medium text-white hover:bg-gray-700 rounded-md">
                        <x-icons.clock class="flex-shrink-0 h-5 w-5" />
                        <span class="ml-3">Attendance</span>
                        <svg class="ml-auto h-5 w-5 transform transition-transform" :class="{ 'rotate-180': openSections.attendance }" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="openSections.attendance" class="space-y-1 ml-4 pl-4">
                        @if(auth()->user()->role_id == 2 || auth()->user()->role_id == 3)
                            <x-responsive-nav-link href="{{ route('attendance.index') }}" :active="request()->routeIs('attendance.index')" class="text-gray-300 hover:bg-gray-700">
                                <span>My Attendance</span>
                            </x-responsive-nav-link>
                        @endif
                        @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                            <x-responsive-nav-link href="{{ route('attendance.team') }}" :active="request()->routeIs('attendance.team')" class="text-gray-300 hover:bg-gray-700">
                                <span>Team Attendance</span>
                            </x-responsive-nav-link>
                        @endif
                        @if(auth()->user()->role_id == 1)
                            <x-responsive-nav-link href="{{ route('attendance.settings') }}" :active="request()->routeIs('attendance.settings')" class="text-gray-300 hover:bg-gray-700">
                                <span>Settings</span>
                            </x-responsive-nav-link>
                        @endif
                    </div>
                </div>

                <!-- My Activity -->
                @if (auth()->user()->role_id == 3)
                    <div class="px-2">
                        <button @click="openSections.myActivity = !openSections.myActivity"
                            class="w-full flex items-center px-2 py-2 text-sm font-medium text-white hover:bg-gray-700 rounded-md">
                            <x-icons.clock class="flex-shrink-0 h-5 w-5" />
                            <span class="ml-3">My Activity</span>
                            <svg class="ml-auto h-5 w-5 transform transition-transform" :class="{ 'rotate-180': openSections.myActivity }" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="openSections.myActivity" class="space-y-1 ml-4 pl-4">
                            <x-responsive-nav-link href="{{ route('my-task-history') }}" :active="request()->routeIs('my-task-history')" class="text-gray-300 hover:bg-gray-700">
                                <span>My Activities</span>
                            </x-responsive-nav-link>
                            <x-responsive-nav-link href="{{ route('attendance.index') }}" :active="request()->routeIs('attendance.index')" class="text-gray-300 hover:bg-gray-700">
                                <span>My Attendance</span>
                            </x-responsive-nav-link>
                        </div>
                    </div>
                @endif
            @endauth

            <!-- Reports -->
            @auth
                @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                    <div class="px-2">
                        <button @click="openSections.reports = !openSections.reports"
                            class="w-full flex items-center px-2 py-2 text-sm font-medium text-white hover:bg-gray-700 rounded-md">
                            <x-icons.report class="flex-shrink-0 h-5 w-5" />
                            <span class="ml-3">Reports</span>
                            <svg class="ml-auto h-5 w-5 transform transition-transform" :class="{ 'rotate-180': openSections.reports }" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="openSections.reports" class="space-y-1 ml-4 pl-4">
                            <x-responsive-nav-link
                                href="{{ auth()->user()->role_id == 1 ? route('admin.generate-report') : route('team-lead.generate-report') }}"
                                :active="request()->routeIs('*.generate-report')" class="text-gray-300 hover:bg-gray-700">
                                <span>Generate Reports</span>
                            </x-responsive-nav-link>
                            <x-responsive-nav-link href="{{ route('task-history.index') }}" :active="request()->routeIs('task-history.*')" class="text-gray-300 hover:bg-gray-700">
                                <span>Task History</span>
                            </x-responsive-nav-link>
                        </div>
                    </div>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-700">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-300">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-white hover:bg-gray-700">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();"
                            class="text-white hover:bg-gray-700">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
