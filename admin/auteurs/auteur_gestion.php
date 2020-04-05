
<?php 
    session_start();
    include('../../classes/livres.php');
    include('../../functions/function_bdd.php');

    $admin = 1;
    // On vérifie si il n'existe pas les tableau dans la session
    if(!empty($_SESSION['auteurs'])){
        $auteurs = unserialize($_SESSION['auteurs']);
    } 
    // Sinon on récupere les données depuis la base de données
    if(empty($albums) || empty($auteurs) || empty($editeurs)){
        if(!empty($_SESSION['albums'])){
            $albums = unserialize($_SESSION['albums']);
        }
        if(!empty($_SESSION['editeurs'])){
            $editeurs = unserialize($_SESSION['editeurs']);
        }
        $albums = array();
        $auteurs = array();
        $editeurs = array();
        $res;
        $req = 'SELECT * from album';
        $res = BDD_Select($req, null);
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
        $res = BDD_Select($req, $res);
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
        $res = BDD_Select($req, $res);
        while($table_info = $res->fetch()){
            $editeur = new editeur();
            $editeur->setID($table_info['editeur_id']);
            $editeur->setName($table_info['editeur_nom']);
            $editeur->setCountry($table_info['editeur_pays']);
            $editeur->setTelephone($table_info['editeur_tel']);
            $editeurs[] = $editeur;
        }
        $res->closeCursor();
    

        // On affecte les auteurs et editeurs en fonction de leurs id au livres oû les id sont correspondant
        for($i= 0; $i < count($albums); $i++){
            for($a = 0; $a < count($auteurs); $a++){
                if(!empty($albums[$i]->getID_Editeur())){
                    if(!empty($auteurs[$a]) && !empty($albums[$i]->getID_Editeur())){
                        if($auteurs[$a]->getID() == $albums[$i]->getID_Auteur()){
                            $albums[$i]->setAuteur($auteurs[$a]);
                        }
                    }
                }
            }
            for($e= 0; $e < count($editeurs); $e++){
                if(!empty($editeurs[$e])){
                    if(!empty($albums[$i]->getID_Editeur())){
                        if($editeurs[$e]->getID() == $albums[$i]->getID_Editeur()){
                            $albums[$i]->setEditor($editeurs[$e]);
                        }
                    }
                }
            }
        }

        $_SESSION['albums'] = serialize($albums); // Tableau des albums contenant les auteurs et editeurs en fonction de leur id.
        $_SESSION['editeurs'] = serialize($editeurs); // Tableau des éditeurs 

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
        
        include('../../includes/header.php');
        
        echo '
        <br><div class="container">';
        if(!empty($_SESSION['erreurs']['success'])){
            echo $_SESSION['erreurs']['success'];
            unset($_SESSION["erreurs"]["success"]);
        }
        echo '
        <center><a href="auteur_new_form.php?type=auteur"><button type="button" class="pull-right btn btn-lg btn-warning">Ajouter un Auteur</button></a></center>
        </div><br>
        <center><p>Nombre actuel de livre : '.count($albums).' Nombre actuel d`auteurs : '.count($auteurs).' Nombre actuel d`editeurs : '.count($editeurs).'</p></center> 
        
        <div class="container-fluid">    
        <br>

        <table id="table_id" class="table"><thead>';

        echo '<tr><th scope="col">ID des Auteurs</th><th scope="col">Nom de l‘auteur</th><th scope="col">Prénom de l‘auteur</th><th scope="col">Nationalité de l‘auteur</th><th scope="col">Age de l‘auteur</th><th></th><th></th></th></thead><tbody>'; 
                for($i = 0; $i <= count($auteurs); $i++){
                    if(!empty($auteurs[$i])){
                        echo '<td>'.$auteurs[$i]->getID().'</td>
                                <td>'.$auteurs[$i]->getLastName().'</td>
                                <td>'.$auteurs[$i]->getFirstName().'</td>
                                <td>'.$auteurs[$i]->getNationality().'</td>
                                 <td>'.$auteurs[$i]->getAge().'</td>';
                    
                        echo '<td><a href="auteur_update_form.php?num_id='.$auteurs[$i]->getID().'"><button type="button" class="btn btn-primary">Modifier</button></a></td>
                        <td><a href="auteur_delete.php?num_id='.$auteurs[$i]->getID().'"> <button type="button" class="btn btn-danger">Supprimer</button></a></td>';
                    }
               echo '</tr>';
            }

        echo '</tbody></table></div></div>';
        
        $_SESSION['auteurs'] = serialize($auteurs);  // Tableau des auteurs 
     
        ?>
        <footer>  
        <script type="text/javascript" src="../../contents/js/jquery-3.4.1.min.js"></script> 
        <script type="text/javascript" src="../../contents/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="../../contents/js/popper.min.js" async></script>
        <script type="text/javascript" src="../../contents/js/bootstrap.min.js" async></script>
        <script type="text/javascript" src="../../contents/js/dataTables.bootstrap4.min.js"></script>
            <script type="text/javascript" async>
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