<script setup>
import { reactive, ref, watch } from 'vue'
import Chart from 'chart.js/auto'
import axios from 'axios'
import { Link } from '@inertiajs/vue3'

// Props
const props = defineProps({
  members: Array, // List of team members
  analyticsUrl: String, // Base URL for fetching analytics data
  user: Object, // Current user with role information
})

console.log(props.analyticsUrl, 'original analytics URL')
console.log(props.user, 'user object')

// User role constants
const ROLE_ADMIN = 1
const ROLE_TEAM_LEAD = 2

// Get current user role from role_id
const userRole = props.user?.role_id

// Determine the correct analytics URL based on role
const correctAnalyticsUrl = userRole === ROLE_ADMIN 
  ? props.analyticsUrl.replace('/team-lead/', '/admin/')
  : props.analyticsUrl

console.log(correctAnalyticsUrl, 'corrected analytics URL based on role')

// Reactive state for selected member and month
const state = reactive({
  selectedMember: props.members.length > 0 ? props.members[0].id : null,
  selectedMonth: new Date().toISOString().slice(0, 7), // Current month in YYYY-MM format
})

// Analytics data
const analytics = ref({
  stats: {
    completed_this_month: 0,
    pending: 0,
    in_progress: 0,
  },
  recent_completed: [],
  completion_trend: [],
})

// Chart instance
let completionChart = null

// Fetch analytics data with corrected URL
const fetchAnalytics = () => {
  if (!state.selectedMember) return

  const url = `${correctAnalyticsUrl}?member_id=${state.selectedMember}&month=${state.selectedMonth}`
  console.log('Fetching from:', url)

  axios.get(url).then((response) => {
    analytics.value = response.data
    updateChart(analytics.value.completion_trend)
  })
}

// Update chart with new data
const updateChart = (trendData) => {
  const ctx = document.getElementById('completionChart').getContext('2d')

  if (completionChart) {
    completionChart.destroy()
  }

  completionChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: trendData.map((item) => item.month),
      datasets: [
        {
          label: 'Tasks Completed',
          data: trendData.map((item) => item.count),
          backgroundColor: 'rgba(59, 130, 246, 0.5)',
          borderColor: 'rgba(59, 130, 246, 1)',
          borderWidth: 1,
        },
      ],
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1,
          },
        },
      },
    },
  })
}

// Generate correct URL for links based on role
const getCorrectUrl = (path) => {
  return userRole === ROLE_ADMIN 
    ? path.replace('/team-lead/', '/admin/') 
    : path
}

// Watch for changes in selected member or month
watch([() => state.selectedMember, () => state.selectedMonth], fetchAnalytics)

// Initial fetch
fetchAnalytics()
</script>
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
            <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round" />
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

          <Link href="#" class="flex items-center px-4 py-2 hover:bg-gray-800">
          <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M9 5H7C5.89543 5 5 5.89543 5 7V19C5 20.1046 5.89543 21 7 21H17C18.1046 21 19 20.1046 19 19V7C19 5.89543 18.1046 5 17 5H15"
              stroke="currentColor" stroke-width="2" />
            <path
              d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5C15 6.10457 14.1046 7 13 7H11C9.89543 7 9 6.10457 9 5Z"
              stroke="currentColor" stroke-width="2" />
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
            <path d="M9 11L12 14L22 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round" />
            <path d="M21 12V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V5C3 3.89543 3.89543 3 5 3H16"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" />
          </svg>
          My Tasks
          </Link>
        </div>

        <div class="py-2">
          <div class="px-4 text-xs text-gray-400 mb-2">REPORTS</div>
          <Link href="#" class="flex items-center px-4 py-2 hover:bg-gray-800">
          <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M14 2H6C4.89543 2 4 2.89543 4 4V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V8L14 2Z"
              stroke="currentColor" stroke-width="2" />
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

      <div>
      <div class="dashboard-container">
        <h2 class="text-xl font-bold mb-4">Team Member Analytics</h2>

        <!-- Member Selection -->
        <div class="mb-4">
          <label for="member-select" class="block text-sm font-medium text-gray-700">Select Team Member</label>
          <select id="member-select" v-model="state.selectedMember"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            <option v-for="member in members" :key="member.id" :value="member.id">
              {{ member.name }}
            </option>
          </select>
        </div>

        <!-- Month Selection -->
        <div class="mb-4">
          <label for="month-select" class="block text-sm font-medium text-gray-700">Select Month</label>
          <input type="month" id="month-select" v-model="state.selectedMonth"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
          <div class="bg-blue-50 p-4 rounded-lg">
            <h3 class="text-lg font-medium text-blue-800">Completed This Month</h3>
            <p id="completed-count" class="text-2xl font-bold text-blue-600">
              {{ analytics.stats.completed_this_month }}
            </p>
          </div>
          <div class="bg-yellow-50 p-4 rounded-lg">
            <h3 class="text-lg font-medium text-yellow-800">Pending Tasks</h3>
            <p id="pending-count" class="text-2xl font-bold text-yellow-600">
              {{ analytics.stats.pending }}
            </p>
          </div>
          <div class="bg-purple-50 p-4 rounded-lg">
            <h3 class="text-lg font-medium text-purple-800">In Progress</h3>
            <p id="in-progress-count" class="text-2xl font-bold text-purple-600">
              {{ analytics.stats.in_progress }}
            </p>
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
          <div id="recent-tasks">
            <div v-for="task in analytics.recent_completed" :key="task.id" class="p-3 bg-gray-50 rounded mb-2">
              <p class="font-medium">{{ task.title }}</p>
              <p class="text-sm text-gray-600">
                Completed on {{ new Date(task.updated_at).toLocaleDateString() }}
              </p>
            </div>
            <p v-if="analytics.recent_completed.length === 0" class="text-gray-500">
              No recently completed tasks
            </p>
          </div>
        </div>
      </div>
    </div>

    </div>
  </div>
</template>
