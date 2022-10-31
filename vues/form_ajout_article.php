<h1>Formulaire d'ajout d'un article</h1>
<form method="get" action="index.php">
    Titre : <input type="text" name="titre" /><br>
    Texte : <input type="text" name="texte" /><br>
    
    <input type="hidden" name="commande" value="AjoutArticle"/>
    <input type="submit" value="Ajouter"/>
</form>
<?php 
    if(isset($donnees["messageErreur"]))
        echo "<p>" . $donnees["messageErreur"] . "</p>";
?>