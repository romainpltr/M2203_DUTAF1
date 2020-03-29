<?php 
session_start();
include('../config_inc.php');
include '../classes/livres.php';
$albums = unserialize($_SESSION['albums']);
$num_id = $_GET['num_id'];
$pos;
$album_name;
$bdd = new PDO('mysql:host='.BDD_SERVER.';dbname='.BDD_DATABASE.';charset=utf8', BDD_LOGIN, BDD_PASSWORD);
$req = 'DELETE FROM album WHERE album_id = '.$num_id.'';
$res = $bdd->query($req);


for($i=0; $i < count($albums); $i++){
    if(!empty($albums[$i])){
        if(isset($num_id) && $albums[$i]->getID() == $num_id){
            $pos = $i;
            $album_name = $albums[$i]->getTitle();
        }
    }
}


unset($albums[$pos]);


$_SESSION['albums'] = serialize($albums);
$_SESSION['erreurs']['success'] = '<div class="alert alert-success" role="alert">
Vous venez de supprimer l\'album : '.$album_name.'  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>';

header('Location: bd_gestion.php');

?>
