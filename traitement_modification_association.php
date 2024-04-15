<?php
// Vérifier si des données ont été envoyées via la méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si l'identifiant du vendeur et du produit ainsi que le nouveau vendeur ont été envoyés
    if (isset($_POST["idVendeur"]) && isset($_POST["idProduit"]) && isset($_POST["nouveauVendeur"])) {
        // Récupérer les valeurs envoyées depuis le formulaire
        $idVendeur = $_POST["idVendeur"];
        $idProduit = $_POST["idProduit"];
        $nouveauVendeur = $_POST["nouveauVendeur"];

        // Effectuer la modification dans la base de données
        include('db.php'); // Inclure le fichier de connexion à la base de données
        $requete = $variable->prepare('UPDATE prodvendeur SET idVendeur = ? WHERE idVendeur = ? AND idProd = ?');
        $requete->execute([$nouveauVendeur, $idVendeur, $idProduit]);

        // Rediriger vers la page principale ou afficher un message de succès
        header("Location: index.php"); // Remplacer "index.php" par la page souhaitée
        exit(); // Arrêter l'exécution du script après la redirection
    } else {
        // Les identifiants du vendeur et du produit, ainsi que le nouveau vendeur n'ont pas été envoyés
        echo "Erreur : Veuillez sélectionner un nouveau vendeur.";
    }
} else {
    // La méthode HTTP utilisée n'est pas POST
    echo "Erreur : La méthode de requête HTTP n'est pas valide.";
}
?>
