@extends('layouts.app')

@section('content')
<div class="container flex justify-center items-center h-screen">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-md">
        <h2 class="text-xl font-bold text-center mb-6">Connexion Employé</h2>
        
        @if (session('error'))
            <div class="mb-4 text-red-500">{{ session('error') }}</div>
        @endif
        
        <form action="{{ route('employes.login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium">Email</label>
                <input type="email" name="email" id="email" required class="w-full px-3 py-2 border rounded">
            </div>
            
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium">Mot de passe</label>
                <input type="password" name="password" id="password" required class="w-full px-3 py-2 border rounded">
            </div>
            
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Se connecter</button>
        </form>
    </div>
</div>
@endsection