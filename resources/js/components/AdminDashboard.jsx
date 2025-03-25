import React, { useState } from "react";
import { BarChart, Bar, XAxis, YAxis, Tooltip, CartesianGrid, ResponsiveContainer } from "recharts";

const AdminDashboard = () => {
    const initialStats = window.adminData?.stats || {
        totalUsers: 0,
        totalQuestions: 0,
        deletedQuestions: 0,
    };
    const initialUsers = window.adminData?.users || [];
    const initialChartData = window.adminData?.chartData || [
        { month: "January", questions: 20 },
        { month: "February", questions: 35 },
        { month: "March", questions: 50 },
    ];

    const [stats] = useState(initialStats);
    const [users, setUsers] = useState(initialUsers.map(user => ({
        ...user,
        isBlocked: user.is_blocked || false,
    })));

    const handleUserBlockUpdate = (id, isBlocked) => {
        setUsers(prev => prev.map(user =>
            user.id === id ? { ...user, isBlocked: !isBlocked } : user
        ));
        console.log(`Toggled block for user ID: ${id}, new status: ${!isBlocked}`);
    };

    return (
        <div className="tailwind-scope tw-min-h-screen tw-bg-gradient-to-br tw-from-gray-50 tw-via-indigo-50 tw-to-purple-100 tw-p-6 md:tw-p-10">
            <header className="tw-text-center tw-mb-12">
                <h1 className="tw-text-5xl tw-font-extrabold tw-text-transparent tw-bg-clip-text tw-bg-gradient-to-r tw-from-indigo-700 tw-to-purple-700 tw-drop-shadow-lg tw-animate-fade-in">
                    Admin Dashboard
                </h1>
                <p className="tw-text-gray-600 tw-mt-2 tw-text-lg">Manage your platform with ease and elegance</p>
            </header>

            <div className="tw-grid tw-grid-cols-1 sm:tw-grid-cols-2 lg:tw-grid-cols-3 tw-gap-6 tw-mb-12">
                {[
                    { title: "Total Users", value: stats.totalUsers, icon: "👤", gradient: "tw-from-indigo-500 tw-to-blue-600" },
                    { title: "Total Questions", value: stats.totalQuestions, icon: "❓", gradient: "tw-from-purple-500 tw-to-indigo-600" },
                    { title: "Deleted Questions", value: stats.deletedQuestions, icon: "🚫", gradient: "tw-from-pink-500 tw-to-red-600" },
                ].map((stat, index) => (
                    <div
                        key={index}
                        className="tw-bg-white/85 tw-backdrop-blur-md tw-shadow-lg tw-rounded-2xl tw-p-6 tw-transform hover:tw--translate-y-2 tw-transition-all tw-duration-300 tw-border tw-border-gray-200/50 hover:tw-border-indigo-300"
                    >
                        <div className="tw-flex tw-items-center tw-justify-between">
                            <div>
                                <h3 className="tw-text-lg tw-font-semibold tw-text-gray-700">{stat.title}</h3>
                                <p className={`tw-text-3xl tw-font-bold tw-mt-2 tw-bg-gradient-to-r ${stat.gradient} tw-text-transparent tw-bg-clip-text`}>
                                    {stat.value}
                                </p>
                            </div>
                            <span className="tw-text-4xl tw-opacity-70">{stat.icon}</span>
                        </div>
                    </div>
                ))}
            </div>

            <div className="tw-bg-white/90 tw-backdrop-blur-md tw-shadow-xl tw-rounded-2xl tw-p-6 tw-mb-12 tw-border tw-border-gray-200/50">
                <h2 className="tw-text-2xl tw-font-semibold tw-text-gray-800 tw-mb-6">Monthly Question Statistics</h2>
                {initialChartData && initialChartData.length > 0 ? (
                    <div style={{ width: "100%", height: "350px" }}>
                        <ResponsiveContainer width="100%" height="100%">
                            <BarChart
                                data={initialChartData}
                                margin={{ top: 20, right: 30, left: 0, bottom: 5 }}
                            >
                                <CartesianGrid strokeDasharray="3 3" stroke="#e0e0e0" />
                                <XAxis
                                    dataKey="month"
                                    stroke="#6b7280"
                                    fontSize={14}
                                    tick={{ fill: "#4b5563" }}
                                    axisLine={{ stroke: "#e0e0e0" }}
                                />
                                <YAxis
                                    stroke="#6b7280"
                                    fontSize={14}
                                    tick={{ fill: "#4b5563" }}
                                    axisLine={{ stroke: "#e0e0e0" }}
                                />
                                <Tooltip
                                    contentStyle={{
                                        backgroundColor: "rgba(255, 255, 255, 0.95)",
                                        borderRadius: "8px",
                                        boxShadow: "0 4px 15px rgba(0, 0, 0, 0.1)",
                                        padding: "10px",
                                        border: "none"
                                    }}
                                    itemStyle={{ color: "#4b5563" }}
                                    cursor={{ fill: "rgba(0, 0, 0, 0.05)" }}
                                />
                                <Bar
                                    dataKey="questions"
                                    fill="url(#barGradient)"
                                    radius={[8, 8, 0, 0]}
                                    barSize={40}
                                />
                                <defs>
                                    <linearGradient id="barGradient" x1="0" y1="0" x2="0" y2="1">
                                        <stop offset="0%" stopColor="#6366f1" />
                                        <stop offset="100%" stopColor="#8b5cf6" />
                                    </linearGradient>
                                </defs>
                            </BarChart>
                        </ResponsiveContainer>
                    </div>
                ) : (
                    <div className="tw-text-center tw-py-10">
                        <p className="tw-text-gray-500">No data available for the chart.</p>
                    </div>
                )}
            </div>

            <div className="tw-bg-white/90 tw-backdrop-blur-md tw-shadow-xl tw-rounded-2xl tw-p-6 tw-mb-12 tw-border tw-border-gray-200/50">
                <h2 className="tw-text-2xl tw-font-semibold tw-text-gray-800 tw-mb-6">User Management</h2>
                {users.length > 0 ? (
                    <div className="tw-overflow-x-auto">
                        <table className="tw-w-full tw-text-left">
                            <thead className="tw-bg-gradient-to-r tw-from-gray-100 tw-to-indigo-100">
                                <tr className="tw-text-gray-700">
                                    <th className="tw-p-4 tw-font-semibold tw-rounded-tl-lg">ID</th>
                                    <th className="tw-p-4 tw-font-semibold">Name</th>
                                    <th className="tw-p-4 tw-font-semibold">Email</th>
                                    <th className="tw-p-4 tw-font-semibold">Status</th>
                                    <th className="tw-p-4 tw-font-semibold tw-rounded-tr-lg">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {users.map(user => (
                                    <tr
                                        key={user.id}
                                        className="tw-border-b tw-border-gray-200 hover:tw-bg-indigo-50/50 tw-transition-colors tw-duration-200"
                                    >
                                        <td className="tw-p-4 tw-text-gray-800">{user.id}</td>
                                        <td className="tw-p-4 tw-font-medium tw-text-gray-800">{user.name}</td>
                                        <td className="tw-p-4 tw-text-gray-600">{user.email}</td>
                                        <td className="tw-p-4">
                                            <span
                                                className={`tw-px-3 tw-py-1 tw-rounded-full tw-text-sm tw-font-medium ${user.isBlocked
                                                    ? "tw-bg-red-100 tw-text-red-600"
                                                    : "tw-bg-green-100 tw-text-green-600"}`}
                                            >
                                                {user.isBlocked ? "Blocked" : "Active"}
                                            </span>
                                        </td>
                                        <td className="tw-p-4">
                                            <form
                                                action={`/admin/users/${user.id}/toggle-block`}
                                                method="POST"
                                                onSubmit={(e) => {
                                                    e.preventDefault();
                                                    handleUserBlockUpdate(user.id, user.isBlocked);
                                                    e.target.submit();
                                                }}
                                            >
                                                <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]').content} />
                                                <input type="hidden" name="_method" value="PATCH" />
                                                <button
                                                    type="submit"
                                                    className={`tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-text-white tw-transition-all tw-duration-200 hover:tw-scale-105 ${user.isBlocked
                                                        ? "tw-bg-green-500 hover:tw-bg-green-600"
                                                        : "tw-bg-red-500 hover:tw-bg-red-600"}`}
                                                >
                                                    {user.isBlocked ? "Unblock" : "Block"}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                ) : (
                    <div className="tw-text-center tw-py-10">
                        <p className="tw-text-gray-500">No users available.</p>
                    </div>
                )}
            </div>

            <div className="tw-bg-white/90 tw-backdrop-blur-md tw-shadow-xl tw-rounded-2xl tw-p-6 tw-border tw-border-gray-200/50">
                <h2 className="tw-text-2xl tw-font-semibold tw-text-gray-800 tw-mb-6">Question Management</h2>
                <p className="tw-text-gray-600">
                    Manage questions on a dedicated page: 
                    <a 
                        href="/admin/questions" 
                        className="tw-text-indigo-600 hover:tw-text-indigo-800 tw-font-medium tw-ml-2"
                    >
                        View All Questions
                    </a>
                </p>
            </div>
        </div>
    );
};

export default AdminDashboard;