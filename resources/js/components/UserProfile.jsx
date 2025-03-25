import React, { useState } from "react";

const UserProfile = () => {
    const initialUser = window.profileData?.user || {};
    const [user] = useState(initialUser);

    return (
        <div className="tailwind-scope tw-min-h-screen tw-bg-blue-50 tw-flex tw-items-center tw-justify-center tw-p-6">
            <div className="tw-max-w-md tw-w-full tw-bg-white tw-rounded-3xl tw-shadow-2xl tw-p-8 tw-border tw-border-blue-100">
                <div className="tw-flex tw-flex-col tw-items-center">
                    {/* Profile Picture Placeholder */}
                    <div className="tw-w-32 tw-h-32 tw-bg-gradient-to-r tw-from-blue-400 tw-to-blue-600 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-mb-6 tw-shadow-lg">
                        <span className="tw-text-5xl tw-font-bold tw-text-white">
                            {user.name ? user.name.charAt(0).toUpperCase() : 'U'}
                        </span>
                    </div>

                    {/* Header */}
                    <h1 className="tw-text-3xl tw-font-bold tw-text-blue-800 tw-mb-2">
                        {user.name || 'User'}
                    </h1>
                    <p className="tw-text-blue-600 tw-text-lg tw-mb-6">
                        {user.email || 'No email'}
                    </p>

                    {/* Additional Info */}
                    <div className="tw-w-full tw-bg-blue-50 tw-rounded-xl tw-p-4 tw-text-center">
                        <p className="tw-text-blue-700 tw-font-medium">
                            Member since {new Date(user.created_at).toLocaleDateString()}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default UserProfile;