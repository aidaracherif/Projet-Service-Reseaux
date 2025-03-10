@extends('layout')
@section('content')
<div class="container">
    <h2>Ajouter un employé</h2>
    
    @if(session('success') && session('temp_password'))
    <div class="alert alert-success">
        <p>{{ session('success') }}</p>
        <p><strong>Informations de connexion :</strong></p>
        <p>Email : {{ session('employe_email') }}</p>
        <p>Mot de passe temporaire : <span class="font-monospace">{{ session('temp_password') }}</span></p>
        <p class="text-danger">Important : Veuillez noter ce mot de passe. Il ne sera plus affiché par la suite.</p>
    </div>
    @endif
    
    <form action="{{ route('employes.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" id="nom" name="nom" class="form-control" required value="{{ old('nom') }}">
            @error('nom')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label class="form-label">Prénom</label>
            <input type="text" id="prenom" name="prenom" class="form-control" required value="{{ old('prenom') }}">
            @error('prenom')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Champ caché pour le username généré -->
        <input type="hidden" id="username" name="username" value="{{ old('username') }}">

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" required value="{{ old('email') }}">
            <div class="form-text">L'employé utilisera cet email pour se connecter.</div>
            @error('email')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label class="form-label">Téléphone</label>
            <input type="text" name="telephone" class="form-control" required value="{{ old('telephone') }}">
            @error('telephone')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label class="form-label">Poste</label>
            <input type="text" name="poste" class="form-control" required value="{{ old('poste') }}">
            @error('poste')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label class="form-label">Date d'embauche</label>
            <input type="date" name="date_embauche" class="form-control" required value="{{ old('date_embauche') }}">
            @error('date_embauche')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label class="form-label">Mot de passe temporaire</label>
            <div class="input-group">
                <input type="text" id="temp_password" name="temp_password" class="form-control" readonly value="{{ old('temp_password', $generatedPassword ?? '') }}">
                <button class="btn btn-outline-secondary" type="button" id="generatePassword">Générer</button>
            </div>
            <div class="form-text">Ce mot de passe temporaire sera envoyé à l'employé. Il devra le changer lors de sa première connexion.</div>
        </div>
        
        <button type="submit" class="btn btn-success">Ajouter</button>
        <a href="{{ route('employes.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const generateBtn = document.getElementById('generatePassword');
    const passwordField = document.getElementById('temp_password');
    const nomField = document.getElementById('nom');
    const prenomField = document.getElementById('prenom');
    const usernameField = document.getElementById('username');
    const emailField = document.getElementById('email');

    // Générer un mot de passe aléatoire lors du chargement de la page
    if (!passwordField.value) {
        generateRandomPassword();
    }

    // Générer un nouveau mot de passe en cliquant sur le bouton
    generateBtn.addEventListener('click', function() {
        generateRandomPassword();
    });

    function generateRandomPassword() {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*';
        let password = '';
        for (let i = 0; i < 10; i++) {
            password += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        passwordField.value = password;
    }

    // Générer automatiquement le username et l'email
    function generateUsername() {
        let nom = nomField.value.trim().toLowerCase().replace(/[^a-zA-Z0-9]/g, '');
        let prenom = prenomField.value.trim().toLowerCase().replace(/[^a-zA-Z0-9]/g, '');
        if (nom && prenom) {
            let username = prenom + nom; // Concaténer sans espaces ni points
            usernameField.value = username;
            emailField.value = username + "@smarttec.sn"; // Générer l'email automatiquement
        }
    }

    // Mettre à jour le username à chaque modification du nom/prénom
    nomField.addEventListener('input', generateUsername);
    prenomField.addEventListener('input', generateUsername);
});
</script>
@endsection
