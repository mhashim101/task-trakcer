<script setup>
import { Head, Link } from '@inertiajs/vue3';
// import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
  teams: Array
});
</script>

<style scoped>
/* Add custom styles if needed */
</style>

<template>
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar - Mobile overlay -->
        <div v-if="sidebarOpen" @click="toggleSidebar" class="fixed inset-0 bg-gray-600 bg-opacity-75 z-30 md:hidden transition-opacity"></div>
        
        <!-- Sidebar -->
        <aside :class="[
            'bg-gray-900 text-white flex-shrink-0 z-40 transition-all duration-300 ease-in-out',
            sidebarOpen ? 'fixed inset-y-0 left-0 w-64' : 'fixed -left-64 w-64 md:left-0 md:relative']">
            <div class="flex h-16 items-center justify-between px-4 border-b border-gray-800">
                <div class="flex items-center">
                    <svg class="w-8 h-8 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L2 7L12 12L22 7L12 2Z" fill="currentColor" />
                        <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" />
                        <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" />
                    </svg>
                    <span class="ml-2 font-bold">Task Tracker</span>
                </div>
                <button @click="toggleSidebar" class="md:hidden text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="overflow-y-auto h-full pb-20">
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
                    <Link href="/amin/teams" class="flex items-center px-4 py-2 hover:bg-gray-800">
                        <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 5H7C5.89543 5 5 5.89543 5 7V19C5 20.1046 5.89543 21 7 21H17C18.1046 21 19 20.1046 19 19V7C19 5.89543 18.1046 5 17 5H15" stroke="currentColor" stroke-width="2" />
                            <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5C15 6.10457 14.1046 7 13 7H11C9.89543 7 9 6.10457 9 5Z" stroke="currentColor" stroke-width="2" />
                            <path d="M9 12H15" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                            <path d="M9 16H15" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                        Manage teams
                    </Link>
                    
                    <Link href="/admin/member-analytics" class="flex items-center px-4 py-2 hover:bg-gray-800">
                        <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 20V10" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                            <path d="M12 20V4" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                            <path d="M6 20V14" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                        Team Analytics
                    </Link>
                </div>

                <!-- <div class="py-2">
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
                </div> -->

                <div class="py-2">
                    <div class="px-4 text-xs text-gray-400 mb-2">REPORTS</div>
                    <Link href="/admin/analytics/generate-report" class="flex items-center px-4 py-2 hover:bg-gray-800">
                        <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 2H6C4.89543 2 4 2.89543 4 4V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V8L14 2Z" stroke="currentColor" stroke-width="2" />
                            <path d="M14 2V8H20" stroke="currentColor" stroke-width="2" />
                            <path d="M16 13H8" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                            <path d="M16 17H8" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                            <path d="M10 9H9H8" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                        Generate Reports
                    </Link>
                </div>
            </div>
        </aside>

        <!-- Main Content Container -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header Navigation -->
            <header class="bg-white shadow-sm z-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <!-- Mobile menu button -->
                            <button @click="toggleSidebar" class="md:hidden p-2 rounded-md text-gray-700 hover:bg-gray-100">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                            <div class="ml-2 md:ml-0">
                                <h1 class="text-lg font-semibold text-gray-900">Dashboard</h1>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <span class="mr-2 text-sm text-gray-700 hidden sm:inline">{{ $page.props.auth.user.name }}</span>
                            <button class="p-1 rounded-full text-gray-700 hover:bg-gray-100">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <Head title="Teams" />

<!-- <AuthenticatedLayout> -->
  <!-- <template #header> -->
    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Teams</h2>
      <Link
        href="/admin/teams/create"
        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition"
      >
        Add Team
      </Link>
    </div>
  <!-- </template> -->

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <!-- Teams Table -->
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Name
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Description
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Team Lead
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Created At
                  </th>
                  <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Actions
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="team in teams" :key="team.id">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <Link :href="`/admin/teams/${team.id}`" class="text-blue-600 hover:underline">
                      {{ team.name }}
                    </Link>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ team.description }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ team.team_lead_id }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ new Date(team.created_at).toLocaleDateString() }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <Link :href="`/teams/${team.id}/edit`" class="text-indigo-600 hover:text-indigo-900 mr-4">
                      Edit
                    </Link>
                    <button 
                      @click="deleteTeam(team.id)" 
                      class="text-red-600 hover:text-red-900"
                    >
                      Delete
                    </button>
                  </td>
                </tr>
                <tr v-if="teams.length === 0">
                  <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                    No teams found.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
            <!-- end content -->
        </div>
    </div>
</template>