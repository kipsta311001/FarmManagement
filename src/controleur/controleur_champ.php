<?php

function actionlisteChamps($twig) {
    $form = array();
    echo $twig->render('listeChamps.html.twig', array());
}
