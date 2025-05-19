import { useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";
import { fetchInsights } from "../redux/insightsThunks";
import InsightCard from "../components/InsightCard";
import RevenueChart from "../components/RevenueChart";

const AdminInsightsPage = () => {
  const dispatch = useDispatch();
  const { insight, dailyRevenue, loading, error } = useSelector(
    (state) => state.platformInsights
  );

  useEffect(() => {
    dispatch(fetchInsights('2025-06'));
  }, [dispatch]);

  return (
    <div className="grid gap-4 p-6">
      <h1 className="text-xl font-semibold">Platform Overview</h1>

      {loading && <div className="text-gray-500">Loading...</div>}

      {error && (
        <div className="text-red-600 bg-red-100 p-2 rounded">
          {error}
        </div>
      )}

      {insight && (
        <>
          <div className="grid grid-cols-3 gap-4">
            <InsightCard
              label="Total Revenue"
              value={`$${insight.total_revenue}`}
              growth={insight.revenue_growth_pct}
            />
            <InsightCard
              label="New Clients"
              value={insight.new_clients_count}
              growth={insight.clients_growth_pct}
            />
            <InsightCard
              label="Total Restaurants"
              value={insight.restaurants_count}
              growth={insight.restaurants_growth_pct}
            />
          </div>

          <div className="mt-6">
            <RevenueChart data={dailyRevenue} />
          </div>
        </>
      )}

      {!loading && !error && !insight && (
        <div className="text-gray-500">No data found.</div>
      )}
    </div>
  );
};

export default AdminInsightsPage;
