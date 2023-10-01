<template>
    <Layout class="h-full w-full" :class="{ blur: addTaskRef }">
        <div class="mb-6 flex justify-between space-x-7 items-center">
            <div class="flex-col">
                <h3 class="text-base">Select project</h3>
                <select
                    name="projects"
                    class="p-2 rounded-lg bg-transparent ring-1 ring-slate-400 min-w-full"
                    @change="getTasks()"
                    v-model="selectedProjectId"
                >
                    <option
                        value=""
                        class="p-2 bg-slate-950/80"
                        selected
                        data-default
                    >
                        Select your option
                    </option>
                    <option
                        v-for="project in projects"
                        :key="project.id"
                        class="p-2 bg-slate-950/80"
                        :value="project.id"
                    >
                        {{ project.name }}
                    </option>
                </select>
            </div>
            <div v-if="selectedProject">
                <button
                    class="bg-transparent ring-2 inset-1 p-2 rounded-md ring-slate-400"
                    @click="showAddTask"
                >
                    ADD TASK
                </button>
            </div>
        </div>
        <div
            class="grid place-items-center space-y-6 max-w-3xl"
            v-if="selectedProject"
        >
            <ul
                v-for="priority in priorities"
                :key="priority.id"
                class="bg-slate-600 p-4 rounded-md space-y-2 w-full drop-zone max-w-3xl"
                @drop="drop($event, priority.id)"
                @dragenter.prevent
                @dragover.prevent
            >
                <li>{{ priority.name }}</li>

                <li
                    v-for="task in selectedProject.tasks.filter(
                        (task) => task.priority_id === priority.id
                    )"
                    :key="task.id"
                    class="p-2 w-full bg-slate-400 flex justify-between space-x-10 items-center"
                    draggable="true"
                    @dragstart="drag($event, task)"
                >
                    <div>
                        {{ task.title }}
                    </div>
                    <div class="flex justify-between space-x-4">
                        <a
                            @click.prevent="updateTask(task)"
                            class="text-blue-700 ring-blue-700 ring-1 p-2 rounded-md"
                            >Update</a
                        >
                        <a
                            @click.prevent="deleteTask(task.id)"
                            class="text-rose-500 ring-rose-500 ring-1 p-2 rounded-md"
                            >Delete</a
                        >
                    </div>
                </li>
            </ul>
        </div>
    </Layout>
    <div v-if="addTaskRef" class="fixed inset-0 grid place-items-center">
        <div class="bg-slate-900 rounded-md p-2">
            <TaskForm
                :selectedProject="selectedProjectId"
                :addTask="addTaskRef"
                :priorities="priorities"
                :updateTaskData="updateTaskData"
                @closeModel="
                    {
                        addTaskRef = false;
                        getTasks();
                    }
                "
                @cleanInputData="
                    {
                        updateTaskData = null;
                        getTasks();
                    }
                "
            ></TaskForm>
        </div>
    </div>
</template>

<script setup>
import Layout from "./Layout.vue";
import TaskForm from "./TaskForm.vue";
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    projects: Array,
    priorities: Array,
    addTask: {
        type: Boolean,
        required: false,
        default: false,
    },
});

let selectedProject = ref("");
let selectedProjectId = ref(null);
let addTaskRef = ref(props.addTask);
let updateTaskData = ref();

const getTasks = () => {
    selectedProject.value = props.projects.find(
        (project) => project.id === selectedProjectId.value
    );
};

const drag = (evt, items) => {
    evt.dataTransfer.dropEffect = "move";
    evt.dataTransfer.effectAllowed = "move";
    evt.dataTransfer.setData("itemId", items.id);
};

const drop = (evt, list) => {
    const itemId = evt.dataTransfer.getData("itemId");
    const item = selectedProject.value.tasks.find((task) => task.id == itemId);
    item.priority_id = list;

    router.visit(`task/priority/update/${item.id}`, {
        method: "patch",
        preserveState: true,
        preserveScroll: true,
        data: {
            id: item.id,
            priority_id: item.priority_id,
        },
    });
};

function showAddTask() {
    return (addTaskRef.value = !addTaskRef.value);
}

function updateTask(task) {
    addTaskRef.value = !addTaskRef.value;
    updateTaskData = task;
}

const deleteTask = (task) => {
    router.visit(`/task/delete/${task}`, {
        method: "delete",
        data: {
            csrf: window.Laravel.csrfToken,
        },
        preserveState: true,
        onSuccess: () => {
            getTasks();
        },
    });
};

watch(selectedProjectId, getTasks);
</script>

<style lang="scss" scoped></style>
