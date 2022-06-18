<?php

function actionlisteIntervention($twig, $db) {
    $form = array();
    $intervention = new Intervention($db);
    $listeIntervention = $intervention->selectAllByIdParcelle($_GET['idParcelle']);
    if(isset($_GET['idIntervention'])){
        $currentDate = date("Y/m/d");
        $intervention->update($_GET['idIntervention'], $currentDate);
     }
     if(isset($_GET['idDel'])){
        $intervention->delete($_GET['idDel']);
     }
    echo $twig->render('listeIntervention.html.twig', array('listeIntervention' => $listeIntervention, 'idParcelle' => $_GET['idParcelle']));
}