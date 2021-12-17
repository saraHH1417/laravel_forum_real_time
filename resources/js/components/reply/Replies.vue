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
            Echo.private('App.Models.User.' + User.id())
                .notification((notification) => {
                    this.content.unshift(notification.reply)
                });
            Echo.channel('likeChannel')
                .listen('LikeEvent', (e) => {
                    if(this.content.id == e.id){
                        e.type == 1 ? this.count++ : this.count--
                    }
                });
            Echo.channel('deleteReplyChannel')
            .listen('DeleteReplyEvent' , (e) => {
                for(let index =0 ; index < this.content.lenght ; index++){
                    if(this.content[index].id == e.id){
                        this.content.splice(index,1)
                    }
                }
            })

        }
    }

}
</script>
<style>

</style>
