<script setup>
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'

// Props
const props = defineProps({
  task: Object, // The task to be edited
  members: Array, // List of members
  teams: Object, // List of teams
})

// Form setup
const form = reactive({
  title: props.task.title || '',
  description: props.task.description || '',
  team_id: props.task.team_id || '', // Assuming team_id is fixed
  assigned_to: props.task.assigned_to || '',
  status: props.task.status || 'pending',
  due_date: props.task.due_date || '',
})

// Submit handler
const submit = () => {
  router.put(`/team-lead/tasks/${props.task.id}`, form, {
    onSuccess: () => {
      // Optionally redirect or show a success message
    },
  })
}
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

          <Link href="/team-lead/tasks" class="flex items-center px-4 py-2 hover:bg-gray-800">
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

      <div class="flex-1 py-12 px-6">
        <header class="bg-white p-4 flex items-center justify-between border-b">
          <h2 class="font-semibold text-xl text-gray-800">Edit Task</h2>
        </header>

        <div class="bg-white shadow-sm sm:rounded-lg p-6 mt-6">
          <form @submit.prevent="submit">
            <div class="mb-4">
              <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
              <input
                type="text"
                v-model="form.title"
                id="title"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                required
              />
            </div>

            <div class="mb-4">
              <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
              <textarea
                v-model="form.description"
                id="description"
                rows="3"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                required
              ></textarea>
            </div>

            <div class="mb-4">
  <label for="team_id" class="block text-sm font-medium text-gray-700">Team</label>
  <select
    v-model="form.team_id"
    id="team_id"
    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
  >
    <option v-for="team in props.teams" :key="team.id" :value="team.id">
      {{ team.name }}
    </option>
  </select>
</div>

            <div class="mb-4">
              <label for="assigned_to" class="block text-sm font-medium text-gray-700">Assigned To</label>
              <select
                v-model="form.assigned_to"
                id="assigned_to"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                required
              >
                <option
                  v-for="member in props.members"
                  :key="member.id"
                  :value="member.id"
                >
                  {{ member.name }}
                </option>
              </select>
            </div>

            <!-- <div class="mb-4">
              <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
              <select
                v-model="form.status"
                id="status"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                required
              >
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
              </select>
            </div> -->

            <div class="mb-4">
              <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
              <input
                type="date"
                v-model="form.due_date"
                id="due_date"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
              />
            </div>

            <div class="flex items-center justify-end space-x-4">
              <Link
                href="/team-lead/dashboard"
                class="bg-gray-500 text-white px-4 py-2 rounded"
              >
                Cancel
              </Link>
              <button
                type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded"
              >
                Update Task
              </button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</template>