<template>
    <div v-if="question">
        <div v-if="editing">
            <edit-question
                :data=question
            >
            </edit-question>
        </div>
        <div v-else>
            <show-question
                :data = question
            >
            </show-question>

            <v-container>
                <replies :question="question"></replies>
                <h5>Add Reply</h5>
                <new-reply v-if="loggedIn" :questionSlug="question.slug"></new-reply>
                <div class="mt-4">
                    <router-link to="/login">
                        Login to reply
                    </router-link>
                </div>
            </v-container>
        </div>
    </div>
</template>

<script>

import ShowQuestion from "./ShowQuestion"
import EditQuestion from "./EditQuestion"
import Replies from "../reply/Replies"
import NewReply from "../reply/NewReply"
    export default {
        components : {ShowQuestion , EditQuestion , Replies , NewReply},
        data(){
            return {
                question:null,
                editing:false
            }
        },
        created(){
            this.listen(),
            this.getQuestion()
        },
        computed:{
            loggedIn(){
                return User.loggedIn()
            }
        },
        methods:{
            listen(){
                EventBus.$on('startEditing' , ()=> {
                    this.editing = true
                })
                EventBus.$on('cancelEditing' , ()=> {
                    this.editing = false
                })
            },
            getQuestion(){
                axios.get(`/api/questions/${this.$route.params.slug}`)
                .then(res => this.question = res.data.data)
            }
        }
    }
</script>

<style>

</style>
