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
            
            <Link href="#" class="flex items-center px-4 py-2 hover:bg-gray-800">
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
            
            <!-- <Link href="/team-lead/tasks" method="get" class="flex items-center px-4 py-2 hover:bg-gray-800">
              <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 11L12 14L22 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M21 12V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V5C3 3.89543 3.89543 3 5 3H16" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
              </svg>
              My Tasks
            </Link> -->
          </div>
  
          <div class="py-2">
            <div class="px-4 text-xs text-gray-400 mb-2">REPORTS</div>
            <Link href="/team-lead/analytics/generate-report" class="flex items-center px-4 py-2 hover:bg-gray-800">
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
  
        <!-- Main Content -->
        <div class="flex-1 p-6 bg-gray-100">
          <h1 class="text-2xl font-semibold mb-6">Team Lead Dashboard</h1>
          
          <div v-if="!team" class="bg-white p-6 rounded shadow-sm">
            <p>You are not assigned as a team lead for any team.</p>
          </div>
          
          <div v-else>
            <!-- Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
              <div class="bg-white p-6 rounded shadow-sm">
                <h3 class="text-lg font-medium mb-2">Team Members</h3>
                <div class="text-3xl font-bold">{{ members.length }}</div>
              </div>
              
              <div class="bg-white p-6 rounded shadow-sm">
                <h3 class="text-lg font-medium mb-2">Active Tasks</h3>
                <div class="text-3xl font-bold">{{ activeTasks.length }}</div>
              </div>
              
              <div class="bg-white p-6 rounded shadow-sm">
                <h3 class="text-lg font-medium mb-2">Completed Tasks</h3>
                <div class="text-3xl font-bold">{{ completedTasks.length }}</div>
              </div>
            </div>
            
            <!-- Team Members -->
            <div class="bg-white p-6 rounded shadow-sm mb-6">
              <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Team Members</h2>
                <button class="bg-blue-500 text-white px-3 py-1 rounded text-sm">Add Member</button>
              </div>
              
              <table class="w-full">
                <thead>
                  <tr class="text-left border-b">
                    <th class="pb-2">Name</th>
                    <th class="pb-2">Email</th>
                    <th class="pb-2">Role</th>
                    <th class="pb-2">Assigned Tasks</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-if="members.length === 0">
                    <td colspan="4" class="py-4 text-center text-gray-500">No team members found</td>
                  </tr>
                  <tr v-for="member in members" :key="member.id" class="border-b">
                    <td class="py-3">{{ member.name }}</td>
                    <td class="py-3">{{ member.email }}</td>
                    <td class="py-3">{{ member.role }}</td>
                    <td class="py-3">{{ memberTasks(member.id).length }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            
            <!-- Recent Tasks -->
            <div class="bg-white p-6 rounded shadow-sm">
              <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Recent Tasks</h2>
                <Link href="tasks/create" class="bg-blue-500 text-white px-3 py-1 rounded text-sm">Create Task</Link>
              </div>
              
              <table class="w-full">
                <thead>
                  <tr class="text-left border-b">
                    <th class="pb-2">Task</th>
                    <th class="pb-2">Assigned To</th>
                    <th class="pb-2">Due Date</th>
                    <th class="pb-2">Status</th>
                    <th class="pb-2">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-if="tasks.length === 0">
                    <td colspan="5" class="py-4 text-center text-gray-500">No tasks found</td>
                  </tr>
                  <tr v-for="task in recentTasks" :key="task.id" class="border-b">
                    <td class="py-3">{{ task.title }}</td>
                    <td class="py-3">{{ findMember(task.assigned_to).name }}</td>
                    <td class="py-3">{{ formatDate(task.due_date) }}</td>
                    <td class="py-3">
                      <span :class="statusClass(task.status)" class="px-2 py-1 rounded text-xs">
                        {{ task.status }}
                      </span>
                    </td>
                    <td class="py-3">
                      <Link :href="`/team-lead/tasks/${task.id}/edit`" class="text-blue-500 mr-2">Edit</Link>
                      <Link
  :href="`/team-lead/tasks/${task.id}`"
  method="delete"
  as="button"
  class="text-red-500"
  confirm="Are you sure you want to delete this task?"
>
  Delete
</Link>                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      
      </div>
    </div>
  </template>
  
  <script>
  import { Link } from '@inertiajs/vue3'
  // import { route } from 'ziggy-js';

  // import { route } from '../../../../vendor/tightenco/ziggy';
// import { route } from 'ziggy-js';
  
  export default {
    components: {
      Link
    },
    
    props: {
      team: Object,
      members: Array,
      tasks: Array
    },
    
    computed: {
      activeTasks() {
        return this.tasks ? this.tasks.filter(task => task.status !== 'completed') : []
      },
      
      completedTasks() {
        return this.tasks ? this.tasks.filter(task => task.status === 'completed') : []
      },
      
      recentTasks() {
        return this.tasks ? this.tasks.slice(0, 5) : [] // Get only 5 most recent tasks
      }
    },
    
    methods: {
      findMember(memberId) {
        if (!this.members) return { name: 'Unassigned' }
        const member = this.members.find(m => m.id === memberId)
        return member || { name: 'Unassigned' }
      },
      
      memberTasks(memberId) {
        if (!this.tasks) return []
        return this.tasks.filter(task => task.assigned_to === memberId)
      },
      
      formatDate(dateString) {
        const date = new Date(dateString)
        return date.toLocaleDateString()
      },
      
      statusClass(status) {
        const classes = {
          'completed': 'bg-green-100 text-green-800',
          'in_progress': 'bg-blue-100 text-blue-800',
          'pending': 'bg-yellow-100 text-yellow-800',
          'overdue': 'bg-red-100 text-red-800'
        }
        
        return classes[status] || 'bg-gray-100 text-gray-800'
      },
      
      deleteTask(taskId) {
        if (confirm('Are you sure you want to delete this task?')) {
          this.$inertia.delete(route('tasks.destroy', taskId))
        }
      }
    }
  }
  </script>