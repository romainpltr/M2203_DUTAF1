<!-- HEADER -->
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">DUTAF</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link" href="https://mmi.romainpltr.fr/dutaf/index.php">Acceuil <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="https://mmi.romainpltr.fr/dutaf/listing.php">Liste des livres</a>
        </li>
       
        <li class="nav-item">
            <a class="nav-link" href="https://mmi.romainpltr.fr/dutaf/admin/admin.php" tabindex="-1" aria-disabled="true">Privé</a>
        </li>

        <?php 

        if(!empty($admin) && $admin == 1){
            echo '<li class="nav-item">
            <a class="nav-link" href="https://mmi.romainpltr.fr/dutaf/admin/bd_gestion.php" tabindex="-1" aria-disabled="true">Gestion de la base de données</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="https://mmi.romainpltr.fr/dutaf/admin/auteurs/auteurs_gestion.php" tabindex="-1" aria-disabled="true">Gestion des auteurs</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="https://mmi.romainpltr.fr/dutaf/admin/editeurs/editeurs_gestion.php" tabindex="-1" aria-disabled="true">Gestion des éditeurs</a>
        </li>';
        }
        
        ?>

        </ul>
        <form method="GET" action="https://mmi.romainpltr.fr/dutaf/recherche.php" class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" name="auteur" placeholder="Nom de l'auteur" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Rechercher</button>
        </form>
    </div>
    </nav>
</header>