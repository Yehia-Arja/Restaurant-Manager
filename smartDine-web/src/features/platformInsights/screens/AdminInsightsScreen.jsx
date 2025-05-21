import React from 'react';
import {
  AreaChart, Area, XAxis, YAxis, CartesianGrid, Tooltip, ResponsiveContainer,
  PieChart, Pie, Cell
} from 'recharts';

const AdminDashboard = () => {
  // Top stat data
  const stats = [
    { label: 'Total Restaurant', value: '10,000', percent: '+17%', trend: 'up' },
    { label: 'Total Revenue', value: '$87,363', percent: '+11%', trend: 'up' },
    { label: 'New Customers', value: '120', percent: '-15%', trend: 'down' },
  ];

  // Order performance donuts
  const performance = [
    { label: 'Total Order Completed', value: 82, color: '#34D399' },
    { label: 'Total Delivery Return', value: 10, color: '#FBBF24' },
    { label: 'Total Delivery Cancel', value: 40, color: '#F87171' },
  ];

  // Order analytics line data
  const orderAnalytics = Array.from({ length: 30 }, (_, i) => ({ date: i + 1, value1: Math.random() * 3000 + 500, value2: Math.random() * 2000 + 200 }));

  // Revenue profile data
  const revenueProfile = [
    { date: 'Jan 01', revenue: 5000 },
    { date: 'Jan 07', revenue: 10000 },
    { date: 'Jan 14', revenue: 20000 },
    { date: 'Jan 21', revenue: 35000 },
    { date: 'Jan 28', revenue: 45000 },
  ];

  // Recent order activities
  const activities = [
    { id: '#26839628288', restaurant: 'Al Baik Fast Food Shop', customer: 'Muhammed Fateh', date: '22 Dec 2024 at 11:20', items: 200, amount: '$5,576.90', status: 'Delivered' },
    { id: '#26839628289', restaurant: 'Taza Bukari House', customer: 'Mukarram Kazi', date: '22 Dec 2024 at 11:30', items: 1050, amount: '$5,576.90', status: 'Delivered' },
    { id: '#26839628290', restaurant: 'Al Tazaz Fast Food Shop', customer: 'Muhammad Khan', date: '22 Dec 2024 at 11:40', items: 300, amount: '$5,576.90', status: 'Delivered' },
  ];

  return (
    <div className="flex h-screen bg-gray-50">
      {/* Sidebar */}
      <aside className="w-64 bg-white shadow-md flex flex-col">
        <div className="px-6 py-4 border-b flex items-center">
          <img src="/logo.png" alt="WeEats" className="h-8 w-8 mr-2" />
          <span className="text-xl font-bold text-gray-800">WeEats</span>
        </div>
        <div className="px-6 py-4 border-b flex items-center">
          <img src="/avatar.jpg" alt="Kazi Mahbub" className="h-10 w-10 rounded-full mr-3" />
          <div>
            <div className="font-semibold">Kazi Mahbub</div>
            <div className="text-xs text-gray-500">Super Admin</div>
          </div>
        </div>
        <nav className="flex-1 px-4 py-6 space-y-1 text-sm">
          <NavItem label="Dashboard" active />
          <NavItem label="Orders" />
          <NavItem label="Food Menu" />
          <NavItem label="Riders" />
          <NavItem label="Restaurant" />
          <NavItem label="Report" />
          <NavItem label="Message" />
          <div className="mt-6 text-xs text-gray-400 uppercase">Others</div>
          <NavItem label="Marketing" />
          <NavItem label="Support" />
          <NavItem label="Settings" />
        </nav>
      </aside>

      {/* Main content */}
      <main className="flex-1 p-6 overflow-auto">
        {/* Top stats & performance */}
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
          {/* Stats cards */}
          <div className="lg:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4">
            {stats.map((s) => (
              <StatCard key={s.label} {...s} />
            ))}
          </div>

          {/* Performance donuts */}
          <div className="bg-white rounded-xl shadow p-4">
            <div className="flex justify-between items-center mb-4">
              <h3 className="text-lg font-semibold text-gray-800">Order Performance vs last month</h3>
              <select className="text-sm text-gray-500">
                <option>Month</option>
              </select>
            </div>
            <div className="flex justify-between">
              {performance.map((p) => (
                <PerfDonut key={p.label} {...p} />
              ))}
            </div>
          </div>
        </div>

        {/* Order Analytics & Revenue Profile */}
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
          {/* Analytics */}
          <div className="lg:col-span-2 bg-white rounded-xl shadow p-4">
            <div className="flex justify-between mb-2 items-center">
              <h3 className="text-lg font-semibold text-gray-800">Order Analytics</h3>
              <div className="space-x-4 text-xs text-gray-500">
                <span>Vendor: All Vendor</span>
                <span>Status: Completed</span>
                <select>
                  <option>Monthly</option>
                </select>
              </div>
            </div>
            <div className="text-2xl font-bold mb-1">12,120.00 <span className="text-sm text-green-500">+15%</span>/Month</div>
            <div className="text-gray-500 mb-4">Excellent job on your order 💪</div>
            <ResponsiveContainer width="100%" height={200}>
              <AreaChart data={orderAnalytics}>
                <CartesianGrid strokeDasharray="3 3" />
                <XAxis dataKey="date" />
                <YAxis />
                <Tooltip />
                <Area type="monotone" dataKey="value1" stroke="#3B82F6" fillOpacity={0.5} fill="#3B82F6" />
                <Area type="monotone" dataKey="value2" stroke="#9CA3AF" fillOpacity={0.2} fill="#9CA3AF" />
              </AreaChart>
            </ResponsiveContainer>
          </div>

          {/* Revenue Profile */}
          <div className="bg-white rounded-xl shadow p-4">
            <div className="flex justify-between items-center mb-2">
              <h3 className="text-lg font-semibold text-gray-800">Revenue Profile</h3>
              <select className="text-sm text-gray-500">
                <option>Monthly</option>
              </select>
            </div>
            <div className="text-2xl font-bold mb-1">$25,843.45 <span className="text-sm text-green-500">+11%</span>/Month</div>
            <div className="text-gray-500 mb-4">Your performance is excellent 👌</div>
            <ResponsiveContainer width="100%" height={150}>
              <AreaChart data={revenueProfile}>
                <defs>
                  <linearGradient id="revGrad" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="5%" stopColor="#6366F1" stopOpacity={0.8} />
                    <stop offset="95%" stopColor="#6366F1" stopOpacity={0} />
                  </linearGradient>
                </defs>
                <CartesianGrid strokeDasharray="3 3" />
                <XAxis dataKey="date" />
                <YAxis />
                <Tooltip />
                <Area type="monotone" dataKey="revenue" stroke="#6366F1" fill="url(#revGrad)" />
              </AreaChart>
            </ResponsiveContainer>
          </div>
        </div>

        {/* Recent Order Activities Table */}
        <div className="bg-white rounded-xl shadow p-4">
          <h3 className="text-lg font-semibold text-gray-800 mb-4">Order Activities</h3>
          <p className="text-sm text-gray-500 mb-2">Keep track of recent order activities</p>
          <div className="overflow-auto">
            <table className="w-full text-sm">
              <thead className="bg-gray-100">
                <tr>
                  <th className="p-2 text-left">Order ID</th>
                  <th className="p-2 text-left">Restaurant Name</th>
                  <th className="p-2 text-left">Customer Name</th>
                  <th className="p-2 text-left">Date & Time</th>
                  <th className="p-2 text-left">Total Item</th>
                  <th className="p-2 text-left">Amount</th>
                  <th className="p-2 text-left">Status</th>
                </tr>
              </thead>
              <tbody>
                {activities.map(a => (
                  <tr key={a.id} className="border-t">
                    <td className="p-2">{a.id}</td>
                    <td className="p-2">{a.restaurant}</td>
                    <td className="p-2">{a.customer}</td>
                    <td className="p-2">{a.date}</td>
                    <td className="p-2">{a.items}</td>
                    <td className="p-2">{a.amount}</td>
                    <td className="p-2 text-green-600">{a.status}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      </main>
    </div>
  );
};

// Sidebar nav item
const NavItem = ({ label, active }) => (
  <div className={`flex items-center px-3 py-2 rounded-lg cursor-pointer ${active ? 'bg-gray-200 text-gray-900 font-semibold' : 'text-gray-600 hover:bg-gray-100'}`}>
    {label}
  </div>
);

// Stat card component
const StatCard = ({ label, value, percent, trend }) => (
  <div className="bg-white rounded-lg shadow p-4 flex flex-col justify-between">
    <div className="text-xs text-gray-500 uppercase tracking-wide">{label}</div>
    <div className="flex items-end justify-between">
      <div className="text-2xl font-bold text-gray-800">{value}</div>
      <div className={`text-sm ${trend === 'up' ? 'text-green-500' : 'text-red-500'}`}>{percent}</div>
    </div>
  </div>
);

// Donut chart component
const PerfDonut = ({ label, value, color }) => (
  <div className="flex flex-col items-center text-center">
    <PieChart width={80} height={80}>
      <Pie
        data={[{ value, rest: 100 - value }]}
        dataKey="value"
        innerRadius={25}
        outerRadius={35}
        startAngle={90}
        endAngle={-270}
      >
        <Cell key="filled" fill={color} />
        <Cell key="empty" fill="#E5E7EB" />
      </Pie>
    </PieChart>
    <div className="text-sm font-semibold text-gray-800">{value}%</div>
    <div className="text-xs text-gray-500">{label}</div>
  </div>
);

export default AdminDashboard;