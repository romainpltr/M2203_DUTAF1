<?php
// INCLUDES 
include('config_inc.php');
include('classes/livres.php');
if(!empty($_SESSION['albums'])){
    session_destroy();
}
session_start();

if(!empty($_SESSION['albums'])){
   $albums = unserialize($_SESSION['albums']);
}

if(empty($albums)){
    $albums = array();
    $auteurs = array();
    $editeurs = array();
    $bdd = new PDO('mysql:host='.BDD_SERVER.';dbname='.BDD_DATABASE.';charset=utf8', BDD_LOGIN, BDD_PASSWORD);
    $req = 'SELECT * from auteur INNER JOIN album ON auteur.auteur_id = album.auteur_id_ INNER JOIN editeur ON album.editeur_id_ = editeur.editeur_id';
    $res = $bdd->query($req);

    while($table_info = $res->fetch()){
    
    $album = new album();
    $album->newAuteur();
    $album->getAuteur()->setAge($table_info['auteur_age']);
    $album->getAuteur()->setFirstName($table_info['auteur_prenom']);
    $album->getAuteur()->setLastName($table_info['auteur_nom']);
    $album->getAuteur()->setNationality($table_info['auteur_nat']);

    $album->setID($table_info['album_id']);
    $album->setISBN($table_info['album_isbn']);
    $album->setSerie($table_info['album_serie']);
    $album->setTitle($table_info['album_titre']);
    $album->setPrix($table_info['album_prix']);
    
    $album->newEditor();
    $album->getEditor()->setName($table_info['editeur_nom']);
    $album->getEditor()->setCountry($table_info['editeur_pays']);
    $album->getEditor()->setTelephone($table_info['editeur_tel']);
    $albums[] = $album;
    }
}



?>


<!DOCTYPE html>
<html>
    <head>
        <title>Listing DUTAF</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://bootswatch.com/4/pulse/bootstrap.min.css">

    </head>

    <body>
    <?php include('includes/header.php');?>
    
    <?php 
    

    echo '<div class="container"><table class="table"><thead>';
    echo '<tr><th scope="col">ISBN</><th>Titre</th><th scope="col">Série</th><th scope="col">Prix</th><th scope="col">Nom de l‘auteur</th><th scope="col">Prénom de l‘auteur</th><th scope="col">Nationalité de l‘auteur</th><th scope="col">Age de l‘auteur</th><th scope="col">Nom de l‘editeur</th><th scope="col">Pays de l‘editeur</th><th scope="col">Téléphone de l‘editeur</th></tr></thead><tbody>';

    for($i = 0; $i < count($albums); $i++){
        if(!empty($albums[$i])){
        echo '<tr>
        <td>'.$albums[$i]->getISBN().'</td>
        <td>'.$albums[$i]->getTitle().'</td>
        <td>'.$albums[$i]->getSerie().'</td>
        <td>'.$albums[$i]->getPrix().'</td>
        <td>'.$albums[$i]->getAuteur()->getLastName().'</td>
        <td>'.$albums[$i]->getAuteur()->getFirstName().'</td>
        <td>'.$albums[$i]->getAuteur()->getNationality().'</td>
        <td>'.$albums[$i]->getAuteur()->getAge().'</td>
        <td>'.$albums[$i]->getEditor()->getName().'</td>
        <td>'.$albums[$i]->getEditor()->getCountry().'</td>
        <td>'.$albums[$i]->getEditor()->getTelephone().'</td>
        </tr>';
        }
    }

    echo '</tbody></table></div>';
    
    $albums_serialized = serialize($albums);
    $_SESSION['albums'] = $albums_serialized;
    ?>
    </body>

</html>