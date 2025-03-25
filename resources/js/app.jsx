import './bootstrap';
import React from 'react';
import { createRoot } from 'react-dom/client';
import AdminDashboard from './components/AdminDashboard';
import AdminQuestions from './components/AdminQuestions';
import UserProfile from './components/UserProfile';

const dashboardElement = document.getElementById('admin-dashboard');
if (dashboardElement) {
    console.log("Mounting React to #admin-dashboard");
    console.log("Admin Data:", window.adminData);
    createRoot(dashboardElement).render(<AdminDashboard />);
} else {
    console.error("Admin dashboard div not found!");
}

const questionsElement = document.getElementById('admin-questions');
if (questionsElement) {
    console.log("Mounting AdminQuestions to #admin-questions");
    console.log("Admin Data:", window.adminData);
    createRoot(questionsElement).render(<AdminQuestions />);
}

const profileElement = document.getElementById('user-profile');
if (profileElement) {
    console.log("Mounting UserProfile to #user-profile");
    console.log("Profile Data:", window.profileData);
    createRoot(profileElement).render(<UserProfile />);
}