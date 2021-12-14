<template>
    <div>
        <v-btn @click="likeIt" :color="color">
            favorite
        </v-btn> {{this.count}}
    </div>
</template>

<script>

    export default {
        props:['content'],
        data(){
            return {
                liked:this.content.liked,
                count:this.content.likes_count
            }
        },
        computed:{
           color(){
               return this.liked ? 'red' : 'red lighten-4';
           }
        },
        methods:{
            likeIt(){
                if(User.loggedIn()){
                    this.liked ? this.decr() : this.incr()
                    this.liked = !this.liked
                }
            },
            incr(){
                axios.post(`/api/reply/${this.content.id}/like`)
                .then(res => this.count ++)

            },
            decr(){
                axios.delete(`/api/reply/${this.content.id}/like`)
                .then(res => this.count --)
            }
        }
    }
</script>

<style>

</style>
