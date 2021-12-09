<template>
    <v-container fluid>
        <v-card>
            <v-form @submit.prevent="update">
                <v-text-field
                    v-model="form.title"
                    type="text"
                    label="Title"
                    required
                ></v-text-field>

                <vue-simplemde preview-class="markdown-body"  v-model="form.body"/>

                <v-card-actions>
                    <v-btn icon small style="margin:3vw" type="submit">
                        <v-icon color="teal">
                            Save
                        </v-icon>
                    </v-btn>
                    <v-btn icon small style="margin:3vw" @click="cancel">
                        <v-icon>
                            Cancel
                        </v-icon>
                    </v-btn>
                </v-card-actions>

            </v-form>
        </v-card>
    </v-container>
</template>
<script>
export default {
    props: ['data'],
    data(){
        return {
            form:{
                title:null,
                body:null
            }

        }
    },
    methods: {
        cancel(){
            EventBus.$emit('cancelEditing');
        },
        update(){
           axios.patch(`/api/questions/${this.form.slug}` , this.form)
            .then(res => this.cancel())
        }
    },
    created(){
        this.form= this.data
    }
}
</script>

<style>

</style>
