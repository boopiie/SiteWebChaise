<?php
// Activer l'affichage des erreurs sur la page web
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>
<body>
<?php

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

if(isset($_SESSION['login']) && isset($_SESSION['pwd'])){


    $json = file_get_contents("data.json");

    $data = json_decode($json, true);

    if (!isset($_SESSION['listePanier'])){
        $_SESSION['listePanier'] = [];
    }

    if(isset($_POST['ajouter'])) {
        $nouvelElt = $_POST['element'];
        if (isset($_SESSION['listePanier'][$nouvelElt])) {
            $_SESSION['listePanier'][$nouvelElt] += 1;
        } else {
            $_SESSION['listePanier'][$nouvelElt] = 1;
        }
    }
    if(isset($_POST['supprimer'])){
        $elt = $_POST['element'];
        unset($data['items'][$elt]);
        file_put_contents("data.json", json_encode($data));
    }


    ?>
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
    echo "<div class='groupecarte'>";
    foreach ($data['items'] as $item => $infos) {
        echo "<div class='cartes'>";
            echo $infos['titre'] . '<br>';
            echo "$" .$infos['prix'] . '<br>';


            $chemin_original = $infos['lien_img'];

            $nom_fichier = basename($chemin_original);
            $vignette = "vignette_" . $nom_fichier;

            $chemin_vignette = dirname($chemin_original) . '/' . $vignette;


            redimage($chemin_original, $chemin_vignette, 200, 200); // Taille de la vignette : 200x200

            // Afficher la vignette
            echo "<form method='post' action='page_produit.php'>";
            echo "<input type='image' src='$chemin_vignette'>";
            echo "<input type='hidden' name='produit' value='$item'>";
            echo "</form>";

            ?>

            <!-- Gerer les ajouts de produit dans le panier -->
            <form method="post">
                <?php echo "<input name='element' type='hidden' value= ". $item. ">"; ?>
                <button type='submit' name='ajouter'>Ajouter au panier</button>
                <?php if($_SESSION['login'] == "root" && $_SESSION['pwd'] == "root") : ?>
                <?php echo "<input name='element' type='hidden' value= $item >"; ?>
                <button id="btn-supprimer" type='submit' name='supprimer'>Supprimer l'article</button>
                <?php endif;?>
            </form>
    <?php

        echo "</div>";
    }
    echo "</div'>";
}
else{
    echo "<h1> Erreur </h1>";
    echo "<h2> <a href = 'index.html'> Tu dois te connecter pour aller sur cette page. </a> </h2>";
}
?>
</body>
