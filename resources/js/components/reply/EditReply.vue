<template>
    <div>
        <h5>Edit Below</h5>
        <vue-simplemde preview-class="markdown-body"  v-model="reply.reply"/>
        <v-card-actions>
            <v-btn small class="green" @click="update">
                save
            </v-btn>

            <v-btn small class="blue" @click="cancel">
                cancel
            </v-btn>
        </v-card-actions>
    </div>
</template>

<script>
export default {
    props:['reply'],
    methods:{
        cancel(){
            EventBus.$emit('cancelEditing');
        },
        update(){
            axios.patch(`/api/${this.reply.question_slug}/reply/${this.reply.id}` , {body:this.reply.reply})
            .then(res => this.cancel())
        }
    }
}
</script>

<style>

</style>
