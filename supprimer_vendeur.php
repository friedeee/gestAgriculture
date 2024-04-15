<?php
// Inclure le fichier de connexion à la base de données
include('db.php');

// Vérifier si l'identifiant du vendeur à supprimer est passé en paramètre
if(isset($_GET['id']) && !empty($_GET['id'])) {
    // Récupérer l'identifiant du vendeur à supprimer depuis les paramètres de l'URL
    $idVendeur = $_GET['id'];

    // Préparer la requête de suppression du vendeur
    $suppression = $variable->prepare('DELETE FROM vendeur WHERE idVendeur = ?');

    // Exécuter la requête de suppression avec l'identifiant du vendeur
    $resultat = $suppression->execute([$idVendeur]);

    // Vérifier si la suppression a réussi
    if($resultat) {
        // Répondre avec un statut HTTP 200 (OK) pour indiquer que la suppression a réussi
        http_response_code(200);
        // Terminer l'exécution du script
        exit();
    } else {
        // Répondre avec un statut HTTP 500 (Erreur interne du serveur) pour indiquer que la suppression a échoué
        http_response_code(500);
        // Terminer l'exécution du script
        exit();
    }
} else {
    // Répondre avec un statut HTTP 400 (Mauvaise requête) si l'identifiant du vendeur n'est pas spécifié
    http_response_code(400);
    // Terminer l'exécution du script
    exit();
}
?>
