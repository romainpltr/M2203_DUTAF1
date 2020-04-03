<?php
    include('../../classes/livres.php');
    include('../../config_inc.php');
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
                if(!empty($_GET['type']) && $_GET['type'] == "auteur"){
            
                    echo '<form action="auteur_new_valide.php" method="GET" ><div class="form-group">
                        <label for="exampleInputPassword1">Prénom de l`auteur :</label>
                        <input  class="form-control" name="a_prenom" id="exampleInputPassword1">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nom de l`auteur :</label>
                        <input  class="form-control" name="a_name" id="exampleInputPassword1">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nationalité de l`auteur :</label>
                        <input  class="form-control" name="a_nationalite" id="exampleInputPassword1">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Age de l`auteur:</label>
                        <input  class="form-control" name="a_age" id="exampleInputPassword1">
                    </div>
                    <button type="submit" class="btn btn-success">Ajouter</button>
                    </form>';
                }
            ?>
        </div>
    </body>
</html>