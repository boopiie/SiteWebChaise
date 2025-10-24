
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

    // Activer l'affichage des erreurs sur la page web
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    echo '<form enctype="multipart/form-data" action="upload.php" method="post">';
    echo 'Titre <input type=text name="titre"><br>';
    echo 'Description <input type=text name="description"><br>';
    echo 'Prix <input type=number name="prix"><br>';
    echo 'Photo <input type=file name="photo"><br>';
    echo '<input type=submit value="Télécharger Photos" name = "photo">';
    echo '</form>';