<!DOCTYPE html>
<html>
<head>
    <title>Confirmation de l'Opération de Fonds</title>
</head>
<body>
    <p>Bonjour,</p>
    <p>Votre opération de fonds a été enregistrée avec succès. Voici les détails :</p>
    <ul>
        <li>Montant en Ariary : {{ $fonds->montant_ariary }}</li>
        <li>Montant en USD : {{ $fonds->montant_usd }}</li>
        <li>Montant en Euro : {{ $fonds->montant_euro }}</li>
        <li>Date de l'opération : {{ $fonds->daty }}</li>
    </ul>

    <p><a href="{{ $confirmationLink }}">Cliquez ici pour valider l'opération</a></p>

    <p>Cordialement,<br>L'équipe de gestion des fonds</p>
</body>
</html>
