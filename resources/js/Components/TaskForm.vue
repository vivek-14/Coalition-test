<template>
    <div>
        <h1></h1>
        <form @submit.prevent="formSubmit" class="p-4 space-y-6">
            <input type="hidden" name="_token" :value="csrfToken" />
            <div>
                <label
                    for="title"
                    class="block text-md font-medium leading-6 mb-2 text-base"
                    >Title</label
                >
                <div class="mt-2">
                    <input
                        v-model="form.title"
                        id="title"
                        name="title"
                        type="text"
                        autocomplete="Title"
                        class="block w-full rounded-md border-0 py-1.5 bg-transparent p-2 ring-1 ring-slate-400"
                    />
                </div>
                <div class="p-1 text-sm text-rose-400" v-if="form.errors.title">
                    {{ form.errors.title }}
                </div>
            </div>

            <div>
                <label
                    for="description"
                    class="block text-md font-medium leading-6 mb-2 text-base"
                    >Description</label
                >
                <textarea
                    v-model="form.description"
                    name="description"
                    class="block w-full rounded-md border-0 py-1.5 bg-transparent p-2 ring-1 ring-slate-400"
                    cols="50"
                    rows="3"
                ></textarea>
                <div
                    class="p-1 text-sm text-rose-400"
                    v-if="form.errors.description"
                >
                    {{ form.errors.description }}
                </div>
            </div>

            <div>
                <label
                    for="priority"
                    class="block text-md font-medium leading-6 mb-2"
                    >Select Priority</label
                >
                <select
                    v-model="form.priority_id"
                    name="priority"
                    class="block w-full rounded-md text-white p-2 bg-transparent ring-1 ring-slate-400"
                >
                    <option value="" selected class="p-2 bg-slate-950/80">
                        Select priority
                    </option>
                    <option
                        v-for="priority in priorities"
                        :key="priority.id"
                        :value="priority.id"
                        class="p-2 bg-slate-950/80"
                    >
                        {{ priority.name }}
                    </option>
                </select>
                <div
                    class="p-1 text-sm text-rose-400"
                    v-if="form.errors.priority_id"
                >
                    {{ form.errors.priority_id }}
                </div>
            </div>
            <input type="hidden" v-model="form.project_id" />
            <div class="mt-14 flex justify-between space-x-8">
                <button
                    type="submit"
                    class="w-full bg-green-800 p-2 rounded-md"
                >
                    Submit
                </button>
                <button
                    @click.prevent="closeModel"
                    type="button"
                    class="w-full bg-rose-800 p-2 rounded-md"
                >
                    Cancel
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { useForm, router } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    selectedProject: Number,
    addTask: Boolean,
    priorities: Array,
    updateTaskData: Object,
});

let currentProject = ref(props.selectedProject);
let updateTaskData = ref(props.updateTaskData);

const emits = defineEmits(["closeModel", "cleanInputData"]);
const closeModel = () => {
    emits("closeModel");
    emits("cleanInputData");
};

const csrfToken = ref(window.Laravel.csrfToken);

const form = useForm({
    title: updateTaskData.value ? updateTaskData.value.title : null,
    description: updateTaskData.value ? updateTaskData.value.description : null,
    priority_id: updateTaskData.value ? updateTaskData.value.priority_id : null,
    project_id: currentProject.value,
});

const formSubmit = () => {
    if (updateTaskData.value === null) {
        form.post(`/task/add`, {
            preserveState: true,
            onSuccess: () => emits("closeModel"),
        });
    } else {
        router.visit(`/task/update/${updateTaskData.value.id}`, {
            method: "patch",
            preserveState: true,
            data: form,
            onSuccess: () => {
                emits("closeModel");
                emits("cleanInputData");
            },
        });
    }
};
</script>
