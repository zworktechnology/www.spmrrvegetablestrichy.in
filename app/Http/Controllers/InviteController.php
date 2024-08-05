<?php

namespace App\Http\Controllers;

use App\Mail\InviteMail;
use App\Models\Invite;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class InviteController extends Controller
{
    public function index()
    {
        $data = Invite::all();
        $role = Role::all();

        return view('page.backend.manager.index', compact('data', 'role'));
    }

    public function store(Request $request)
    {
        do
        {
            $token = Str::random();
        }
        while (Invite::where('token', $token)->first());

        $randomkey = Str::random(5);

        $data = new Invite();

        $data->role_id = $request->get('role_id');
        $data->name = $request->get('name');
        $data->contact_number = $request->get('contact_number');
        $data->email = $request->get('email');
        $data->token = $token;
        $data->unique_key = $randomkey;

        $data->save();

        Mail::to($request->get('email'))->send(new InviteMail($data));

        return redirect()->route('invite.index')->with('add', 'Successful invite mail send to user !');
    }

    public function accept($token)
    {
        if (!$invite = Invite::where('token', $token)->first())
        {
            abort(404);
        }

        $user = new User();

        $user->email = $invite->email;
        $user->name = $invite->name;
        $user->password = Hash::make('Password@1234');

        $user->save();

        Invite::where('email', $invite->email)
            ->where('token', $token)
            ->update(['invite_accepted_at' => Carbon::now()]);

        $role = Role::find($invite->role_id);

        $user->assignRole($role->name);

        return redirect('login');
    }





    public function passwordview()
    {
        $GetUser = User::where('id', '=', auth()->user()->id)->first();

        return view('page.backend.settings.index', compact('GetUser'));
    }


    public function passwordupdate(Request $request, $id)
    {
        $GetUser = User::where('id', '=', $id)->first();

        $new_password = $request->get('new_password');
        $confirmnew_password = $request->get('confirmnew_password');

        

        if($new_password == $confirmnew_password){

            if (Hash::check($new_password, $GetUser->password)){

                return redirect()->route('settings.passwordview')->with('error', 'Please Enter New Password!');
                 
            }else {
                
                $GetUser->password = Hash::make($request->get('new_password'));
                $GetUser->update();

                return redirect()->route('settings.passwordview')->with('update', 'Password Changed successfully!');
            }

            

            
        }else if($new_password != $confirmnew_password){

            return redirect()->route('settings.passwordview')->with('warning', 'Passwords Mismatched!');
        }

        

    }
}
