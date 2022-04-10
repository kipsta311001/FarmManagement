<?php 


function actionAjoutEntreprise($twig,$db) {

    $form = array();
    if(isset($_POST['btAjoutEntreprise'])){
        $entreprise = new Entreprise($db);
        $exec = $entreprise->insert($_POST['libelle']);
        if($exec){
            $form['valide'] = true;
            $form['message'] = "Entreprise ajoutée";
        }else{
            $form['valide'] = false;
            $form['message'] = "Erreur d'ajout d'entreprise";
        }
    }


    echo $twig->render('ajoutEntreprise.html.twig', array('form'=>$form));
}




?>