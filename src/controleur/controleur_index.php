<?php

function actionAccueil($twig, $db) {
    $form = array();
    
    $semis = new Semis($db);
    $listeSemis = $semis->semenceByID($_SESSION['idUtilisateur']);
    $listeResult= [];

    foreach($listeSemis as $semence) //pour toutes les parcelles cochés
    {
        $semence[0] = iconv('utf-8','ASCII//IGNORE//TRANSLIT',$semence[0]);
        array_push($listeResult, $semence[0]);
        
    }
    
    echo $twig->render('accueil.html.twig', array('semences'=>$listeResult, 'semenceNom' => $listeSemis));
}

function actionMentions($twig){
    echo $twig->render('mentions.html.twig',array());
}

function actionApropos($twig){
    echo $twig->render('apropos.html.twig',array());
}

function actionMaintenance($twig){
    echo $twig->render('maintenance.html.twig',array());
}

function actionAbonnements($twig){
    echo $twig->render('abonnement.html.twig',array());
}


function actionDeconnexion($twig){
    session_unset();
    session_destroy();
    header("Location:index.php");
}

function actionInscription($twig,$db){
    $form = array();
    if (isset($_POST['btInscrire'])){
        //$nbUnique = uniqid();
        $email = $_POST['email'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $mdp = $_POST['password'];
        $confirmation =$_POST['confirmation'];
        if(isset($_POST['role'])){
            if($_POST['role']){
                $role = 3;
            }else{
                $role = 4;
            }
        }else{
            $role = 2;
        }
        $entreprise = isset($_SESSION['entreprise'])? $_SESSION['entreprise'] : $_GET['idEntreprise'];
        $form['valide'] = true;
        if ($mdp!=$confirmation){
            $form['valide'] = false;
            $form['message'] = 'Les mots de passe sont différents';
        }
        else{
            $utilisateur = new Utilisateur($db);
            $exec = $utilisateur->insert($email, password_hash($mdp,PASSWORD_DEFAULT),$nom, $prenom, $role, $entreprise);
            if (!$exec){
                $form['valide'] = false;
                $form['message'] = 'Problème d\'insertion dans la table utilisateur ';
            }

        }
        $form['email'] = $email;
        $form['nom'] = $nom;
        $form['prenom'] = $prenom;
    }
    echo $twig->render('inscription.html.twig',array('form'=>$form));
}



