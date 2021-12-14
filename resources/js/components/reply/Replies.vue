<template>
    <div>
        <reply v-for="(reply , index) in content"
               v-if="content"
               :key="reply.id"
               :index=index
               :data="reply">

        </reply>
    </div>
</template>

<script>
import Reply from "./Reply"
export default {
    props : ['question'],
    components: {Reply},
    data(){
        return {
            content: this.question.replies
        }
    },
    created(){
        this.listen()
    },
    methods:{
        listen(){
            EventBus.$on('newReply' , (reply) => {
                this.content.unshift(reply)
            })
            EventBus.$on('deleteReply' , (index) => {
                axios.delete(`/api/${this.question.slug}/reply/${this.content[index].id}`)
                .then(res => this.content.splice(index, 1))
            })

        }
    }

}
</script>
<style>

</style>
