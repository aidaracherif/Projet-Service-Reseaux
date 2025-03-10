@extends('layouts.app')
@section('content')

<!-- Styles personnalisés -->
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
    }
    .dashboard-card {
        background-color: #ffffff;
        border-radius: 15px;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }
    .dashboard-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
    .dashboard-header {
        font-size: 2rem;
        font-weight: 700;
        color: #343a40;
    }
    .card {
        border: none;
        border-radius: 15px;
    }
    .btn-outline-primary {
        border-color: #007bff;
        color: #007bff;
    }
    .btn-outline-primary:hover {
        background-color: #007bff;
        color: white;
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
    .container {
        background: linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%);
        padding: 20px;
        border-radius: 15px;
    }
    .header-section {
        background-color: #e9ecef;
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 20px;
    }
</style>

<div class="container mt-5">
    <div class="card shadow-lg p-4 header-section">
        <header class="text-center mb-4">
            <h2 class="text-primary dashboard-header">🚀 Tableau de Bord Smarttec</h2>
            <p class="text-muted">Bonjour, <strong>{{ Auth::user()->prenom }}</strong> ! Vous êtes connecté en tant que <strong class="text-success">{{ Auth::user()->poste }}</strong>.</p>
        </header>
    </div>

    <div class="row g-4">
        <!-- 📊 Statistiques -->
        <div class="col-md-6">
            <div class="card dashboard-card shadow-sm p-4 text-center">
                <h4 class="text-primary"><i class="fas fa-chart-line"></i> Statistiques</h4>
                <p class="text-muted">Aperçu de vos performances et activités récentes.</p>
            </div>
        </div>

        <!-- 📩 Messagerie -->
        <div class="col-md-6">
            <div class="card dashboard-card shadow-sm p-4 text-center">
                <h4 class="text-primary"><i class="fas fa-envelope"></i> Messagerie</h4>
                <p class="text-muted">Accédez à votre messagerie et restez connecté.</p>
                <a href="#" class="btn btn-outline-primary mt-2">Voir mes messages</a>
            </div>
        </div>

        <!-- 📤 Téléverser des Documents -->
        <div class="col-md-6">
            <div class="card dashboard-card shadow-sm p-4">
                <h4 class="text-primary"><i class="fas fa-upload"></i> Téléverser des Documents</h4>
                <form action="{{ route('employes.documents.upload') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                    @csrf
                    <input type="file" name="document" class="form-control mb-3" required>
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-cloud-upload-alt"></i> Téléverser</button>
                </form>
                @if (session('success'))
                    <p class="text-success mt-2"><i class="fas fa-check-circle"></i> {{ session('success') }}</p>
                @endif
                @if (session('error'))
                    <p class="text-danger mt-2"><i class="fas fa-exclamation-triangle"></i> {{ session('error') }}</p>
                @endif
            </div>
        </div>

        <!-- 📁 Mes Documents -->
        <div class="col-md-6">
            <div class="card dashboard-card shadow-sm p-4 text-center">
                <h4 class="text-primary"><i class="fas fa-folder-open"></i> Mes Documents</h4>
                <p class="text-muted"><a href="{{ route('employes.documents.index') }}" class="text-decoration-none">Voir tous les documents</a></p>
            </div>
        </div>

        <!-- 📂 Transfert de Fichiers -->
        <div class="col-md-12">
            <div class="card dashboard-card shadow-sm p-4 text-center">
                <h4 class="text-primary"><i class="fas fa-exchange-alt"></i> Transfert de Fichiers</h4>
                <p class="text-muted">Partagez des fichiers en toute sécurité.</p>
                <a href="{{ route('files.index', ['employee_id' => Auth::id()]) }}" class="btn btn-outline-primary mt-2"><i class="fas fa-share"></i> Accéder au transfert de fichiers</a>
            </div>
        </div>

        <!-- ✅ Tâches en Attente -->
        <div class="col-md-12">
            <div class="card dashboard-card shadow-sm p-4">
                <h4 class="text-primary"><i class="fas fa-tasks"></i> Tâches en Attente</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><i class="fas fa-thumbtack"></i> Finaliser le rapport mensuel.</li>
                    <li class="list-group-item"><i class="fas fa-calendar-alt"></i> Réunion d'équipe à 14h.</li>
                </ul>
            </div>
        </div>
    </div>

    <footer class="text-center mt-4 text-muted">
        <p>&copy; 2025 <strong>Smarttec</strong>. Tous droits réservés.</p>
    </footer>
</div>

<!-- Ajouter FontAwesome pour les icônes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@endsection
