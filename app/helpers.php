<?php

use App\Models\Session;
use App\Models\User;

if (! function_exists('checkRole')) {
    function checkRole(string $sessionToken)
    {
        $session = Session::where('session_token', $sessionToken)->first();

        if (!$session) {
            return 'plz login to continue';
        }

        $user = $session->user;

        if (!$user) {
            return 'plz login to continue';
        }

        $role = $user->roles()->first();

        if (!$role) {
            return 'Role not assigned';
        }

        return $role->name;
    }
}
