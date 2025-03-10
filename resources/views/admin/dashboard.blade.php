@extends('layout')

@section('content')
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
    .list-group-item {
        background-color: #ffffff;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        margin-bottom: 10px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .list-group-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    .list-group-item i {
        margin-right: 10px;
        color: #007bff;
    }
    .list-group-item-action {
        color: #495057;
    }
    .list-group-item-action:hover {
        color: #007bff;
        background-color: #e9ecef;
    }
</style>

<div class="container mt-5">
    <div class="card shadow-lg p-4 header-section">
        <header class="text-center mb-4">
            <h2 class="text-primary dashboard-header"><i class="fa-solid fa-tachometer-alt"></i> Tableau de bord Admin</h2>
        </header>
    </div>

    <div class="list-group">
        <a href="{{ route('clients.index') }}" class="list-group-item list-group-item-action dashboard-card">
            <i class="fa-solid fa-building"></i> Gestion des clients
        </a>
        <a href="{{ route('employes.index') }}" class="list-group-item list-group-item-action dashboard-card">
            <i class="fa-solid fa-users"></i> Gestion des employés
        </a>
        <a href="{{ route('documents.index') }}" class="list-group-item list-group-item-action dashboard-card">
            <i class="fa-solid fa-file"></i> Gestion des documents
        </a>
    </div>
</div>

<!-- Ajouter FontAwesome pour les icônes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection
