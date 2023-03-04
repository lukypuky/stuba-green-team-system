<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Task;
use App\Models\User;

class PurchaseController extends Controller
{
    public function getUsers(){
        $users = User::all();

        return Inertia::render('DashboardPurchase', [
            'users' => $users,
        ]);
    }
}
