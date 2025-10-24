<?php 
    $login_valide = ['root','tom'];
    $pwd_valide = ['root','tom'];
    if(isset($_POST['login']) && isset($_POST['pwd'])){
        if(in_array($_POST['login'], $login_valide) && in_array($_POST['pwd'], $pwd_valide) ){
            session_start();
            $_SESSION['login'] = $_POST['login'];
            $_SESSION['pwd'] = $_POST['pwd'];
            header ('location: page_membre.php');}
        else {
            echo '<body onLoad="alert(\'Membre non reconnu...\')">';
            // puis on le redirige vers la page d'accueil
            echo '<meta http-equiv="refresh" content="0;URL=index.html">';
            }
        } 
    else {
        echo 'Les variables du formulaire ne sont pas déclarées.';
        }

?>