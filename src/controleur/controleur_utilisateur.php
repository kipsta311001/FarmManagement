<?php


function actionConnexion($twig,$db){
    $form = array();
    $form['valide'] = true;

    if (isset($_POST['btConnexion'])){
        $email = $_POST['Email'];
        $mdp = $_POST['mdp'];
        $utilisateur = new Utilisateur($db);
        $unUtilisateur = $utilisateur->connect($email);
        if ($unUtilisateur!=null){
            if(!password_verify($mdp,$unUtilisateur['mdp'])){
                
                $form['valide'] = false;
                $form['message'] = 'Login ou mot de passe incorrect';
                
            }
            else{
                $_SESSION['login'] = $email;
                $_SESSION['role'] = $unUtilisateur['id_role'];
                $_SESSION['idUtilisateur'] = $unUtilisateur['id'];
                header("Location:index.php?page=accueil");
            }
        }
        else{
            $form['valide'] = false;
            $form['message'] = 'Login ou mot de passe incorrect';
        }
    }
    echo $twig->render('login.html.twig',array('form'=>$form));
}