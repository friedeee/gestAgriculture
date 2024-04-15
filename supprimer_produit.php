<?php
// Inclure le fichier de connexion à la base de données
include ('db.php');

// Vérifier si l'ID du produit à supprimer est passé en paramètre
if(isset($_GET['id'])) {
    $idProduit = $_GET['id'];

    // Préparer et exécuter la requête de suppression du produit
    $requeteSuppression = $variable->prepare('DELETE FROM produit WHERE idProd = ?');
    $requeteSuppression->execute([$idProduit]);

    // Envoyer une réponse indiquant le succès ou l'échec de la suppression
    if($requeteSuppression) {
        echo "Produit supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression du produit.";
    }
} else {
    echo "ID de produit non fourni.";
}
?>
