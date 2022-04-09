<?php

function actionAjoutProjet($twig) {
    echo $twig->render('ajoutProjet.html.twig', array());
}

function actionListeProjets($twig) {
    echo $twig->render('listeProjets.html.twig', array());
}

?>