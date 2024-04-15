<?php
// Inclure le fichier de connexion à la base de données
include('db.php');

// Vérifier si l'identifiant du vendeur à supprimer est passé en paramètre dans le formulaire
if(isset($_POST['id'])) {
    // Récupérer l'identifiant du vendeur à supprimer depuis le formulaire
    $idVendeur = $_POST['id'];

    // Supprimer le vendeur de la base de données
    $requete = $variable->prepare('DELETE FROM vendeur WHERE idVendeur = ?');
    $requete->execute([$idVendeur]);

    // Rediriger vers la page listant les vendeurs après la suppression
    header('Location: liste_vendeurs.php');
    exit; // Arrêter l'exécution du script
} else {
    // Rediriger vers une page d'erreur si l'identifiant du vendeur n'est pas spécifié
    header('Location: erreur.php');
    exit; // Arrêter l'exécution du script
}
?>
