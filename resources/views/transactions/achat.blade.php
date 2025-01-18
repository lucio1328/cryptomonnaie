@extends('layouts.app')

@section('content')
    <h1>Liste des achats</h1>

    @if($achats->isEmpty())
        <p>Aucun achat trouvé.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID Transaction</th>
                    <th>Quantité</th>
                    <th>Prix</th>
                    <th>Date</th>
                    <th>Crypto</th>
                </tr>
            </thead>
            <tbody>
                @foreach($achats as $achat)
                    <tr>
                        <td>{{ $achat->id_transactions }}</td>
                        <td>{{ $achat->quantite }}</td>
                        <td>{{ number_format($achat->prix, 2) }} €</td>
                        <td>{{ $achat->date_transaction }}</td>
                        <td>{{ $achat->cryptos->nom_crypto }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
