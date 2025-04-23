<div class="hidden md:flex md:w-64 md:flex-col">
    <div class="flex flex-col h-0 flex-1 bg-gray-800">
        <!-- Sidebar Header -->
        <div class="flex items-center h-16 flex-shrink-0 px-4 bg-gray-900">
            <h1 class="text-white text-lg font-semibold">Task Tracker</h1>
        </div>

        <!-- Sidebar Content -->
        <div class="flex-1 flex flex-col overflow-y-auto">
            <nav class="flex-1 px-2 py-4 space-y-1">
                <!-- Dashboard Link -->
                <x-sidebar.link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    <x-icons.dashboard class="flex-shrink-0 h-6 w-6" />
                    <span class="ml-3">Dashboard</span>
                </x-sidebar.link>

                @auth
                    @if (auth()->user()->role_id == 1)
                        <!-- Admin Links -->
                        <x-sidebar.section title="Admin">
                            <x-sidebar.link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                                <x-icons.admin class="flex-shrink-0 h-6 w-6" />
                                <span class="ml-3">Admin Dashboard</span>
                            </x-sidebar.link>
                            <x-sidebar.link href="{{ route('teams.index') }}" :active="request()->routeIs('teams.*')">
                                <x-icons.team class="flex-shrink-0 h-6 w-6" />
                                <span class="ml-3">Manage Teams</span>
                            </x-sidebar.link>
                            <x-sidebar.link href="{{ route('admin.member-analytics') }}" :active="request()->routeIs('admin.member-analytics')">
                                <x-icons.analytics class="flex-shrink-0 h-6 w-6" />
                                <span class="ml-3">Member Analytics</span>
                            </x-sidebar.link>

                            <!-- 👤 User Management Section -->
                            <x-sidebar.section title="User Management">
                                <x-sidebar.link href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.users.index')">
                                    <x-icons.user class="flex-shrink-0 h-6 w-6" />
                                    <span class="ml-3">All Users</span>
                                </x-sidebar.link>
                                <x-sidebar.link href="{{ route('admin.users.create') }}" :active="request()->routeIs('admin.users.create')">
                                    <x-icons.add-user class="flex-shrink-0 h-6 w-6" />
                                    <span class="ml-3">Add New User</span>
                                </x-sidebar.link>
                                {{-- <x-sidebar.link href="{{ route('admin.users.edit') }}" :active="request()->routeIs('admin.roles.index')">
                                    <x-icons.roles class="flex-shrink-0 h-6 w-6" />
                                    <span class="ml-3">Manage Roles</span>
                                </x-sidebar.link> --}}
                            </x-sidebar.section>
                        </x-sidebar.section>
                    @endif
                @endauth

                @auth
                    @if (auth()->user()->role_id == 2)
                        <!-- Team Lead Links -->
                        <x-sidebar.section title="Team Lead">
                            <x-sidebar.link href="{{ route('team-lead.dashboard') }}" :active="request()->routeIs('team-lead.dashboard')">
                                <x-icons.lead class="flex-shrink-0 h-6 w-6" />
                                <span class="ml-3">Team Dashboard</span>
                            </x-sidebar.link>
                            <x-sidebar.link href="{{ route('tasks.index') }}" :active="request()->routeIs('tasks.*')">
                                <x-icons.task class="flex-shrink-0 h-6 w-6" />
                                <span class="ml-3">Manage Tasks</span>
                            </x-sidebar.link>
                            <x-sidebar.link href="{{ route('team-lead.member-analytics') }}" :active="request()->routeIs('team-lead.member-analytics')">
                                <x-icons.analytics class="flex-shrink-0 h-6 w-6" />
                                <span class="ml-3">Team Analytics</span>
                            </x-sidebar.link>
                        </x-sidebar.section>
                    @endif
                @endauth

                @auth
                    @if (auth()->user()->role_id == 2)
                <x-sidebar.section title="Tasks">
                    <x-sidebar.link href="{{ route('tasks.create') }}" :active="request()->routeIs('tasks.create')">
                        <x-icons.add class="flex-shrink-0 h-6 w-6" />
                        <span class="ml-3">Create Task</span>
                    </x-sidebar.link>
                    <x-sidebar.link href="{{ route('tasks.index') }}" :active="request()->routeIs('tasks.index')">
                        <x-icons.list class="flex-shrink-0 h-6 w-6" />
                        <span class="ml-3">My Tasks</span>
                    </x-sidebar.link>
                </x-sidebar.section>
                @endif
                @endauth

                <!-- Reports Section -->
                <x-sidebar.section title="Reports">
                    @auth
                        @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                            <x-sidebar.link
                                href="{{ auth()->user()->role_id == 1 ? route('admin.generate-report') : route('team-lead.generate-report') }}"
                                :active="request()->routeIs('*.generate-report')">
                                <x-icons.report class="flex-shrink-0 h-6 w-6" />
                                <span class="ml-3">Generate Reports</span>
                            </x-sidebar.link>
                            <x-sidebar.link href="{{ route('task-history.index') }}" :active="request()->routeIs('task-history.*')">
                                <x-icons.history class="flex-shrink-0 h-6 w-6" />
                                <span class="ml-3">Task History</span>
                            </x-sidebar.link>


                        @endif
                    @endauth

                    {{-- <x-sidebar.link href="#" :active="false">
                        <x-icons.history class="flex-shrink-0 h-6 w-6" />
                        <span class="ml-3">Task History</span>
                    </x-sidebar.link> --}}
                    @auth
                        @if (auth()->user()->role_id == 3)
                            <x-sidebar.link href="{{ route('my-task-history') }}" :active="request()->routeIs('my-task-history')">
                                <x-icons.user-history class="flex-shrink-0 h-6 w-6" />
                                <span class="ml-3">My Activities</span>
                            </x-sidebar.link>
                        @endif
                    @endauth
                </x-sidebar.section>
            </nav>
        </div>
    </div>
</div>
