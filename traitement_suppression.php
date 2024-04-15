<?php
include('db.php');

// Vérifier si l'identifiant du produit à supprimer est passé en paramètre dans le formulaire
if(isset($_POST['id'])) {
    // Récupérer l'identifiant du produit à supprimer depuis le formulaire
    $idProduit = $_POST['id'];

    // Supprimer le produit de la base de données
    $requete = $variable->prepare('DELETE FROM produit WHERE idProd = ?');
    $requete->execute([$idProduit]);

    // Rediriger vers la page listant les produits après la suppression
    header('Location: liste_produits.php');
    exit; // Arrêter l'exécution du script
} else {
    // Rediriger vers une page d'erreur si l'identifiant du produit n'est pas spécifié
    header('Location: erreur.php');
    exit; // Arrêter l'exécution du script
}
?>