<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Team Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium">{{ $team->name }}</h3>
                        <p class="text-gray-600 mt-1">{{ $team->description }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-md font-medium mb-2">Team Lead</h4>
                            <div class="bg-gray-50 p-4 rounded">
                                <p>{{ $team->teamLead->name }}</p>
                                <p class="text-gray-600">{{ $team->teamLead->email }}</p>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-md font-medium mb-2">Team Members</h4>
                            <div class="bg-gray-50 p-4 rounded">
                                @if($team->members->isEmpty())
                                    <p>No members in this team.</p>
                                @else
                                    <ul class="space-y-2">
                                        @foreach($team->members as $member)
                                            <li>{{ $member->name }} ({{ $member->email }})</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h4 class="text-md font-medium mb-2">Team Tasks</h4>
                        @if($team->tasks->isEmpty())
                            <p>No tasks assigned to this team.</p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned To</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($team->tasks as $task)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $task->title }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $task->assignedTo->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    {{ $task->status === 'completed' ? 'bg-green-100 text-green-800' :
                                                       ($task->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                                    {{ str_replace('_', ' ', ucfirst($task->status)) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '-' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('teams.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Back to Teams</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
