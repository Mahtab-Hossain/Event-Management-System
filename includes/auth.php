<?php
session_start();

/**
 * Check if the user is logged in.
 *
 * @return bool True if the user is logged in, false otherwise.
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Require the user to be logged in.
 * Redirects to the login page if the user is not logged in.
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}

/**
 * Check if the user is an admin.
 *
 * @return bool True if the user is an admin, false otherwise.
 */
function isAdmin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
}


/**
 * Require the user to be an admin.
 * Redirects to the home page if the user is not an admin.
 */
function requireAdmin() {
    if (!isAdmin()) {
        header('Location: index.php');
        exit();
    }
}
