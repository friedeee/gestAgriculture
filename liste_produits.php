<?php
include('db.php');

// Sélectionner tous les enregistrements de produits depuis la base de données
$requete = $variable->prepare('SELECT idProd, nomProd, prix FROM produit');
$requete->execute();
$resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Produits</title>
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
    <h1>Liste des Produits</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom du Produit</th>
                <th>Prix (FCFA)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultats as $produit): ?>
                <tr>
                    <td><?php echo $produit['idProd']; ?></td>
                    <td><?php echo $produit['nomProd']; ?></td>
                    <td><?php echo $produit['prix']; ?></td>
                    <td>
                        <a href="modifier.php?id=<?php echo $produit['idProd']; ?>">Modifier</a>
                        <form action="traitement_suppression.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $produit['idProd']; ?>">
                            <button type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table> <br> <br>
    <div class="actions">
        <a href="produit.php">Retour à la page des produits</a>
    </div>
</body>
</html>
