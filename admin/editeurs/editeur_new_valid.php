

<?php 
include('../../classes/livres.php');
include('../../functions/function_bdd.php');
session_start();

if(!empty($_SESSION['editeurs'])){
    $editeurs = unserialize($_SESSION['editeurs']);
}


if(!empty($_GET['e_name']) || !empty($_GET['e_tel']) || !empty($_GET['e_country'])){
    $name = $_GET['e_name'];
    $tel = $_GET['e_tel'];
    $country = $_GET['e_country'];
    
    $req = 'INSERT INTO editeur (editeur_nom, editeur_tel, editeur_pays) VALUES ("'.$name.'", "'.$tel.'", "'.$country.'")';
    $id = BDD_Add($req);

    $editeur = new editeur();
    $editeur->setID($id);
    $editeur->setName($name);
    $editeur->setTelephone($tel);
    $editeur->setCountry($country);
    $editeurs[] = $editeur;
    $_SESSION['erreurs']['success'] = '<div class="alert alert-success" role="alert"> Vous avez ajouter '.$editeur->getName().' à la liste des éditeurs <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>';
    $_SESSION['editeurs'] = serialize($editeurs);
    header('Location: editeur_gestion.php');

}


?>