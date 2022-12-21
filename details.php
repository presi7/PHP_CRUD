<?php
//On demarre une session
session_start();

//Est-ce que l'id existe et n'est pas vide dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('connect.php');

    //On nettoie l'id envoyé
    $id =strip_tags($_GET['id']);

    $sql ='SELECT * FROM liste WHERE id = :id';

    //On prepare la requete
    $query = $db->prepare($sql);

    //On accroche les parametres
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    //On execute la requete
    $query->execute();

    //On recupére le produit
    $produit = $query->fetch();

    //on verifie si le produit existe
    if(!$produit){
        $_SESSION['erreur'] = "Cet id n'existe pas";
        header('Location: index.php');
        
    }
}else{
    $_SESSION['erreur'] ="URL invalide";
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail du produit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <h1 class="my-3">Detail du produit <?= $produit['produit'] ?></h1>
                <p><span class="fw-bold">ID :</span> <?=$produit['id'] ?></p>
                <p><span class="fw-bold">Produit :</span> <?=$produit['produit'] ?></p>
                <p><span class="fw-bold">Prix :</span> <?=$produit['prix'] ?></p>
                <p><span class="fw-bold">Nombre :</span> <?=$produit['nombre'] ?></p>
                <p><a href="index.php" class="btn btn-primary my-2">Retour</a><a href="edit.php?id=<?= $produit['id'] ?>" class="btn btn-primary mx-3 my-2">Modifier</a></p>
            </section>
        </div>
    </main>
</body>
</html>