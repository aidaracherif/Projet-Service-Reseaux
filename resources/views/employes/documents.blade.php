@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h2 class="text-primary text-center mb-4">📂 Mes Documents</h2>
        
        @if($documents->isEmpty())
            <p class="text-center text-muted">Aucun document disponible.</p>
        @else
            <div class="list-group">
                @foreach($documents as $document)
                    <a href="{{ asset('storage/' . $document->path) }}" target="_blank" 
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-file-earmark-text text-primary"></i> 
                            {{ $document->nom_fichier }}
                        </div>
                        <span class="badge bg-secondary">{{ $document->taille }} Ko</span>
                    </a>
                @endforeach
            </div>
        @endif

        <div class="text-center mt-4">
            <a href="{{ route('employes.dashboard') }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left"></i> Retour au Tableau de Bord
            </a>
        </div>
    </div>
</div>

<!-- Ajouter Bootstrap si ce n'est pas encore fait -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
@endsection