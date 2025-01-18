@extends('layouts.app')

@section('title', 'Liste des Cryptomonnaies')

@section('content')
<h1 class="mb-4">Liste des Cryptomonnaies</h1>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Symbole</th>
            <th>Pourcentage</th>
            <th>Prix Actuel</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($cryptos as $crypto)
        <tr>
            <td>{{ $crypto->nom_crypto }}</td>
            <td>{{ $crypto->symbole }}</td>
            <td>{{ number_format($crypto->pourcentage, 2) }}%</td>
            <td>{{ number_format($crypto->prix_actuel, 2) }}</td>
            <td>
                <a href="{{ route('cryptos.evolution', $crypto->id_cryptos) }}" class="btn btn-info btn-sm">Evolution</a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center">Aucune cryptomonnaie trouvée.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
