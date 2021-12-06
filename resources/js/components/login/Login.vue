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
        </v-container>
    </v-form>
<!--    <form @submit.prevent="login">-->

<!--        &lt;!&ndash; email input &ndash;&gt;-->
<!--        <input type="email" v-model="email" placeholder="Email">-->

<!--        &lt;!&ndash; password input &ndash;&gt;-->
<!--        <input type="password" v-model="password" placeholder="Password">-->

<!--        &lt;!&ndash; submit button &ndash;&gt;-->
<!--        <button type="submit">Submit</button>-->

<!--    </form>-->
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
        methods:{
            login(){
                User.login(this.form)
            }

        }
    }
</script>

<style>

</style>
