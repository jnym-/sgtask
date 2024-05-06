<template>
    <section>
        <form @submit.prevent="upload">
            <h1>Homeowner CSV upload</h1>
            <div class="form-group">
                <input type="file" ref="csv"> <br>
                <small v-if="state.errors.csv" id="error">
                    {{ state.errors.csv[0] }}
                </small>
            </div>
            <button type="submit">Upload</button>
        </form>
        <div v-if="state.names.length">
            <table>
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
            <button @click="clear">Clear</button>
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