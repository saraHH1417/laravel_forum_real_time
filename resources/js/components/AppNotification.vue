<template>
    <div class="text-xs-center">
        <v-menu offset-y>
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    color="primary"
                    dark
                    v-bind="attrs"
                    v-on="on"
                >
                    Alerts ({{unreadCount}})
                </v-btn>
            </template>
            <v-list>
                <div v-if="unread.length == 0 && read.length == 0 ">
                    <v-list-item>
                        <v-list-item-title>
                            No Alerts Available
                        </v-list-item-title>
                    </v-list-item>
                </div>
                <div v-else>
                    <v-list-item v-for="item in unread" :key="item.id">
                        <router-link :to="item.path">
                            <v-list-item-title @click="readNotifications(item)">{{ item.question }}</v-list-item-title>
                        </router-link>
                    </v-list-item>

                    <v-list-item v-for="item in read" :key="item.id">
                        <router-link :to="item.path">
                            <v-list-item-title>(seen) {{item.question}}</v-list-item-title>
                        </router-link>
                    </v-list-item>
                </div>
            </v-list>
        </v-menu>
    </div>
</template>

<script>
export default {
    data(){
        return {
            read:{},
            unread:{},
            unreadCount:0
        }

    },
    created(){
        if(User.loggedIn()){
            this.getNotifications()
        }
        Echo.private('App.Models.User.' + User.id())
            .notification((notification) => {
                this.unread.unshift(notification)
                this.unreadCount++
            });
    },
    methods: {
        getNotifications(){
            axios.post('/api/notifications/')
            .then(res => {
                this.read = res.data.read,
                this.unread = res.data.unread,
                this.unreadCount = res.data.unread.length
            })
            .catch(error => Exception.handle(error))
        },
        readNotifications(notification){
            axios.post('/api/markAsRead' , {id: notification.id})
                .then(res => {
                    this.unread.splice(notification,1)
                    this.read.push(notification)
                    this.unreadCount--
                })
        }
    },
    computed:{
        color(){
            return this.unreadCount > 0 ? 'red' : 'red lighten-4'
        },
    },




}
</script>

<style>

</style>
