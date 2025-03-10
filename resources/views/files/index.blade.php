@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">📁 Transfert de fichiers</h5>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <!-- Formulaire d'envoi -->
                    <h5 class="mb-3">📤 Envoyer un fichier</h5>
                    <form action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data" class="mb-4">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">📂 Sélectionner un fichier</label>
                            <input type="file" class="form-control" name="file" id="file" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">📝 Description</label>
                            <input type="text" class="form-control" name="description" id="description">
                        </div>
                        <div class="mb-3">
                            <label for="recipient_id" class="form-label">👤 Destinataire</label>
                            <select class="form-select" name="recipient_id" id="recipient_id" required>
                                @foreach($employes as $employe)
                                    <option value="{{ $employe->id }}">{{ $employe->prenom }} {{ $employe->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">📤 Envoyer</button>
                    </form>

                    <hr>

                    <!-- Liste des fichiers -->
                    <h5 class="mb-3">📂 Mes fichiers</h5>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered text-center align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>📄 Nom</th>
                                    <th>📝 Description</th>
                                    <th>📏 Taille</th>
                                    <th>👤 Expéditeur/Destinataire</th>
                                    <th>⚙️ Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($files as $file)
                                    <tr>
                                        <td>{{ $file->name }}</td>
                                        <td>{{ $file->description ?? 'N/A' }}</td>
                                        <td>{{ number_format($file->size / 1024, 2) }} KB</td>
                                        <td>
                                            @if($file->user_id == auth()->id())
                                                ➡️ Envoyé à : {{ $file->recipient->prenom }} {{ $file->recipient->nom }}
                                            @else
                                                ⬅️ Reçu de : {{ $file->user->prenom }} {{ $file->user->nom }}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('files.download', $file->id) }}" class="btn btn-sm btn-success">⬇️ Télécharger</a>
                                            @if($file->user_id == auth()->id())
                                                <form action="{{ route('files.destroy', $file->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce fichier?')">🗑️ Supprimer</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
