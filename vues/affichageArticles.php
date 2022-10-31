<h1>Liste des articles</h1><a href=""></a>

    <?php 
    
    
    while($rangee = mysqli_fetch_assoc($donnees["articles"]))
    {
        if(isset($_SESSION["usager"])){
        if($rangee["idAuteur"] == $_SESSION["usager"]){

        echo  " <div><h3>" . "Titre : "  . $rangee["titre"] . "</h3> 
         " . "<p>" . $rangee["texte"] . "</p>"  ." <h4> " . "Auteur : ". $rangee["nom"] ." " . $rangee["prenom"] . " </h4>  <a href='index.php?commande=FormulaireModifArticle&id=" . $rangee["id"] . "'>Modifier l'article</a>
         <a href='index.php?commande=SupprimerArticle&idArticles=" . $rangee["id"] . "&idAuteur=".$rangee["idAuteur"]."'>Supprimer l'article</a>  </div><br><br>  ";
        }else{
            echo  " <div><h3>" . "Titre : "  . $rangee["titre"] . "</h3> 
            " . "<p>" . $rangee["texte"] . "</p>"  ." <h4> " . "Auteur : ". $rangee["nom"] ." " . $rangee["prenom"] ."</h4></div>";
           
        }
    }
        else {
            echo  " <div><h3>" . "Titre : "  . $rangee["titre"] . "</h3> 
         " . "<p>" . $rangee["texte"] . "</p>"  ." <h4> " . "Auteur : ". $rangee["nom"] ." " . $rangee["prenom"] ."</h4></div>";
        }
    }


    ?>
    