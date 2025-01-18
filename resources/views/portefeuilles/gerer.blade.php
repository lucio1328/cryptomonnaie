@extends('layouts.app')

@section('title', 'Gérer les Fonds')

@section('content')
<h1>Gérer les Fonds du Portefeuille: {{ $portefeuille->nom_portefeuille }}</h1>

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

<form action="{{ route('portefeuilles.storeFonds', $portefeuille->id_portefeuilles) }}" method="POST">
    @csrf
    <input type="hidden" name="id_portefeuilles" value="{{ $portefeuille->id_portefeuilles }}">
    <div class="form-group">
        <label for="type_operation">Type d'Opération</label>
        <select name="type_operation" id="type_operation" class="form-control">
            <option value="">Sélectionner un type d'opération</option>
            @foreach ($typeFonds as $type)
                <option value="{{ $type->id_type_fonds }}">{{ $type->type }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="montant">Montant</label>
        <input type="number" name="montant" id="montant" class="form-control" step="0.01" required>
    </div>

    <div class="form-group">
        <label for="daty">Date de l'opération</label>
        <input type="date" name="daty" id="daty" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Enregistrer l'opération</button>
</form>

<a href="{{ route('portefeuilles.show', $portefeuille->id_portefeuilles) }}" class="btn btn-secondary mt-3">Retour</a>
@endsection
