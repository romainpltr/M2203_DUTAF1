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
    
    include('config_inc.php');
    if(isset($_GET['auteur'])){
        $auteur = $_GET['auteur'];
        $bdd = new PDO('mysql:host='.BDD_SERVER.';dbname='.BDD_DATABASE.';charset=utf8', BDD_LOGIN, BDD_PASSWORD);
        $req = 'SELECT * from auteur INNER JOIN album ON auteur.auteur_id = album.auteur_id_ INNER JOIN editeur ON album.editeur_id_ = editeur.editeur_id WHERE (auteur.auteur_nom LIKE "%'.$auteur.'%") OR (auteur.auteur_prenom LIKE "%'.$auteur.'%") ORDER BY auteur.auteur_nom, auteur.auteur_prenom ASC';
        $res = $bdd->query($req);
        echo '<div class="container"><table class="table"><thead>';
        echo '<tr><th scope="col">ISBN</><th>Titre</th><th scope="col">Série</th><th scope="col">Prix</th><th scope="col">Nom de l‘auteur</th><th scope="col">Prénom de l‘auteur</th><th scope="col">Nationalité de l‘auteur</th><th scope="col">Age de l‘auteur</th><th scope="col">Nom de l‘editeur</th><th scope="col">Pays de l‘editeur</th><th scope="col">Téléphone de l‘editeur</th></tr></thead><tbody>';
        while($ligne = $res->fetch()){
            echo '<tr>
                    <td>'.$ligne['album_isbn'].'</td>
                    <td>'.$ligne['album_titre'].'</td>
                    <td>'.$ligne['album_serie'].'</td>
                    <td>'.$ligne['album_prix'].'</td>
                    <td>'.$ligne['auteur_nom'].'</td>
                    <td>'.$ligne['auteur_prenom'].'</td>
                    <td>'.$ligne['auteur_nat'].'</td>
                    <td>'.$ligne['auteur_age'].'</td>
                    <td>'.$ligne['editeur_nom'].'</td>
                    <td>'.$ligne['editeur_pays'].'</td>
                    <td>'.$ligne['editeur_tel'].'</td>
                </tr>';
        }
        echo '</tbody></table></div>';
        
    }

?>