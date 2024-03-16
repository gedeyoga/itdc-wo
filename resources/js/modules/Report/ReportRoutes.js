
import ReportDailyList from "./components/ReportDailyList";
import ReportMonthlyList from "./components/ReportMonthlyList";

export default [
    
    {
        path: "/report/daily",
        name: "report.daily",
        component: ReportDailyList,
    },
    {
        path: "/report/monthly",
        name: "report.monthly",
        component: ReportMonthlyList,
    },

];