<?php

function actionCulture($twig, $db) {
    $form = array();
   
    $parcelle = new Parcelle($db);
    $listeParcelle = $parcelle->selectByUtilisateur($_SESSION['login']);
    if(isset($_POST['btValider'])){
        if(isset($_POST['checkboxParcelle'])){
            $checkboxParcelle = $_POST['checkboxParcelle'];
        }else{
            $checkboxParcelle = array();
        }

        $culture = new Culture($db);
        $cout = floatval($_POST['cout']);
        // si pas de parcelle selectionné
        if(sizeof($checkboxParcelle) == 0){
            $form['valide'] = false;
            $form['message'] = "Attention, vous n'avez sélectionné aucun champs pour cette intervention";
        }else{
           
            $listeSurfaceCheck = array();
            var_dump($checkboxParcelle);
            foreach($checkboxParcelle as $idParcelle) //pour toutes les parcelles cochés
            {
                // Si plusieurs parcelle cochés
                if(sizeof($checkboxParcelle) > 1 && $cout != 0){
                    array_push($listeSurfaceCheck, $parcelle->selectSurfaceCheck($idParcelle));
                    $surfaceTotal = 0;
                }else{ 
                    //Sinon faire l'insert direct
                    $exec = $culture->insert($idParcelle, $_POST['name'], $_POST['date_intervention'],  $cout);
                    if (!$exec) {
                        $form['valide'] = false;
                        $form['message'] = "Probleme d'insertion de l'intervention";
                    }
                    $surfaceTotal = 1;
                }
            }
            // Calcul de la surface total
            foreach($listeSurfaceCheck as $uneSurface)
            {
                $surfaceTotal = $surfaceTotal + floatval($uneSurface[0]['surface']);
            }
            $prixByHa = $cout / $surfaceTotal;
            
            foreach($checkboxParcelle as $idParcelle) // pour diviser le cout en fonction du nombre d'Ha
            {
                if(sizeof($checkboxParcelle) > 1 && $cout != 0){
                    $maSurface = $parcelle->selectSurfaceCheck($idParcelle);
                    $cout = $prixByHa * $maSurface[0]['surface'];
                    $exec = $culture->insert($idParcelle, $_POST['name'], $_POST['date_intervention'],  $cout);
                    if (!$exec) {
                        $form['valide'] = false;
                        $form['message'] = "Probleme d'insertion de l'intervention";
                    }
                }
            }
        }
    }

    echo $twig->render('culture.html.twig', array('form' => $form, 'parcelles'=>$listeParcelle));
}

?>