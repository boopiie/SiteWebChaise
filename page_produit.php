<?php
// Activer l'affichage des erreurs sur la page web
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();

if(isset($_SESSION['login']) && isset($_SESSION['pwd'])){

    $json = file_get_contents("data.json");

    $data = json_decode($json, true); }
?>

<link rel="stylesheet" href="style.css">
<nav>
    <div id="lien-navbar">
    <a href="page_membre.php">Les chaises</a>
    <a href="logout.php">Se deconnecter</a>
    <a href="panier.php">Panier</a>
    </div>
</nav>
<div class='grand_produit'>
<?php 
    $produit = $_POST['produit'];
    echo $data['items'][$produit]['titre'] . "<br>";
    echo "$" . $data['items'][$produit]['prix'] . "<br>";
    echo $data['items'][$produit]['description'] . "<br>";
    echo "<img src=" .$data['items'][$produit]['lien_img'] . ">";
?>
</div>
