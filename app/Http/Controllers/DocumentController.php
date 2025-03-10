<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Document;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Auth::user()->documents;
        return view('employes.documents', compact('documents'));
    }

    /**
     * Upload a new document.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,docx,jpg,png|max:2048',
        ]);

        if ($request->file('document')) {
            $file = $request->file('document');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName, 'public');

            Document::create([
                'nom_fichier' => $fileName,
                'type' => $file->getClientMimeType(),
                'taille' => $file->getSize(),
                'path' => $filePath,
                'employe_id' => Auth::id(),
            ]);

            return redirect()->back()->with('success', 'Document téléversé avec succès !');
        }

        return redirect()->back()->with('error', 'Échec du téléversement du document.');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Logique pour afficher le formulaire de création si nécessaire
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Logique pour afficher un document spécifique
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Logique pour afficher le formulaire d'édition
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Logique pour mettre à jour un document
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Logique pour supprimer un document
    }
}
