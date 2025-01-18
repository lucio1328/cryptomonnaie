@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Historique des Transactions</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID Transaction</th>
                <th>Crypto</th>
                <th>Quantité</th>
                <th>Total</th>
                <th>Utilisateur</th>
                <th>Type de Transaction</th>
                <th>Date de Transaction</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id_transactions }}</td>
                    <td>{{ $transaction->cryptos->nom_crypto }}</td>
                    <td>{{ $transaction->quantite }}</td>
                    <td>{{ number_format($transaction->prix, 2) }} {{ $transaction->cryptos->symbole }}</td>
                    <td>{{ $transaction->utilisateur->nom }}</td>
                    <td>{{ $transaction->type_transaction->type }}</td>
                    <td>{{ $transaction->date_transaction->format('d-m-Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
