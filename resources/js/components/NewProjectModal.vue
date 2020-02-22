<template>
    <modal name="new-project" classes="card" height="auto">
        <h1 class="font-normal text-center mb-8 mt-3 text-2xl">Create new project</h1>

        <form @submit.prevent="submit">
            <div class="flex">
                <div class="flex-1 mr-4">

                    <div class="mb-4">
                        <label for="title" class="text-sm block mb-2">Title</label>
                        <input type="text" name="title" id="title"
                               class="border rounded p-2 text-xs block w-full"
                               :class="errors.title ? 'border-red-500' : 'border-gray-500'"
                               v-model="form.title"
                        required>
                        <span class="text-xs text-red-700 font-bold" v-if="errors.title" v-text="error.title[0]"></span>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="text-sm block mb-2">Description</label>
                        <textarea name="description" id="description" class="border border-gray-500 rounded p-2 text-xs block w-full" rows="7" v-model="form.description" ></textarea>
                    </div>

                </div>
                <div class="flex-1 ml-4">

                    <div class="mb-4">
                        <label class="text-sm block mb-2">Add some tasks</label>
                        <input type="text"  class="border border-gray-500 rounded mb-2 p-2 text-xs block w-full" placeholder="A task for this project" v-for="task in form.tasks" v-model="task.body">
                    </div>

                    <button type="button" class="inline-flex items-center text-xs" @click="addTask">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" class="mr-2">
                            <g fill="none" fill-rule="evenodd" opacity=".307">
                                <path stroke="#000" stroke-opacity=".012" stroke-width="0" d="M-3-3h24v24H-3z"></path>
                                <path fill="#000" d="M9 0a9 9 0 0 0-9 9c0 4.97 4.02 9 9 9A9 9 0 0 0 9 0zm0 16c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7zm1-11H8v3H5v2h3v3h2v-3h3V8h-3V5z"></path>
                            </g>
                        </svg>

                        <span>Add New Task Field</span>
                    </button>
                </div>
            </div>
            <footer class="flex justify-end">
                <button type="button" class="rounded-lg border p-4 bg-red-700 mr-3 text-white" @click="$modal.hide('new-project')">Cancel</button>
                <button type="submit" class="button" >Create</button>
            </footer>
        </form>

    </modal>
</template>

<script>
    import  BirdboardForm from './BirdboardForm';

    export default {
        data() {
            return{
                form: new BirdboardForm ({
                    title: '',
                    description: '',
                    tasks: [
                        {body: ''},
                    ]
                }),
                errors: {},
            };
        },

        methods: {
            addTask() {
                this.form.tasks.push({value: ''});
            },
            async submit() {
                this.form.submit('projects')
                    .then(response => location = response.data.message);

                // try {
                //    location = (await axios.post('/projects', this.form)).data.message;
                // } catch (error) {
                //     this.errors = error.response.data.errors;
                // }
            }
        }
    }
</script>
