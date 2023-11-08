
import RoleList from "./components/RoleList";
import RoleForm from "./components/RoleForm";

export default [
    {
        path: "/roles/",
        name: "roles.index",
        component: RoleList,
    },
    {
        path: "/roles/create",
        name: "roles.create",
        component: RoleForm,
    },
    {
        path: "/roles/:role/edit",
        name: "roles.edit",
        component: RoleForm,
    },
];