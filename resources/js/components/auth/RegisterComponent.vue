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
                                        name="first_name"
                                        label="First Name"
                                        prepend-icon="mdi-account"
                                        :error-messages="errorFor('first_name')"
                                        v-model="user.first_name"
                                    ></v-text-field>
                                    <v-text-field
                                        name="last_name"
                                        label="Last Name"
                                        prepend-icon="mdi-account"
                                        :error-messages="errorFor('last_name')"
                                        v-model="user.last_name"
                                    ></v-text-field>
                                    <v-text-field
                                        name="username"
                                        label="User Name"
                                        prepend-icon="mdi-email"
                                        :error-messages="errorFor('username')"
                                        v-model="user.username"
                                    ></v-text-field>
                                    <v-text-field
                                        name="password"
                                        label="Password"
                                        type="password"
                                        prepend-icon="mdi-lock"
                                        :error-messages="errorFor('password')"
                                        v-model="user.password"
                                    ></v-text-field>
                                    <v-text-field
                                        name="password_confirmation"
                                        label="Password Confirmation"
                                        type="password"
                                        prepend-icon="mdi-lock"
                                        v-model="user.password_confirmation"
                                    ></v-text-field>
                                </v-form>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="primary" block dark @click.prevent="register"
                                    >Register</v-btn
                                >
                            </v-card-actions>
                            <v-spacer></v-spacer>
                            <v-card-subtitle>
                                <h5>
                                    Already have an account?
                                    <router-link :to="{ name: 'login' }"
                                        >Login</router-link
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
import axios from "axios";
import ValidationErrors from "../../shared/mixins/ValidationErrors";
export default {
    mixins:[ValidationErrors],
    data() {
        return {
            user: {
                first_name: null,
                last_name: null,
                username: null,
                password: null,
                password_confirmation: null,
            },
            loading: false,
        };
    },
    methods: {
        async register() {
            this.loading = true;
            this.errors = null;
            try {
                const response = (await axios.post("/api/register", this.user))
                    .data;
                localStorage.setItem("token", response.token);
                this.$router.push({ name: "admin" });
            } catch (error) {
                this.errors = error.response && error.response.data.errors;
            }
            this.loading = false;
        },
    },
};
</script>
