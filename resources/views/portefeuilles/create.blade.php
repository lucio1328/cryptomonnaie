@extends('layouts.app')

@section('title', 'Ajouter un Portefeuille')

@section('content')
<div class="card p-5">
    <h1 class="text-center">Ajouter un Portefeuille</h1>
    <form action="#" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nom_portefeuille" class="form-label">Nom du Portefeuille</label>
            <input type="text" id="nom_portefeuille" name="nom_portefeuille" class="form-control" placeholder="Entrez le nom du portefeuille" required>
        </div>
        <div class="mb-3">
            <label for="solde" class="form-label">Solde</label>
            <input type="number" id="solde" name="solde" class="form-control" step="0.00001" placeholder="0" required>
        </div>
        <div class="mb-3">
            <input type="hidden" id="Id_utilisateur" name="Id_utilisateur" value="1" class="form-control" placeholder="Entrez l'ID de l'utilisateur" required>
        </div>
        <div class="mb-3">
            <label for="Id_cryptos" class="form-label">Cryptomonnaie</label>
            <select id="Id_cryptos" name="Id_cryptos" class="form-control" required>
                <option value="">Sélectionnez une cryptomonnaie</option>
                @foreach($cryptos as $crypto)
                    <option value="{{ $crypto->id_cryptos }}">{{ $crypto->nom_crypto }} ({{ $crypto->symbole }})</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary w-100">Ajouter</button>
    </form>
</div>
@endsection
