<x-app-layout>
    @section('title')
        @if (auth()->id() == 1)
            Admin Attendance - Settings
        @else
            Team Lead Attendance - Settings
        @endif
    @endsection
    <x-attendance.layout title="Attendance Settings">
        <form action="{{ route('attendance.settings.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                        <input type="time" id="start_time" name="start_time" value="{{ old('start_time', $settings->start_time ? $settings->start_time->format('H:i') : '09:00') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('start_time')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                        <input type="time" id="end_time" name="end_time" value="{{ old('end_time', $settings->end_time ? $settings->end_time->format('H:i') : '17:00') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('end_time')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="late_threshold" class="block text-sm font-medium text-gray-700">Late Threshold (minutes)</label>
                        <input type="number" id="late_threshold" name="late_threshold" value="{{ old('late_threshold', $settings->late_threshold ?? 15) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('late_threshold')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="half_day_threshold" class="block text-sm font-medium text-gray-700">Half Day Threshold (hours)</label>
                        <input type="number" id="half_day_threshold" name="half_day_threshold" value="{{ old('half_day_threshold', $settings->half_day_threshold ?? 4) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('half_day_threshold')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Working Days</label>
                    <div class="mt-2 flex flex-wrap gap-4">
                        @foreach(['Monday' => 1, 'Tuesday' => 2, 'Wednesday' => 3, 'Thursday' => 4, 'Friday' => 5, 'Saturday' => 6, 'Sunday' => 7] as $day => $value)
                            <div class="flex items-center">
                                <input id="day-{{ $value }}" name="working_days[]" type="checkbox" value="{{ $value }}"
                                    {{ in_array($value, old('working_days', $settings->working_days ?? [1,2,3,4,5])) ? 'checked' : '' }}
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="day-{{ $value }}" class="ml-2 block text-sm text-gray-700">{{ $day }}</label>
                            </div>
                        @endforeach
                    </div>
                    @error('working_days')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="holidays" class="block text-sm font-medium text-gray-700">Holidays (YYYY-MM-DD, one per line)</label>
                    <textarea id="holidays" name="holidays" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('holidays', $settings->holidays ? implode("\n", $settings->holidays) : '') }}</textarea>
                    <p class="mt-2 text-sm text-gray-500">Enter one date per line in YYYY-MM-DD format.</p>
                    @error('holidays')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Save Settings
                    </button>
                </div>
            </div>
        </form>
    </x-attendance.layout>
</x-app-layout>
