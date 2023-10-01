<template>
    <h1 class="text-3xl text-center py-8">Task Manager</h1>
    <section class="flex items-center">
        <TaskList :projects="projects" :priorities="priorities"></TaskList>
    </section>
</template>

<script setup>
import TaskList from "../Components/TaskList.vue";

const props = defineProps({
    projects: Array,
    priorities: Array,
});
</script>
