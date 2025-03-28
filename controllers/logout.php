<?php
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session completely
session_destroy();

// Prevent browser from caching old session data
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Set logout message
session_start(); // Start a new session to set the logout message
$_SESSION['message'] = "Logout Successful";
$_SESSION['code'] = "success";

// Redirect to login page
header("Location: /IT322/login.php");
exit();
