<?php

class Auth
{
    /**
     * Return the user authentication status
     *
     * @return boolean True if a user is logged in, false otherwise
     */
    public static function isLoggedIn()
    {
        return isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'];
    }

    public static function requireLogin()
    {
        if (! Auth::isLoggedIn()) {

            die("unauthorised");
        
        }
    }

    public static function login()
    {
        session_regenerate_id(true);

        $_SESSION['is_logged_in'] = true;
    }

    public static function logout()
    {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
    }
}