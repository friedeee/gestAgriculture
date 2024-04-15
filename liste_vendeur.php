<?php
include('db.php');

// Sélectionner tous les enregistrements de vendeurs depuis la base de données
$requete = $variable->prepare('SELECT idVendeur, nomVendeur, prenomVendeur, tel, email, dateNaissance FROM vendeur');
$requete->execute();
$resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Vendeurs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        thead {
            background-color: #f2f2f2;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .actions {
            display: flex;
            justify-content: space-between;
        }

        .actions a:hover, .actions button:hover {
            background-color: #45a049;
        }

        .actions a, .actions button {
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .actions a:hover, .actions button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Liste des Vendeurs</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Téléphone</th>
                <th>Email</th>
                <th>Date de Naissance</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultats as $vendeur): ?>
                <tr>
                    <td><?php echo $vendeur['idVendeur']; ?></td>
                    <td><?php echo $vendeur['nomVendeur']; ?></td>
                    <td><?php echo $vendeur['prenomVendeur']; ?></td>
                    <td><?php echo $vendeur['tel']; ?></td>
                    <td><?php echo $vendeur['email']; ?></td>
                    <td><?php echo $vendeur['dateNaissance']; ?></td>
                    <td>
                        <a href="modifiervend.php?id=<?php echo $vendeur['idVendeur']; ?>">Modifier</a>
                        <form action="traitement_vendeur_sup.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $vendeur['idVendeur']; ?>">
                            <button type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="actions"> <br> <br>
        <a href="vendeurs.php">Ajouter un Vendeur</a>
        <a href="accueil.html">Retour à l'accueil</a>
    </div>
</body>
</html>
