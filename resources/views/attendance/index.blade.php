<x-app-layout>
    @section('title')
        @if (auth()->id() == 2)
            Team Lead - Attendance
        @else
            Member - Attendance
        @endif
    @endsection
    <x-attendance.layout title="My Attendance">
        <x-slot name="actions">
            @if(!$todayRecord || !$todayRecord->check_in)
                <form action="{{ route('attendance.check-in') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Check In
                    </button>
                </form>
            @elseif($todayRecord && $todayRecord->check_in && !$todayRecord->check_out)
                <form action="{{ route('attendance.check-out') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Check Out
                    </button>
                </form>
            @endif
        </x-slot>

        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-900">Today's Status</h3>
            @if($todayRecord)
                <div class="mt-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-500">Check In</p>
                        <p class="mt-1 text-lg font-semibold text-gray-900">
                            {{ $todayRecord->check_in ? $todayRecord->check_in->format('D, M d, Y, H:i:s') : '--:--' }}
                        </p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-500">Check Out</p>
                        <p class="mt-1 text-lg font-semibold text-gray-900">
                            {{ $todayRecord->check_out ? $todayRecord->check_out : '--:--' }}
                        </p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-500">Status</p>
                        <p class="mt-1 text-lg font-semibold text-gray-900 capitalize">
                            {{ $todayRecord->status }}
                        </p>
                    </div>
                </div>
            @else
                <p class="mt-2 text-sm text-gray-600">No attendance record for today.</p>
            @endif
        </div>

        <div>
            <h3 class="text-lg font-medium text-gray-900">Attendance History</h3>
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check In</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check Out</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">No attendance records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $records->links() }}
            </div>
        </div>
    </x-attendance.layout>
</x-app-layout>
