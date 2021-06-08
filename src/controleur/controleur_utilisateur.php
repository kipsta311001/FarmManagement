<?php
function actionListeUtilisateur($twig, $db){
    $form = array();
    $utilisateur = new Utilisateur($db);
    $liste = $utilisateur->select();
    if(isset($_GET['id'])){
        $score = new Score($db);
        $exec1 = $score->deleteByUtilisateur($_GET['id']);
        if (!$exec1){
            $form['valide1'] = false;
            $form['message'] = 'Problème de suppression dans la table score';
        }
        else{
            $form['valide1'] = true;
        }
        $commentaire = new Commentaire($db);
        $exec2 = $commentaire->deleteByUtilisateur($_GET['id']);
        if (!$exec2){
            $form['valide2'] = false;
            $form['message'] = 'Problème de suppression dans la table utilisateur';
        }
        else{
            $form['valide2'] = true;
            $form['message'] = 'Utilisateur supprimé avec succès';
        }
        $exec3=$utilisateur->delete($_GET['id']);
        if (!$exec3){
            $form['valide3'] = false;
            $form['message'] = 'Problème de suppression dans la table utilisateur';
        }
        else{
            $form['valide3'] = true;
            $form['message'] = 'Utilisateur supprimé avec succès';
        }
    }


    $limite=3;
    if(!isset($_GET['nopage'])){
        $inf=0;
        $nopage=0;
    }
    else{
        $nopage=$_GET['nopage'];
        $inf=$nopage * $limite;
    }
    $r = $utilisateur->selectCount();
    $nb = $r['nb'];

    $liste = $utilisateur->selectLimit($inf,$limite);
    $form['nbpages'] = ceil($nb/$limite);

    echo $twig->render('listeUtilisateur.html.twig', array('form'=>$form,'liste'=>$liste));
}


function actionProfil($twig,$db){
    if (isset($_SESSION['login'])) {
        $utilisateur = new Utilisateur($db);
        $unUtilisateur = $utilisateur->selectByEmail($_SESSION['login']);
        $score = new Score($db);
        $liste= $score->selectByEmail($_SESSION['login']);
    }
    echo $twig->render('profil.html.twig',array('u'=>$unUtilisateur,'liste'=>$liste));
}

function actionModifProfil($twig,$db){

$form['modif'] = false;

    if (isset($_POST['btModifProfil'])) {
        $form['modif'] = true;
        $utilisateur = new Utilisateur($db);

        $email = $_POST['email'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $nbUnique = $_POST['nbUnique'];
        $exec = $utilisateur->update($email, $nom, $prenom,$nbUnique);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Échec de la modification';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Modification réussie';
            $_SESSION['login'] = $email;
        }
    }

    if (isset($_SESSION['login'])) {

        $utilisateur = new Utilisateur($db);
        $unUtilisateur = $utilisateur->selectByEmail($_SESSION['login']);
    }

    echo $twig->render('modifProfil.html.twig',array('u'=>$unUtilisateur,'form'=>$form));
}

function actionModifProfilAdmin($twig,$db){

    $form['modif'] = false;

    if (isset($_POST['btModifProfil'])) {
        $form['modif'] = true;
        $utilisateur = new Utilisateur($db);

        $email = $_POST['email'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $nbUnique = $_POST['nbUnique'];
        $exec = $utilisateur->update($email, $nom, $prenom,$nbUnique);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Échec de la modification';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Modification réussie';
        }
    }

    if (isset($_SESSION['login'])) {

        $utilisateur = new Utilisateur($db);
        $unUtilisateur = $utilisateur->selectByNbUnique($_GET['nbUnique']);
    }

    echo $twig->render('modifProfilAdmin.html.twig',array('u'=>$unUtilisateur,'form'=>$form));
}

function actionModifImage($twig){
    if(isset($_POST['btModifImage']))
    $photo=NULL;
    if(isset($_FILES['photo'])){
        if(!empty($_FILES['photo']['name'])){
            $extensions_ok = array('png', 'gif', 'jpg', 'jpeg');
            $taille_max = 500000;
            $dest_dossier = '/var/www/html/symfony4-4060/public/Englearn/web/images/';
            if( !in_array( substr(strrchr($_FILES['photo']['name'], '.'), 1), $extensions_ok ) ){
                echo 'Veuillez sélectionner un fichier de type png, gif ou jpg !';
            }
            else{
                if( file_exists($_FILES['photo']['tmp_name'])&& (filesize($_FILES['photo']
                    ['tmp_name'])) > $taille_max){
                    echo 'Votre fichier doit faire moins de 500Ko !';
                }
                else{$photo = basename($_FILES['photo']['name']);
                    // enlever les accents

                    $photo=strtr($photo,'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ','AAA
AAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                    // remplacer les caractères autres que lettres, chiffres et point par _
                    $photo = preg_replace('/([^.a-z0-9]+)/i', '_', $photo);
                    // copie du fichier
                    move_uploaded_file($_FILES['photo']['tmp_name'], $dest_dossier.$photo);
                }
            }
        }
    }
       echo $twig->render('modifImage.html.twig',array());
}

function actionRechercheUtilisateur($twig,$db){
        $form = array();
        $utilisateur = new Utilisateur($db);

        if (isset($_POST['btRecherche'])) {

            $recherche = $_POST['Recherche'];

            $listeRecherche = $utilisateur->rechercher($recherche);
        }
    echo $twig->render('rechercheUtilisateur.html.twig',array('form'=>$form,'listeRecherche'=>$listeRecherche));
}
?>

