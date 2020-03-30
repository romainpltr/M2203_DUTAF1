<?php 
include('../config_inc.php');
include('../classes/livres.php');
include('../functions/function_bdd.php');
session_start();

if(!empty($_SESSION['albums'])){
    $albums = unserialize($_SESSION['albums']);
} 

//AUTEUR
if(!empty($_GET['a_prenom']) || !empty($_GET['a_name']) || 
!empty($_GET['a_nationalite']) || !empty($_GET['a_age'])){
    if(!empty($_SESSION['auteurs'])){
        $auteurs = unserialize($_SESSION['auteurs']);
    }
    // RECUPERATION DES INFOS
    $prenom = $_GET['a_prenom'];
    $nom = $_GET['a_name'];
    $nationalite = $_GET['a_nationalite'];
    $age = $_GET['a_age'];

    // A FAIRE CREER DES OBJET POUR LES REQUETES
    $req = 'INSERT INTO auteur (auteur_prenom, auteur_nom, auteur_nat, auteur_age) VALUES ("'.$prenom.'", "'.$nom.'", "'.$nationalite.'", '.$age.')';
    
    // Fonction qui ajoute en fonction de la requete avec une sous-fonction pour recupere le dernier ID.
    $id = BDD_Add($req);
    

    //CREATION D'UN AUTEUR
    $auteur = new auteur();
    $auteur->setID($id);
    $auteur->setFirstName($prenom);
    $auteur->setLastName($nom);
    $auteur->setNationality($nationalite);
    $auteur->setAge($age);
    $auteurs[] = $auteur;
    
    $_SESSION['erreurs']['success'] = '<div class="alert alert-success" role="alert"> Vous avez ajouter '.$auteur->getFirstName()." ". $auteur->getLastName(). ' à la liste des auteurs <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>';
    $_SESSION['auteurs'] = serialize($auteurs);
    header('Location: bd_gestion.php');


}
//EDITEUR
else if(!empty($_GET['e_name']) || !empty($_GET['e_tel']) || !empty($_GET['e_country'])){
    if(!empty($_SESSION['editeurs'])){
        $editeurs = unserialize($_SESSION['editeurs']);
    }

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
    header('Location: bd_gestion.php');
   

}

//LIVRE
else if(!empty($_GET['type']) == "livre"){
 
}
?>