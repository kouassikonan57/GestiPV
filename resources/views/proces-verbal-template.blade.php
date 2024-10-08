<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Relevé de Notes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        h1, h2, h3 {
            text-align: center;
        }
    </style>
</head>
<body>
<h1>UNIVERSITÉ FÉLIX HOUPHOUËT-BOIGNY</h1>
<h2>UFR Mathématiques et Informatique</h2>
<h2>RELEVÉ DE NOTES</h2>

<p>Année Universitaire: 2022-2023</p>
<p>Diplôme Préparé: Master</p>
<p>Mention: Informatique</p>
<p>Niveau: Master 1</p>
<p>Nom: {{ $etudiant->nom }} {{ $etudiant->prenom }}</p>
<p>Identifiant Permanent: {{ $etudiant->matricule }}</p>
<p>Date et Lieu de Naissance: {{ $etudiant->date_naissance }} à {{ $etudiant->lieu_naissance }}</p>

@foreach($decisionSemestres as $semestreData)
    <h3>Semestre {{ $semestreData['semestre']->libelle }}</h3>
    <table>
        <thead>
        <tr>
            <th>Codes</th>
            <th>Unités d'Enseignement</th>
            <th>Crédits</th>
            <th>Moyennes</th>
        </tr>
        </thead>
        <tbody>
        @foreach($semestreData['semestre']->ues as $ue)
            <tr>
                <td>{{ $ue->code }}</td>
                <td>{{ $ue->libelle }}</td>
                <td>{{ $ue->getTotalCoefficient() }}</td>
                <td>{{ $ue->mention->moyenne ?? 'N/A' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <p>Moyenne Semestrielle: {{ $semestreData['moyenne'] }}</p>
    <p>Décision Semestrielle: {{ $semestreData['decision'] }}</p>
@endforeach

<h3>Total Crédits: {{ $totalCredits }}</h3>
<h3>Décision Annuelle: {{ $decisionAnnuelle }}</h3>

<p>Abidjan, le {{ date('d F Y') }}</p>
<p>Le Directeur Adjoint chargé de la Pédagogie,</p>
<br>
<p>Signature:</p>
</body>
</html>
