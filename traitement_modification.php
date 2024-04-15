<?php
include('db.php');

// Vérifier si le formulaire de modification a été soumis
if(isset($_POST['btnModifier'])) {
    // Récupérer les données du formulaire
    $idProduit = $_POST['id'];
    $nomProduit = $_POST['nom'];
    $prixProduit = $_POST['prix'];

    // Mettre à jour les informations du produit dans la base de données
    $requete = $variable->prepare('UPDATE produit SET nomProd = ?, prix = ? WHERE idProd = ?');
    $requete->execute([$nomProduit, $prixProduit, $idProduit]);

    // Rediriger vers la page listant les produits après la modification
    header('Location: liste_produits.php');
    exit; // Arrêter l'exécution du script
} else {
    // Rediriger vers une page d'erreur si le formulaire de modification n'a pas été soumis
    header('Location: erreur.php');
    exit; // Arrêter l'exécution du script
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Produit</title>
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

        input[type="text"],
        input[type="number"] {
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

    </style>
</head>
<body>
    <h1>Modifier Produit</h1>
    <form action="traitement_modification.php" method="post">
        <input type="hidden" name="id" value="<?php echo $produit['idProd']; ?>">
        <label for="nom">Nom du Produit :</label>
        <input type="text" id="nom" name="nom" value="<?php echo $produit['nomProd']; ?>" required>
        <label for="prix">Prix (FCFA) :</label>
        <input type="number" id="prix" name="prix" value="<?php echo $produit['prix']; ?>" step="0.01" min="0" required>
        <button type="submit" name="btnModifier">Modifier</button>
    </form>
</body>
</html>
