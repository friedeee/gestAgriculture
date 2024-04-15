<?php
include('db.php');

$msg = $error_nom = '';

// Récupérer les informations du produit à modifier depuis la base de données
if(isset($_GET['id'])) {
    $idProduit = $_GET['id'];
    $requete = $variable->prepare('SELECT * FROM produit WHERE idProd = ?');
    $requete->execute([$idProduit]);
    $produit = $requete->fetch(PDO::FETCH_ASSOC);
}

// Vérifier si le formulaire de modification a été soumis
if(isset($_POST['btnModifier'])) {
    // Vérifier si l'identifiant du produit est passé en tant que champ caché dans le formulaire
    if(isset($_POST['id'])) {
        $idProduit = $_POST['id'];
        
        // Récupérer les données soumises par le formulaire
        $nom = $_POST['nom'];
        $prix = $_POST['prix'];

        // Vérifier si le nom du produit existe déjà dans la base de données (sauf pour le produit actuel)
        $requete = $variable->prepare('SELECT COUNT(*) AS nbr FROM produit WHERE nomProd = ? AND idProd != ?');
        $requete->execute([$nom, $idProduit]);
        $resultat = $requete->fetch(PDO::FETCH_ASSOC);

        if($resultat['nbr'] > 0) {
            // Le produit existe déjà, afficher un message d'erreur
            $error_nom = "Ce produit existe déjà.";
        } else {
            // Le produit n'existe pas encore, procéder à la modification
            $requete = $variable->prepare('UPDATE produit SET nomProd = ?, prix = ? WHERE idProd = ?');
            $requete->execute([$nom, $prix, $idProduit]);
            
            // Vérifier si la modification a été effectuée avec succès
            if($requete) {
                $msg = "Modification effectuée avec succès.";
            } else {
                $msg = "Une erreur s'est produite lors de la modification du produit.";
            }
        }
    } else {
        // L'identifiant du produit n'a pas été passé dans le formulaire, afficher un message d'erreur
        $msg = "L'identifiant du produit est manquant.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
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

                /* Styles CSS pour le bouton de retour */
        .bouton-retour {
            position: fixed;
            bottom: 20px; /* ajustez la distance du bas selon votre préférence */
            right: 20px; /* ajustez la distance de la gauche selon votre préférence */
            display: block;
            width: 120px;
            padding: 10px;
            margin: 20px auto;
            background-color: #007bff;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .bouton-retour:hover {
            background-color: #0056b3;
        }
        .bouton-retour a {
            text-decoration: none; 
        }
    </style>
</head>
<body>
    <h1>Modifier Produit</h1>
    <?php if(isset($produit)): ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $produit['idProd']; ?>">
        <label for="nom">Nom du Produit :</label>
        <input type="text" id="nom" name="nom" value="<?php echo $produit['nomProd']; ?>" required>
        <label for="prix">Prix (FCFA) :</label>
        <input type="number" id="prix" name="prix" value="<?php echo $produit['prix']; ?>" step="0.01" min="0" required>
        <button type="submit" name="btnModifier">Modifier</button>
        <button type="submit" name="retour" class="bouton-retour"><a href="liste_produits.php">retour</a></button>
    </form>

    <!-- Boîte de dialogue pour les messages -->
    <div id="messageBox" style="display: none;">
        <p id="messageContent"></p>
        <button onclick="closeMessageBox()">Fermer</button>
    </div>
    <script>
        // Fonction pour afficher un message dans la boîte de dialogue
        function showMessage(message) {
            document.getElementById('messageContent').innerText = message;
            document.getElementById('messageBox').style.display = 'block';
        }

        // Fonction pour fermer la boîte de dialogue
        function closeMessageBox() {
            document.getElementById('messageBox').style.display = 'none';
        }

    <?php endif; ?>
    <?php if(isset($msg)) echo "<p>$msg</p>"; ?>
    <?php if(isset($error_nom)) echo "<p>$error_nom</p>"; ?>
</body>
</html>
