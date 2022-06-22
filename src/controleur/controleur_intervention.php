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


function actionStats($twig, $db) {
    $form = array();
    $intervention = new Intervention($db);
    $parcelle = new Parcelle($db);
    $dataParcelle = $parcelle->selectById($_GET['idParcelle']);
    $surface = $dataParcelle[0]['surface'];
    $listeIntervention = $intervention->selectAllByIdParcelle($_GET['idParcelle']);
    $charge = 0;
    foreach($listeIntervention as $intervention){
        if(isset($intervention['variete'])){
            $variete = $intervention['variete'];
        }
        if(isset($intervention['cout'])){
            $charge = $charge + $intervention['cout'];
        }
        if(isset($intervention['rendement'])){
            $rendement = $intervention['rendement'];
        }
        if(isset($intervention['prix_vente'])){
            $prix_vente = $intervention['prix_vente'];
        }
    }
    $ca = ( $rendement/100 * $surface ) * $prix_vente;
    $benef = $ca - $charge;
    $coutByHa = $charge / $surface;
    $benefByHa = $benef / $surface;
    

    echo $twig->render('statistiques.html.twig', array('listeIntervention' => $listeIntervention, 'parcelle' => $dataParcelle
    , 'variete' => $variete, 'charge' => $charge, 'rendement' => $rendement, 'prix_vente' => $prix_vente, 'benef' => $benef
    , 'coutByHa' => $coutByHa, 'benefByHa' => $benefByHa, 'ca' => $ca));
}
