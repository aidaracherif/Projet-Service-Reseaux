@extends('layout')

@section('content')
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
    }
    .content-header {
        background-color: #e9ecef;
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 20px;
    }
    .table {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    .table th {
        background-color: #343a40;
        color: #ffffff;
    }
    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }
    .btn-success:hover {
        background-color: #218838;
        border-color: #218838;
    }
    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
    }
    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #e0a800;
    }
    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }
    .btn-danger:hover {
        background-color: #c82333;
        border-color: #c82333;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4 content-header">
    <h2><i class="fa-solid fa-users"></i> Liste des Employés</h2>
    <a href="{{ route('employes.create') }}" class="btn btn-success">
        <i class="fa-solid fa-user-plus"></i> Ajouter un employé
    </a>
</div>

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Succès !',
            text: '{{ session("success") }}',
            timer: 2000,
            showConfirmButton: false
        });
    </script>
@endif

<table class="table table-hover">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Poste</th>
            <th>Date d'embauche</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($employes as $employe)
            <tr>
                <td>{{ $employe->id }}</td>
                <td><strong>{{ $employe->nom }}</strong></td>
                <td>{{ $employe->prenom }}</td>
                <td>
                    <a href="mailto:{{ $employe->email }}" class="text-decoration-none">
                        <i class="fa-solid fa-envelope"></i> {{ $employe->email }}
                    </a>
                </td>
                <td>{{ $employe->telephone }}</td>
                <td>
                    <span class="badge bg-primary">{{ $employe->poste }}</span>
                </td>
                <td>{{ $employe->date_embauche }}</td>
                <td>
                    <a href="{{ route('employes.edit', $employe->id) }}" class="btn btn-warning btn-sm">
                        <i class="fa-solid fa-edit"></i> Modifier
                    </a>
                    <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $employe->id }}">
                        <i class="fa-solid fa-trash"></i> Supprimer
                    </button>
                    <form id="delete-form-{{ $employe->id }}" action="{{ route('employes.destroy', $employe->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            let employeId = this.getAttribute('data-id');
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Cette action est irréversible !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimer !',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + employeId).submit();
                }
            });
        });
    });
</script>
@endsection
