<form method="GET">
        Mot de passe : <input type="text" name="pwd"/>
        <input type="submit" value="Encrypter"/>
    </form>
    <?php 
        if(isset($_GET["pwd"]))
        {
            $motDePasseEncrypte = password_hash($_GET["pwd"], PASSWORD_DEFAULT);
            var_dump($motDePasseEncrypte);
        }
    ?>