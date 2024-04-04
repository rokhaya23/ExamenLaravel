<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrat de travail</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .info {
            margin-bottom: 20px;
        }
        .info h2 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .info p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <div class="small-container">
            <div class="inner-header text-center" style="text-align: center">
                <h1>Contrat de travail</h1>
            </div>
            <div class="inner-content">
                <p>Entre les soussignés :</p>
                <p>Zenix Technologies, société SARL, au capital de 10.000.000.000 CFA, dont le siège social est situé à DAKAR, immatriculée au Registre du Commerce et des Sociétés de DAKAR sous le numéro 12097642310, représentée par Massamba DIOUF, en qualité de Directeur Générale, dûment habilité aux fins des présentes.</p>
                <p>D'une part,</p>
                <p>Et :</p>
                <p>{{$contrat->employee->prenom}} {{$contrat->employee->nom}}, @if($contrat->employee->sexe=='M')  né @else née @endif le {{date('d F Y',strtotime($contrat->employee->date_naissance))}}, demeurant au {{$contrat->employee->adresse}}, de nationalité [Senegalaise], titulaire de la carte d'identité ou du passeport numéro [12098746], délivré(e) le [02/08/2009].</p>
                <p>D'autre part,</p>
                <p>Il a été convenu et arrêté ce qui suit :</p>
                <h3>Article 1 - Engagement</h3>
                <p>L'employeur engage l'employé(e) en qualité de {{$contrat->employee->poste}} , à compter du {{ date('d F Y', strtotime($contrat->date_debut)) }}.</p>
                <h3>Article 2 - Durée</h3>
                @if($contrat->type_contrat=='CDI')
                    <p>Le présent contrat est conclu pour une durée indéterminée.</p>
                @elseif($contrat->type_contrat=='CDD')
                    <p>Le présent contrat est conclu pour une durée de {{ date('d F Y', strtotime($contrat->date_debut)) }} à {{ date('d F Y', strtotime($contrat->date_fin)) }}.</p>
                @else
                    <p>Le présent contrat est conclu pour une Prestation de service.</p>
                @endif
                <h3>Article 3 - Rémunération</h3>
                <p>L'employé(e) percevra une rémunération de {{$contrat->employee->salaire}} CFA bruts par mois.</p>
                <h3>Article 4 - Obligations de l'employé(e)</h3>
                <p>L'employé(e) s'engage à :</p>
                <ul>
                    <li>exécuter les tâches qui lui sont confiées avec diligence et professionnalisme ;</li>
                    <li>respecter les consignes et règlements de l'entreprise ;</li>
                    <li>préserver les intérêts et la réputation de l'entreprise.</li>
                </ul>
                <h3>Article 5 - Obligations de l'employeur</h3>
                <ul>
                    <li>verser la rémunération convenue à l'employé(e) dans les délais convenus ;</li>
                    <li>assurer un environnement de travail sûr et respectueux des droits de l'employé(e) ;</li>
                    <li>respecter les dispositions légales et réglementaires en vigueur en matière de droit du travail.</li>
                </ul>
                <h3>Article 6 - Résiliation</h3>
                <p>Le présent contrat pourra être résilié par l'une ou l'autre des parties, moyennant un préavis de 20 jours.</p>
                <p>Fait en double exemplaire à DAKAR, le {{date('d F Y')}}, en présence des témoins soussignés :</p>
                <div class="signature">
                    <p>Signature de l'employeur :</p>
                    <p>Signature de l'employé(e) :</p>
                    <p>Témoins :</p>
                </div>
            </div>

        </div>

    </div>
    <!-- /Page Content -->

</div>

</body>
</html>
