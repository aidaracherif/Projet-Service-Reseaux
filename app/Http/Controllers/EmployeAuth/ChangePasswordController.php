<?php

namespace App\Http\Controllers\EmployeAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Service\IRedMailService;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employes');
    }

    public function showChangePasswordForm()
    {
        return view('employes.auth.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $employe = Auth::guard('employes')->user();

        // Si ce n'est pas le premier login, on vérifie l'ancien mot de passe
        if (!$employe->first_login) {
            if (!Hash::check($request->current_password, $employe->password)) {
                return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect']);
            }
        }

        $employe->password = Hash::make($request->password);
        $employe->first_login = false;
        $employe->save();

        return redirect()->route('employes.dashboard')->with('success', 'Mot de passe changé avec succès');
    }

    
}