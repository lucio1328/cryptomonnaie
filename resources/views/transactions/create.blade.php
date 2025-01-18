@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Faire une Transaction</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="quantite" class="form-label">Quantité</label>
                <input type="number" name="quantite" id="quantite" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="date_transaction" class="form-label">Date de Transaction</label>
                <input type="date" name="date_transaction" id="date_transaction" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="id_cryptos" class="form-label">Cryptomonnaie</label>
                <select name="id_cryptos" id="id_cryptos" class="form-control" required>
                    <option value="">Sélectionnez une cryptomonnaie</option>
                    @foreach($cryptos as $crypto)
                        <option value="{{ $crypto->id_cryptos }}">{{ $crypto->nom_crypto }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="id_type_transaction" class="form-label">Type de Transaction</label>
                <select name="id_type_transaction" id="id_type_transaction" class="form-control" required>
                    <option value="">Sélectionnez un type de transaction</option>
                    @foreach($typeTransactions as $typeTransaction)
                        <option value="{{ $typeTransaction->id_type_transaction }}">{{ $typeTransaction->type }}</option>
                    @endforeach
                </select>
            </div>

            <input type="hidden" name="id_utilisateur" value="1">

            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>
@endsection
