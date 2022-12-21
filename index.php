<?php
//On demarre une session
session_start();

//On inclut la connexion à la base
require_once('connect.php');

$sql = 'SELECT * FROM liste';

//On prepare la requete
$query = $db->prepare($sql);

//On execute la requete
$query->execute();

//On stocke le resultat dans un tableau associatif
$result = $query->fetchAll(PDO::FETCH_ASSOC);

require_once('close.php')
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des produits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
    <h1 class="text-center text-primary fw-bold fs-1 my-5 text-decoration-underline">Liste des produits</h1>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <?php
                if(!empty($_SESSION['erreur'])){
                    echo '<div class="alert alert-danger" role="alert">
                            '. $_SESSION['erreur'].'
                </div>';
                $_SESSION['erreur'] = "";
                }
                ?>   
                <?php
                if(!empty($_SESSION['message'])){
                    echo '<div class="alert alert-success" role="alert">
                            '. $_SESSION['message'].'
                </div>';
                $_SESSION['erreur'] = "";
                }
                ?>      
                <table class="table">
                    <thead>
                        <th>ID</th>
                        <th>Produit</th>
                        <th>Nombre</th>
                        <th>Prix</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        <?php
                        //On boucle sur la variable result
                            foreach($result as $produit){
                        ?>
                        <tr>
                            <td><?= $produit['id'] ?></td>
                            <td><?= $produit['produit'] ?></td>
                            <td><?= $produit['nombre'] ?></td>
                            <td><?= $produit['prix'] ?></td>
                            <td><a href="details.php?id=<?= $produit['id'] ?>">Voir</a><a href="edit.php?id=<?= $produit['id'] ?>" class="mx-2">Modifier</a><a href="delete.php?id=<?= $produit['id'] ?>" class="mx-2">Supprimer</a></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <a class="btn btn-primary my-3" href="add.php">Ajouter un produit</a>
            </section>
        </div>
    </main>
</body>
</html>