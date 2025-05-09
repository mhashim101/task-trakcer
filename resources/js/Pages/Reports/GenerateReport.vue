<script setup>
import { reactive, ref } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'

// Props
const props = defineProps({
  members: Array, // List of team members
  tasks: Array, // List of tasks
  period: Object, // Start and end date
  total_tasks: Number, // Total number of tasks
  completed_tasks: Number, // Number of completed tasks
  user: Object, // Current user with role information
})

console.log(props.user)

// User role constants
const ROLE_ADMIN = 1
const ROLE_TEAM_LEAD = 2

// Get current user role
const userRole = props.user?.role_id || ROLE_TEAM_LEAD // Default to team lead if no role specified

// Reactive state for the form - with role-specific defaults
const form = useForm({
  member_id: userRole === ROLE_ADMIN ? (props.members?.length > 0 ? props.members[0].id : null) : props.user?.id,
  start_date: props.period?.start,
  end_date: props.period?.end,
  // Admin can see all teams' data
  include_all_teams: userRole === ROLE_ADMIN ? true : false,
})

// Reactive state for report data
const reportData = ref({
  tasks: props.tasks || [],
  period: props.period || { start: '', end: '' },
  total_tasks: props.total_tasks || 0,
  completed_tasks: props.completed_tasks || 0,
  member: null
})

// Is member selector disabled?
const isMemberSelectorDisabled = userRole === ROLE_TEAM_LEAD

// Method to handle form submission with role-specific endpoints
const generateReport = () => {
  // Different endpoints based on user role
  const endpoint = userRole === ROLE_ADMIN 
    ? '/admin/analytics/generate-report' 
    : '/team-lead/analytics/generate-report'

    console.log(endpoint,'asd')
  
  form.post(endpoint, {
    preserveScroll: true,
    onSuccess: (response) => {
      // Update tasks and other data dynamically
      reportData.value = {
        tasks: response.props.tasks || [],
        period: response.props.period || { start: '', end: '' },
        total_tasks: response.props.total_tasks || 0,
        completed_tasks: response.props.completed_tasks || 0,
        member: response.props.member || null
      }
      console.log('Report generated successfully:', response.props)
    },
    onError: (errors) => {
      console.error('Error generating report:', errors)
    },
  })
}

// Admin-only method to export report as CSV
const exportReportCSV = () => {
  if (userRole !== ROLE_ADMIN) return
  
  window.location.href = `/admin/analytics/export-csv?member_id=${form.member_id}&start_date=${form.start_date}&end_date=${form.end_date}&include_all_teams=${form.include_all_teams}`
}

// Helper function to format status
const formatStatus = (status) => {
  return status.replace('_', ' ').charAt(0).toUpperCase() + status.replace('_', ' ').slice(1)
}

// Get status color class
const getStatusColorClass = (status) => {
  switch(status) {
    case 'completed':
      return 'bg-green-100 text-green-800'
    case 'in_progress':
      return 'bg-yellow-100 text-yellow-800'
    case 'pending':
      return 'bg-gray-100 text-gray-800'
    default:
      return 'bg-gray-100 text-gray-800'
  }
}

// Additional admin-only function to get team performance comparison
const getTeamPerformance = async () => {
  if (userRole !== ROLE_ADMIN) return
  
  try {
    const response = await fetch('/admin/analytics/team-performance', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({
        start_date: form.start_date,
        end_date: form.end_date
      })
    })
    
    const data = await response.json()
    console.log('Team performance data:', data)
    // Handle team performance data display logic here
  } catch (error) {
    console.error('Error fetching team performance:', error)
  }
}
</script>
<style scoped>
/* Add hover effects and modern styling */
button:hover {
  background-color: #2563eb;
}

button:disabled {
  background-color: #93c5fd;
  cursor: not-allowed;
}
</style>


