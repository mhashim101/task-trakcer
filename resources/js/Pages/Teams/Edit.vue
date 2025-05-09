<script setup>
import { reactive } from 'vue';
import { useForm } from '@inertiajs/vue3';

// Props
const props = defineProps({
  team: Object, // Team details
  members: Array, // List of members
});

// Reactive form state
const form = useForm({
  name: props.team.name || '',
  team_lead_id: props.team.team_lead_id || null, // Default to null if not provided
  members: (props.team.members || []).map(member => member.id),
});

// Submit form
const updateTeam = () => {
  form.put(`/admin/teams/${props.team.id}`, {
    onSuccess: () => {
      alert('Team updated successfully!');
    },
    onError: (errors) => {
      console.error('Error updating team:', errors);
    },
  });
};
</script>

<template>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <h2 class="text-xl font-bold mb-4">Edit Team</h2>

          <form @submit.prevent="updateTeam" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label for="team-name" class="block text-sm font-medium text-gray-700">Team Name</label>
              <input
                type="text"
                id="team-name"
                v-model="form.name"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
              />
            </div>

            <div>
              <label for="team-lead" class="block text-sm font-medium text-gray-700">Team Lead</label>
              <select
  id="team-lead"
  v-model="form.team_lead_id"
  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
>
  <option v-for="member in members" :key="member.id" :value="member.id">
    {{ member.name }}
  </option>
</select>
            </div>

            <div class="col-span-2">
              <label for="team-members" class="block text-sm font-medium text-gray-700">Team Members</label>
              <select
                id="team-members"
                v-model="form.members"
                multiple
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
              >
                <option v-for="member in members" :key="member.id" :value="member.id">
                  {{ member.name }}
                </option>
              </select>
            </div>

            <div class="col-span-2 flex justify-end">
              <button
                type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition"
              >
                Update Team
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Add custom styles if needed */
</style>