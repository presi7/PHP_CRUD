<?php
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
//On demarre une session
session_start();

if($_POST){
    if(isset($_POST['id']) && !empty($_POST['id'])
    && isset($_POST['produit']) && !empty($_POST['produit'])
    && isset($_POST['prix']) && !empty($_POST['prix'])
    && isset($_POST['nombre']) && !empty($_POST['nombre'])){
        //On inclut la connexion à la base
        require_once('connect.php');

        //Onnettoie lesdonnées envoyées
        $id = strip_tags($_POST['id']);
        $produit = strip_tags($_POST['produit']);
        $prix = strip_tags($_POST['prix']);
        $nombre = strip_tags($_POST['nombre']);

        $sql = 'UPDATE liste SET produit=:produit, prix=:prix, nombre=:nombre WHERE id=:id';

        $query = $db->prepare($sql);

        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':produit', $produit, PDO::PARAM_STR);
        $query->bindValue(':prix', $prix, PDO::PARAM_STR);
        $query->bindValue(':nombre', $nombre, PDO::PARAM_INT);

        $query->execute();

        $_SESSION['message'] ="Produit modifié";
        require_once('close.php');

        header('Location: index.php');  

        

    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un produit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <?php
                if(!empty($_SESSION['erreur'])){
                    echo '<div class="alert alert-success" role="alert">
                            '. $_SESSION['erreur'].'
                </div>';
                $_SESSION['erreur'] = "";
                }
                ?>      
               <h1 class="text-center text-primary fw-bold fs-1 my-5 text-decoration-underline">Modifier un produit</h1>
               <form method="post">
                    <div class="form-group">
                        <label for="produit">Produit</label>
                        <input type="text" id="produit" name="produit" class="form-control" value="<?= $produit['produit'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="prix">Prix</label>
                        <input type="text" id="prix" name="prix" class="form-control" value="<?= $produit['prix'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="number" id="nombre" name="nombre" class="form-control" value="<?= $produit['nombre'] ?>">
                    </div>
                    <input type="hidden" name="id" value="<?= $produit['id'] ?>">
                    <button class="btn btn-primary my-4">Envoyer</button>
                    
               </form>
            </section>
        </div>
    </main>
</body>
</html>