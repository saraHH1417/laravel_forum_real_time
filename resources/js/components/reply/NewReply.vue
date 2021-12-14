<template>
    <div class="mt-4">
        <vue-simplemde preview-class="markdown-body"  v-model="body"/>
        <v-btn dark color="green" @click="submitReply">Reply</v-btn>
    </div>
</template>

<script>
export default {
    props:['questionSlug'],
    data(){
        return {
            body:null
        }
    },
    methods:{
        submitReply(){
            axios.post(`/api/${this.questionSlug}/reply` , {body:this.body})
            .then(
                res => {
                    this.body = ''
                    EventBus.$emit('newReply', res.data.reply)
                    window.scrollTo(0,0)
                })
        }
    }
}

</script>

<style>

</style>
