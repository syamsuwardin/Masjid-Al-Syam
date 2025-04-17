<?php

class AuthController extends Controller
{
    public function login()
    {
        // Logic for handling user login
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and authenticate user
        }
        // Load the login view
        require_once '../app/views/auth/login.php';
    }

    public function register()
    {
        // Logic for handling user registration
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and create a new user
        }
        // Load the registration view
        require_once '../app/views/auth/register.php';
    }
}