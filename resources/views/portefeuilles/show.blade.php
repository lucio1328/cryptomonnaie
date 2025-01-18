@extends('layouts.app')

@section('title', 'Détails du Portefeuille')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Card for Portfolio Details -->
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Détails du Portefeuille: {{ $portefeuille->nom_portefeuille }}</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <p><strong>Nom du portefeuille:</strong> {{ $portefeuille->nom_portefeuille }}</p>
                    </div>
                    <div class="mb-3">
                        <p><strong>Solde:</strong> <span class="text-success">{{ number_format($portefeuille->solde, 5) }}</span></p>
                    </div>
                    <div class="mb-3">
                        <p><strong>Cryptomonnaie:</strong> {{ $portefeuille->crypto->nom_crypto }}</p>
                    </div>
                    <div class="mb-3">
                        <p><strong>Prix actuel:</strong> {{ number_format($portefeuille->crypto->prix_actuel, 2) }} Ar</p>
                    </div>
                    <div class="mb-3">
                        <p><strong>Date de création:</strong> {{ $portefeuille->date_creation->format('d/m/Y') }}</p>
                    </div>
                    <!-- solde == quantite crypto -->
                    <div class="alert alert-info">
                        <strong>Valeur actuelle du portefeuille:</strong> {{ number_format($portefeuille->solde * $portefeuille->crypto->prix_actuel , 2) }} Ar
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('portefeuilles.liste') }}" class="btn btn-secondary">Retour à la liste</a>
                    <a href="{{ route('portefeuilles.fonds', $portefeuille->id_portefeuilles) }}" class="btn btn-warning btn-sm ml-2">Gérer les fonds</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
