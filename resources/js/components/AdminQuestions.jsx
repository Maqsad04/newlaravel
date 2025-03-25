import React, { useState, useEffect } from "react";

const AdminQuestions = () => {
    const initialQuestions = window.adminData?.questions || [];
    const [questions, setQuestions] = useState(initialQuestions.map(question => ({
        ...question,
        isDeleted: question.status === "deleted",
    })));

    const fetchQuestions = async () => {
        try {
            const response = await fetch('/admin/questions/data', {
                headers: {
                    'Accept': 'application/json',
                },
            });
            if (!response.ok) {
                throw new Error('Failed to fetch questions');
            }
            const data = await response.json();
            setQuestions(data.map(question => ({
                ...question,
                isDeleted: question.status === "deleted",
            })));
        } catch (error) {
            console.error('Error fetching questions:', error);
        }
    };

    useEffect(() => {
        fetchQuestions();
    }, []);

    const handleQuestionStatusUpdate = async (id, currentStatus) => {
        const newStatus = currentStatus ? "accepted" : "deleted";

        try {
            const response = await fetch(`/admin/questions/${id}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ status: newStatus }),
            });

            if (!response.ok) {
                throw new Error('Failed to update question status');
            }

            // Fetch updated questions after the status update
            await fetchQuestions();
            console.log(`Updated question ID ${id} to status: ${newStatus}`);
        } catch (error) {
            console.error('Error updating question status:', error);
        }
    };

    return (
        <div className="tailwind-scope tw-min-h-screen tw-bg-gradient-to-br tw-from-gray-50 tw-via-indigo-50 tw-to-purple-100 tw-p-6 md:tw-p-10">
            <header className="tw-text-center tw-mb-12">
                <h1 className="tw-text-5xl tw-font-extrabold tw-text-transparent tw-bg-clip-text tw-bg-gradient-to-r tw-from-indigo-700 tw-to-purple-700 tw-drop-shadow-lg tw-animate-fade-in">
                    Question Management
                </h1>
                <p className="tw-text-gray-600 tw-mt-2 tw-text-lg">Manage questions with ease</p>
            </header>

            <div className="tw-bg-white/90 tw-backdrop-blur-md tw-shadow-xl tw-rounded-2xl tw-p-6 tw-border tw-border-gray-200/50">
                <h2 className="tw-text-2xl tw-font-semibold tw-text-gray-800 tw-mb-6">All Questions</h2>
                {questions.length > 0 ? (
                    <div className="tw-overflow-x-auto">
                        <table className="tw-w-full tw-text-left">
                            <thead className="tw-bg-gradient-to-r tw-from-gray-100 tw-to-indigo-100">
                                <tr className="tw-text-gray-700">
                                    <th className="tw-p-4 tw-font-semibold tw-rounded-tl-lg">ID</th>
                                    <th className="tw-p-4 tw-font-semibold">Title</th>
                                    <th className="tw-p-4 tw-font-semibold">Author</th>
                                    <th className="tw-p-4 tw-font-semibold">Status</th>
                                    <th className="tw-p-4 tw-font-semibold tw-rounded-tr-lg">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {questions.map(question => (
                                    <tr
                                        key={question.id}
                                        className="tw-border-b tw-border-gray-200 hover:tw-bg-indigo-50/50 tw-transition-colors tw-duration-200"
                                    >
                                        <td className="tw-p-4 tw-text-gray-800">{question.id}</td>
                                        <td className="tw-p-4 tw-font-medium tw-text-gray-800">{question.title}</td>
                                        <td className="tw-p-4 tw-text-gray-600">{question.user?.name || "Unknown"}</td>
                                        <td className="tw-p-4">
                                            <span
                                                className={`tw-px-3 tw-py-1 tw-rounded-full tw-text-sm tw-font-medium ${question.isDeleted
                                                    ? "tw-bg-red-100 tw-text-red-600"
                                                    : "tw-bg-green-100 tw-text-green-600"}`}
                                            >
                                                {question.isDeleted ? "Deleted" : "Active"}
                                            </span>
                                        </td>
                                        <td className="tw-p-4 tw-flex tw-space-x-2">
                                            <button
                                                onClick={() => handleQuestionStatusUpdate(question.id, question.isDeleted)}
                                                className={`tw-px-4 tw-py-2 tw-rounded-lg tw-font-medium tw-text-white tw-transition-all tw-duration-200 hover:tw-scale-105 ${question.isDeleted
                                                    ? "tw-bg-green-500 hover:tw-bg-green-600"
                                                    : "tw-bg-red-500 hover:tw-bg-red-600"}`}
                                            >
                                                {question.isDeleted ? "Restore" : "Delete"}
                                            </button>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                ) : (
                    <div className="tw-text-center tw-py-10">
                        <p className="tw-text-gray-500">No questions available.</p>
                    </div>
                )}
            </div>
        </div>
    );
};

export default AdminQuestions;