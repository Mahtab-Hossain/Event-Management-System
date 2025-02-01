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


## 📁 Project Structure  

- **index.php** - Homepage  
- **login.php** - User login page  
- **register.php** - User registration page  
- **dashboard.php** - Event dashboard  
- **create_event.php** - Create new event  
- **update_event.php** - Update an event  
- **delete_event.php** - Delete an event  
- **view_event.php** - View event details  
- **register_attendee.php** - Register for an event  
- **download_attendees.php** - Download attendee list (CSV)  
- **css/** - Contains stylesheets  
  - `styles.css` - Main stylesheet  
- **js/** - JavaScript files  
  - `scripts.js` - Main script  
- **includes/** - Core backend functions  
  - `db.php` - Database connection  
  - `auth.php` - Authentication logic  
  - `functions.php` - Helper functions  