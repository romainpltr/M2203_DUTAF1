<?php 
include('../config_inc.php');
include('../classes/livres.php');
session_start();

if(!empty($_SESSION['albums'])){
    $albums = unserialize($_SESSION['albums']);
 }
if(!empty($_SESSION['auteurs'])){
     $auteurs = unserialize($_SESSION['auteurs']);
} 
if(!empty($_SESSION['editeurs'])){
     $editeurs = unserialize($_SESSION['editeurs']);
}




//AUTEUR
if(!empty($_GET['a_prenom']) || !empty($_GET['a_name']) || 
!empty($_GET['a_nationalite']) || !empty($_GET['a_age'])){
    // RECUPERATION DES INFOS
    $id;
    $prenom = $_GET['a_prenom'];
    $nom = $_GET['a_name'];
    $nationalite = $_GET['a_nationalite'];
    $age = $_GET['a_age'];


    // A FAIRE CREER DES OBJET POUR LES REQUETES
    
    $bdd = new PDO('mysql:host='.BDD_SERVER.';dbname='.BDD_DATABASE.';charset=utf8', BDD_LOGIN, BDD_PASSWORD);
    $req = 'INSERT INTO auteur (auteur_prenom, auteur_nom, auteur_nat, auteur_age) VALUES ("'.$prenom.'", "'.$nom.'", "'.$nationalite.'", '.$age.')';
    $res = $bdd->query($req);
    $res = $res->exec();
    var_dump($res);
    $id = $res->lastInsertId();

  
    
    // CREATION D'UN AUTEUR
    
    $auteur = new auteur();
    
    $auteur->setID($id);
    
    $auteur->setFirstName($prenom);
    
    $auteur->setLastName($nom);
    
    $auteur->setNationality($nationalite);
    
    $auteur->setAge($age);
    
    //$auteurs[] = $auteur;



}
//EDITEUR
else if(!empty($_GET['e_name']) || 
!empty($_GET['e_tel']) || !empty($_GET['e_country'])){

    $name = $_GET['e_name'];
    $tel = $_GET['e_tel'];
    $country = $_GET['e_country'];
    $id;

    $bdd = new PDO('mysql:host='.BDD_SERVER.';dbname='.BDD_DATABASE.';charset=utf8', BDD_LOGIN, BDD_PASSWORD);
    $req = 'INSERT INTO editeur (editeur_nom, editeur_tel, editeur_pays) VALUES ("'.$name.'", "'.$tel.'", "'.$country.'", "'.$age.'")';
    $res = $bdd->query($req);

    $editeur = new editeur();
    $editeur->setName($name);
    $editeur->setTelephone($tel);
    $editeur->setCountry($country);
    $edteurs[] = $editeur;
   

}

//LIVRE
else if(!empty($_GET['auteur'])){
    var_dump($_GET['auteur']);
}

?>