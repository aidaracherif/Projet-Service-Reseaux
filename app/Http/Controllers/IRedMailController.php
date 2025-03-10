<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\IRedMailService;

class IRedMailController extends Controller
{
    protected $iredmailService;

    public function __construct(IRedMailService $iredmailService)
    {
        $this->iredmailService = $iredmailService;
    }

    public function processRequest(Request $request)
    {
        // Vérification de la clé API
        if ($request->header('X-API-KEY') !== config('services.iredmail.api_key')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Validation de base
        $validated = $request->validate([
            'action' => 'required|in:create,delete,password',
            // autres validations selon l'action
        ]);

        // Traitement selon l'action
        switch ($request->input('action')) {
            case 'create':
                // Validation
                $request->validate([
                    'username' => 'required',
                    'domain' => 'required',
                    'password' => 'required',
                    'display_name' => 'required',
                ]);
                
                return $this->iredmailService->create(
                    $request->input('username'),
                    $request->input('domain'),
                    $request->input('password'),
                    $request->input('display_name')
                );
                
            // Autres cas...
        }
    }
}