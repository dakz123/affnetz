<template>
    <v-app>
        <v-navigation-drawer v-model="drawer" fixed app>
            <v-list dense>
                <v-list-item to="profile">
                    <v-list-item-action>
                        <v-icon>mdi-home</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Home</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item @click="">
                    <v-list-item-action>
                        <v-icon>mdi-mail</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Contact</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item to="adduser" >
                    <v-list-item-action>
                        <v-icon>mdi-account-multiple</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Admin</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item @click="logout">
                    <v-list-item-action>
                        <v-icon>mdi-logout</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Logout</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar color="indigo" dark app>
            <v-app-bar-nav-icon @click.stop="drawer = !drawer">
            </v-app-bar-nav-icon>

            <v-toolbar-title>Admin Profile</v-toolbar-title>
        </v-app-bar>

        <!-- Sizes your content based upon application components -->
        <v-main>
            <!-- Provides the application the proper gutter -->
            <v-container fluid>
                <router-view></router-view>
                <!-- If using vue-router -->
                
            </v-container>
        </v-main>

        <v-footer app>
            <!-- -->
        </v-footer>
    </v-app>
</template>
<script>
export default {
    data() {
        return {
            drawer:null
        }
    },
    methods: {
        logout(){
            localStorage.removeItem('token');
            localStorage.removeItem('role');
            this.$router.push({name:'login'})
        }
    },
}
</script>