<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // Vous pourriez ajouter un middleware 'admin' si vous en avez un
    }

    /**
     * Affiche le dashboard admin.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.dashboard');
    }
    
    /**
     * Gestion des employés
     */
    public function employees()
    {
        return view('admin.employees');
    }
    
    /**
     * Gestion des clients
     */
    public function clients()
    {
        return view('admin.clients');
    }
}