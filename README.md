# PHP_DUTAF1
Dutaf 1 is a project of a library gestion create on POO with PHP

J'ai décidé de faire ce projet en POO pour pouvoir m'améliorer et améliorer ma compréhention de ceux-ci.
Je sais que le code serais plus simple avec de simple requetes PDO vers MariaDB, seulement cela a un coup mémoire non négligeable pour le serveur.
J'ai donc décidé de restreindre au maximum les requetes, et de stocker mes élements dans des session pour les faire transiter de page en pages.

**CE QU'IL ME RESTE A FAIRE**

- Implémentation des nouvaux livres, auteurs, et editeurs.
- Implémentation de la modification des livres, auteurs et editeurs indépendament de leur livre attribuer (Pour pouvoir modifier un ensemble de livre à la fois,   exemple la ville de l'auteur Uderzo change, je veux que tout ses bouquins au pour la ville de l'auteur, changer).
- Implémentation d'un schémat Relationnel viable et stable pour les optimisation future.

A l'heure actuel voici le schéma relationnel de mes objets

- _Objet Auteur_
- _Objet Editeur_
- _Objet Livre : Objet Auteur et Objet Editeur_

Tout ses objets sont stocker dans des tableaux indépendant.

Un Objet Editeur et Auteur est copié dans un livre oû leur attribut de classe Editeur_ID_ et Auteur_ID_ = Editeur_ID et Auteur_ID

Seulement, cela n'est pas stable car si on dois faire une modification on dois parcourir chaque tableau et donc créer une boucle itérative à la génération de notre page.




