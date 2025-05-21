import React from "react";
import {
  LineChart,
  Line,
  XAxis,
  YAxis,
  Tooltip,
  ResponsiveContainer,
  PieChart,
  Pie,
  Cell,
} from "recharts";

const Dashboard = () => {
  // Dummy data
  const orderData = [
    { day: "Mon", orders: 2100 },
    { day: "Tue", orders: 4300 },
    { day: "Wed", orders: 6500 },
    { day: "Thu", orders: 3200 },
    { day: "Fri", orders: 7800 },
    { day: "Sat", orders: 9200 },
    { day: "Sun", orders: 6100 },
  ];

  const revenueData = [
    { name: "Completed", value: 75 },
    { name: "Pending", value: 15 },
    { name: "Cancelled", value: 10 },
  ];

  const COLORS = ["#FF8127", "#FFA726", "#FFCC80"];

  return (
    <div style={styles.container}>
      {/* Sidebar */}
      <div style={styles.sidebar}>
        <div style={styles.profileSection}>
          <h2 style={styles.companyName}>SmartDine</h2>
          <div style={styles.userInfo}>
            <h3 style={styles.userName}>Alex Johnson</h3>
            <p style={styles.userRole}>Support Admin</p>
          </div>
        </div>

        <nav style={styles.navSection}>
          <h4 style={styles.navTitle}>Dashboard</h4>
          <ul style={styles.navList}>
            {["Orders", "Food Menu", "Riders", "Restaurant", "Report", "Message"].map(
              (item) => (
                <li key={item} style={styles.navItem}>
                  {item}
                </li>
              )
            )}
          </ul>

          <h4 style={styles.navTitle}>Others</h4>
          <ul style={styles.navList}>
            {["Marketing", "Support"].map((item) => (
              <li key={item} style={styles.navItem}>
                {item}
              </li>
            ))}
          </ul>
        </nav>
      </div>

      {/* Main Content */}
      <div style={styles.mainContent}>
        {/* Stats Row */}
        <div style={styles.statsContainer}>
          <StatCard title="Total Restaurant" value="10,000" change="+17%" />
          <StatCard title="Total Revenue" value="$87,363" change="+11%" />
          <StatCard title="New Customers" value="120" change="-15%" />
        </div>

        {/* Order Analytics */}
        <div style={styles.chartCard}>
          <div style={styles.chartHeader}>
            <div>
              <h3 style={styles.chartTitle}>Order Analytics</h3>
              <p style={styles.chartSubtitle}>12,120.00 (+15%) /Month</p>
            </div>
            <div style={styles.filterContainer}>
              <select style={styles.filterSelect}>
                <option>All Vendor</option>
              </select>
              <select style={styles.filterSelect}>
                <option>Completed</option>
              </select>
              <select style={styles.filterSelect}>
                <option>Monthly</option>
              </select>
            </div>
          </div>
          <div style={{ height: 300 }}>
            <ResponsiveContainer width="100%" height="100%">
              <LineChart data={orderData}>
                <XAxis dataKey="day" />
                <YAxis />
                <Tooltip />
                <Line
                  type="monotone"
                  dataKey="orders"
                  stroke="#FF8127"
                  strokeWidth={2}
                />
              </LineChart>
            </ResponsiveContainer>
          </div>
        </div>

        {/* Revenue Profile */}
        <div style={styles.chartCard}>
          <div style={styles.chartHeader}>
            <div>
              <h3 style={styles.chartTitle}>Revenue Profile</h3>
              <p style={styles.chartSubtitle}>$25,843.45 (+11%) /Month</p>
              <p style={styles.performanceText}>
                Your performance is excellent (50%)
              </p>
            </div>
          </div>
          <div style={{ height: 300, textAlign: "center" }}>
            <ResponsiveContainer width="100%" height="100%">
              <PieChart>
                <Pie
                  data={revenueData}
                  cx="50%"
                  cy="50%"
                  innerRadius={60}
                  outerRadius={80}
                  paddingAngle={5}
                  dataKey="value"
                >
                  {revenueData.map((entry, index) => (
                    <Cell
                      key={`cell-${index}`}
                      fill={COLORS[index % COLORS.length]}
                    />
                  ))}
                </Pie>
                <Tooltip />
              </PieChart>
            </ResponsiveContainer>
          </div>
        </div>
      </div>
    </div>
  );
};

