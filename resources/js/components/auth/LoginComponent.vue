<template>
    <v-app>
        <v-main>
            <v-container fluid fill-height>
                <v-layout justify-center align-center>
                    <v-flex xs12 sm8 md4>
                        <v-card class="elevation-12">
                            <v-card-text>
                                <v-form>
                                    <v-text-field
                                        name="username"
                                        label="UserName"
                                        v-model="username"
                                        prepend-icon="mdi-account"
                                        :error-messages="errorFor('username')"
                                    ></v-text-field>
                                    <v-text-field
                                        name="password"
                                        label="Password"
                                        type="password"
                                        prepend-icon="mdi-lock"
                                        v-model="password"
                                        :error-messages="errorFor('password')"
                                    ></v-text-field>
                                </v-form>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="primary" block dark @click.prevent="login">Login</v-btn>
                            </v-card-actions>
                            <v-spacer></v-spacer>
                            <v-card-subtitle>
                                <h5>
                                    No account yet?
                                    <router-link :to="{name:'register'}">Register</router-link>
                                </h5>
                                <h5>
                                    Password forgotten?
                                    <router-link to=""
                                        >Reset Password</router-link
                                    >
                                </h5>
                            </v-card-subtitle>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-main>
    </v-app>
</template>
<script>
import ValidationErrors from '../../shared/mixins/ValidationErrors'
export default {
    mixins:[ValidationErrors],
    data() {
        return {
            username: null,
            password: null,
            loading: false,
        };
    },
    methods: {
        async login() {
            this.loading = true;
            this.errors=null
            try {
                const response=(await axios.post('/api/login',{
                   username:this.username,
                   password:this.password 
                })).data;
                console.log(response.token);
                localStorage.setItem('token',response.token);
                localStorage.setItem('role',response.role);
                if(response.role === 1){
                    this.$router.push({name:'profile'});    
                }else if(response.role === 0)
                {
                    this.$router.push({name:'admin'});
                     
                   
                }
                
            } catch (error) {
               this.errors=error.response && error.response.data.errors
            }

            this.loading = false;
        },
    },
};
</script>
