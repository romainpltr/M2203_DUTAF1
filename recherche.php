<?php 
    include('config_inc.php');
    if(isset($_GET['auteur'])){
        
        $bdd = new PDO('mysql:host='.BDD_SERVER.';dbname='.BDD_DATABASE.';charset=utf8', BDD_LOGIN, BDD_PASSWORD);
        $req = 'SELECT * from album INNER JOIN auteur ON album.auteur_id_ = auteur.auteur_id WHERE '. .' ORDER BY auteur.auteur_nom, auteur.auteur_prenom ASC';
        $res = $bdd->query($req);
        echo '<div class="container"><table class="table"><thead>';
        echo '<tr><th scope="col">ISBN</><th>Titre</th><th scope="col">Série</th><th scope="col">Prix</th><th scope="col">Nom de l‘auteur</th><th scope="col">Prénom de l‘auteur</th><th scope="col">Nationalité de l‘auteur</th><th scope="col">Age de l‘auteur</th><th scope="col">Nom de l‘editeur</th><th scope="col">Prénom de l‘editeur</th><th scope="col">Nationalité de l‘editeur</th><th scope="col">Age de l‘editeur</th></tr></thead><tbody>';
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
                </tr>';
        }
        echo '</tbody></table></div>';
        
    }

?>