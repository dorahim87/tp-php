<?php 
    if(mysqli_num_rows($donnees["articles"]) > 0)
    {
?>
<table>
    <tr><th>Titre</th><th>Texte</th></tr>
    <?php 
    while($rangee = mysqli_fetch_assoc($donnees["articles"]))
    {
        echo "<tr><td>" . $rangee["titre"] . "</td><td>" . $rangee["texte"]    . "</td></tr>";
    }
    ?>
</table>
<?php
    } 
    else 
    {
    ?>
    <p>Aucun résultat pour cette recherche</p>
    <?php
    }
?>