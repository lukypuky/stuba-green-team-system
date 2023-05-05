<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use App\Models\Role;
use App\Models\Division;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\User as UserRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterUser;

class RegisterController extends Controller
{
    public function getStoreUserPage(){
        $roles = Role::all();
        $divisions = Division::all();

        return Inertia::render('Admin/AdminUserStore', [
            'roles' => $roles,
            'divisions' => $divisions,
        ]);
    }

    public function storeUser(UserRequest $request){
        $checkEmail = User::where('email', $request->email)->first();

        if(!is_null($checkEmail)){
            return redirect()->back()->with('unsuccess_user_save', 'Tento email už niekto používa.');
        }

        $password = Str::random(10);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'division_id' => $request->division_id,
            'role_id' => $request->role_id,
        ]);

        event(new Registered($user));
        Mail::to('lukash.baca@gmail.com')->send(new RegisterUser($password, $request->email));
        return redirect()->route('dashboard-get-users')->with('success_object_save', 'Nový používateľ bol vytvorený.');
    }
}
