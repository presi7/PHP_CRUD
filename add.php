<?php
//On demarre une session
session_start();

if($_POST){
    if(isset($_POST['produit']) && !empty($_POST['produit'])
    && isset($_POST['prix']) && !empty($_POST['prix'])
    && isset($_POST['nombre']) && !empty($_POST['nombre'])){
        //On inclut la connexion à la base
        require_once('connect.php');

        //Onnettoie lesdonnées envoyées
        $produit = strip_tags($_POST['produit']);
        $prix = strip_tags($_POST['prix']);
        $nombre = strip_tags($_POST['nombre']);

        $sql = 'INSERT INTO liste(produit,prix,nombre) VALUES(:produit, :prix, :nombre)';

        $query = $db->prepare($sql);

        $query->bindValue(':produit', $produit, PDO::PARAM_STR);
        $query->bindValue(':prix', $prix, PDO::PARAM_STR);
        $query->bindValue(':nombre', $nombre, PDO::PARAM_INT);

        $query->execute();

        $_SESSION['message'] ="Produit ajouter";
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
    <title>Ajouter un produit</title>
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
               <h1 class="text-center text-primary fw-bold fs-1 my-5 text-decoration-underline">Ajouter un produit</h1>
               <form method="post">
                    <div class="form-group">
                        <label for="produit">Produit</label>
                        <input type="text" id="produit" name="produit" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="prix">Prix</label>
                        <input type="text" id="prix" name="prix" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="number" id="nombre" name="nombre" class="form-control">
                    </div>
                    <button class="btn btn-primary my-4">Envoyer</button>
                    
               </form>
            </section>
        </div>
    </main>
</body>
</html>