<template>
    <v-container>
        <v-form @submit.prevent="submit">
            <v-text-field
                label="Category Name"
                v-model="form.name"
                required
            >
            </v-text-field>
            <v-btn type="submit" color="pink" v-if="editSlug">Update</v-btn>
            <v-btn type="submit" color="teal" v-else>Create</v-btn>
        </v-form>

        <v-card>
            <v-toolbar color="indigo" dark dense>
                <v-toolbar-title>
                    Categories
                </v-toolbar-title>
            </v-toolbar>

            <v-list>
                <div v-for="(category, index) in categories" :key="category.id">
                    <v-list-item>
                        <v-list-item-action @click="edit(index)">
                            <v-btn small>
                                edit
                            </v-btn>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>
                                {{category.name}}
                            </v-list-item-title>
                        </v-list-item-content>
                        <v-list-item-action @click="destroy(category.slug , index)">
                            <v-btn small>
                                delete
                            </v-btn>
                        </v-list-item-action>
                    </v-list-item>
                    <v-divider></v-divider>
                </div>
            </v-list>
        </v-card>
    </v-container>
</template>

<script>
    export default {
        data(){
            return {
                form:{
                    name:null
                },
                categories:{},
                editSlug:null
            }
        },
        created(){
            if(! User.admin()){
                this.$router.push('/forum')
            }
            axios.get('/api/categories')
                .then(res => this.categories = res.data.data)
        },
        methods:{
            submit(){
                this.editSlug ? this.update() : this.create()
            },
            create(){
                axios.post('/api/categories' , this.form)
                    .then(res => {
                        this.categories.unshift(res.data.data)
                        this.form.name=null
                    })
            },
            update(){
                console.log(this.editSlug)
                axios.put(`/api/categories/${this.editSlug}` , this.form)
                    .then(res => {
                        this.categories.unshift(res.data.data)
                        this.editSlug = null
                        this.form.name=null
                    })
            },
            destroy(slug , index){
                axios.delete(`/api/categories/${slug}`)
                .then(res => this.categories.splice(index,1))
            },
            edit(index){
                this.form.name = this.categories[index].name
                this.editSlug = this.categories[index].slug
                this.categories.splice(index,1)
            },
        }
    }
</script>
<style>

</style>
