<!DOCTYPE html>
<?php 
    include('../classes/livres.php');
    $store = file_get_contents('../store');
    $albums = unserialize($store);
?>
<html>
    <head>
        <title>Listing DUTAF</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>

    <body>
    <?php 
    
    include('../includes/header.php');
    echo '<div class="container"><table class="table"><thead>';

    echo '<tr><th scope="col">ISBN</><th>Titre</th><th scope="col">Série</th><th scope="col">Prix</th><th scope="col">Nom de l‘auteur</th><th scope="col">Prénom de l‘auteur</th><th scope="col">Nationalité de l‘auteur</th><th scope="col">Age de l‘auteur</th><th scope="col">Nom de l‘editeur</th><th scope="col">Pays de l‘editeur</th><th scope="col">Téléphone de l‘editeur</th><th scope="col></th><th scope="col></th></tr></thead><tbody>';
    
    for($i = 0; $i < count($albums); $i++){
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
        <td><a href="bd_update_form.php?num_id='.$albums[$i]->getID().'"><button type="button" class="btn btn-primary">Modifier</button></a></td>
        <td><a href="bd_delete.php?num_id='.$albums[$i]->getID().'" <button type="button" class="btn btn-danger">Supprimer</button></a></td>
    </tr>';
    
    }
    echo '</tbody></table></div>';
    
    
    
    ?>
    
<btn