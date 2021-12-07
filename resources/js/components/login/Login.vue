<template>
    <v-form @submit.prevent="login">
        <v-container>
            <v-row>
                <v-text-field
                    v-model="form.email"
                    type="email"
                    label="E-mail"
                    required
                ></v-text-field>

                <v-text-field
                    v-model="form.password"
                    label="Password"
                    type="password"
                    required
                ></v-text-field>
            </v-row>
            <v-btn
                color="green"
                type="submit">
                Login
            </v-btn>

            <router-link to="/signup">
                <v-btn color="blue" text>Sign Up</v-btn>
            </router-link>
        </v-container>
    </v-form>
</template>

<script>
    export default {
        data(){
            return {
                form: {
                    email: null,
                    password: null,
                }
            }
        },
        created(){
            if(User.loggedIn()){
                this.$router.push({name : 'forum'})
            }
        },
        methods:{
            login(){
                User.login(this.form)
                this.$router.push({name :'forum'})
            }

        }
    }
</script>

<style>

</style>
