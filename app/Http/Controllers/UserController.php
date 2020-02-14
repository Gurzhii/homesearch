<?php

namespace App\Http\Controllers;

use App\Jobs\DeleteUserJob;
use App\User;

class UserController extends Controller
{
    public function destroy(User $user)
    {
        $this->authorize('update', $user);
        try {
            $this->dispatchNow(new DeleteUserJob($user));
            return response()->json(['success' => true]);
        } catch (\Exception $_) {
            return response()->json(['success' => false], 422);
        }
    }
}
