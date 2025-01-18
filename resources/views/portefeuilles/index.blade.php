@extends('layouts.app')

@section('title', 'Liste des Portefeuilles')

@section('content')
<h1 class="mb-4">Liste des Portefeuilles</h1>

<a href="{{ route('portefeuilles.create') }}" class="btn btn-primary mb-3">Ajouter un portefeuille</a>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Nom du portefeuille</th>
            <th>Cryptomonnaie</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($portefeuilles as $portefeuille)
        <tr>
            <td>{{ $portefeuille->nom_portefeuille }}</td>
            <td>{{ $portefeuille->crypto->nom_crypto }}</td>
            <td>
                <a href="{{ route('portefeuilles.show', $portefeuille->id_portefeuilles) }}" class="btn btn-info btn-sm">Voir les détails</a>
                <a href="{{ route('portefeuilles.fonds', $portefeuille->id_portefeuilles) }}" class="btn btn-warning btn-sm ml-2">Gérer les fonds</a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center">Aucun portefeuille trouvé.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
