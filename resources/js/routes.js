import Login from "./components/auth/LoginComponent.vue";
import Register from "./components/auth/RegisterComponent.vue";
import UserIndex from "./components/user/index.vue";
import UserTable from "./components/user/table.vue";
import AdminIndex from "./components/admin/index.vue";
import AdminTable from "./components/admin/table.vue";
export const routes = [
    {
        path: "/",
        redirect: "/login",
    },
    {
        path: "/login",
        name: "login",
        component: Login,
    },
    {
        path: "/register",
        name: "register",
        component: Register,
    },
    {
        path: "/user_index",
        name: "user_index",
        component: UserIndex,
        children: [
            {
                path: "/list",
                name: "list",
                component: UserTable,
            },
        ],
        beforeEnter: (to, from, next) => {
            if (localStorage.getItem("role")=== '0') {
                next();
            } else {
                next("/login");
            }
        },
    },
    {
        path: "/admin_index",
        name: "admin_index",
        component: AdminIndex,
        children: [
            {
                path: "/admin_table",
                name: "admin_table",
                component: AdminTable,
            },
        ],
        
        beforeEnter: (to, from, next) => {
            if (localStorage.getItem("role")=== '1') {
                next();
            } else {
                next("/login");
            }
        },
    },
];
