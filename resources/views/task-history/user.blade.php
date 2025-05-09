<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Task Activities') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="space-y-4">
                        @forelse ($histories as $history)
                        <div class="p-4 border rounded-lg">
                            <div class="flex justify-between">
                                <a href="{{ route('team-member.tasks-show', $history->task_id) }}" class="font-medium text-blue-600 hover:text-blue-900">
                                    {{ $history->task->title }}
                                </a>
                                <span class="text-sm text-gray-500">{{ $history->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="mt-2">{{ $history->description }}</p>

                            @if($history->event_type === 'status_changed')
                                <div class="mt-2 text-sm">
                                    Status changed from
                                    <span class="font-medium">{{ $history->old_values['status'] ?? 'N/A' }}</span>
                                    to <span class="font-medium">{{ $history->new_values['status'] }}</span>
                                </div>
                            @endif
                        </div>
                        @empty
                        <p class="text-gray-500">You haven't made any task activities yet.</p>
                        @endforelse
                    </div>

                    <div class="mt-4">
                        {{ $histories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
