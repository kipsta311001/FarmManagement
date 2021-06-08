<?php

function actionAjoutQuestion($twig,$db){
    $form = array();
    $test = new Test($db);
    $liste = $test->select();
    if (isset($_POST['btAjoutQuestion'])) {
        $intitule = $_POST['intitule'];
        $reponse = $_POST['reponse'];
        $idTest = $_POST['idTest'];
        $question = new Question($db);
        $exec = $question->insert($intitule,$reponse,$idTest);
        if (!$exec){
            $form['valide'] = false;
            $form['message'] = 'Problème d\'insertion dans la table utilisateur ';
        } else {
            $form['valide'] = true;
            $form['message'] = 'La question a bien été ajoutée ';

        }
        $form['intitule'] = $intitule;
        $form['reponse'] = $reponse;
        $form['idTest'] = $idTest;

    }
    echo $twig->render('ajoutQuestion.html.twig',array('form'=>$form,'liste'=>$liste));
}

function actionListeQuestion($twig,$db){
    $form = array();
    $question = new Question($db);
    $liste = $question->select();
    if(isset($_GET['id'])) {
        $exec = $question->delete($_GET['id']);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table question';
        } else {
            $form['valide'] = true;
            $form['message'] = 'La question a bien été suprimée';

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
    $r = $question->selectCount();
    $nb = $r['nb'];


    $liste = $question->selectLimit($inf,$limite);
    $form['nbpages'] = ceil($nb/$limite);
    echo $twig->render('listeQuestion.html.twig',array('form'=>$form,'liste'=>$liste));
}

function actionQuestion($twig, $db){
    $form = array();
    $form['finTest'] = false;
    $idTest = $_GET['test'];
    $question = new Question($db);
    $liste = $question->selectByTest($idTest);
    $_SESSION['question'] = $liste;
    $nbQuestions=sizeof($liste);
    if (!isset($_POST['btReponse'])) {
        $questionActuelle = 0;
        $score = 0;
        $_SESSION['questionActuelle'] = $questionActuelle;
        $_SESSION['score'] = $score;
        }else{
        $questionActuelle = $_SESSION['questionActuelle'];
        $bonneReponse = $liste[$questionActuelle]['reponse'];
        $bonneReponse = mb_strtolower($bonneReponse);
        $bonneReponse = trim($bonneReponse," ");
        $reponseProposee = $_POST['reponse'];
        $reponseProposee = mb_strtolower($reponseProposee);
        $reponseProposee = trim($reponseProposee," ");
        if ($bonneReponse == $reponseProposee){
            $score = $_SESSION['score'];
            $_SESSION['score'] = $score + 1;
        }
        if($nbQuestions-1 != $_SESSION['questionActuelle']){
            $questionActuelle = $_SESSION['questionActuelle'];
            $_SESSION['questionActuelle'] = $questionActuelle + 1;
        }else {
            $score = $_SESSION['score'];
            $form['finTest'] = true;
            $questionActuelle = $nbQuestions - 1;
            $_SESSION['questionActuelle'] = $questionActuelle;
            $scoreFinal = New Score($db);
            $listeScore = $scoreFinal->select($_SESSION['login'], $_GET['test']);
            if ($listeScore == NULL){
                $exec = $scoreFinal->insert($_SESSION['login'], $_GET['test'], $score);
                if (!$exec) {
                    $form['valide'] = false;
                    $form['message'] = 'Problème d\'insertion dans la table score ';
                }


            }
            else {
                $exec = $scoreFinal->update($_SESSION['login'], $_GET['test'], $score);
                if (!$exec) {
                    $form['valide'] = false;
                    $form['message'] = 'Problème de modification dans la table score ';
                }
            }
        }

    }

    echo $twig->render('question.html.twig',array('form'=>$form,'liste'=>$liste,'questionActuelle'=>$questionActuelle,'session'=>$_SESSION,'nbQuestions'=>$nbQuestions));

}

function actionModifQuestion($twig,$db){
    $form['modif'] = false;
    $test = new Test($db);
    $liste = $test->select();
    $question = new Question($db);
    $uneQuestion = $question->selectById($_GET["question"]);
    if (isset($_POST['btModifQuestion'])) {
        $form['modif'] = true;
        $form['valide']=true;
        $intitule = $_POST['intitule'];
        $reponse = $_POST['reponse'];
        $idTest = $_POST['idTest'];
        $id = $_GET['question'];
        $exec = $question->update($intitule,$reponse,$idTest,$id);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Problème de modification dans la table question ';
        }
    }

    echo $twig->render('modifQuestion.html.twig',array('liste'=>$liste,"question"=>$uneQuestion,'form'=>$form));
}