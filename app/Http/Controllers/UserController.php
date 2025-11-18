<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->with(['role'])
            ->latest()
            ->paginate(12);

        return view('senarai-user', [
            'users' => $users,
        ]);
    }
}