const StatCard = ({ title, value, change }) => (
  <div style={styles.statCard}>
    <h4 style={styles.statTitle}>{title}</h4>
    <div style={styles.statValueContainer}>
      <span style={styles.statValue}>{value}</span>
      <span
        style={{
          ...styles.statChange,
          color: change.startsWith("+") ? "#38A169" : "#E53E3E",
        }}
      >
        {change}
      </span>
    </div>
    <p style={styles.statSubtext}>/Month</p>
  </div>
);

// Styles
const styles = {
  container: {
    display: "flex",
    minHeight: "100vh",
    backgroundColor: "#F8FAFC",
  },
  sidebar: {
    width: "280px",
    backgroundColor: "#FFFFFF",
    padding: "20px",
    boxShadow: "2px 0 8px rgba(0,0,0,0.1)",
  },
  mainContent: {
    flex: 1,
    padding: "30px",
  },
  profileSection: {
    marginBottom: "40px",
  },
  companyName: {
    color: "#FF8127",
    fontSize: "24px",
    marginBottom: "15px",
  },
  userInfo: {
    borderLeft: "3px solid #FF8127",
    paddingLeft: "15px",
  },
  userName: {
    fontSize: "18px",
    margin: "0 0 5px 0",
  },
  userRole: {
    color: "#718096",
    margin: 0,
  },
  navSection: {
    marginTop: "30px",
  },
  navTitle: {
    color: "#718096",
    fontSize: "14px",
    margin: "20px 0 10px 0",
  },
  navList: {
    listStyle: "none",
    padding: 0,
    margin: 0,
  },
  navItem: {
    padding: "12px",
    borderRadius: "8px",
    margin: "5px 0",
    cursor: "pointer",
    ":hover": {
      backgroundColor: "#FFF5EB",
      color: "#FF8127",
    },
  },
  statsContainer: {
    display: "grid",
    gridTemplateColumns: "repeat(auto-fit, minmax(300px, 1fr))",
    gap: "20px",
    marginBottom: "30px",
  },
  statCard: {
    backgroundColor: "white",
    padding: "20px",
    borderRadius: "12px",
    boxShadow: "0 2px 8px rgba(0,0,0,0.1)",
  },
  statTitle: {
    color: "#718096",
    fontSize: "14px",
    margin: "0 0 10px 0",
  },
  statValueContainer: {
    display: "flex",
    alignItems: "baseline",
    gap: "10px",
    marginBottom: "5px",
  },
  statValue: {
    fontSize: "28px",
    fontWeight: "600",
    color: "#1A202C",
  },
  statChange: {
    fontSize: "14px",
    fontWeight: "500",
  },
  statSubtext: {
    color: "#A0AEC0",
    margin: 0,
    fontSize: "14px",
  },
  chartCard: {
    backgroundColor: "white",
    padding: "20px",
    borderRadius: "12px",
    boxShadow: "0 2px 8px rgba(0,0,0,0.1)",
    marginBottom: "30px",
  },
  chartHeader: {
    display: "flex",
    justifyContent: "space-between",
    alignItems: "center",
    marginBottom: "20px",
  },
  chartTitle: {
    fontSize: "18px",
    margin: "0 0 5px 0",
    color: "#1A202C",
  },
  chartSubtitle: {
    color: "#718096",
    margin: "0 0 5px 0",
    fontSize: "14px",
  },
  performanceText: {
    color: "#38A169",
    margin: 0,
    fontSize: "14px",
  },
  filterContainer: {
    display: "flex",
    gap: "10px",
  },
  filterSelect: {
    padding: "8px 12px",
    borderRadius: "6px",
    border: "1px solid #E2E8F0",
    backgroundColor: "white",
    color: "#1A202C",
  },
};

export default Dashboard;
