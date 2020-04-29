

<?php 
include('../../classes/livres.php');
include('../../functions/function_bdd.php');
session_start();

if(!empty($_SESSION['editeurs'])){
    $editeurs = unserialize($_SESSION['editeurs']);
}

if(!empty($_GET['valide'])){
    if(!empty($_GET['e_name']) || !empty($_GET['e_tel']) || !empty($_GET['e_country'])){

        $name = $_GET['e_name'];
        $tel = $_GET['e_tel'];
        $country = $_GET['e_country'];

        $data;
        $req = 'INSERT INTO editeur (editeur_nom, editeur_tel, editeur_pays) VALUES ("'.$name.'", "'.$tel.'", "'.$country.'")';
        $id = BDD_Add($req, $data);

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
        header('Location: editeur_gestion.php');

    }
}


?>

<!DOCTYPE html>
<html>
    <head>
        <title>Listing DUTAF - Ajouter un <?php echo $_GET['type'] ?></title
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://bootswatch.com/4/pulse/bootstrap.min.css">
  
        <script src="https://code.jquery.com/jquery-3.4.1.slim.js" integrity="sha256-BTlTdQO9/fascB1drekrDVkaKd9PkwBymMlHOiG+qLI=" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php include '../../includes/header.php'; ?>
        <div class="container">
            <?php 
                
                    echo '
                    <form action="#" method="GET" ><div class="form-group">
                        <label for="exampleInputPassword1">Nom de l`editeur :</label>
                        <input class="form-control" value="'.$_GET['e_name'].'" name="e_name" placeholder="'.$_GET['e_name'].'" id="exampleInputPassword1" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Pays de l`editeur :</label>
                        <input class="form-control" value="'.$_GET['e_country'].'" name="e_country" placeholder="'.$_GET['e_name'].'" id="exampleInputPassword1" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Téléphone de l`editeur :</label>
                        <input class="form-control" name="e_tel" value="'.$_GET['e_tel'].'"placeholder="'.$_GET['e_name'].'" id="exampleInputPassword1" readonly> 
                    </div>
                    <button type="submit" name="valide" value="true"  class="btn btn-danger">Valider cet Ajout</button> 
                    </form>';
                
            ?>
        </div>
    </body>
</html>