<template>
  <div class="dashboard-container">
    <!-- Header Navigation -->
    <header class="bg-white p-4 flex items-center justify-between border-b">
      <div class="flex items-center">
        <div class="mr-2">
          <svg class="w-8 h-8 text-gray-800" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2L2 7L12 12L22 7L12 2Z" fill="currentColor" />
            <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" />
            <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" />
          </svg>
        </div>
        <span class="font-medium">Dashboard</span>
      </div>
      
      <div class="flex items-center">
        <span class="mr-2">{{ $page.props.auth.user.name }}</span>
        <button class="p-1">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </button>
      </div>
    </header>

    <div class="flex">
      <!-- Sidebar -->
      <div class="w-64 bg-gray-900 text-white h-screen">
        <div class="p-4 font-bold text-lg border-b border-gray-800">Task Tracker</div>
        
        <div class="py-4">
          <div class="px-4 text-xs text-gray-400 mb-2">DASHBOARD</div>
          <Link href="/dashboard" class="flex items-center px-4 py-2 hover:bg-gray-800">
            <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect x="3" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2" />
              <rect x="14" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2" />
              <rect x="3" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2" />
              <rect x="14" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2" />
            </svg>
            Dashboard
          </Link>
        </div>

        <div class="py-2">
          <div class="px-4 text-xs text-gray-400 mb-2">TEAM LEAD</div>
          <!-- <Link :href="route('team-lead.dashboard')" class="flex items-center px-4 py-2 bg-gray-800 hover:bg-gray-700">
            <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M17 21V19C17 16.7909 15.2091 15 13 15H5C2.79086 15 1 16.7909 1 19V21" stroke="currentColor" stroke-width="2" />
              <path d="M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11Z" stroke="currentColor" stroke-width="2" />
              <path d="M23 21V19C22.9986 17.1771 21.8242 15.5857 20.0673 15.1309" stroke="currentColor" stroke-width="2" />
              <path d="M16 3.13086C17.7602 3.58401 19 5.17543 19 7.00001C19 8.82458 17.7602 10.416 16 10.8691" stroke="currentColor" stroke-width="2" />
            </svg>
            Team Dashboard
          </Link> -->
          
          <Link href="/team-lead/tasks" class="flex items-center px-4 py-2 hover:bg-gray-800">
            <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M9 5H7C5.89543 5 5 5.89543 5 7V19C5 20.1046 5.89543 21 7 21H17C18.1046 21 19 20.1046 19 19V7C19 5.89543 18.1046 5 17 5H15" stroke="currentColor" stroke-width="2" />
              <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5C15 6.10457 14.1046 7 13 7H11C9.89543 7 9 6.10457 9 5Z" stroke="currentColor" stroke-width="2" />
              <path d="M9 12H15" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
              <path d="M9 16H15" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
            Manage Tasks
          </Link>
          
          <Link href="/team-lead/member-analytics" class="flex items-center px-4 py-2 hover:bg-gray-800">
            <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M18 20V10" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
              <path d="M12 20V4" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
              <path d="M6 20V14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
            Team Analytics
          </Link>
        </div>

        <div class="py-2">
          <div class="px-4 text-xs text-gray-400 mb-2">TASKS</div>
          <Link href="tasks/create" class="flex items-center px-4 py-2 hover:bg-gray-800">
            <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 5V19" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
              <path d="M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
            Create Task
          </Link>
          
          <Link href="/team-lead/tasks" method="get" class="flex items-center px-4 py-2 hover:bg-gray-800">
            <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M9 11L12 14L22 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M21 12V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V5C3 3.89543 3.89543 3 5 3H16" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
            My Tasks
          </Link>
        </div>

        <div class="py-2">
          <div class="px-4 text-xs text-gray-400 mb-2">REPORTS</div>
          <Link href="#" class="flex items-center px-4 py-2 hover:bg-gray-800">
            <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M14 2H6C4.89543 2 4 2.89543 4 4V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V8L14 2Z" stroke="currentColor" stroke-width="2" />
              <path d="M14 2V8H20" stroke="currentColor" stroke-width="2" />
              <path d="M16 13H8" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
              <path d="M16 17H8" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
              <path d="M10 9H9H8" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
            Generate Reports
          </Link>
          
          <!-- <Link :href="route('tasks.history')" class="flex items-center px-4 py-2 hover:bg-gray-800">
            <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
              <path d="M12 6V12L16 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
            </svg>
            Task History
          </Link> -->
        </div>
      </div>
      <!-- content -->

      <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <h2 class="text-xl font-bold mb-4">Generate Member Report</h2>

          <!-- Report Form -->
          <form @submit.prevent="generateReport" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
              <label for="member-select" class="block text-sm font-medium text-gray-700">Team Member</label>
              <select
                id="member-select"
                v-model="form.member_id"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
              >
                <option v-for="member in members" :key="member.id" :value="member.id">
                  {{ member.name }}
                </option>
              </select>
            </div>

            <div>
              <label for="start-date" class="block text-sm font-medium text-gray-700">Start Date</label>
              <input
                type="date"
                id="start-date"
                v-model="form.start_date"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
              />
            </div>

            <div>
              <label for="end-date" class="block text-sm font-medium text-gray-700">End Date</label>
              <input
                type="date"
                id="end-date"
                v-model="form.end_date"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
              />
            </div>

            <div class="col-span-2 flex justify-end">
              <button
                type="submit"
                class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition font-medium"
                :disabled="form.processing"
              >
                <span v-if="form.processing">Generating...</span>
                <span v-else>Generate Report</span>
              </button>
            </div>
          </form>

          <!-- Report Results -->
          <div v-if="reportData.tasks.length > 0" class="mt-8">
            <h3 class="text-lg font-medium mb-4">Report Results</h3>

            <!-- Summary Section -->
            <div class="bg-gray-50 p-6 rounded-lg mb-6 shadow-sm border border-gray-100">
              <div class="flex items-center justify-between mb-4">
                <h4 class="font-medium text-lg text-gray-800">Summary</h4>
                <span v-if="reportData.member" class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                  {{ reportData.member.name }}
                </span>
              </div>
              
              <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                  <p class="text-sm text-gray-500">Period</p>
                  <p class="font-medium">{{ reportData.period.start }} to {{ reportData.period.end }}</p>
                </div>
                
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                  <p class="text-sm text-gray-500">Total Tasks</p>
                  <p class="font-medium text-xl">{{ reportData.total_tasks }}</p>
                </div>
                
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                  <p class="text-sm text-gray-500">Completion Rate</p>
                  <div class="flex items-end gap-2">
                    <p class="font-medium text-xl">{{ reportData.completed_tasks }}</p>
                    <p class="text-sm text-gray-500">
                      ({{ reportData.total_tasks > 0 ? ((reportData.completed_tasks / reportData.total_tasks) * 100).toFixed(1) : 0 }}%)
                    </p>
                  </div>
                  
                  <!-- Progress bar -->
                  <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                    <div 
                      class="bg-blue-600 h-2.5 rounded-full" 
                      :style="{width: reportData.total_tasks > 0 ? `${(reportData.completed_tasks / reportData.total_tasks) * 100}%` : '0%'}"
                    ></div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Task Details Section -->
            <h4 class="font-medium text-lg mb-3 text-gray-800">Tasks</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
              <div
                v-for="task in reportData.tasks"
                :key="task.id"
                class="p-5 border rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 bg-white"
              >
                <div class="flex justify-between items-start mb-3">
                  <h4 class="font-medium text-lg text-gray-800">{{ task.title }}</h4>
                  <span :class="[getStatusColorClass(task.status), 'px-2 py-1 rounded-full text-xs font-medium']">
                    {{ formatStatus(task.status) }}
                  </span>
                </div>
                
                <div class="space-y-2 text-sm">
                  <div v-if="task.description" class="text-gray-600 mb-3">
                    {{ task.description }}
                  </div>
                  
                  <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <p class="text-gray-600">Assigned by: <span class="font-medium">{{ task.assigned_by?.name || 'N/A' }}</span></p>
                  </div>
                  
                  <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <p class="text-gray-600">Team: <span class="font-medium">{{ task.team?.name || 'N/A' }}</span></p>
                  </div>
                  
                  <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-gray-600">Due: <span class="font-medium">{{ task.due_date || 'N/A' }}</span></p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div v-else-if="form.processing" class="text-center py-12">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mx-auto"></div>
            <p class="mt-3 text-gray-600">Generating report...</p>
          </div>

          <div v-else class="text-center text-gray-500 mt-8 py-12 bg-gray-50 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <p class="mt-2">No tasks found for the selected period.</p>
            <p class="text-sm">Adjust the date range and try again.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

      <!-- end content -->
  
  </div>
  </div>
</template>