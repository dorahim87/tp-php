<?php 
    /*
        modele.php est le fichier qui représente notre modèle dans notre architecture MVC. C'est donc dans ce fichier que nous retrouverons TOUTES nos requêtes SQL sans AUCUNE EXCEPTION. C'est aussi ici que se trouvera LA connexion à la base de données ET les informations de connexion relatives à celle-ci (qui pourraient être dans un fichier de configuration séparé... voir les frameworks).

    */

  //en local

    // define("SERVER", "localhost");
    // define("USERNAME", "root");
    // define("PASSWORD", "");
    // define("DBNAME", "baseblog");

    //webdev
     
    define("SERVER", "localhost");
    define("USERNAME", "e2295578");
    define("PASSWORD", "YmOQcgWx5ktavsZ0fPsd");
    define("DBNAME", "e2295578");

    
    function connectDB()
    {
        //se connecter à la base de données
        $c = mysqli_connect(SERVER, USERNAME, PASSWORD, DBNAME);

        if(!$c)
        {
            die("Erreur de connexion. MySQLI : " . mysqli_connect_error());
        }

        //s'assurer que la connexion traite le utf8
        mysqli_query($c, "SET NAMES 'utf8'");

        return $c;
    }

    $connexion = connectDB();

    function obtenir_articles()
    {
        global $connexion;
        $requete = "SELECT id, titre, texte, idAuteur, usagers.nom AS nom, usagers.prenom AS prenom
        FROM articles
        JOIN usagers ON articles.idAuteur = usagers.username
        ORDER BY id DESC
        ";

        $resultats = mysqli_query($connexion, $requete);
        //retourner le résultat...
        return $resultats;
    }

    function obtenir_articles_par_id($id)
    {
        global $connexion;
        $requete = "SELECT id, idAuteur, titre, texte
        FROM articles
        WHERE id = $id";

        $resultats = mysqli_query($connexion, $requete);

        return $resultats;
    }

    function obtenir_auteur()
    {
        global $connexion;
        $requete = "SELECT username, prenom, nom FROM usagers";
        
        $resultats = mysqli_query($connexion, $requete);
        
        return $resultats;
    }
    
    

    function supprime_article($id)
    {
        global $connexion;
        $requete = "DELETE FROM articles WHERE id = $id";
        
        $resultats = mysqli_query($connexion, $requete);
        
        return $resultats;
    }

    function modifie_article($idA, $t, $te, $id)
    {
        global $connexion;
        $requete = "UPDATE articles SET idAuteur=?, titre=?, texte=?  WHERE id=?";
        //2. préparer la requête
        $reqPrep = mysqli_prepare($connexion, $requete);

        if($reqPrep)
        {
            //3. faire le lien entre les paramètres envoyés par l'usager et les ? dans la requete
            mysqli_stmt_bind_param($reqPrep, "issi", $idA, $t, $te, $id);
            //4. exécuter la requête préparée et retourner le résultat...
            return mysqli_stmt_execute($reqPrep);
        }
        else
            die("Erreur de requête préparée...");
    }
    // ***************************

    function login($username, $password)
    {
        global $connexion;
        $requete = "SELECT * FROM usagers WHERE username=? AND password=?";

        $reqPrep = mysqli_prepare($connexion, $requete);
 
        if($reqPrep)
        {
            //3. faire le lien entre les paramètres envoyés par l'usager et les ? dans la requete
            mysqli_stmt_bind_param($reqPrep, "ss", $username, $password);
            //4. exécuter la requête préparée et retourner le résultat...
            mysqli_stmt_execute($reqPrep);
            $resultats = mysqli_stmt_get_result($reqPrep);

            //s'il y a un usager avec cette combinaison, retourner le username, sinon return false
            if(mysqli_num_rows($resultats) > 0)
            {
                $rangee = mysqli_fetch_assoc($resultats);
                return $rangee["username"];
            }
            else
            {
                return false;
            }
        }
    }

    function loginEncrypte($username, $password)
    {
        global $connexion;
        $requete = "SELECT * FROM usagers WHERE username=?";

        $reqPrep = mysqli_prepare($connexion, $requete);
 
        if($reqPrep)
        {
            //3. faire le lien entre les paramètres envoyés par l'usager et les ? dans la requete
            mysqli_stmt_bind_param($reqPrep, "s", $username);
            //4. exécuter la requête préparée et retourner le résultat...
            mysqli_stmt_execute($reqPrep);
            $resultats = mysqli_stmt_get_result($reqPrep);

            //s'il y a un usager avec ce username, vérifier que le mot de passe dans la BD est le même que le mot de passe envoyé lorsque je l'encrypte
            //une seule façon de faire : password_verify
            if(mysqli_num_rows($resultats) > 0)
            {
                $rangee = mysqli_fetch_assoc($resultats);
                $motDePasseEncrypte = $rangee["password"];
                if(password_verify($password, $motDePasseEncrypte))
                {
                    //on est authentifié
                    return $rangee["username"];
                }
                else 
                    return false;
            }
            else
            {
                return false;
            }
        }
    }

    function recherche_articles($texte)
    {
        global $connexion;

        $requete = "SELECT titre, texte 
        FROM articles
        WHERE titre LIKE ? OR texte LIKE ?";
        //2. préparer la requête
        $reqPrep = mysqli_prepare($connexion, $requete);

        if($reqPrep)
        {
            $texte = "%$texte%";
            //3. faire le lien entre les paramètres envoyés par l'usager et les ? dans la requete
            mysqli_stmt_bind_param($reqPrep, "ss", $texte, $texte);
            //4. exécuter la requête préparée et retourner le résultat...
            mysqli_stmt_execute($reqPrep);
            $resultats = mysqli_stmt_get_result($reqPrep);
            return $resultats;
         }
         else 
             die("Erreur de requête préparée...");
        }

        function ajoute_article($idA, $t, $te)
    {
        global $connexion;
        $requete = "INSERT INTO articles(idAuteur, titre, texte ) VALUES (?, ?, ?)";
        //2. préparer la requête
        $reqPrep = mysqli_prepare($connexion, $requete);

        if($reqPrep)
        {
            //3. faire le lien entre les paramètres envoyés par l'usager et les ? dans la requete
            mysqli_stmt_bind_param($reqPrep, "sss", $idA, $t, $te );
            //4. exécuter la requête préparée et retourner le résultat...
            return mysqli_stmt_execute($reqPrep);
        }
        else
            die("Erreur de requête préparée...");
    }
             
?>