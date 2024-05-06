<template>
    <section>
        <h1 class="mt-5 mb-4 text-center">Homeowner CSV upload</h1>
        <form @submit.prevent="upload" class="row mt-5">
            <div class="col-12 col-md-6 offset-md-2 form-group">
                <input type="file" ref="csv" class="form-control"> <br>
                <small v-if="state.errors.csv" id="error" class="form-text text-danger">
                    {{ state.errors.csv[0] }}
                </small>
            </div>
            <div class="col-12 col-md-2">
                <button type="submit" class="btn btn-success w-100 mt-2 mt-md-0">Upload</button>
            </div>
        </form>
        <div v-if="state.names.length" class="mt-5">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>title</th>
                        <th>first_name</th>
                        <th>inital</th>
                        <th>last_name</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="name in state.names">
                        <td>{{ name.title }}</td>
                        <td>{{ name.first_name }}</td>
                        <td>{{ name.initial }}</td>
                        <td>{{ name.last_name }}</td>
                    </tr>
                </tbody>
            </table>
            <button @click="clear" class="btn btn-warning mt-3 mb-5 mx-auto">Clear</button>
        </div>
    </section>
</template>

<script setup>
import { reactive, ref } from 'vue';

const state = reactive({
    names: [],
    errors: [],
})

const csv = ref(null)

const upload = async () => {
    state.errors = [];

    const form = new FormData;
    form.append('csv', csv.value.files[0])

    axios.post('/home-owners/import', form)
        .then((response) => {
            state.names = response.data.names;
        })
        .catch((error) => {
            state.errors = error.response.data.errors;
        })
}

const clear = async () => {
    state.names = [];
    state.errors = [];
}
</script>