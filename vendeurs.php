<?php
include ('db.php');
$dateNaissance = "01-20-2000";
$email = "adressemail@gmail.com";
    if(isset($_POST['btn']))
    {
        //Controle du champ nom
        if(isset($_POST['nom']))
        {
            if(empty(trim($_POST['nom'])))
            {
                $error_nom = "Veuillez entrer un nom valide";
            }
            else
            {
                // Le nom est valide
                $nom = htmlspecialchars($_POST['nom']);
            }
        }
        else
        {
            $error_nom = "Champ obligatoire";
        }

        //Controle du champ prenom
        if(isset($_POST['prenom']))
        {
            if(empty(trim($_POST['prenom'])))
            {
                $error_prenom = "Veuillez entrer un prénom valide";
            }
            else
            {
                // Le prénom est valide
                $prenom = htmlspecialchars($_POST['prenom']);
            }
        }
        else
        {
            $error_prenom = "Champ obligatoire";
        }

        //Controle du champ téléphone
if(isset($_POST['tel']))
{
    if(empty(trim($_POST['tel'])))
    {
        $error_tel = "Veuillez entrer une valeur valide";
    }
    else
    {
        // Vérification du format du numéro de téléphone (8 chiffres)
        if (!preg_match("/^\d{8}$/", $_POST['tel'])) {
            $error_tel = "Le numéro de téléphone doit contenir exactement 8 chiffres";
        } else {
            $t = $variable->prepare('SELECT COUNT(idVendeur) AS nbr FROM vendeur WHERE tel=?');
            $t->execute(array($_POST['tel']));
            
            $nbr = 0;
            while ($ts = $t->fetch()) {
                $nbr = $ts['nbr'];
            }
            
            if($nbr > 0)
            {
                $error_tel = "Ce numéro existe déjà";
            }
            else
            {
                $tel = htmlspecialchars($_POST['tel']);
            }
        }
    }
}
else
{
    $error_tel = "Champ obligatoire";
}

        //Controle du champ email
        if(isset($_POST['email']))
        {
            if(empty($_POST['email']))
            {
                $error_email = "Veuillez entrer une adresse e-mail";
            }
            else
            {
                // Vérifie si l'adresse e-mail est au bon format
                $email = $_POST['email'];
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error_email = "Adresse e-mail invalide";
                } else {
                    // L'adresse e-mail est valide
                    $email = htmlspecialchars($email);

                    // Vérifie si l'adresse e-mail est déjà utilisée
                    $t = $variable->prepare('SELECT COUNT(idVendeur) AS nbr FROM vendeur WHERE email=?');
                    $t->execute(array($_POST['email']));
                    $ts = $t->fetch();
                    if ($ts['nbr'] > 0) {
                        $error_email = "Cette adresse e-mail est déjà utilisée";
                        }
                    }
            }
        }
        else
        {
            $error_email = "Champ obligatoire";
        }     
        
        //Controle du champ date de naissance
        if(isset($_POST['dateNaissance']))
        {
            if(empty($_POST['dateNaissance']))
            {
                $error_dateNaissance = "Veuillez entrer une date de naissance valide";
            }
            else
            {
                // Vérifie si la date de naissance est au bon format
                $dateNaissance = $_POST['dateNaissance'];
                if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $dateNaissance)) {
                    $error_dateNaissance = "Format de date de naissance invalide";
                } else {
                    // La date de naissance est au bon format, tu peux faire d'autres vérifications si nécessaire
                    $dateNaissance = htmlspecialchars($dateNaissance);
                }
            }
        }
        else
        {
            $error_dateNaissance = "Champ obligatoire";
        }
        

        //Controle générale et insertion
        if(empty($error_tel) && empty($error_email))
        {
            $ajout = $variable -> prepare('INSERT INTO vendeur(nomVendeur, prenomVendeur, tel, email, dateNaissance) VALUES (?, ?, ?, ?, ?)');
            $ajout -> execute(array($nom, $prenom, $tel, $email, $dateNaissance));
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
        <title>tpAgriculture</title>
        <meta charset="utf-8">
        <!--link rel="stylesheet" href="style.css"-->
        <link rel="stylesheet" href="vend.css">
        <script>
        function supprimerVendeur(id) {
            if (confirm("Êtes-vous sûr de vouloir supprimer ce vendeur ?")) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            // Recharger la page après la suppression
                            window.location.reload();
                        } else {
                            alert("Erreur lors de la suppression du vendeur.");
                        }
                    }
                };
                xhr.open("GET", "supprimer_vendeur.php?id=" + id, true);
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
                <form action="" method="post">
                    <div class="form-group">
                        <label for="nom">Nom :</label>
                        <input type="text" id="nom" name="nom" required>
                        <?php 
                        if(isset($error_nom))
                        {
                            echo $error_nom;
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom :</label>
                        <input type="text" id="prenom" name="prenom" required>
                        <?php 
                        if(isset($error_prenom))
                        {
                            echo $error_prenom;
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="tel">Téléphone :</label>
                        <input type="tel" id="tel" name="tel" required>
                        <small>Format attendu : 00000000</small>
                        <?php 
                        if(isset($error_tel))
                        {
                            echo $error_tel;
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="email">Email :</label>
                        <input type="email" id="email" name="email" required>
                        <?php 
                        if(isset($error_email))
                        {
                            echo $error_email;
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="dateNaissance">Date de naissance :</label>
                        <input type="date" id="dateNaissance" name="dateNaissance" required>
                        <?php 
                        if(isset($error_dateNaissance))
                        {
                            echo $error_dateNaissance;
                        }
                        ?>
                    </div>
                    <button type="submit" name="btn">Enregistrer</button>
                    <?php 
                    if(isset($msg))
                    {
                        echo $msg;
                    }
                    ?>
                </form>
            </div>
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
            <h2 >Liste des Vendeurs</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nom du vendeur</th>
                        <th>Prenom du vendeur</th>
                        <th>Téléphone</th>
                        <th>email</th>
                        <th>Date de naissance</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Sélectionner tous les enregistrements de vendeur
                        $requete = $variable->prepare('SELECT idVendeur, nomVendeur, prenomVendeur, tel, email, dateNaissance FROM vendeur');
                        $requete->execute();
                        $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);

                        // Afficher les informations des vendeurs dans un tableau HTML
                        foreach ($resultats as $vendeur) {
                            echo '<tr>';
                            echo '<td style="border-right: 1px solid #ddd;">' . $vendeur['nomVendeur'] . '</td>';
                            echo '<td style="border-right: 1px solid #ddd;">' . $vendeur['prenomVendeur'] . '</td>';
                            echo '<td style="border-right: 1px solid #ddd;">' . $vendeur['tel'] . '</td>';
                            echo '<td style="border-right: 1px solid #ddd;">' . $vendeur['email'] . '</td>';
                            echo '<td style="border-right: 1px solid #ddd;">' . $vendeur['dateNaissance'] . '</td>';

                            echo '<td>';
                            echo '<a href="modifiervend.php?id=' . $vendeur['idVendeur'] . '" class="modifier">Modifier</a>';
                            echo '<a href="#" onclick="supprimerVendeur(' . $vendeur['idVendeur'] . ')" class="supprimer">Supprimer</a>';
                            echo '</td>';
                            echo '</tr>';
                                }
                            ?>
                </tbody>
            </table>
        </div>

    </body>
</html>
