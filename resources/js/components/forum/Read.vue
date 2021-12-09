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
        </div>
    </div>
</template>

<script>

import ShowQuestion from "./ShowQuestion"
import EditQuestion from "./EditQuestion";
    export default {
        components : {ShowQuestion , EditQuestion},
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
