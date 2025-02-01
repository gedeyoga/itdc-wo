
import MinuteCounterList from "./components/minute-counter/MinuteCounterList";
import DetailMinuteCounter from "./components/minute-counter/DetailMinuteCounter";

export default [
    {
        path: "/history/minute-counter",
        name: "history.minute-counter.list",
        component: MinuteCounterList,
    },
    {
        path: "/history/minute-counter/detail/:location_installation_id",
        name: "history.minute-counter.detail",
        component: DetailMinuteCounter,
    },
];