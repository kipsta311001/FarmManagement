<?php

function actionAjoutIntervention($twig, $db) {
    $form = array();
    $intervention = new Intervention($db);
    $client = new Client($db);
    $prestation = new Prestation($db);
    $clients = $client->select();
    $prestations = $prestation->select();
    $today = date("Y-m-d");
    if (isset($_POST['btAjouter'])){
        var_dump(date("H:i"));
        $h1=strtotime($_POST['heureDebut']);

        $h2=strtotime($_POST['heureFin']);

        $heure = date('H:i',$h2-$h1);
       
        $exec = $intervention->insert($_POST['client'], $_POST['prestation'], $_POST['nombreHa'], $heure, $_POST['chauffeur'], $_POST['dateIntervention'], 1, NULL);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = "Probleme d'insertion de l'intervention";
        }else{
            $form['valide'] = true;
            $form['message'] = "Intervention ajoutée avec succès"; 
        }
    }
  
    echo $twig->render('ajoutIntervention.html.twig', array('form'=>$form, 'prestations'=>$prestations, 'clients'=>$clients, 'date'=>$today));
}

function actionListeIntervention($twig, $db) {
    $form = array();
    $intervention = new Intervention($db);
    if (isset($_GET['idClient'])){
        $interventionClient = $intervention->selectByClient($_GET['idClient']);
    }else{
        $form['valide'] = false;
        $form['message'] = "Client incorrect";
    }
    echo $twig->render('listeIntervention.html.twig', array('form'=>$form, 'interventions'=>$interventionClient));
}


