<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'nom_entreprise' => 'required|string',
            'contact' => 'required|string',
            'email' => 'required|email|unique:clients',
            'adresse' => 'required|string',
        ]);

        Client::create($request->all());
        return redirect()->route('clients.index')->with('success', 'Client ajouté avec succès !');
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'nom_entreprise' => 'required|string',
            'contact' => 'required|string',
            'email' => 'required|email|unique:clients,email,' . $client->id,
            'adresse' => 'required|string',
        ]);

        $client->update($request->all());
        return redirect()->route('clients.index')->with('success', 'Client mis à jour !');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Client supprimé !');
    }
}
