<?php 
session_start();

include('../../classes/livres.php');
include('../../functions/function_bdd.php');

$albums = unserialize($_SESSION['albums']);
$num_id = $_GET['num_id'];
$album_name;


$req = 'DELETE FROM album WHERE album_id = '.$num_id.'';
BDD_Del($req);

for($i=0; $i <= count($albums); $i++){
    if(!empty($albums[$i])){
        if(isset($num_id) && $albums[$i]->getID() == $num_id){
            $album_name = $albums[$i]->getTitle();
            unset($albums[$i]);
        }
    }
}





$_SESSION['albums'] = serialize($albums);
$_SESSION['erreurs']['success'] = '<div class="alert alert-success" role="alert">
Vous venez de supprimer l\'album : '.$album_name.'  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>';

header('Location: bd_gestion.php');

?>
