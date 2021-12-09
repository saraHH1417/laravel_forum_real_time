<template>
    <v-container>
        <v-form @submit.prevent="create">
            <v-container>
                <v-row>
                    <v-text-field
                        v-model="form.title"
                        type="text"
                        label="Title"
                        required
                    ></v-text-field>
                    <v-select
                        v-model="form.category_id"
                        :items="categories"
                        item-text="name"
                        item-value="id"
                        label="Category"
                    ></v-select>
                </v-row>

                <vue-simplemde preview-class="markdown-body"  v-model="form.body"/>
                <v-btn color="green" type="submit" text>Create</v-btn>
            </v-container>
        </v-form>
    </v-container>
</template>

<script>
    export default {
        data() {
           return {
               form : {
                   title:null,
                   category_id:null,
                   body:null
               },
               categories:[],
               errors:{}
           }
        },
        created(){
            axios.get('/api/categories')
            .then(res => this.categories = res.data.data)
        },
        methods : {
            create(){
                axios.post('/api/questions' , this.form)
                .then(res => this.$router.push(res.data.path))
                .catch(error => this.errors = error.response.data.error)
            }
        }
    }
</script>
