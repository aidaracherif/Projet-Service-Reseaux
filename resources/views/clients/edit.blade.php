@extends('layout')

@section('content')
    <div class="container">
        <h2>Modifier le client</h2>
        <form action="{{ route('clients.update', $client->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control" value="{{ $client->nom }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Prénom</label>
                <input type="text" name="prenom" class="form-control" value="{{ $client->prenom }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nom Entreprise</label>
                <input type="text" name="nom_entreprise" class="form-control" value="{{ $client->nom_entreprise }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contact</label>
                <input type="text" name="contact" class="form-control" value="{{ $client->contact }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $client->email }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Adresse</label>
                <input type="text" name="adresse" class="form-control" value="{{ $client->adresse }}" required>
            </div>
            <button type="submit" class="btn btn-warning">Modifier</button>
            <a href="{{ route('clients.index') }}" class="btn btn-secondary">Retour</a>
        </form>
    </div>
@endsection
