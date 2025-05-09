<x-app-layout>
    @section('title')
        @if (auth()->id() == 1)
            Admin Attendance - Report
        @else
            Team Lead Attendance - Report
        @endif
    @endsection
    <x-attendance.layout title="{{ $user->name }}'s Attendance Report">
        <x-slot name="actions">
            <form action="{{ route('attendance.report', $user->id) }}" method="GET" class="flex space-x-2">
                <input type="date" name="start_date" value="{{ $startDate }}" class="border-gray-300 rounded-md">
                <input type="date" name="end_date" value="{{ $endDate }}" class="border-gray-300 rounded-md">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Filter
                </button>
            </form>
        </x-slot>

        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-900">Summary</h3>
            <div class="mt-2 grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm font-medium text-gray-500">Total Days</p>
                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $summary['total_days'] }}</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <p class="text-sm font-medium text-green-500">Present</p>
                    <p class="mt-1 text-lg font-semibold text-green-900">{{ $summary['present'] }}</p>
                </div>
                <div class="bg-yellow-50 p-4 rounded-lg">
                    <p class="text-sm font-medium text-yellow-500">Late</p>
                    <p class="mt-1 text-lg font-semibold text-yellow-900">{{ $summary['late'] }}</p>
                </div>
                <div class="bg-red-50 p-4 rounded-lg">
                    <p class="text-sm font-medium text-red-500">Absent</p>
                    <p class="mt-1 text-lg font-semibold text-red-900">{{ $summary['absent'] }}</p>
                </div>
            </div>
        </div>

        <div>
            <h3 class="text-lg font-medium text-gray-900">Detailed Records</h3>
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check In</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check Out</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($records as $record)
                            <tr>
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
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $record->notes ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No attendance records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </x-attendance.layout>
</x-app-layout>
