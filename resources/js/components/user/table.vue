<template>
    <v-data-table
        :headers="headers"
        :items="users"
        item-key="name"
        class="elevation-1"
        :loading="loading"
        loading-text="Loading... Please wait"
    >
        <template v-slot:top>
            <v-toolbar flat>
                <v-toolbar-title>Profile</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-spacer></v-spacer>
                <v-dialog v-model="dialog" max-width="500px">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            color="primary"
                            dark
                            class="mb-2"
                            v-bind="attrs"
                            v-on="on"
                        >
                            New Item
                        </v-btn>
                    </template>
                    <v-card>
                        <v-card-title>
                            <span class="text-h5">{{ formTitle }}</span>
                        </v-card-title>

                        <v-card-text>
                            <v-form>
                                <v-select
                                    name="profile_name"
                                    v-model="editedItem.profile_name"
                                    :items="items"
                                    :error-messages="errorFor('profile_name')"
                                    label="Profile Name"
                                ></v-select>
                                <v-text-field
                                    name="profile_email"
                                    v-model="editedItem.user_email"
                                    label="Profile Email"
                                    :error-messages="errorFor('profile_email')"
                                ></v-text-field>
                                <v-text-field
                                    name="profile_phone"
                                    v-model="editedItem.user_phone"
                                    label="Mobile"
                                    :error-messages="errorFor('profile_phone')"
                                ></v-text-field>
                                <v-text-field
                                    name="profile_address"
                                    v-model="editedItem.user_address"
                                    label="Address"
                                    :error-messages="
                                        errorFor('profile_address')
                                    "
                                ></v-text-field>
                            </v-form>
                        </v-card-text>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" text @click="close">
                                Cancel
                            </v-btn>
                            <v-btn color="blue darken-1" text @click="save">
                                Save
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
                <v-dialog v-model="dialogDelete" max-width="500px">
                    <v-card>
                        <v-card-title class="text-h5"
                            >Are you sure you want to delete this
                            item?</v-card-title
                        >
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                color="blue darken-1"
                                text
                                @click="closeDelete"
                                >Cancel</v-btn
                            >
                            <v-btn
                                color="blue darken-1"
                                text
                                @click="deleteItemConfirm"
                                >OK</v-btn
                            >
                            <v-spacer></v-spacer>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-toolbar>
        </template>
        <template v-slot:item.actions="{ item }">
            <v-icon small class="mr-2" @click="editItem(item)">
                mdi-pencil
            </v-icon>
            <v-icon small @click="deleteItem(item)"> mdi-delete </v-icon>
        </template>
        <template v-slot:no-data>
            <v-btn color="primary" @click="initialize"> Reset </v-btn>
        </template>
    </v-data-table>
</template>
<script>

import ValidationErrors from "../../shared/mixins/ValidationErrors";
export default {
    mixins: [ValidationErrors],
    props: { userId: [String, Number] },
    data: () => ({
        dialog: false,
        dialogDelete: false,
        loading: false,
        headers: [
            {
                text: "#",
                align: "start",
                sortable: false,
                value: "id",
            },
            { text: "Profile", value: "profile" },
            { text: "Email", value: "email" },
            { text: "Mobile", value: "phone" },
            { text: "Address", value: "address" },

            { text: "Actions", value: "actions", sortable: false },
        ],
        users: [],
        editedIndex: -1,
        editedItem: {
            profile_name: "",
            user_email: "",
            user_phone: "",
            user_address: "",
        },
        defaultItem: {
            profile_name: "",
            user_email: "",
            user_phone: "",
            user_address: "",
        },
        items: ["public", "work", "private"],
    }),

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? "New Item" : "Edit Item";
        },
    },

    watch: {
        dialog(val) {
            val || this.close();
        },
        dialogDelete(val) {
            val || this.closeDelete();
        },
    },

    created() {
        this.initialize();
        console.log(this.$route.params.id);
    },

    methods: {
        initialize() {
            this.loading = true;
            axios
                .get(`/api/users`, { params: { id: this.$route.params.id } })
                .then((res) => {
                    this.users = res.data.data;
                })
                .catch((error) => {})
                .then(() => (this.loading = false));
        },

        editItem(item) {
            this.editedIndex = this.users.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialog = true;
        },

        deleteItem(item) {
            this.editedIndex = this.users.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialogDelete = true;
        },

        deleteItemConfirm() {
            this.users.splice(this.editedIndex, 1);
            this.closeDelete();
        },

        close() {
            this.dialog = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            });
        },

        closeDelete() {
            this.dialogDelete = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            });
        },

        async save() {
            if (this.editedIndex > -1) {
            } else {
                this.errors = null;
                try {
                    await axios.post("/api/users", this.editedItem);
                    this.initialize();
                    this.close();
                } catch (error) {
                    this.errors = error.response.data.errors;
                }
            }
        },
    },
};
</script>
