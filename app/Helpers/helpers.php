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


/*بحط 

        $sessionToken = $request->header('session-token'); // أو أي طريقة تحصلين فيها على التوكن

        $roleName = checkRole($request->header('session-token'));

        if ($roleName === 'plz login to continue' || $roleName === 'Role not assigned') {
            return response()->json(['error' => $roleName], 401);
        }
*/