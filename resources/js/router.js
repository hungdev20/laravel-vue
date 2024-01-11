import { createWebHistory, createRouter } from "vue-router";
import Login from "./pages/Login.vue";
import Register from "./pages/Register.vue";
import Dashboard from "./pages/Dashboard.vue";
import UserList from "./components/User/List.vue";
import AddUser from "./components/User/Add.vue";
import EditUser from "./components/User/Edit.vue";
import UserGroupList from "./components/UserGroup/List.vue";
import AddUserGroup from "./components/UserGroup/Add.vue";
import EditUsergroup from "./components/UserGroup/Edit.vue";

const routes = [
    {
        path: "/",
        name: "Home",
        component: Dashboard,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/login",
        name: "Login",
        component: Login,
        meta: {
            requiresAuth: false,
        },
    },
    {
        path: "/register",
        name: "Register",
        component: Register,
        meta: {
            requiresAuth: false,
        },
    },
    {
        path: "/dashboard",
        name: "Dashboard",
        component: Dashboard,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/users",
        name: "UserList",
        component: UserList,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/user/add",
        name: "AddUser",
        component: AddUser,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/user/:id",
        name: "EditUser",
        component: EditUser,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/usergroups",
        name: "UserGroupList",
        component: UserGroupList,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/usergroup/add",
        name: "AddUserGroup",
        component: AddUserGroup,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/usergroup/:id",
        name: "EditUsergroup",
        component: EditUsergroup,
        meta: {
            requiresAuth: true,
        },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from) => {
    if (to.meta.requiresAuth && !localStorage.getItem("token")) {
        return {
            name: "Login",
        };
    }
    if (to.meta.requiresAuth == false && localStorage.getItem("token")) {
        return { name: "Dashboard" };
    }
});

export default router;
