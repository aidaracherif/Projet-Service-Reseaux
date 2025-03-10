@extends('layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa-solid fa-building"></i> Liste des Clients</h2>
        <a href="{{ route('clients.create') }}" class="btn btn-success">
            <i class="fa-solid fa-user-plus"></i> Ajouter un client
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
                <th>Nom Entreprise</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Adresse</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
                <tr>
                    <td>{{ $client->id }}</td>
                    <td><strong>{{ $client->nom }}</strong></td>
                    <td>{{ $client->prenom }}</td>
                    <td>{{ $client->nom_entreprise }}</td>
                    <td>{{ $client->contact }}</td>
                    <td><a href="mailto:{{ $client->email }}" class="text-decoration-none">{{ $client->email }}</a></td>
                    <td>{{ $client->adresse }}</td>
                    <td>
                        <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning btn-sm">
                            <i class="fa-solid fa-edit"></i> Modifier
                        </a>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $client->id }}">
                            <i class="fa-solid fa-trash"></i> Supprimer
                        </button>
                        <form id="delete-form-{{ $client->id }}" action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display: none;">
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
                let clientId = this.getAttribute('data-id');
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
                        document.getElementById('delete-form-' + clientId).submit();
                    }
                });
            });
        });
    </script>
@endsection
