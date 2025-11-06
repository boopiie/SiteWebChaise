<link rel="stylesheet" href="style.css">
<nav>
    <div id="lien-navbar">
    <a href="page_membre.php">Les chaises</a>
    <a class = 'deconnexion' href="logout.php">Se deconnecter</a>
    <a href="panier.php">Panier</a>
    </div>
</nav>
<form method="post">
<?php
    echo "Veuillez entrer vos informations : <br>";
    echo "<input type='input' name='codecarte' maxlength='16'>Code<br>";
    echo "<button type='submit' name='payer'> Payer</button>";?>
</form>
<?php
    $codecarte = $_POST['codecarte'];
    $premier_chiffre = $codecarte[0];
    $dernier_chiffre = $codecarte[15];
    if(isset($_POST['payer'])){
        if($premier_chiffre == $dernier_chiffre && !empty($codecarte)){
            echo "Commande effectuer";
            unset($_SESSION['listePanier'][$_POST['panier']]);
            return;
            }
        if(empty($codecarte)){
            echo "Veuillez renseigner les codes de votre carte.";
        }
        else{
            echo "Probleme code carte";
        }
    }
