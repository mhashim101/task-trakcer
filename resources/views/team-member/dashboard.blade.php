<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Team Member Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium mb-4">Your Tasks</h3>

                    @if($tasks->isEmpty())
                        <p>You don't have any tasks assigned yet.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($tasks as $task)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('team-member.tasks-show', $task->id) }}" class="font-medium text-blue-600 hover:text-blue-900">
                                                {{ $task->title }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4">{{ Str::limit($task->description, 50) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $task->status === 'completed' ? 'bg-green-100 text-green-800' :
                                                   ($task->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                                {{ str_replace('_', ' ', ucfirst($task->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form action="{{ route('tasks.update-status', $task->id) }}" method="POST" class="inline">
                                                @csrf
                                                {{-- @method('PATCH') --}}
                                                <select name="status" class="rounded border-gray-300" onchange="handleStatusChange(this, {{ $task->id }})">
                                                    <option value="pending"
                                                        {{ $task->status === 'pending' ? 'selected' : '' }}
                                                        {{ $task->status !== 'pending' ? 'disabled' : '' }}>
                                                        Pending
                                                    </option>
                                                    <option value="in_progress"
                                                        {{ $task->status === 'in_progress' ? 'selected' : '' }}
                                                        {{ $task->status === 'completed' ? 'disabled' : '' }}>
                                                        In Progress
                                                    </option>
                                                    <option value="completed"
                                                        {{ $task->status === 'completed' ? 'selected' : '' }}>
                                                        Completed
                                                    </option>
                                                </select>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-4">
                                {{ $tasks->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function handleStatusChange(selectElement, taskId) {
            const selectedStatus = selectElement.value;

            if (selectedStatus === 'completed') {
                if (confirm("Do you want to upload a file for this task?")) {
                    window.location.href = `/team-member/tasks/${taskId}`; // Customize route as needed
                    return;
                }
            }

            // Submit the form normally if not uploading
            selectElement.form.submit();
        }
    </script>
</x-app-layout>
