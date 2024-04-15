<?php
include('db.php');

$msg = $error_nom = '';

// Récupérer les informations du vendeur à modifier depuis la base de données
if(isset($_GET['id'])) {
    $idVendeur = $_GET['id'];
    $requete = $variable->prepare('SELECT * FROM vendeur WHERE idVendeur = ?');
    $requete->execute([$idVendeur]);
    $vendeur = $requete->fetch(PDO::FETCH_ASSOC);
}

// Vérifier si le formulaire de modification a été soumis
if(isset($_POST['btnModifier'])) {
    // Vérifier si l'identifiant du vendeur est passé en tant que champ caché dans le formulaire
    if(isset($_POST['id'])) {
        $idVendeur = $_POST['id'];
        
        // Récupérer les données soumises par le formulaire
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $tel = $_POST['tel'];
        $email = $_POST['email'];
        $date_naissance = $_POST['date_naissance'];

        // Procéder à la modification du vendeur
        $requete = $variable->prepare('UPDATE vendeur SET nomvendeur = ?, prenomvendeur = ?, tel = ?, email = ?, dateNaissance = ? WHERE idVendeur = ?');
        $requete->execute([$nom, $prenom, $tel, $email, $date_naissance, $idVendeur]);
        
        // Vérifier si la modification a été effectuée avec succès
        if($requete) {
            $msg = "Modification effectuée avec succès.";
        } else {
            $msg = "Une erreur s'est produite lors de la modification du vendeur.";
        }
    } else {
        // L'identifiant du vendeur n'a pas été passé dans le formulaire, afficher un message d'erreur
        $msg = "L'identifiant du vendeur est manquant.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Vendeur</title>
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
        input[type="tel"],
        input[type="email"],
        input[type="date"] {
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
            text-decoration: none; /* Enlève le soulignement du lien */
        }
    </style>
</head>
<body>
    <h1>Modifier Vendeur</h1>
    <?php if(isset($vendeur)): ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $vendeur['idVendeur']; ?>">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?php echo $vendeur['nomVendeur']; ?>" required>
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo $vendeur['prenomVendeur']; ?>" required>
        <label for="tel">Téléphone :</label>
        <input type="tel" id="tel" name="tel" value="<?php echo $vendeur['tel']; ?>" required>
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" value="<?php echo $vendeur['email']; ?>" required>
        <label for="date_naissance">Date de Naissance :</label>
        <input type="date" id="date_naissance" name="date_naissance" value="<?php echo $vendeur['dateNaissance']; ?>" required>
        <button type="submit" name="btnModifier">Modifier</button>
        <button type="submit" name="retour" class="bouton-retour"><a href="liste_vendeur.php">retour</a></button>
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
