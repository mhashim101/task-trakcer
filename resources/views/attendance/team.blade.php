<x-app-layout>
    @section('title')
        @if (auth()->id() == 1)
            Admin Attendance - Team
        @else
            Team Lead Attendance - Team
        @endif
    @endsection
    <x-attendance.layout title="Team Attendance">
        <x-slot name="actions">
            <form action="{{ route('attendance.team') }}" method="GET" class="flex space-x-2">
                <input type="date" name="start_date" value="{{ $startDate }}" class="border-gray-300 rounded-md">
                <input type="date" name="end_date" value="{{ $endDate }}" class="border-gray-300 rounded-md">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Filter
                </button>
            </form>
        </x-slot>

        <div class="mb-4">
            <label for="user-filter" class="block text-sm font-medium text-gray-700">Filter by Team Member</label>
            <select id="user-filter"
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                    onchange="redirectToUserReport(this)">
                <option value="">All Members</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>

        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check In</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check Out</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($records as $record)
                        <tr class="user-row" data-user-id="{{ $record->user_id }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                            {{ substr($record->user->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $record->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $record->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $record->date->format('D, M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $record->check_in ?? '--:--' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $record->check_out ?? '--:--' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium capitalize">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $record->status === 'present' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $record->status === 'late' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $record->status === 'half_day' ? 'bg-orange-100 text-orange-800' : '' }}
                                    {{ $record->status === 'absent' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ $record->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No attendance records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $records->links() }}
        </div>

        @push('scripts')
            <script>
               function redirectToUserReport(selectElement) {
                    const userId = selectElement.value;
                    if (userId) {
                        const url = `{{ route('attendance.report', ['user' => 'USER_ID']) }}`.replace('USER_ID', userId);
                        window.location.href = url;
                    } else {
                        window.location.href = `{{ route('attendance.team') }}`;
                    }
                }
            </script>
        @endpush
    </x-attendance.layout>
</x-app-layout>
