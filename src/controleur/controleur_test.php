<?php

function actionListeTest($twig,$db){
    $form = array();
    $test = new Test($db);
    $liste = $test->select();
    if(isset($_GET['id'])){
        $score = new Score($db);
        $exec1 = $score->deleteByTest($_GET['id']);
        if (!$exec1){
            $form['valide1'] = false;
            $form['message'] = 'Problème de suppression dans la table score';
        }
        else{
            $form['valide1'] = true;
        }
        $question = new Question($db);
        $exec2 = $question->deleteByTest($_GET['id']);
        if (!$exec2){
            $form['valide2'] = false;
            $form['message'] = 'Problème de suppression dans la table question';
        }
        else{
            $form['valide2'] = true;
        }

        $exec3=$test->delete($_GET['id']);
        if (!$exec3){
            $form['valide3'] = false;
            $form['message'] = 'Problème de suppression dans la table test';
        }
        else{
            $form['valide3'] = true;
            $form['message'] = 'Test supprimé avec succès';
        }
    }

    $limite=3;
    if(!isset($_GET['nopage'])){
        $inf=0;
        $nopage=0;
    }
    else{
        $nopage=$_GET['nopage'];
        $inf=$nopage * $limite;
    }
    $r = $test->selectCount();
    $nb = $r['nb'];

    $liste = $test->selectLimit($inf,$limite);
    $form['nbpages'] = ceil($nb/$limite);
    echo $twig->render('listeTest.html.twig',array('form'=>$form,'liste'=>$liste));
}

function actionAjoutTest($twig,$db){
    $form = array();
    if (isset($_POST['btAjoutTest'])) {
        $nom = $_POST['nom'];
        $test = new Test($db);
        $exec = $test->insert($nom);
        if (!$exec){
            $form['valide'] = false;
            $form['message'] = 'Problème d\'insertion dans la table test ';
        }else{
            $form['valide'] = true;
            $form['message'] = 'Le test a bien été ajouté ';

        }
        $form['nom'] = $nom;

    }
    echo $twig->render('ajoutTest.html.twig',array('form'=>$form));
}


function actionTests($twig,$db){
    $form = array();
    $test = new Test($db);
    $liste = $test->selectByNb();
    echo $twig->render('tests.html.twig',array('form'=>$form,'liste'=>$liste));
}

function actionModifTest($twig,$db){
      $form['modif'] = false;
      $test = new Test($db);
      $unTest = $test->selectById($_GET['test']);
      if (isset($_POST['btModifTest'])) {
            $form['modif'] = true;
            $form['valide']=true;
            $nom = $_POST['nom'];
            $id = $_GET['test'];
            $exec = $test->update($nom,$id);
            if (!$exec) {
                $form['valide'] = false;
                $form['message'] = 'Problème de modification dans la table question ';
            }
        }
    echo $twig->render('modifTest.html.twig',array('form'=>$form,'test'=>$unTest));
}