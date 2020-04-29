<html>
    <head>
        <title>Listing DUTAF</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://bootswatch.com/4/pulse/bootstrap.min.css">

    </head>

    <body>
    <?php $admin = 1; include('../includes/header.php');?>
    <br>
    <div class="container">
        <div class="row">
            <div class="col">
                <a href="bd/bd_gestion.php" class="btn btn-danger btn-large">Gestion des Albums</a>
            </div>
            <div class="col">
                <a href="auteurs/auteurs_gestion.php" class="btn btn-danger btn-large">Gestion des Auteurs</a>
            </div>
            <div class="col">
                <a href="editeurs/editeurs_gestion.php" class="btn btn-danger btn-large">Gestion des Editeurs</a>
            </div>
        </div>
    </div>

    </body>
</html>
