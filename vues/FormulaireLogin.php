
<body>
    <form method="POST" action="index.php">
        Nom d'usager : <input type="text" name="user"/><br>
        Mot de passe : <input type="password" name="pass"/><br>
        <input type="hidden" name='commande' value='connectLogin'>
        <input type="submit"  value="connect"/>
    </form>
    <a href="index.php?commande=ListeTousArticles">Liste des articles</a><br>
    <?php 
    
    if(isset($message))
        echo "<p>$message</p>";
    ?>
</body>
</html>