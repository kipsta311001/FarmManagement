<?php

if(isset($_POST['fonction'])){
   
   
}
function actionApi(){

$config['serveur']='localhost';
$config['login'] = 'login4066';
$config['mdp'] ='ZpOHhSeWUcUkAhG';
$config['bd'] = 'poinB3';
$db = connect($config);
$semis = new Semis($db);
$listeSemis = $semis->semenceByID($_SESSION['idUtilisateur']);
$retourApi = array(
    array('dates','2022-06-14', '2022-06-15','2022-06-16', '2022-06-17', '2022-06-18', '2022-06-19', '2022-06-20', '2022-06-21', '2022-06-22'),
       
);
foreach($listeSemis as $semence) //pour toutes les parcelles cochés
    {
        $semence[0] = iconv('utf-8','ASCII//IGNORE//TRANSLIT',$semence[0]);
        $donnee = array($semence[0], rand(7,16), rand(7,16), rand(7,16), rand(7,16), rand(7,16), rand(7,16), rand(7,16), rand(7,16), rand(7,16));
        array_push($retourApi, $donnee);
    }

   

    // some action goes here under php
    echo json_encode($retourApi);
}
   
?>