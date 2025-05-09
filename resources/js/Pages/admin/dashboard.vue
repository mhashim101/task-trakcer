<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import logo from '../../../../public/logo/svg_logo.svg';

// Props to receive data from the backend
defineProps({
    users: Array,
    teams: Array
});

// const sidebarOpen = ref(false);

// const toggleSidebar = () => {
//     sidebarOpen.value = !sidebarOpen.value;
// };

const deleteTeam = (id) => {
    if (confirm('Are you sure you want to delete this team?')) {
        router.delete(`/admin/teams/${id}`, {
            onSuccess: () => {
                alert('Team deleted successfully!');
            },
            onError: (errors) => {
                console.error('Error deleting team:', errors);
            },
        });
    }
};

const sidebarOpen = ref(false);
const showDropdown = ref(false);

// Toggle sidebar function for mobile menu
const toggleSidebar = () => {
  sidebarOpen.value = !sidebarOpen.value;
};

// Toggle dropdown function
const toggleDropdown = () => {
  showDropdown.value = !showDropdown.value;
};

// Close dropdown when clicking outside
const closeDropdown = (event) => {
  if (showDropdown.value) {
    showDropdown.value = false;
  }
};

// Setup click outside listener for dropdown
onMounted(() => {
  document.addEventListener('click', handleOutsideClick);
});

onUnmounted(() => {
  document.removeEventListener('click', handleOutsideClick);
});

