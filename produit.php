<?php
include ('db.php');
    if(isset($_POST['btn']))
    {
        //Controle du champ nom
        if(isset($_POST['nom']))
        {
            if(trim($_POST['nom']==""))
            {
                $error_nom = "Veillez entrer de vrais valeurs";
            }else
            {
                $t=$variable -> prepare('SELECT COUNT(idProd) AS nbr FROM produit WHERE nomProd=?');
                $t -> execute(array($_POST['nom']));
                # code...
                while ($ts = $t -> fetch()) {
                    $nbr = $ts['nbr'];
                }
                if($nbr > 0)
                {
                    $error_nom = "Ce produit existe déjà";
                }else
                {
                    $nom = htmlspecialchars($_POST['nom']);
                }
            }
            
        }else
        {
            $error_nom = "Champ obligatoire";
        }

        //Controle du champ de prix
        if(isset($_POST['prix']))
        {
            if(trim($_POST['prix']==""))
            {
                $error_prix = "Entrez de vraies valeurs";
            }else
            {
                if($_POST['prix'] < 0)
                {
                    $error_prix = "Le prix doit être supérieur à 0";
                }else
                {
                    $prix = htmlspecialchars($_POST['prix']);
                }
            }
        }else
        {
            $error_prix = "Champ obligatoire";
        }

        //Controle générale et insertion
        if(empty($error_nom) && empty($error_prix))
        {
            $ajout = $variable -> prepare('INSERT INTO produit(nomProd, prix) VALUES (?, ?)');
            $ajout -> execute(array($nom, $prix));
            if($ajout)
            {
                $msg = "Enregistrement éffectué";
            }else
            {
                $msg = "Enregistrement non éffectué";
            }
        }else
        {
            $msg = "Remplissez tous les champs";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits</title>
    <link rel="stylesheet" href="prod.css">
    <script>
    function supprimerProduit(id) {
    if (confirm("Êtes-vous sûr de vouloir supprimer ce produit ?")) {
        // Envoyer une requête AJAX vers le fichier PHP pour supprimer le produit
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    // Recharger la page après la suppression
                    window.location.reload();
                } else {
                    // Afficher un message d'erreur en cas d'échec de la suppression
                    alert("Erreur lors de la suppression du produit.");
                }
            }
        };
        xhr.open("GET", "supprimer_produit.php?id=" + id, true); // Remplacez "chemin_vers_supprimer_produit.php" par le chemin réel de votre fichier PHP
        xhr.send();
    }
}

    </script>
</head>
<body>
    <div class="main">
        <div class="menu">
            <ul>
                <li><a href="accueil.html">Accueil</a></li>
                <li><a href="vendeurs.php">Gestion des Vendeurs</a></li>
                <li><a href="produit.php">Gestion des Produits</a></li>
                <li><a href="affectation.php">Affectation</a></li>
            </ul>
        </div>
        <div class="cont">
            <form action="" method="post" >
                <div class="form-group">
                    <label for="nom">Nom du Produit :</label>
                    <input type="text" id="nom" name="nom" required>
                    <?php 
                    if(isset($error_nom))
                    {
                        echo $error_nom;
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label for="prix">Prix (FCFA) :</label>
                    <input type="number" id="prix" name="prix" step="0.1" min="0" required>
                    <small>Entrez le montant en Francs CFA.</small> <br> <br> <br>
                    <?php 
                    if(isset($error_prix))
                    {
                        echo $error_prix;
                    }
                    ?>
                <button type="submit" name="btn">Enregistrer</button>
                <?php 
                    if(isset($msg))
                    {
                        echo $msg;
                    }
                    ?>
            </form>
        </div>

        <style>
            .liste-produits table {
                width: 100%;
                border-collapse: collapse;
            }

            .liste-produits th, .liste-produits td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: center;
            }

            .liste-produits th {
                background-color: #f2f2f2;
            }
            .liste-produits h2
            {
                text-align: center;
            }
        </style>
        <div class="liste-produits">
            <h2 >Liste des Produits</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nom du Produit</th>
                        <th>Prix (FCFA)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Sélectionner tous les enregistrements de produits
                        $requete = $variable->prepare('SELECT idProd, nomProd, prix FROM produit');
                        $requete->execute();
                        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);

                        // Afficher les noms des produits dans un tableau HTML
                        foreach ($resultats as $produit) {
                            echo '<tr>';
                    echo '<td style="border-right: 1px solid #ddd;">' . $produit['nomProd'] . '</td>';
                    echo '<td style="border-right: 1px solid #ddd;">' . $produit['prix'] . '</td>';
                    echo '<td>';
                    echo '<a href="modifier.php?id=' . $produit['idProd'] . '" class="modifier">Modifier</a>';
                    echo '<a href="#" onclick="supprimerProduit(' . $produit['idProd'] . ');" class="supprimer">Supprimer</a>';
                    echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
            
</body>
</html>