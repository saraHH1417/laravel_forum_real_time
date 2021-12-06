<template>
    <v-card
        color="grey lighten-4"
        flat
        tile
    >
        <v-toolbar>
            <v-app-bar-nav-icon></v-app-bar-nav-icon>

            <v-toolbar-title>Title</v-toolbar-title>

            <v-spacer></v-spacer>
            <v-btn text>
                Forum
            </v-btn>

            <v-btn text>
                Ask Question
            </v-btn>

            <v-btn text>
                Category
            </v-btn>

            <router-link to="/login">
                <v-btn text>
                    Login
                </v-btn>
            </router-link>

        </v-toolbar>
    </v-card>
</template>
<script>

</script>

<style>

</style>
