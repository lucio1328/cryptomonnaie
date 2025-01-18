@extends('layouts.app')

@section('content')
    <h1>Liste des ventes</h1>

    @if($ventes->isEmpty())
        <p>Aucune vente trouvée.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID Transaction</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th>Date</th>
                    <th>Crypto</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventes as $vente)
                    <tr>
                        <td>{{ $vente->id_transactions }}</td>
                        <td>{{ $vente->quantite }}</td>
                        <td>{{ number_format($vente->prix, 2) }} €</td>
                        <td>{{ $vente->date_transaction }}</td>
                        <td>{{ $vente->cryptos->nom_crypto }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
