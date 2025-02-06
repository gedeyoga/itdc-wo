
import HistoryAssetList from "./components/history-asset/HistoryAssetList";
import DetailHistoryAsset from "./components/history-asset/DetailHistoryAsset";

export default [
    {
        path: "/history/history-asset",
        name: "history.history-asset.list",
        component: HistoryAssetList,
    },
    {
        path: "/history/history-asset/detail/:asset_master",
        name: "history.history-asset.detail",
        component: DetailHistoryAsset,
    },
];