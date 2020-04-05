<?php 
include('../../classes/livres.php');
include('../../functions/function_bdd.php');
session_start();
$albums = unserialize($_SESSION['albums']);
$auteurs = unserialize($_SESSION['auteurs']);
$num_id = $_GET['num_id'];
$pos;
$auteur_name;



for($i=0; $i < count($auteurs); $i++){
    if(!empty($num_id) && !empty($auteurs[$i])){
        if($auteurs[$i]->getID() == $num_id){
            $pos = $i;
            $auteur_name = $auteurs[$i]->getFirstName()." ".$auteurs[$i]->getLastName();
        }       
    } 
}

for($i=0; $i < count($albums); $i++){
    if(!empty($albums[$i])){
        if(isset($num_id) && $albums[$i]->getID_Auteur() == $num_id){  
            $albums[$i]->setID_Auteur(NULL);
            $albums[$i]->setAuteur(NULL);
            unset($auteurs[$pos]);
        }
    }
}

$req = 'DELETE FROM auteur WHERE auteur_id = '.$num_id.'';
BDD_Del($req);
$_SESSION['auteurs'] = serialize($auteurs);
$_SESSION['albums'] = serialize($albums);
header('Location: auteur_gestion.php');

?>