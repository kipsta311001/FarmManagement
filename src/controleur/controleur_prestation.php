<?php

function actionMesPrestations($twig, $db) {
    $form = array();
    $prestation = new Prestation($db);
    $maPrestation = NULL;
    if ((isset($_POST['btAjouter'])) && (isset($_GET['idPrestationUpdate']))) {
        $exec = $prestation->update($_GET['idPrestationUpdate'], $_POST['libelle'], $_POST['tarifHeure'], $_POST['tarifHa'], $_POST['TVA']);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = "Probleme d'insertion de la prestation";
        }
        $form['update'] = false;
       header("Location:index.php?page=mesprestations");
    }elseif((isset($_POST['btAjouter']))){
        $exec = $prestation->insert($_POST['libelle'], $_POST['tarifHeure'], $_POST['tarifHa'], $_POST['TVA']);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = "Probleme d'insertion de la prestation";
        }
    }
    if (isset($_GET['idPrestationDelete'])){
        $exec = $prestation->delete($_GET['idPrestationDelete']);
    }
    if (isset($_GET['idPrestationUpdate'])){
        $maPrestation = $prestation->selectById($_GET['idPrestationUpdate']);
        $form['update'] = true;
    }
    $mesPrestations = $prestation->select();

    echo $twig->render('mesPrestations.html.twig', array('form'=>$form, 'prestation'=>$mesPrestations,'maPrestation'=>$maPrestation));
}


