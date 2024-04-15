<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Association Vendeur à Produit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
        .btn a {
            text-decoration: none; 
            color: white;
            font-size: 15px;
        }
    </style>
</head>
<body>
    <h1>Modifier Association Vendeur à Produit</h1>
    <form action="traitement_modification_association.php" method="post">
        <input type="hidden" name="idVendeur" value="<?php echo $_GET['idVendeur']; ?>">
        <input type="hidden" name="idProduit" value="<?php echo $_GET['idProduit']; ?>">
        
        <label for="nouveauVendeur">Sélectionner un nouveau Vendeur :</label>
        <select id="nouveauVendeur" name="nouveauVendeur" required>
            <?php
            // Inclure le fichier de connexion à la base de données
            include('db.php');
            // Sélectionner tous les enregistrements de vendeurs depuis la base de données
            $requeteVendeurs = $variable->prepare('SELECT idVendeur, nomVendeur, prenomVendeur FROM vendeur');
            $requeteVendeurs->execute();
            $resultatsVendeurs = $requeteVendeurs->fetchAll(PDO::FETCH_ASSOC);
            foreach ($resultatsVendeurs as $vendeur) {
                echo '<option value="' . $vendeur['idVendeur'] . '">' . $vendeur['nomVendeur'] . ' ' . $vendeur['prenomVendeur'] . '</option>';
            }
            ?>
        </select>

        <button type="submit" class="btn"><a href="affectation.php">Modifier</a></button>
    </form>
</body>
</html>
