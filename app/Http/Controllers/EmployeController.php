<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use App\Services\IRedMailService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class EmployeController extends Controller
{
    protected $iredMailService;
    
    public function __construct(IRedMailService $iredMailService)
    {
        $this->iredMailService = $iredMailService;
    }

    public function index()
    {
        $employes = Employe::all();
        return view('employes.index', compact('employes'));
    }

    public function show(Employe $employe)
    {
        return view('employes.show', compact('employe'));
    }

    public function edit(Employe $employe)
    {
        return view('employes.edit', compact('employe'));
    }
    

    private function generateRandomPassword()
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
        $password = '';
        
        for ($i = 0; $i < 8; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $password .= $characters[$index];
        }
        
        return $password;
    }
    public function create()
    {
        $generatedPassword = $this->generateRandomPassword();
        return view('employes.create', compact('generatedPassword'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employes',
            'telephone' => 'required|string|max:20',
            'poste' => 'required|string|max:255',
            'date_embauche' => 'required|date',
            'username' => 'required|string|max:255|unique:employes',
        ]);

        // 🔹 Assurer que le username est bien formaté (juste au cas où)
        $username = strtolower(trim($validated['prenom'] . $validated['nom']));
        $username = preg_replace('/[^a-zA-Z0-9]/', '', $username); // Supprimer les caractères spéciaux
        $password = $this->generateRandomPassword(); 

        // 🔹 Création du compte email sur iRedMail
        $mailCreated = $this->iredMailService->createMailbox($username, $password);

        if (!$mailCreated) {
            return redirect()->back()->with('error', 'Erreur lors de la création du compte email')->withInput();
        }

        // 🔹 Création de l'employé
        $employe = Employe::create([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'],
            'poste' => $validated['poste'],
            'date_embauche' => $validated['date_embauche'],
            'password' => bcrypt($password),
            'first_login' => true,
            'username' => $username
        ]);

        return redirect()->route('employes.index')->with('success', 'Employé ajouté avec succès!');
    }



    public function destroy(Employe $employe)
    {
        $emailParts = explode('@', $employe->email);
        $username = $emailParts[0];

        // 🔹 Suppression du compte email
        $mailDeleted = $this->iredMailService->deleteMailbox($username);

        if (!$mailDeleted) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression du compte email');
        }

        // 🔹 Suppression de l'employé en base de données
        $employe->delete();

        return redirect()->route('employes.index')->with('success', 'Employé et compte email supprimés avec succès!');
    }

    public function update(Request $request, Employe $employe)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:employes,email,' . $employe->id,
            'telephone' => 'required|string|max:20',
            'poste' => 'required|string|max:255',
            'date_embauche' => 'required|date',
        ]);

        $employe->update($request->all());

        return redirect()->route('employes.index')->with('success', 'Employé mis à jour avec succès !');
    }

    
    
}