const handleOutsideClick = (event) => {
  const dropdownElement = document.querySelector('.relative');
  if (dropdownElement && !dropdownElement.contains(event.target) && showDropdown.value) {
    showDropdown.value = false;
  }
};
</script>

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
                    <Link href="/admin/teams" class="flex items-center px-4 py-2 hover:bg-gray-800">
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
        <div class="flex items-center relative"> 
          <!-- User dropdown -->
          <div class="relative"> 
            <div @click="toggleDropdown" class="flex items-center cursor-pointer"> 
              <span class="mr-2 text-sm text-gray-700 hidden sm:inline">{{ $page.props.auth.user.name }}</span> 
              <button class="p-1 rounded-full text-gray-700 hover:bg-gray-100"> 
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> 
                  <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /> 
                </svg> 
              </button> 
            </div> 
            <!-- Dropdown menu -->
            <div v-if="showDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 z-50"> 
              <inertia-link href="/profile.edit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"> 
                Profile 
              </inertia-link> 
              <inertia-link href="/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"> 
                Settings 
              </inertia-link> 
              <div class="border-t border-gray-100"></div> 
              <Link href="/logout" method="post" as="button" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"> 
                Logout 
              </Link> 
            </div> 
          </div> 
        </div> 
      </div> 
    </div> 
  </header> 

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto bg-gradient-to-r from-indigo-50 via-purple-50 to-pink-50">
                <div class="max-w-7xl mx-auto py-6 sm:py-8 px-4 sm:px-6 lg:px-8">
                    <!-- Header with animated gradient -->
                    <div class="mb-6 md:mb-8 relative overflow-hidden rounded-lg md:rounded-xl bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 shadow-lg">
                        <div class="absolute inset-0 bg-grid-white/5 bg-[url('/grid.svg')]"></div>
                        <div class="relative px-4 sm:px-8 py-6 sm:py-10">
                            <h2 class="text-xl sm:text-3xl font-bold text-white tracking-tight">
                                Admin Dashboard
                            </h2>
                            <p class="mt-2 text-indigo-100 max-w-2xl text-sm sm:text-base">
                                Manage users and teams from a single dashboard
                            </p>
                        </div>
                    </div>

                    <!-- Dashboard Content -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
                        <!-- Users Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
                            <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                                <h3 class="text-base sm:text-lg font-medium text-gray-900 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                    </svg>
                                    <span class="hidden xs:inline">Users</span>
                                </h3>
                                <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-2 sm:px-3 py-1 rounded-full">
                                    {{ users.length }} Total
                                </span>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr class="bg-gray-50">
                                            <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Name
                                            </th>
                                            <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Email
                                            </th>
                                            <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Role
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-100">
                                        <tr v-for="user in users" :key="user.id" class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap flex items-center">
                                                <div class="h-6 w-6 sm:h-8 sm:w-8 rounded-full bg-gradient-to-r from-indigo-400 to-purple-400 flex items-center justify-center text-white font-medium mr-2 sm:mr-3">
                                                    {{ user.name.charAt(0) }}
                                                </div>
                                                <span class="font-medium text-gray-900 text-sm sm:text-base">{{ user.name }}</span>
                                            </td>
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-600">
                                                <span class="hidden sm:inline">{{ user.email }}</span>
                                                <span class="sm:hidden">{{ user.email.substring(0, 10) }}...</span>
                                            </td>
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                <span class="px-2 sm:px-3 py-1 rounded-full text-xs font-medium" 
                                                    :class="user.role?.name === 'Admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800'">
                                                    {{ user.role?.name || 'N/A' }}
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Teams Card -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
                            <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                                <h3 class="text-base sm:text-lg font-medium text-gray-900 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v1h8v-1zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-1a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v1h-3zM4.75 12.094A5.973 5.973 0 004 15v1H1v-1a3 3 0 013.75-2.906z" />
                                    </svg>
                                    <span class="hidden xs:inline">Team Leads</span>
                                </h3>
                                <div class="flex gap-1 sm:gap-2">
                                    <Link href="/teams" class="text-xs inline-flex items-center px-2 sm:px-3 py-1 rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors">
                                        Teams
                                    </Link>
                                    <Link href="/admin/teams/create" class="text-xs inline-flex items-center px-2 sm:px-3 py-1 rounded-md bg-indigo-500 text-white hover:bg-indigo-600 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="hidden sm:inline">Create</span>
                                    </Link>
                                </div>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr class="bg-gray-50">
                                            <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Name
                                            </th>
                                            <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Team Lead
                                            </th>
                                            <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-100">
                                        <tr v-for="team in teams" :key="team.id" class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-6 w-6 sm:h-8 sm:w-8 rounded-md bg-gradient-to-r from-pink-400 to-red-400 flex items-center justify-center text-white font-medium mr-2 sm:mr-3">
                                                        {{ team.name.charAt(0) }}
                                                    </div>
                                                    <span class="font-medium text-gray-900 text-sm sm:text-base">{{ team.name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-600">
                                                {{ team.teamLead.name }}
                                            </td>
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                                <div class="flex space-x-1 sm:space-x-2">
                                                    <Link :href="`/admin/teams/${team.id}/edit`"
                                                        class="group inline-flex items-center px-1 sm:px-2 py-1 border border-transparent rounded-md text-xs leading-4 font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-0 sm:mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                        <span class="hidden sm:inline">Edit</span>
                                                    </Link>
                                                    <button @click="deleteTeam(team.id)"
                                                        class="group inline-flex items-center px-1 sm:px-2 py-1 border border-transparent rounded-md text-xs leading-4 font-medium text-red-600 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-0 sm:mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        <span class="hidden sm:inline">Delete</span>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Analytics Preview Section -->
                    <div class="mt-6 sm:mt-8 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
                        <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-100 bg-gray-50">
                            <h3 class="text-base sm:text-lg font-medium text-gray-900 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                                </svg>
                                Quick Analytics
                            </h3>
                        </div>
                        <div class="p-4 sm:p-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                <div class="p-4 bg-gradient-to-br from-indigo-50 to-blue-50 rounded-lg border border-indigo-100">
                                    <div class="text-sm font-medium text-indigo-600 mb-1">Total Users</div>
                                    <div class="text-2xl font-bold text-gray-900">{{ users.length }}</div>
                                    <div class="text-xs text-gray-500 mt-1">Active accounts</div>
                                </div>
                                <div class="p-4 bg-gradient-to-br from-purple-50 to-pink-50 rounded-lg border border-purple-100">
                                    <div class="text-sm font-medium text-purple-600 mb-1">Teams</div>
                                    <div class="text-2xl font-bold text-gray-900">{{ teams.length }}</div>
                                    <div class="text-xs text-gray-500 mt-1">Active teams</div>
                                </div>
                                <div class="p-4 bg-gradient-to-br from-green-50 to-teal-50 rounded-lg border border-green-100 sm:col-span-2 md:col-span-1">
                                    <div class="text-sm font-medium text-green-600 mb-1">System Status</div>
                                    <div class="text-lg font-bold text-gray-900 flex items-center">
                                        <span class="h-2 w-2 rounded-full bg-green-500 mr-2"></span>
                                        Operational
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">All services running</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <!-- end content -->
    </div>
</template>