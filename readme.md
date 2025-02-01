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




  # Application Usage Guide

This guide provides detailed instructions for testing and using the application features. Follow the steps below for different tasks.

---

## Login Credentials for Testing

### Admin User
- **Username:** `admin`
- **Password:** `Admin@123`

### Regular User
- **Username:** `user`
- **Password:** `User@123`

---

## Creating an Event

1. **Log in** as a regular user.
2. **Navigate** to the **"Create Event"** page.
3. **Fill in** the event details.
4. **Submit** the form.

---

## Managing Events

1. **Log in** as a regular user.
2. **Navigate** to the **"Manage Events"** page.
3. **View, edit, or delete** your events.

---

## Registering for an Event

1. **Log in** as a regular user.
2. **Navigate** to the **"Event Dashboard"** page.
3. **Click** on an event to view its details.
4. **Click** the **"Register"** button to register for the event.

---

## Viewing Attendees

1. **Log in** as a regular user.
2. **Navigate** to the **"Manage Events"** page.
3. **Click** the **"View Attendees"** button for an event to see the list of attendees.

---

## Downloading Attendee List

1. **Log in** as a regular user.
2. **Navigate** to the **"Manage Events"** page.
3. **Click** the **"Download Attendees"** button for an event to download the list of attendees in CSV format.

---

## Admin Features

1. **Log in** as an admin user.
2. **Navigate** to the **"Reports"** page to view and download event reports.
3. **Navigate** to the **"Register Admin"** page to register new admin users.
