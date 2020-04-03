<?php 
include('../../classes/livres.php');
include('../../functions/function_bdd.php');
session_start();
$albums = unserialize($_SESSION['albums']);
$auteurs = unserialize($_SESSION['auteurs']);
$num_id = $_GET['num_id'];
$pos;
$auteur_name;

$req = 'DELETE FROM auteur WHERE auteur_id = '.$num_id.'';
BDD_Del($req);

for($i=0; $i <= count($auteurs); $i++){
    if(!empty($editeurs[$i])){
        if(isset($num_id) && $auteurs[$i]->getID() == $num_id){
            $pos = $i;
            echo $pos;
            $auteur_name = $auteurs[$i]->getName();
            unset($auteurs[$pos]);
        }
    }
}

for($i=0; $i <= count($albums); $i++){
    if(!empty($albums[$i])){
        if(isset($num_id) && $albums[$i]->getID_Auteur() == $num_id){
            $albums[$i]->setID_Auteur(NULL);
            $albums[$i]->setAuteur(NULL);
        }
    }
}

$_SESSION['albums'] = serialize($albums);
$_SESSION['auteurs'] = serialize($auteurs);
header('Location: auteur_gestion.php');

?>