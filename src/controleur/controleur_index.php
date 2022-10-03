<?php

function actionAccueil($twig, $db) {
    $form = array();
    echo $twig->render('accueil.html.twig', array());
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



