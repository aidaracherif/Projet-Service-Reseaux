@extends('layout')

@section('content')
    <div class="container">
        <h2>Modifier l'employé</h2>
        <form action="{{ route('employes.update', $employe->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control" value="{{ $employe->nom }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Prénom</label>
                <input type="text" name="prenom" class="form-control" value="{{ $employe->prenom }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $employe->email }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Téléphone</label>
                <input type="text" name="telephone" class="form-control" value="{{ $employe->telephone }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Poste</label>
                <input type="text" name="poste" class="form-control" value="{{ $employe->poste }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Date d'embauche</label>
                <input type="date" name="date_embauche" class="form-control" value="{{ $employe->date_embauche }}" required>
            </div>
            <button type="submit" class="btn btn-warning">Modifier</button>
            <a href="{{ route('employes.index') }}" class="btn btn-secondary">Retour</a>
        </form>
    </div>
@endsection
