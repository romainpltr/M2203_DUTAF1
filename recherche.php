

<?php 
include('config_inc.php');
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
    <?php include('includes/header.php');?>
    <?php 

    if(isset($_GET['auteur'])){
        $auteur = $_GET['auteur'];
        $bdd = new PDO('mysql:host='.BDD_SERVER.';dbname='.BDD_DATABASE.';charset=utf8', BDD_LOGIN, BDD_PASSWORD);
   
        $req = 'SELECT * from auteur INNER JOIN album ON auteur.auteur_id = album.auteur_id_ INNER JOIN editeur ON album.editeur_id_ = editeur.editeur_id WHERE (auteur.auteur_nom LIKE "%'.$auteur.'%") OR (auteur.auteur_prenom LIKE "%'.$auteur.'%") ORDER BY auteur.auteur_nom, auteur.auteur_prenom ASC';
        $res = $bdd->prepare($req);
        $res->execute();
        
        echo '<br><div class="container"><table id="table_id" class="table"><thead>';
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
        <script type="text/javascript" src="contents/js/jquery-3.4.1.min.js"></script> 
        <script type="text/javascript" src="contents/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="contents/js/popper.min.js" async></script>
        <script type="text/javascript" src="contents/js/bootstrap.min.js" async></script>
        <script type="text/javascript" src="contents/js/dataTables.bootstrap4.min.js"></script>
        <script>
        $(document).ready(function () {
            $('#table_id').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
                },
                "initComplete": function () {
                    var api = this.api();
                    $( api.column( 5 ).footer() ).html(
                        api.column( 5 ).data().reduce( function (a, b) {
                            return a + b;
                        } )
                    );
                }
            });
        });
    </script>
