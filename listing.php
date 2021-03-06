<?php
// INCLUDES 
include('config_inc.php');
include('classes/livres.php');
$albums = array();
$auteurs = array();
$editeurs = array();

ob_start("ob_gzhandler");

if(!empty($_SESSION['albums'])){
    $albums = unserialize($_SESSION['albums']);
 }else if(!empty($_SESSION['auteurs'])){
     $auteurs = unserialize($_SESSION['auteurs']);
 }else if(!empty($_SESSION['editeurs'])){
     $editeurs = unserialize($_SESSION['editeurs']);
 }



if(empty($albums)){
    $bdd = new PDO('mysql:host='.BDD_SERVER.';dbname='.BDD_DATABASE.';charset=utf8', BDD_LOGIN, BDD_PASSWORD);
    $req = 'SELECT * from album';
    $res = $bdd->query($req);
    while($table_info = $res->fetch()){
        $album = new album();
        $album->setID($table_info['album_id']);
        $album->setID_Editeur($table_info['auteur_id_']);
        $album->setID_Auteur($table_info['editeur_id_']);
        $album->setISBN($table_info['album_isbn']);
        $album->setSerie($table_info['album_serie']);
        $album->setTitle($table_info['album_titre']);
        $album->setPrix($table_info['album_prix']);
        $albums[] = $album;
    }

    $res->closeCursor();

    $req = 'SELECT * from auteur';
    $res = $bdd->query($req);
    while($table_info = $res->fetch()){
        $auteur = new auteur();
        $auteur->setID($table_info['auteur_id']);
        $auteur->setAge($table_info['auteur_age']);
        $auteur->setFirstName($table_info['auteur_prenom']);
        $auteur->setLastName($table_info['auteur_nom']);
        $auteur->setNationality($table_info['auteur_nat']);
        $auteurs[] = $auteur;
    }

    $res->closeCursor();

    $req = 'SELECT * from editeur';
    $res = $bdd->query($req);
    while($table_info = $res->fetch()){
        $editeur = new editeur();
        $editeur->setID($table_info['editeur_id']);
        $editeur->setName($table_info['editeur_nom']);
        $editeur->setCountry($table_info['editeur_pays']);
        $editeur->setTelephone($table_info['editeur_tel']);
        $editeurs[] = $editeur;
    }

    $res->closeCursor();

    for($i= 0; $i < count($albums); $i++){
        for($a = 0; $a < count($auteurs); $a++){
            if(isset($auteurs[$a])){
                if($auteurs[$a]->getID() == $albums[$i]->getID_Auteur()){
                     $albums[$i]->setAuteur($auteurs[$a]);
                }
            }
        }
        for($e= 0; $e < count($editeurs); $e++){
            if(isset($editeurs[$e])){
                if($editeurs[$e]->getID() == $albums[$i]->getID_Editeur()){
                    $albums[$i]->setEditor($editeurs[$e]);
                }
            }
        }
    }
}  

?>


<!DOCTYPE html>
<html>
    <head>
        <title>Listing DUTAF</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://bootswatch.com/4/pulse/bootstrap.min.css">
        </head>
        <body>
            <?php 
            
            include('includes/header.php');
            
            echo '<br><div class="container"><table id="table_id" class="table table-striped table-bordered"><thead>';
            echo '<tr><th scope="col">ISBN</><th>Titre</th><th scope="col">Série</th><th scope="col">Prix</th><th scope="col">Nom de l‘auteur</th><th scope="col">Prénom de l‘auteur</th><th scope="col">Nationalité de l‘auteur</th><th scope="col">Age de l‘auteur</th><th scope="col">Nom de l‘editeur</th><th scope="col">Pays de l‘editeur</th><th scope="col">Téléphone de l‘editeur</th></tr></thead><tbody>';

            for($i = 0; $i < count($albums); $i++){
                if(!empty($albums[$i])){
                    echo '<tr>
                    <td>'.$albums[$i]->getISBN().'</td>
                    <td>'.$albums[$i]->getTitle().'</td>
                    <td>'.$albums[$i]->getSerie().'</td>
                    <td>'.$albums[$i]->getPrix().' €</td>';
                
                    if(!empty($albums[$i]->getAuteur())){
                        echo '<td>'.$albums[$i]->getAuteur()->getLastName().'</td>
                        <td>'.$albums[$i]->getAuteur()->getFirstName().'</td>
                        <td>'.$albums[$i]->getAuteur()->getNationality().'</td>
                        <td>'.$albums[$i]->getAuteur()->getAge().'</td>';
                    }else{
                        echo '<td></td><td></td><td></td><td></td>';
                    }

                    if(!empty($albums[$i]->getEditor())){
                        echo '<td>'.$albums[$i]->getEditor()->getName().'</td>
                        <td>'.$albums[$i]->getEditor()->getCountry().'</td>
                        <td>'.$albums[$i]->getEditor()->getTelephone().'</td>
                        </tr>';
                    }else{
                        echo '<td></td><td></td><td></td><td></td>';
                    }
                }
            }

            echo '</tbody></table></div>';
            
            $_SESSION['albums'] = serialize($albums);
            $_SESSION['auteurs'] = serialize($auteurs);
            $_SESSION['editeurs'] = serialize($editeurs);

            ?>
            <footer>  
                <script type="text/javascript" src="contents/js/jquery-3.4.1.min.js"></script> 
                <script type="text/javascript" src="contents/js/popper.min.js"></script>
                <script type="text/javascript" src="contents/js/bootstrap.min.js"></script>
                <script type="text/javascript" src="contents/js/query.dataTables.min.js"></script>
                <script type="text/javascript" src="contents/js/jquery.dataTables.min.js"></script>
                <script type="text/javascript">
                    $(document).ready(function () {
                        $('#table_id').DataTable({
                            "language": {
                                "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
                            },
                            "initComplete": function () {
                                var api = this.api();
                                // Put the sum of column 5 into the footer cell
                                $( api.column( 5 ).footer() ).html(
                                    api.column( 5 ).data().reduce( function (a, b) {
                                        return a + b;
                                    } )
                                );
                            }
                        });
                    });
                </script>
            </footer>
        </body>
    </html>
