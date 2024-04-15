<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Associer Vendeur à Produit</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background: linear-gradient(to right, rgba(12, 116, 25, 0.5)0%,rgba(94, 168, 10, 0.5)25%,
     rgba(10, 238, 10, 0.4)50%,rgb(122, 211, 102)),url(fd2.jpg);
    opacity: 0.9;
    background-position: center;
    background-size: cover;
    margin: 0;
    padding: 0;
}

        .main
{
    width: 100%;
    height: 65vh;
}
.menu
{

    height: 70px;
    left: 500px;
}
ul
{
    float: left;
    width: 1000px;
    display: flex ;
    justify-content: center;
    align-items:center;
}
ul li{
    list-style: none;
    margin-left: 62px;
    margin-top: 27px;
    font-size: 14px;

}
ul li a{
    text-decoration: none;
    color: #fff;
    font-family: arial;
    font-weight: bold;
    transition: 0.4s ease-in-out;
}

ul li a:hover
{
    color: #91ff00;
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

        select {
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        thead {
            background-color: #f2f2f2;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .actions {
            display: flex;
        }

        .actions a, .actions button {
            margin-right: 5px;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .actions a.modify {
            background-color: #45a049;
            color: white;
        }

        .actions button.delete {
            background-color: #ff0000;
            color: white;
        }

        .actions a:hover, .actions button:hover {
            opacity: 0.8;
        }
    </style>
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
    <h1>Associer un Vendeur à son Produit</h1>
    <form action="traitement_association.php" method="post">
        <label for="vendeur">Sélectionner un Vendeur :</label>
        <select id="vendeur" name="vendeur" required>
            <?php
            include ('db.php');
            // Sélectionner tous les enregistrements de vendeurs depuis la base de données
            $requeteVendeurs = $variable->prepare('SELECT idVendeur, nomVendeur, prenomVendeur FROM vendeur');
            $requeteVendeurs->execute();
            $resultatsVendeurs = $requeteVendeurs->fetchAll(PDO::FETCH_ASSOC);
            foreach ($resultatsVendeurs as $vendeur) {
                echo '<option value="' . $vendeur['idVendeur'] . '">' . $vendeur['nomVendeur'] . ' ' . $vendeur['prenomVendeur'] . '</option>';
            }
            ?>
        </select>

        <label for="produit">Sélectionner un Produit :</label>
        <select id="produit" name="produit" required>
            <?php
            include ('db.php');
            // Sélectionner tous les enregistrements de produits depuis la base de données
            $requeteProduits = $variable->prepare('SELECT idProd, nomProd FROM produit');
            $requeteProduits->execute();
            $resultatsProduits = $requeteProduits->fetchAll(PDO::FETCH_ASSOC);
            foreach ($resultatsProduits as $produit) {
                echo '<option value="' . $produit['idProd'] . '">' . $produit['nomProd'] . '</option>';
            }
            ?>
        </select>

        <button type="submit">Associer</button>
    </form>
    </div>

    <!-- Tableau d'association -->
    <h2>Associations Vendeur - Produit</h2>
    <table>
        <thead>
            <tr>
                <th>ID Vendeur</th>
                <th>Nom Vendeur</th>
                <th>ID Produit</th>
                <th>Nom Produit</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include ('db.php');
            // Sélectionner toutes les associations vendeur-produit depuis la base de données
            $requeteAssociations = $variable->prepare('SELECT prodvendeur.idVendeur, vendeur.nomVendeur, prodvendeur.idProd, produit.nomProd FROM vendeur, prodvendeur, produit Where vendeur.idVendeur=prodvendeur.idvendeur AND produit.idProd = prodvendeur.idProd');
            $requeteAssociations->execute();
            $resultatsAssociations = $requeteAssociations->fetchAll(PDO::FETCH_ASSOC);
            foreach ($resultatsAssociations as $association) {
                echo '<tr>';
                echo '<td>' . $association['idVendeur'] . '</td>';
                echo '<td>' . $association['nomVendeur'] . '</td>';
                echo '<td>' . $association['idProd'] . '</td>';
                echo '<td>' . $association['nomProd'] . '</td>';
                echo '<td class="actions">';
                echo '<a href="modifier_association.php?idVendeur=' . $association['idVendeur'] . '&idProduit=' . $association['idProd'] . '" class="modify">Modifier</a>';
                echo '<form action="traitement_suppression_association.php" method="post">';
                echo '<input type="hidden" name="idVendeur" value="' . $association['idVendeur'] . '">';
                echo '<input type="hidden" name="idProduit" value="' . $association['idProd'] . '">';
                echo '<button type="submit" class="delete">Supprimer</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</body>
</html>
