<template>
    <v-container fluid grid-list-md>
        <v-layout row wrap>
            <v-flex xs8>
                <question
                    v-for="question in questions"
                    :key="question.id"
                    :data=question
                >
                </question>
            </v-flex>
            Sidebar
        </v-layout>
    </v-container>
</template>

<script>
import Question from "./Question";

export default {
    data(){
        return {
            questions: {}
        }
    },
    components:{Question},
    created() {
        axios.get('api/questions')
        .then(res => this.questions = res.data.data)
        .catch(error => console.log(error.response.data))
    }
}
</script>
<style>

</style>
