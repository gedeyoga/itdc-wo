
import UserList from "./components/UserList";
import UserForm from "./components/UserForm";
import Login from "./components/Login";
import ProfileForm from "./components/ProfileForm";

export default [
    {
        path: "/users/",
        name: "users.index",
        component: UserList,
    },
    {
        path: "/users/create",
        name: "users.create",
        component: UserForm,
    },
    {
        path: "/users/:user/edit",
        name: "users.edit",
        component: UserForm,
    },
    {
        path: "/users/:user/profile",
        name: "users.profile",
        component: ProfileForm,
    },
    {
        path: "/login/",
        name: "login",
        component: Login,
        meta: {
            layout: "full",
        },
    },
];