<template>
    <div class="min-h-screen flex">
      <Sidebar />
  
      <div class="flex-1 flex flex-col overflow-hidden">
        <Navigation />
  
        <main class="flex-1 overflow-y-auto p-4">
          <slot />
        </main>
      </div>
    </div>
  </template>
  
  <script setup>
  import Sidebar from '@/Components/Sidebar.vue'
  import Navigation from '@/Layouts/Navigation.vue'
  </script>
  