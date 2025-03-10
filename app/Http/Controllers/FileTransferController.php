<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Employe;

class FileTransferController extends Controller
{
    /**
     * Afficher la liste des fichiers
     */
    public function index($employee_id = null)
    {
        // Si un ID d'employé est spécifié et que l'utilisateur est administrateur,
        // on peut afficher les fichiers d'un employé spécifique
        if ($employee_id && auth()->user()->hasRole('admin')) {
            $files = File::where(function($query) use ($employee_id) {
                $query->where('user_id', $employee_id)
                    ->orWhere('recipient_id', $employee_id);
            })->get();
        } else {
            // Sinon, on affiche les fichiers de l'utilisateur connecté
            $files = File::where(function($query) {
                $query->where('user_id', auth()->id())
                    ->orWhere('recipient_id', auth()->id());
            })->get();
        }

        // Récupérer tous les employés sauf l'utilisateur actuel
        $employes = Employe::where('id', '!=', auth()->id())->get();
        
        return view('files.index', compact('files', 'employes'));
    }

    /**
     * Télécharger un fichier
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:20480', // 20MB max
            'description' => 'nullable|string|max:255',
            'recipient_id' => 'required|exists:employes,id'
        ]);

        // Traiter le fichier
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('employee_transfers', 'ftp');
            
            // Sauvegarder les informations dans la base de données
            $file = new File();
            $file->name = $request->file('file')->getClientOriginalName();
            $file->path = $path;
            $file->description = $request->description;
            $file->size = $request->file('file')->getSize();
            $file->user_id = auth()->id();
            $file->recipient_id = $request->recipient_id;
            $file->save();

            return redirect()->route('files.index')
                ->with('success', 'Fichier téléchargé avec succès.');
        }

        return back()->with('error', 'Erreur lors du téléchargement du fichier.');
    }

    /**
     * Télécharger un fichier
     */
    public function download($id)
    {
        $file = File::findOrFail($id);
        
        // Vérifier que l'utilisateur a le droit de télécharger le fichier
        if ($file->user_id == auth()->id() || $file->recipient_id == auth()->id()) {
            return Storage::disk('ftp')->download($file->path, $file->name);
        }
        
        return back()->with('error', 'Vous n\'avez pas accès à ce fichier.');
    }

    /**
     * Supprimer un fichier
     */
    public function destroy($id)
    {
        $file = File::findOrFail($id);
        
        // Vérifier que l'utilisateur a le droit de supprimer le fichier
        if ($file->user_id == auth()->id()) {
            // Supprimer du stockage FTP
            Storage::disk('ftp')->delete($file->path);
            
            // Supprimer l'enregistrement de la base de données
            $file->delete();
            
            return redirect()->route('files.index')
                ->with('success', 'Fichier supprimé avec succès.');
        }
        
        return back()->with('error', 'Vous n\'avez pas le droit de supprimer ce fichier.');
    }
}
