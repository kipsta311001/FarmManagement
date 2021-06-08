<?php

function actionAjoutCommentaire($twig, $db) {
    $form=array();
    $commentaire = new Commentaire($db);
    if (isset($_POST['btCommentaire'])) {
        $email = $_SESSION['login'];
        $message = $_POST['message'];
        $note = $_POST['note'];
        $form['email'] = $email;
        $form['message'] = $message;
        $form['note'] = $note;
        if (1<=$note and $note<=5) {
            $exec = $commentaire->insert($email, $message, $note);
            if (!$exec) {
                $form['valide'] = false;
                $form['message'] = "Problème d'insertion dans la table commentaire";
            } else {
                $form['valide'] = true;
                $form['message'] = "Votre commentaire a bien été ajouté";
            }
        }else{
            $form['valide'] = false;
            $form['message'] = "Attention votre note doit être un entier entre 1 et 5";
        }
    }

    echo $twig->render('ajoutCommentaire.html.twig', array('form' => $form));
}

function actionListeCommentaire($twig, $db){
    $commentaire = new Commentaire($db);
    $liste = $commentaire->select();

    $limite=3;
    if(!isset($_GET['nopage'])){
        $inf=0;
        $nopage=0;
    }
    else{
        $nopage=$_GET['nopage'];
        $inf=$nopage * $limite;
    }
    $r = $commentaire->selectCount();
    $nb = $r['nb'];

    $liste = $commentaire->selectLimit($inf,$limite);
    $form['nbpages'] = ceil($nb/$limite);
    echo $twig->render('listeCommentaire.html.twig', array('liste'=>$liste,'form'=>$form));
}