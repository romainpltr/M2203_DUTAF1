<?php 
include('../../classes/livres.php');
include('../../functions/function_bdd.php');
session_start();
$albums = unserialize($_SESSION['albums']);
$editeurs = unserialize($_SESSION['editeurs']);
$num_id = $_GET['num_id'];
$pos;
$editeur_name;



$req = 'DELETE FROM editeur WHERE editeur_id = '.$num_id.'';
BDD_Del($req);

for($i=0; $i < count($editeurs); $i++){
    if(!empty($editeurs[$i])){
        if(isset($num_id) && $editeurs[$i]->getID() == $num_id){
            $pos = $i;
            echo $pos;
            $editeur_name = $editeurs[$i]->getName();
        }
    }
}


for($i=0; $i < count($albums); $i++){
    if(!empty($albums[$i])){
        if(isset($num_id) && $albums[$i]->getID_Editeur() == $num_id){
            $albums[$i]->setID_Editeur(NULL);
            $albums[$i]->setEditor(NULL);
        }
    }
}

unset($editeurs[$pos]);
$_SESSION['albums'] = serialize($albums);
$_SESSION['editeurs'] = serialize($editeurs);
header('Location: editeur_gestion.php');

?>