@extends('layout')
@section('content')
<div class="container">
    <h2>Changer votre mot de passe</h2>
    
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    
    <form action="{{ route('employe.update-password') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label class="form-label">Mot de passe actuel</label>
            <input type="password" name="current_password" class="form-control" required>
            @error('current_password')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label class="form-label">Nouveau mot de passe</label>
            <input type="password" name="password" class="form-control" required>
            @error('password')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label class="form-label">Confirmer le nouveau mot de passe</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Changer le mot de passe</button>
    </form>
</div>
@endsection