<?php
// Vérifier si des données ont été envoyées via la méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les champs vendeur et produit ont été envoyés
    if (isset($_POST["vendeur"]) && isset($_POST["produit"])) {
        // Récupérer les valeurs envoyées depuis le formulaire
        $idVendeur = $_POST["vendeur"];
        $idProduit = $_POST["produit"];

        // Inclure le fichier de connexion à la base de données
        include('db.php');

        // Vérifier si le vendeur existe déjà dans la base de données
        $requeteVerificationVendeur = $variable->prepare('SELECT idVendeur FROM vendeur WHERE idVendeur = ?');
        $requeteVerificationVendeur->execute([$idVendeur]);
        $resultatVerificationVendeur = $requeteVerificationVendeur->fetch(PDO::FETCH_ASSOC);

        // Vérifier si le produit existe déjà dans la base de données
        $requeteVerificationProduit = $variable->prepare('SELECT idProd FROM produit WHERE idProd = ?');
        $requeteVerificationProduit->execute([$idProduit]);
        $resultatVerificationProduit = $requeteVerificationProduit->fetch(PDO::FETCH_ASSOC);

        // Si le vendeur n'existe pas dans la base de données, l'insérer
        if (!$resultatVerificationVendeur) {
            // Insérer le vendeur dans la base de données
            // Remplacez les placeholders par les valeurs réelles de votre vendeur
            $requeteInsertionVendeur = $variable->prepare('INSERT INTO vendeur (idVendeur, $nomVendeur, $prenomVendeur, tel, email, dateNaissance) VALUES (?, ...)');
            $requeteInsertionVendeur->execute([$idVendeur, $nomVendeur, $prenomVendeur, tel, email, dateNaissance]); // Remplacez les placeholders par les valeurs réelles de votre vendeur
        }

        // Si le produit n'existe pas dans la base de données, l'insérer
        if (!$resultatVerificationProduit) {
            // Insérer le produit dans la base de données
            // Remplacez les placeholders par les valeurs réelles de votre produit
            $requeteInsertionProduit = $variable->prepare('INSERT INTO produit (idProd, ...) VALUES (?, ...)');
            $requeteInsertionProduit->execute([$idProduit, prix]); // Remplacez les placeholders par les valeurs réelles de votre produit
        }

        // Insérer les données d'association dans la base de données
        $requete = $variable->prepare('INSERT INTO prodvendeur (idVendeur, idProd) VALUES (?, ?)');
        $requete->execute([$idVendeur, $idProduit]);

        // Rediriger vers la page principale ou afficher un message de succès
        header("Location: index.php"); 
        exit(); // Arrêter l'exécution du script après la redirection
    } else {
        // Les champs vendeur et produit n'ont pas été envoyés
        echo "Erreur : Veuillez sélectionner un vendeur et un produit.";
    }
} else {
    // La méthode HTTP utilisée n'est pas POST
    echo "Erreur : La méthode de requête HTTP n'est pas valide.";
}
?>
