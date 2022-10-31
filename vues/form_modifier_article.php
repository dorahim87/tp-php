<?php 

 $rangee = mysqli_fetch_assoc($donnees["articles"]);
if($rangee["idAuteur"] == $_SESSION["usager"])
   
?>
<h1>Formulaire de modification d'article</h1>
<form method="GET" action="index.php">
    Titre de l'article : <input type="text" name="titre" value="<?= $rangee["titre"] ?>"/><br>
    Texte : <textarea name="texte" aria-valuemax="" id="" cols="30" rows="10"><?= $rangee["texte"] ?></textarea><br>
    
    <input type="hidden" name="commande" value="ModifierArticle"/>
    <input type="hidden" name="id" value="<?= $rangee["id"] ?>""/>
    <input type="submit" value="Modifier"/>
</form>
<?php 
    if(isset($donnees["messageErreur"]))
        echo "<p>" . $donnees["messageErreur"] . "</p>";
?>

