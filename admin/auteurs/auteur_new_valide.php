<?php 
include('../../classes/livres.php');
include('../../functions/function_bdd.php');
session_start();


if(!empty($_SESSION['auteurs'])){
    $auteurs = unserialize($_SESSION['auteurs']);
}

//AUTEUR
if(!empty($_GET['a_prenom']) || !empty($_GET['a_name']) || 
!empty($_GET['a_nationalite']) || !empty($_GET['a_age'])){

    // RECUPERATION DES INFOS
    $prenom = $_GET['a_prenom'];
    $nom = $_GET['a_name'];
    $nationalite = $_GET['a_nationalite'];
    $age = $_GET['a_age'];


    // A FAIRE CREER DES OBJET POUR LES REQUETES
    $data;
    $req = 'INSERT INTO auteur (auteur_prenom, auteur_nom, auteur_nat, auteur_age) VALUES ("'.$prenom.'", "'.$nom.'", "'.$nationalite.'", '.$age.')';
    
    // Fonction qui ajoute en fonction de la requete avec une sous-fonction pour recupere le dernier ID.
    $id = BDD_Add($req,$data);

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
    header('Location: auteur_gestion.php');


}

?>