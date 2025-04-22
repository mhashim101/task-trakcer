<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Task History: ') . $task->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <a href="{{ route('tasks.show', $task->id) }}" class="text-blue-600 hover:text-blue-900">
                            &larr; Back to Task
                        </a>
                    </div>

                    <div class="space-y-4">
                        @forelse ($histories as $history)
                        <div class="p-4 border rounded-lg">
                            <div class="flex justify-between">
                                <div>
                                    <span class="font-medium">{{ $history->user->name }}</span>
                                    <span class="text-sm text-gray-500 ml-2">{{ $history->created_at->diffForHumans() }}</span>
                                </div>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $history->event_type === 'created' ? 'bg-green-100 text-green-800' :
                                       ($history->event_type === 'deleted' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                    {{ ucfirst(str_replace('_', ' ', $history->event_type)) }}
                                </span>
                            </div>
                            <p class="mt-2">{{ $history->description }}</p>

                            @if($history->event_type === 'updated' && count($history->new_values) > 0)
                                <div class="mt-3 p-3 bg-gray-50 rounded">
                                    <h4 class="text-sm font-medium mb-2">Changes:</h4>
                                    <ul class="text-sm space-y-1">
                                        @foreach($history->new_values as $field => $value)
                                            @if(!in_array($field, ['updated_at', 'created_at']))
                                                <li>
                                                    <span class="font-medium">{{ str_replace('_', ' ', ucfirst($field)) }}:</span>
                                                    @if(isset($history->old_values[$field]))
                                                        <span class="line-through text-red-500 mx-1">{{ $history->old_values[$field] }}</span> →
                                                    @endif
                                                    <span class="text-green-600">{{ $value }}</span>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        @empty
                        <p class="text-gray-500">No history found for this task.</p>
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
