# Event Management System
## Objective
The goal of this project is to develop a simple, web-based event
management system that allows users to create, manage, and view events,
as well as register attendees and generate event reports.

Task Requirements

1. Core Functionalities

• User Authentication: Implement user login and registration with secure
password hashing.
• Event Management: Authenticated users can create, update, view, and
delete events with details like name, desc.
• Attendee Registration: Provide a form for event registration and prevent
registration beyond the maximum capacity.
• Event Dashboard: Display events in a paginated, sortable, and filterable
format.
• Event Reports: Enable admins to download attendee lists for specific
events in CSV format.

2. Technical Requirements

Backend development using pure PHP (no frameworks).
• Use MySQL for the database.
• Ensure client-side and server-side validation.
Use prepared statements to prevent SQL injection.
Create a basic, responsive Ul using frameworks like Bootstrap
• Provide setup instructions for the project.

3. Hosting and Code Submission
• Host the project on any free or paid hosting service (e.g., Heroku,
Vercel, or a shared hosting provider).
• Share the live project link and login credentials for testing.
• Upload the full project to GitHub or a similar platform.- Include a
README file with project overview, features, installation instructions,
and login credentials for testing.

4. Bonus Points (Optional)
• Implement search functionality across events and attendees.
• Use AJAX to enhance user experience during event registration.
• Add a JSON API endpoint to fetch event details programmatically.

### Evaluation Criteria

Code Quality: Well-structured, readable code adhering to best practices.

Functionality: Proper implementation of features and handling of edge cases.

Security: Secure practices, including password hashing, input validation, and prepared statements.

Database Design: Efficient and relational structure for events and
attendees.

Documentation: Clear instructions for setup and usage.

Hosting and Accessibility: Live demo link with login credentials and
GitHub repository.

### Project Structure

```
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
├── download_report.php
├── css/
│   └── styles.css
├── js/
│   └── scripts.js
└── includes/
    ├── db.php
    ├── auth.php
    └── functions.php
