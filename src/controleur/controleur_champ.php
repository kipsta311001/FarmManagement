<?php

function actionlisteChamps($twig, $db) {
    $form = array();
    $parcelle = new Parcelle($db);
    $listeParcelle = $parcelle->selectByUtilisateur($_SESSION['login']);
    if(isset($_GET['idChamp'])){
        $parcelle->deleteById($_GET['idChamp']);
        $ilot = new Ilots($db);
        $nbIlot = $ilot->selectCountById($_GET['idIlot']);
        if(sizeof($nbIlot) == 0){
            $ilot->delete($_GET['idIlot']);
        }
     }
    echo $twig->render('listeChamps.html.twig', array('listeParcelle' => $listeParcelle));
}


function actionAjoutChamps($twig, $db) {
    $form = array();
    $ilotExist = false;
    $parcelle = new Parcelle($db);
    $ilot = new Ilots($db);
    if(isset($_POST['btAjouter'])){
        $listeIlot = $ilot->selectByUtilisateur($_SESSION['idUtilisateur']);
        foreach($listeIlot as $unIlot){
            var_dump($unIlot['numIlot']);
            if($unIlot['numIlot'] == $_POST['ilot']){
                $ilotExist = true;
            }
        }
        if($ilotExist == false){
            $exec = $ilot->insert($_POST['ilot'], $_SESSION['idUtilisateur']);
            if (!$exec) {
                $form['valide'] = false;
                $form['message'] = "Probleme d'insertion de l'ilot";
            }else{
                $exec = $parcelle->insert($_POST['ilot'], $_POST['libelle'], $_POST['surface']);
                if (!$exec) {
                    $form['valide'] = false;
                    $form['message'] = "Probleme d'insertion de la parcelle";
                }
            }
        }else{
            $exec = $parcelle->insert($_POST['ilot'], $_POST['libelle'], $_POST['surface']);
            if (!$exec) {
                $form['valide'] = false;
                $form['message'] = "Probleme d'insertion de la parcelle";
            }
        }
    }
    echo $twig->render('ajoutChamp.html.twig', array('form'=>$form));
}
