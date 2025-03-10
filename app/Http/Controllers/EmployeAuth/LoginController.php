<?php

namespace App\Http\Controllers\EmployeAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function guard()
    {
        return Auth::guard('employes');
    }

    protected $redirectTo = '/employes/dashboard';

    public function __construct()
    {
        $this->middleware('guest:employes')->except('logout');
    }

    public function showLoginForm()
    {
        return view('employes.auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('employes')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $employe = Auth::guard('employes')->user();

            // Vérifier si c'est le premier login
            if ($employe->first_login) {
                return redirect()->route('employes.change-password');
            }

            return redirect()->intended($this->redirectTo);
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        Auth::guard('employes')->logout();
        $request->session()->invalidate();
        return redirect()->route('employes.login');
    }

    protected function authenticated(Request $request, $user)
    {
        // Actions supplémentaires après une authentification réussie
    }
}
