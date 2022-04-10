<?php

function actionAjoutProjet($twig, $db) {
    $form = array();
    if(isset($_POST['btAjoutProjet'])){
        $projet = new Projet($db);
        $exec = $projet->insert($_POST['libelle']);
        if($exec){
            $form['valide'] = true;
            $form['message'] = "Projet ajouté";
        }else{
            $form['valide'] = false;
            $form['message'] = "Erreur d'ajout du projet";
        }
    }

    echo $twig->render('ajoutProjet.html.twig', array('form'=>$form));
}

function actionListeProjets($twig) {
    echo $twig->render('listeProjets.html.twig', array());
}

?>