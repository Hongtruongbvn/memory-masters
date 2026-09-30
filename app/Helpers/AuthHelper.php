<?php

namespace App\Helpers;

class AuthHelper
{
    public static function user()
    {
        return session('user');
    }

    public static function id()
    {
        return session('user')['id'] ?? null;
    }

    public static function check()
    {
        return !is_null(session('user'));
    }

    public static function isVip()
    {
        return session('user')['is_vip'] ?? false;
    }

    public static function isAdmin()
    {
        return session('user')['is_admin'] ?? false;
    }

    public static function name()
    {
        return session('user')['name'] ?? null;
    }

    public static function email()
    {
        return session('user')['email'] ?? null;
    }
}