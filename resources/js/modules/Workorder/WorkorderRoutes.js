
import WorkorderList from "./components/WorkorderList";
import WorkOrderScan from "./components/WorkOrderScan";

export default [
    {
        path: "/work-order/",
        name: "work-order.list",
        component: WorkorderList,
    },
    {
        path: "/work-order/scan",
        name: "work-order.scan",
        component: WorkOrderScan,
        meta: {
            layout: "full",
        },
    },
];