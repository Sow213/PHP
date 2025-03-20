<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Médicaments - GSB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #1c1c68;
            color: #FFFFFF;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #000000;
            padding: 15px;
            text-align: center;
        }
        .header a {
            color: #87cb28;
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
        }
        .header a:hover {
            text-decoration: underline;
        }
        .card {
            background-color: #000000;
            border: 1px solid #87cb28;
            padding: 20px;
            margin: 15px 0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .card img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #87cb28;
        }
        .btn {
            background-color: #c61e18;
            color: white;
            padding: 8px 12px;
            display: inline-block;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 10px;
        }
        .btn:hover {
            background-color: #87cb28;
            color: #000000;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <a href="accueil.php">Accueil</a>
        <a href="medicaments.php">Médicaments</a>
        <a href="activite.php">Activités</a>
        <a href="pagejuridique.php">Mentions Légales</a>
    </div>

    <div class="container">
        <h1 class="text-3xl font-bold text-center mb-6">Médicaments fabriqués par GSB</h1>

        <?php
        // Tableau des médicaments (Simule une base de données)
        $medicaments = [
            [
                "nom" => "Doliprane",
                "image" => "https://via.placeholder.com/100", // Remplace par une vraie image
                "effets_thera" => "Soulage la douleur et la fièvre.",
                "effets_second" => "Risque d'hépatotoxicité en cas de surdosage.",
                "interactions" => "Interaction avec les anticoagulants."
            ],
            [
                "nom" => "Ibuprofène",
                "image" => "https://via.placeholder.com/100",
                "effets_thera" => "Antalgique et anti-inflammatoire.",
                "effets_second" => "Troubles digestifs, maux de tête.",
                "interactions" => "Ne pas associer avec l'aspirine."
            ],
            [
                "nom" => "Amoxicilline",
                "image" => "https://via.placeholder.com/100",
                "effets_thera" => "Antibiotique contre les infections bactériennes.",
                "effets_second" => "Allergies, troubles digestifs.",
                "interactions" => "Réduit l'efficacité des contraceptifs oraux."
            ]
        ];

        // Affichage des médicaments
        foreach ($medicaments as $med) {
            echo "
            <div class='card'>
                <img src='{$med['image']}' alt='Image de {$med['nom']}'>
                <div>
                    <h2 class='text-xl font-bold'>{$med['nom']}</h2>
                    <p><strong>Effets thérapeutiques :</strong> {$med['effets_thera']}</p>
                    <p><strong>Effets secondaires :</strong> {$med['effets_second']}</p>
                    <p><strong>Interactions :</strong> {$med['interactions']}</p>
                    <a href='details.php?medicament=" . urlencode($med['nom']) . "' class='btn'>Voir plus</a>
                </div>
            </div>";
        }
        ?>
    </div>

</body>
</html>
