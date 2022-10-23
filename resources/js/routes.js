import Login from "./components/auth/LoginComponent.vue";
import Register from "./components/auth/RegisterComponent.vue";
import Admin from "./components/admin/AdminComponent.vue";
import User from "./components/admin/UserComponent.vue";
import Profile from "./components/user/ProfileComponent.vue";
import AddUser from "./components/user/AddUser.vue"
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
        path: "/admin",
        name: "admin",
        component: Admin,
        children: [
            {
                path: "/user",
                name: "user",
                component: User,
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
        path: "/profile",
        name: "profile",
        component: Profile,
        children: [
            {
                path: "/adduser",
                name: "adduser",
                component: AddUser,
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
