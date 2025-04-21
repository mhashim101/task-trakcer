<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Generate Member Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form id="report-form">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="report-member" class="block text-sm font-medium text-gray-700">Team Member</label>
                                <select id="report-member" name="member_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                    @foreach($members as $member)
                                        <option value="{{ $member->id }}">{{ $member->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="start-date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="date" id="start-date" name="start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>

                            <div>
                                <label for="end-date" class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="date" id="end-date" name="end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Generate Report</button>
                        </div>
                    </form>

                    <div id="report-results" class="mt-8 hidden">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium">Report Results</h3>
                            <div class="flex space-x-2" id="download-buttons">
                                <!-- Download buttons will appear here -->
                            </div>
                        </div>
                        <div id="report-data" class="space-y-4">
                            <!-- Report data will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        console.log("Script Loaded");

        document.addEventListener('DOMContentLoaded', function() {
            // Set default dates (last month)
            const endDate = new Date();
            const startDate = new Date();
            startDate.setMonth(startDate.getMonth() - 1);

            document.getElementById('start-date').valueAsDate = startDate;
            document.getElementById('end-date').valueAsDate = endDate;

            // Handle form submission
            document.getElementById('report-form').addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                console.log(formData);
                const memberId = document.getElementById('report-member').value;
                const startDate = document.getElementById('start-date').value;
                const endDate = document.getElementById('end-date').value;


                const userRole = "{{ Auth::user()->role->id }}"; // Assuming you have a relationship like: User belongsTo Role
                let baseUrl = '';

                if (userRole == 1) {
                    baseUrl = '/admin/analytics/generate-report';
                } else if (userRole == 2) {
                    baseUrl = '/team-lead/analytics/generate-report';
                }

                fetch(baseUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const resultsContainer = document.getElementById('report-data');
                    resultsContainer.innerHTML = '';

                    // Summary
                    const summaryElement = document.createElement('div');
                    summaryElement.className = 'bg-gray-50 p-4 rounded-lg mb-4';
                    summaryElement.innerHTML = `
                        <h4 class="font-medium text-lg mb-2">Summary</h4>
                        <p>Period: ${new Date(data.period.start).toLocaleDateString()} to ${new Date(data.period.end).toLocaleDateString()}</p>
                        <p>Total Tasks: ${data.total_tasks}</p>
                        <p>Completed Tasks: ${data.completed_tasks} (${Math.round((data.completed_tasks / data.total_tasks) * 100)}%)</p>
                    `;
                    resultsContainer.appendChild(summaryElement);

                    // Tasks list
                    if (data.tasks.length > 0) {
                        const tasksElement = document.createElement('div');
                        tasksElement.className = 'space-y-2';
                        tasksElement.innerHTML = '<h4 class="font-medium text-lg">Tasks Details</h4>';

                        data.tasks.forEach(task => {
                            const taskElement = document.createElement('div');
                            taskElement.className = 'p-3 border rounded';
                            taskElement.innerHTML = `
                                <p class="font-medium">${task.title}</p>
                                <p class="text-sm">Team: ${task.team.name}</p>
                                <p class="text-sm">Status: <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    ${task.status === 'completed' ? 'bg-green-100 text-green-800' :
                                       (task.status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')}">
                                    ${task.status.replace('_', ' ')}
                                </span></p>
                                <p class="text-sm">Assigned by: ${task.assigned_by.name}</p>
                                <p class="text-sm">Last updated: ${new Date(task.updated_at).toLocaleString()}</p>
                            `;
                            tasksElement.appendChild(taskElement);
                        });

                        resultsContainer.appendChild(tasksElement);
                    } else {
                        resultsContainer.innerHTML += '<p class="text-gray-500">No tasks found for the selected period.</p>';
                    }

                    // Add download buttons
                    const downloadButtons = document.getElementById('download-buttons');
                    downloadButtons.innerHTML = `
                        <form action="/analytics/download-report" method="POST" target="_blank">
                            @csrf
                            <input type="hidden" name="member_id" value="${memberId}">
                            <input type="hidden" name="start_date" value="${startDate}">
                            <input type="hidden" name="end_date" value="${endDate}">
                            <input type="hidden" name="format" value="pdf">
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                </svg>
                                PDF
                            </button>
                        </form>
                        <form action="/analytics/download-report" method="POST" target="_blank">
                            @csrf
                            <input type="hidden" name="member_id" value="${memberId}">
                            <input type="hidden" name="start_date" value="${startDate}">
                            <input type="hidden" name="end_date" value="${endDate}">
                            <input type="hidden" name="format" value="excel">
                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Excel
                            </button>
                        </form>
                    `;

                    // Show results
                    document.getElementById('report-results').classList.remove('hidden');
                });
            });
        });
    </script>

</x-app-layout>
