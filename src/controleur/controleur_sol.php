<?php

function actionSol($twig, $db) {
    $form = array();
   
    $parcelle = new Parcelle($db);
    $listeParcelle = $parcelle->selectByUtilisateur($_SESSION['login']);
    if(isset($_POST['btValider'])){
        if(isset($_POST['checkboxParcelle'])){
            $checkboxParcelle = $_POST['checkboxParcelle'];
        }else{
            $checkboxParcelle = array();
        }

        $sol = new Sol($db);
        $cout = floatval($_POST['cout']);
        // si plusieurs parcelle et que le cout est rempli
        // if(sizeof($checkboxParcelle) > 1 && $cout != 0){
          //   $form['valide'] = false;
          //   $form['message'] = "Attention, le cout rentrez va etre diviser entre les différents champs selectionnés,
           //                      \n Voulez-vous continuer ?";
            // faire un calcul qui divise le cout equitablement par rapport aux nombre d'hectares

        // si pas de parcelle selectionné
        if(sizeof($checkboxParcelle) == 0){
            $form['valide'] = false;
            $form['message'] = "Attention, vous n'avez sélectionné aucun champs pour cette intervention";
            // petite ligne en js et empecher de cliquer sur le bouton valider
        }else{
           
            $listeSurfaceCheck = array();
            //var_dump($checkboxParcelle);
            foreach($checkboxParcelle as $idParcelle) //pour toutes les parcelles cochés
            {
                if(sizeof($checkboxParcelle) > 1 && $cout != 0){
                    array_push($listeSurfaceCheck, $parcelle->selectSurfaceCheck($idParcelle));
                    $surfaceTotal = 0;
                }else{
                    $exec = $sol->insert($idParcelle, $_POST['name'], $_POST['date_intervention'], $_POST['description'],  $cout, 'Travail du sol');
                    if (!$exec) {
                        $form['valide'] = false;
                        $form['message'] = "Probleme d'insertion de l'intervention";
                    }
                    $surfaceTotal = 1;
                }
            }
            foreach($listeSurfaceCheck as $uneSurface)
            {
                $surfaceTotal = $surfaceTotal + floatval($uneSurface[0]['surface']);
                var_dump($surfaceTotal);
            }
            $prixByHa = $cout / $surfaceTotal;

            foreach($checkboxParcelle as $idParcelle) // pour diviser le cout en fonction du nombre d'Ha
            {
                if(sizeof($checkboxParcelle) > 1 && $cout != 0){
                    $maSurface = $parcelle->selectSurfaceCheck($idParcelle);
                    $cout = $prixByHa * $maSurface[0]['surface'];
                    $exec = $sol->insert($idParcelle, $_POST['name'], $_POST['date_intervention'], $_POST['description'],  $cout, 'Travail du sol');
                    if (!$exec) {
                        $form['valide'] = false;
                        $form['message'] = "Probleme d'insertion de l'intervention";
                    }
                }
            }
        }
    }

    echo $twig->render('sol.html.twig', array('form' => $form, 'parcelles'=>$listeParcelle));
}

?>