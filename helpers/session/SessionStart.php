<?php

class SessionFlash
{
    // get
    public static function get(): string
    {
        $message = $_SESSION['message'];
        self::delete();
        return $message;
    }

    //  set
    public static function set(string $message): void
    {
        $_SESSION['message'] = $message;
    }

    // delete
    public static function delete()
    {
        unset($_SESSION['message']);
    }

    // exist
    public static function exist(): bool
    {
        return isset($_SESSION['message']);
    }
}
