<x-app-layout>
    @section('title')
        @if (auth()->id() == 1)
            Admin Users - Member Performance
        @else
            Team Lead - Member Performance
        @endif
    @endsection
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Team Member Analytics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Member Selection -->
                    <div class="mb-8">
                        <label for="member-select" class="block text-sm font-medium text-gray-700">Select Team Member</label>
                        <select id="member-select" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @foreach($members as $member)
                                <option selected value="{{ $member->id }}">{{ $member->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Month Selection -->
                    <div class="mb-8">
                        <label for="month-select" class="block text-sm font-medium text-gray-700">Select Month</label>
                        <input type="month" id="month-select" value="{{ date('Y-m') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-blue-800">Completed This Month</h3>
                            <p id="completed-count" class="text-2xl font-bold text-blue-600">0</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-yellow-800">Pending Tasks</h3>
                            <p id="pending-count" class="text-2xl font-bold text-yellow-600">0</p>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-purple-800">In Progress</h3>
                            <p id="in-progress-count" class="text-2xl font-bold text-purple-600">0</p>
                        </div>
                    </div>

                    <!-- Completion Trend Chart -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium mb-4">Task Completion Trend (Last 6 Months)</h3>
                        <canvas id="completionChart" height="100"></canvas>
                    </div>

                    <!-- Recent Completed Tasks -->
                    <div>
                        <h3 class="text-lg font-medium mb-4">Recently Completed Tasks</h3>
                        <div id="recent-tasks" class="space-y-2">
                            <!-- Dynamically loaded content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const memberSelect = document.getElementById('member-select');
            const monthSelect = document.getElementById('month-select');
            let completionChart;

            function loadAnalyticsData() {
                const memberId = memberSelect.value;
                const month = monthSelect.value;


                // Injected role from backend
                const userRole = "{{ Auth::user()->role->id }}"; // Assuming you have a relationship like: User belongsTo Role
                let baseUrl = '';

                if (userRole == 1) {
                    baseUrl = '/admin/analytics/member-performance';
                } else if (userRole == 2) {
                    baseUrl = '/team-lead/analytics/member-performance';
                }

                const url = `${baseUrl}?member_id=${memberId}&month=${month}`;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        // Update stats
                        document.getElementById('completed-count').textContent = data.stats.completed_this_month;
                        document.getElementById('pending-count').textContent = data.stats.pending;
                        document.getElementById('in-progress-count').textContent = data.stats.in_progress;

                        // Update recent tasks
                        const recentTasksContainer = document.getElementById('recent-tasks');
                        recentTasksContainer.innerHTML = '';

                        if (data.recent_completed.length > 0) {
                            data.recent_completed.forEach(task => {
                                const taskElement = document.createElement('div');
                                taskElement.className = 'p-3 bg-gray-50 rounded';
                                taskElement.innerHTML = `
                                    <p class="font-medium">${task.title}</p>
                                    <p class="text-sm text-gray-600">Completed on ${new Date(task.updated_at).toLocaleDateString()}</p>
                                `;
                                recentTasksContainer.appendChild(taskElement);
                            });
                        } else {
                            recentTasksContainer.innerHTML = '<p class="text-gray-500">No recently completed tasks</p>';
                        }

                        // Update chart
                        updateChart(data.completion_trend);
                    });
            }

            function updateChart(trendData) {
                const ctx = document.getElementById('completionChart').getContext('2d');

                if (completionChart) {
                    completionChart.destroy();
                }

                completionChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: trendData.map(item => item.month),
                        datasets: [{
                            label: 'Tasks Completed',
                            data: trendData.map(item => item.count),
                            backgroundColor: 'rgba(59, 130, 246, 0.5)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            }

            // Initial load
            loadAnalyticsData();

            // Reload when selection changes
            memberSelect.addEventListener('change', loadAnalyticsData);
            monthSelect.addEventListener('change', loadAnalyticsData);
        });
    </script>
    @endpush
</x-app-layout>
