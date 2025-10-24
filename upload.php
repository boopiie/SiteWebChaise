<link href="/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="style.css" rel="stylesheet">
<nav>
    <div id="lien-navbar">
    <a href="page_membre.php">Les chaises</a>
    <a href="logout.php">Se deconnecter</a>
    <a href="panier.php">Panier</a>
    <?php 
    if($_SESSION['login'] == "root" && $_SESSION['pwd'] == "root"){
        echo "<a href='ajouter_produit.php'>Ajouter un produit</a>";
    } ?>
    </div>
</nav>


<?php

    $json = file_get_contents("data.json");

    $data = json_decode($json, true);
    

    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $tmpName = $_FILES['photo']['tmp_name'];
    $name = $_FILES['photo']['name'];

    if(is_uploaded_file($tmpName)){
        $destination = "images/" . basename($name);
        move_uploaded_file($tmpName, $destination);
        echo "<h1> Produit ajouté avec succès !</h1>";
    }

    // Ajout des nouvelles informations dans le json

    $data["items"]["ch5"]["titre"] = $titre;
    $data["items"]["ch5"]["description"] = $description;
    $data["items"]["ch5"]["prix"] = $prix;
    $data["items"]["ch5"]["lien_img"] = $destination;

    $nvlDonneeJson = json_encode($data);

    file_put_contents("data.json", $nvlDonneeJson);