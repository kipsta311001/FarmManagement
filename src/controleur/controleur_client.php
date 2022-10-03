<?php

function actionAjoutClient($twig, $db) {
    $form = array();
    $client = new Client($db);
    $unClient = NULL;
    if (isset($_GET['idClientUpdate'])){
        $unClient = $client->selectById($_GET['idClientUpdate']);
        $form['update'] = true;
    }
    if ((isset($_POST['btAjouter'])) && (isset($_GET['idClientUpdate']))) {
        $exec = $client->update($_GET['idClientUpdate'], $_POST['nom'], $_POST['adresse'], $_POST['codePostal'], $_POST['ville'], $_POST['tvaIntra']);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = "Probleme d'insertion du client";
        }
        //$form['update'] = false;
       header("Location:index.php?page=listeClient");
    }elseif((isset($_POST['btAjouter']))){
        $exec = $client->insert($_POST['nom'], $_POST['adresse'], $_POST['codePostal'], $_POST['ville'], $_POST['tvaIntra']);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = "Probleme d'insertion du client";
        }else{
            $form['valide'] = true;
            $form['message'] = "Client ajouté avec succès";
        }
    }
    echo $twig->render('ajoutClient.html.twig', array('form'=>$form, 'unClient'=>$unClient));
}

function actionListeClient($twig, $db) {
    $form = array();
    $client = new Client($db);
    if (isset($_GET['idClientDelete'])){
        $exec = $client->delete($_GET['idClientDelete']);
    }
    $clients = $client->select();

    echo $twig->render('clients.html.twig', array('form'=>$form, 'clients'=>$clients));
}


