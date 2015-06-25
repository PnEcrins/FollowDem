<?php
include ("../config/config.php");
include ("../classes/db.class.php");
include ("../classes/config.class.php");
session_start();

$db = db::get();
$query = 'SELECT identifiant, pass, nom_user, prenom_user FROM '.config::get('db_prefixe').'users WHERE identifiant = :login AND session_id = :session_id';
$sth=$db->prepare($query);
$sth->execute(array(':login'=>$_SESSION['xlogin'],':session_id'=>session_id()));
$result = $sth->fetchAll(PDO::FETCH_ASSOC);
if (count($result) != 1){
    //redirection vers la page d'identification
    header("Location: index.php");
}
?>