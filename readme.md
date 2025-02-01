# Event Management System

## Overview
The Event Management System is a web-based application that allows users to create, manage, and view events. Users can register for events, and admins can generate reports. The system ensures secure user authentication, client-side and server-side validation, and provides a responsive user interface.

## Features
- **User Authentication**: Secure login and registration with password hashing.
- **Event Management**: Authenticated users can create, update, view, and delete events.
- **Attendee Registration**: Users can register for events, with capacity limits enforced.
- **Event Dashboard**: Displays events in a paginated, sortable, and filterable format.
- **Event Reports**: Admins can download attendee lists for specific events in CSV format.
- **Role-Based Access Control**: Admins can manage all events, view reports, and register other admins. Regular users can manage their own events and view attendee lists.
- **Responsive Design**: The application is mobile-friendly and uses Bootstrap for a responsive UI.
- **Notifications**: Toastr notifications for user feedback.

## Installation Instructions
1. **Clone the Repository**
   ```bash
   git clone https://github.com/Mahtab-Hossain/Event-Management-System
   cd event-management-system


## Project Structure

event-management-system/
├── index.php
├── login.php
├── register.php
├── dashboard.php
├── create_event.php
├── update_event.php
├── delete_event.php
├── view_event.php
├── register_attendee.php
├── download_attendees.php
├── css/
│   └── styles.css
├── js/
│   └── scripts.js
└── includes/
    ├── db.php
    ├── auth.php
    └── functions.php