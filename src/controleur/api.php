<?php
$registration = $_POST['registration'];
$name= $_POST['name'];
$email= $_POST['email'];
$_SESSION['login'];
$retourApi = array(
    array('dates','2022-06-14', '2022-06-15','2022-06-16', '2022-06-17', '2022-06-18', '2022-06-19', '2022-06-20', '2022-06-21', '2022-06-22'),
    array('blé dure', 10.23, 11, 10.1, 10.4, 9, 10, 10.5, 10.7, 12.12),
    array('mais',12.1, 11.9, 12.3, 13, 14.6, 14, 11.1, 12.6, 15),
    array('orge', 7.1, 7, 8.3, 9, 9.2 , 10, 8.7, 10.7, 9.12)


);
if ($registration == "success"){
    // some action goes here under php
    echo json_encode($retourApi);
}     
?>