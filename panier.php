<?php
// Activer l'affichage des erreurs sur la page web
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

function redimage($img_src, $img_dest, $dst_w, $dst_h) {
    $size = GetImageSize("$img_src");
    $src_w = $size[0];
    $src_h = $size[1];
    $test_h = round(($dst_w / $src_w) * $src_h);
    $test_w = round(($dst_h / $src_h) * $src_w);
    $dst_im = ImageCreateTrueColor($dst_w, $dst_h);
    $src_im = ImageCreateFromJpeg("$img_src");
    ImageCopyResampled($dst_im, $src_im, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
    ImageJpeg($dst_im, "$img_dest");
    ImageDestroy($dst_im);
    ImageDestroy($src_im);
}


session_start();
if(isset($_SESSION['login']) && isset($_SESSION['pwd'])) {
    ?>
    <link rel="stylesheet" href="style.css">
    <nav>
        <div id="lien-navbar">
        <a href="page_membre.php">Les chaises</a>
        <a class = 'deconnexion' href="logout.php">Se deconnecter</a>
        <a href="panier.php">Panier</a>
        </div>
    </nav>
    <h1>Votre panier :</h1>
    <?php
    
    if(isset($_POST['supprimer'])){
        unset($_SESSION['listePanier'][$_POST['produit']]);
    }

    $json = file_get_contents("data.json");

    $data = json_decode($json, true);

    $chaise = $data['items']; ?>
    <?php
    echo "<div class='groupecarte'>";
    if(isset($_SESSION['listePanier'])){
        foreach($_SESSION['listePanier'] as $panier => $quantite){
            echo "<div class='cartes'>";
            echo $chaise[$panier]['titre'] . "<br>";
            echo $chaise[$panier]['description'] . "<br>";
            echo "$" . $chaise[$panier]['prix'] . "<br>";

            $chemin_original = $chaise[$panier]['lien_img'];
            $image = basename($chemin_original);
            $vignette = "vignette_panier_" . $image;

            $chemin_vignette = dirname($chemin_original) . '/' . $vignette;
            redimage($chemin_original, $chemin_vignette, 150, 150); 


            echo "<img src='" . $chemin_vignette . "'><br>";
            echo "Quantité : " . $quantite . "<br>";
            echo "Prix total : $" . $quantite * $chaise[$panier]['prix'] . "<br>";
            echo "<br>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='produit' value='$panier'>";
            echo "<button type='submit' class='supprimer-panier' name='supprimer'>supprimer</button>";
            echo "</form>";
            echo "<br>-";
            echo "</div>";
        }
    echo "</div>";
    }
}?>
<a href="paiement.php">Payer</a>
