@extends('layout')

@section('content')
    <div class="container">
        <h2>Ajouter un client</h2>
        <form action="{{ route('clients.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Prénom</label>
                <input type="text" name="prenom" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nom Entreprise</label>
                <input type="text" name="nom_entreprise" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contact</label>
                <input type="text" name="contact" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Adresse</label>
                <input type="text" name="adresse" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Ajouter</button>
            <a href="{{ route('clients.index') }}" class="btn btn-secondary">Retour</a>
        </form>
    </div>
@endsection
