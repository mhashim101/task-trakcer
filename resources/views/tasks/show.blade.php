<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Task Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium">{{ $task->title }}</h3>
                        <p class="text-gray-600 mt-2">{{ $task->description }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h4 class="text-md font-medium mb-2">Team</h4>
                            <p>{{ $task->team->name }}</p>
                        </div>

                        <div>
                            <h4 class="text-md font-medium mb-2">Assigned By</h4>
                            <p>{{ $task->assignedBy->name }}</p>
                        </div>

                        <div>
                            <h4 class="text-md font-medium mb-2">Assigned To</h4>
                            <p>{{ $task->assignedTo->name }}</p>
                        </div>

                        <div>
                            <h4 class="text-md font-medium mb-2">Status</h4>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $task->status === 'completed' ? 'bg-green-100 text-green-800' :
                                   ($task->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ str_replace('_', ' ', ucfirst($task->status)) }}
                            </span>
                        </div>

                        <div>
                            <h4 class="text-md font-medium mb-2">Due Date</h4>
                            <p>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : 'Not set' }}</p>
                        </div>

                        <div>
                            <h4 class="text-md font-medium mb-2">Created At</h4>
                            <p>{{ $task->created_at->format('Y-m-d H:i') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-4">
                        @if(auth()->user()->isTeamLead() || auth()->user()->isAdmin())
                            <a href="{{ route('tasks.edit', $task->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">Edit Task</a>
                        @endif
                        <a href="{{ url()->previous() }}" class="bg-gray-500 text-white px-4 py-2 rounded">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
