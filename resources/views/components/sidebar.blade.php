<div class="hidden md:flex md:w-64 md:flex-col">
    <div class="flex flex-col h-0 flex-1 bg-gray-800">
        <!-- Sidebar Header -->
        <div class="flex items-center h-16 flex-shrink-0 px-4 bg-gray-900">
            <h1 class="text-white text-lg font-semibold">Task Tracker</h1>
        </div>

        <!-- Sidebar Content -->
        <div class="flex-1 flex flex-col overflow-y-auto">
            <nav class="flex-1 px-2 py-4 space-y-1" x-data="{ openSections: {} }">
                <!-- Dashboard -->
                <x-sidebar.link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    <x-icons.dashboard class="flex-shrink-0 h-6 w-6" />
                    <span class="ml-3">Dashboard</span>
                </x-sidebar.link>

                @auth
                    @if (auth()->user()->role_id == 1)
                        <!-- Admin Section -->
                        <div>
                            <button @click="openSections.admin = !openSections.admin"
                                class="w-full flex items-center px-2 py-2 text-sm font-medium text-white hover:bg-gray-700 rounded-md">
                                <x-icons.admin class="flex-shrink-0 h-6 w-6" />
                                <span class="ml-3">Admin</span>
                            </button>
                            <div x-show="openSections.admin" class="space-y-1 ml-4">
                                <x-sidebar.link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                                    <span class="ml-9">Admin Dashboard</span>
                                </x-sidebar.link>
                                <x-sidebar.link href="{{ route('teams.index') }}" :active="request()->routeIs('teams.*')">
                                    <span class="ml-9">Manage Teams</span>
                                </x-sidebar.link>
                                <x-sidebar.link href="{{ route('admin.member-analytics') }}" :active="request()->routeIs('admin.member-analytics')">
                                    <span class="ml-9">Member Analytics</span>
                                </x-sidebar.link>
                                <!-- User Management -->
                                <button @click="openSections.users = !openSections.users"
                                    class="w-full flex items-center px-2 py-2 text-sm font-medium text-white hover:bg-gray-700 rounded-md">
                                    <x-icons.user class="flex-shrink-0 h-6 w-6" />
                                    <span class="ml-3">User Management</span>
                                </button>
                                <div x-show="openSections.users" class="space-y-1 ml-4">
                                    <x-sidebar.link href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.users.index')">
                                        <span class="ml-9">All Users</span>
                                    </x-sidebar.link>
                                    <x-sidebar.link href="{{ route('admin.users.create') }}" :active="request()->routeIs('admin.users.create')">
                                        <span class="ml-9">Add New User</span>
                                    </x-sidebar.link>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (auth()->user()->role_id == 2)
                        <!-- Team Lead Section -->
                        <div>
                            <button @click="openSections.lead = !openSections.lead"
                                class="w-full flex items-center px-2 py-2 text-sm font-medium text-white hover:bg-gray-700 rounded-md">
                                <x-icons.lead class="flex-shrink-0 h-6 w-6" />
                                <span class="ml-3">Team Lead</span>
                            </button>
                            <div x-show="openSections.lead" class="space-y-1 ml-4">
                                <x-sidebar.link href="{{ route('team-lead.dashboard') }}" :active="request()->routeIs('team-lead.dashboard')">
                                    <span class="ml-9">Team Dashboard</span>
                                </x-sidebar.link>
                                <x-sidebar.link href="{{ route('tasks.index') }}" :active="request()->routeIs('tasks.*')">
                                    <span class="ml-9">Manage Tasks</span>
                                </x-sidebar.link>
                                <x-sidebar.link href="{{ route('team-lead.member-analytics') }}" :active="request()->routeIs('team-lead.member-analytics')">
                                    <span class="ml-9">Team Analytics</span>
                                </x-sidebar.link>
                                <x-sidebar.link href="{{ route('attendance.team') }}" :active="request()->routeIs('attendance.team')">
                                    <span class="ml-9">Team Attendance</span>
                                </x-sidebar.link>
                            </div>
                        </div>
                    @endif

                    <!-- Tasks -->
                    @if (auth()->user()->role_id == 2)
                        <div>
                            <button @click="openSections.tasks = !openSections.tasks"
                                class="w-full flex items-center px-2 py-2 text-sm font-medium text-white hover:bg-gray-700 rounded-md">
                                <x-icons.task class="flex-shrink-0 h-6 w-6" />
                                <span class="ml-3">Tasks</span>
                            </button>
                            <div x-show="openSections.tasks" class="space-y-1 ml-4">
                                <x-sidebar.link href="{{ route('tasks.create') }}" :active="request()->routeIs('tasks.create')">
                                    <span class="ml-9">Create Task</span>
                                </x-sidebar.link>
                                <x-sidebar.link href="{{ route('tasks.index') }}" :active="request()->routeIs('tasks.index')">
                                    <span class="ml-9">My Tasks</span>
                                </x-sidebar.link>
                            </div>
                        </div>
                    @endif

                    <!-- Attendance -->
                    <div>
                        <button @click="openSections.attendance = !openSections.attendance"
                            class="w-full flex items-center px-2 py-2 text-sm font-medium text-white hover:bg-gray-700 rounded-md">
                            <x-icons.clock class="flex-shrink-0 h-6 w-6" />
                            <span class="ml-3">Attendance</span>
                        </button>
                        <div x-show="openSections.attendance" class="space-y-1 ml-4">
                            @if(auth()->user()->role_id == 2 || auth()->user()->role_id == 3)
                                <x-sidebar.link href="{{ route('attendance.index') }}" :active="request()->routeIs('attendance.index')">
                                    <span class="ml-9">My Attendance</span>
                                </x-sidebar.link>
                            @endif
                            @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                                <x-sidebar.link href="{{ route('attendance.team') }}" :active="request()->routeIs('attendance.team')">
                                    <span class="ml-9">Team Attendance</span>
                                </x-sidebar.link>
                            @endif
                            @if(auth()->user()->role_id == 1)
                                <x-sidebar.link href="{{ route('attendance.settings') }}" :active="request()->routeIs('attendance.settings')">
                                    <span class="ml-9">Settings</span>
                                </x-sidebar.link>
                            @endif
                        </div>
                    </div>

                    <!-- My Activity -->
                    @if (auth()->user()->role_id == 3)
                        <div>
                            <button @click="openSections.myActivity = !openSections.myActivity"
                                class="w-full flex items-center px-2 py-2 text-sm font-medium text-white hover:bg-gray-700 rounded-md">
                                <x-icons.clock class="flex-shrink-0 h-6 w-6" />
                                <span class="ml-3">My Activity</span>
                            </button>
                            <div x-show="openSections.myActivity" class="space-y-1 ml-4">
                                <x-sidebar.link href="{{ route('my-task-history') }}" :active="request()->routeIs('my-task-history')">
                                    <span class="ml-9">My Activities</span>
                                </x-sidebar.link>
                                <x-sidebar.link href="{{ route('attendance.index') }}" :active="request()->routeIs('attendance.index')">
                                    <span class="ml-9">My Attendance</span>
                                </x-sidebar.link>
                            </div>
                        </div>
                    @endif
                @endauth

                <!-- Reports -->
                @auth
                    @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                        <div>
                            <button @click="openSections.reports = !openSections.reports"
                                class="w-full flex items-center px-2 py-2 text-sm font-medium text-white hover:bg-gray-700 rounded-md">
                                <x-icons.report class="flex-shrink-0 h-6 w-6" />
                                <span class="ml-3">Reports</span>
                            </button>
                            <div x-show="openSections.reports" class="space-y-1 ml-4">
                                <x-sidebar.link
                                    href="{{ auth()->user()->role_id == 1 ? route('admin.generate-report') : route('team-lead.generate-report') }}"
                                    :active="request()->routeIs('*.generate-report')">
                                    <span class="ml-9">Generate Reports</span>
                                </x-sidebar.link>
                                <x-sidebar.link href="{{ route('task-history.index') }}" :active="request()->routeIs('task-history.*')">
                                    <span class="ml-9">Task History</span>
                                </x-sidebar.link>
                                {{-- <x-sidebar.link href="{{ route('attendance.report') }}" :active="request()->routeIs('attendance.report')">
                                    <span class="ml-9">Attendance Reports</span>
                                </x-sidebar.link> --}}
                            </div>
                        </div>
                    @endif
                @endauth
            </nav>
        </div>
    </div>
</div>
