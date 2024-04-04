<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attestation de travail</title>
    <!-- styles, si nécessaire -->
</head>
<body>
<h1>Attestation de travail</h1>

<p>Fait à [Ville], le {{ date('d F Y') }}</p>

<p>Je soussigné(e) [Nom du signataire], [Fonction du signataire] de la société [Nom de la société], certifie que :</p>

<p>Mr/Mme {{ $employee->prenom }} {{ $employee->nom }}, @if($employee->sexe == 'M') né @else née @endif le {{ date('d F Y', strtotime($employee->date_naissance)) }}, demeurant au {{ $employee->adresse }}, a été engagé(e) par notre société en qualité de {{ $employee->poste }} le {{ date('d F Y', strtotime($employee->date_embauche)) }}.</p>

<p>Cette attestation est délivrée à la demande de l'intéressé(e) pour servir et valoir ce que de droit.</p>

<p>Fait pour servir et valoir ce que de droit.</p>

<div>
    <p>Signature du responsable :</p>
</div>
</body>
</html>
