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

                    <!-- Add this right before the action buttons -->
                    @if($task->status === 'completed')
                        <div class="mt-8">
                            <h3 class="text-lg font-medium mb-2">Completion Details</h3>

                            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                                <h4 class="font-medium mb-2">Completion Notes</h4>
                                <p>{{ $task->completion_notes }}</p>
                            </div>

                            @if($task->attachments->count() > 0)
                                <h4 class="font-medium mb-2">Attachments</h4>
                                <div class="space-y-4">
                                    @foreach($task->attachments as $attachment)
                                        <x-attachment-card :attachment="$attachment" />
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @elseif(auth()->user()->id === $task->assigned_to)
                        <div class="mt-8">
                            <h3 class="text-lg font-medium mb-2">Mark Task as Complete</h3>
                            <x-task-complete-form :task="$task" />
                        </div>
                    @endif

                    <div class="flex items-center justify-end space-x-4 mt-6">
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
