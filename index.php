<?php
session_start();
require_once('modele.php');

if (isset($_REQUEST["commande"])) {
    $commande = $_REQUEST["commande"];
} else {
    //ici, on devrait spécifier la commande par défaut, typiquement celle qui mène à votre page d'accueil
    $commande = "Accueil";
}

switch ($commande) {
    case "connectLogin":

        if (isset($_POST["user"], $_POST["pass"])) {
            $nomUsager = loginEncrypte($_POST["user"], $_POST["pass"]);
            if ($nomUsager) {
                
                $_SESSION["usager"] = $nomUsager;
                header("Location: index.php");
                die();
            } else {
                $message = "Mauvaise combinaison username / password.";
            }
        }
        break;
    case "Accueil":
        //on déclare les variables dont on a besoin (elles peuvent venir du modèle)
       

        $donnees["titre"] = "Page d'accueil";
        //afficher les vues
        require_once("vues/header.php");
        require("vues/accueil.html");
        require_once("vues/footer.php");
        break;

    case "ListeTousArticles":
        if (isset($_SESSION['usager']))
            $usager = $_SESSION["usager"];

        $donnees["titre"] = "Liste des articles";
        $donnees["articles"] = obtenir_articles();

        require_once("vues/header.php");
        require("vues/affichageArticles.php");
        require_once("vues/footer.php");
        break;

    case "SupprimerArticle":
        if ((isset($_REQUEST["idArticles"]) && is_numeric($_REQUEST["idArticles"]))&&($_REQUEST['idAuteur']==$_SESSION['usager'])) {
            supprime_article($_REQUEST["idArticles"]);
            $donnees["titre"] = "Supprimer l'article";
           
            header("Location: index.php?commande=Accueil");
        }
        break;

    case "FormulaireModifArticle":
        if ((isset($_REQUEST["idArticles"]) && is_numeric($_REQUEST["idArticles"]))&&($_REQUEST['idAuteur']==$_SESSION['usager'])){

            $donnees["titre"] = "Formulaire de modification d'article";
            $donnees["articles"] = obtenir_articles_par_id($_REQUEST["id"]);
            require_once("vues/header.php");
            require_once("vues/form_modifier_article.php");
            require_once("vues/footer.php");
        } else {
            header("Location: index.php");
        }
        break;

    case "ModifierArticle":
        $donnees["titre"] = "Modifierer l'article";
        modifie_article($_REQUEST["idAuteur"], $_REQUEST["titre"], $_REQUEST["texte"], $_REQUEST["id"]);
        require_once("vues/header.php");
        require("vues/accueil.html");
        require_once("vues/footer.php");

        break;

    case "RechercheArticle":
        $donnees["titre"] = "Formulaire de recherche d' articles";
        require_once("vues/header.php");
        require_once("vues/form_recherche.php");
        if (isset($_REQUEST["texteRecherche"]) && !empty($_REQUEST["texteRecherche"])) {
            //faire la recherche 
            $donnees["articles"] = recherche_articles($_REQUEST["texteRecherche"]);
            //afficher les résultats de la recherche
            require("vues/resultat_recherche.php");
        }
        require_once("vues/footer.php");
        break;

    case "FormulaireAjoutArticle":
        AfficheAjoutArticle();
        break;

    case "AjoutArticle":
        if (isset($_REQUEST["titre"]) && isset($_REQUEST["texte"]) ) {
            //ici on met la validation des entrées du formulaire
            if (ValideArticle($_REQUEST["titre"], $_REQUEST["texte"] )) {
                //on procède à l'insertion
                $insertion = ajoute_article($_SESSION["usager"],$_REQUEST["titre"], $_REQUEST["texte"], );
                if ($insertion)
                    header("Location: index.php?commande=affichageArticles");
            } else {
                $donnees["messageErreur"] = "Veuillez remplir les champs correctement.";
                AfficheAjoutArticle($donnees);
            }
        }
        break;
    
    case 'Logout';
        $_SESSION = array();

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();

        header("Location: index.php?commande=Accueil");


        break;
    case "Login":

        $donnees["titre"] = "Page Login";
        require_once("vues/header.php");
        require("vues/FormulaireLogin.php");
        require_once("vues/footer.php");
        break;

    default:

        header("Location: index.php");
        die();
}



function ValideArticle($titre, $texte)
{
    $valide = false;

    $t = trim($titre);
    $te = trim($texte);
   

    if ($t != "" && $te != "" ) { $valide = true;}

    return $valide;
}

function AfficheAjoutArticle($donnees = array())
{
    $donnees["titre"] = "Formulaire d'ajout d'article";
    $donnees["usagers"] = obtenir_auteur();

    require_once("vues/header.php");
    require("vues/form_ajout_article.php");
    require_once("vues/footer.php");
}
