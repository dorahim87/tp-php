<?php
$Utilisateur='Visiteur';
if(isset($_SESSION['usager']))
$Utilisateur=$_SESSION['usager'];
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ' bonjour '.$donnee['titre'] ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
    <a href="index.php?commande=ListeTousArticles">Liste des articles</a><br>
<a href="index.php?commande=Logout">Log out</a><br>
<a href="index.php?commande=Login">Log in</a><br>
<a href="index.php?commande=RechercheArticle">Accéder à la recherche d'article</a><br>
<a href="index.php?commande=FormulaireAjoutArticle">Ajout d'article</a> <br>
    </nav>

    
    <header><?= ' Bonjour '. $Utilisateur ?></header>