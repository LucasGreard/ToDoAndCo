# Contribution au projet (V1)

Project 8 : Améliorez une application existante de ToDo & Co

Vous venez d’intégrer une startup dont le cœur de métier est une application permettant de gérer ses tâches quotidiennes.

Votre rôle ici est donc d’améliorer la qualité de l’application. La qualité est un concept qui englobe bon nombre de sujets : on parle souvent de qualité de code, mais il y a également la qualité perçue par l’utilisateur de l’application ou encore la qualité perçue par les collaborateurs de l’entreprise, et enfin la qualité que vous percevez lorsqu’il vous faut travailler sur le projet.

## Duplication du projet

Si vous voulez contribuer à mon projet mais que vous n’avez pas les droits. Vous pouvez le dupliquer. Cela signifie que GitHub va faire pour vous une copie personnelle du projet qui se situe dans votre espace.
Vous pourrez ainsi faire les modifications que vous voulez dessus et fournir une contribution au dépôt originel en créant une requête de tirage. (pull request)

Ceci ouvre un fil de discussion avec possibilité de revue de code, pour que le propriétaire et le contributeur puissent discuter et modifier le code proposé jusqu’à ce que le propriétaire soit satisfait du résultat et le fusionne dans son dépôt.

### Principe Générale

Le principe général est le suivant :

1. Duplication du projet.
2. Création d’une branche thématique à partir de la branche master,
3. Validation de quelques améliorations (commit),
4. Poussée de la branche thématique sur votre projet GitHub (push),
5. Ouverture d’une requête de tirage sur GitHub (Pull Request),
6. Discussion et éventuellement possibilité de nouvelles validations (commit).
7. Le propriétaire du projet fusionne (merge) ou ferme (close) la requête de tirage.
8. Synchronisation de la branche master mise à jour avec celle de votre propre dépôt.

### Création d’une requête de tirage (pull request)

Premièrement, nous cliquons sur le bouton « Fork » pour obtenir une copie du projet.
Votre copie de ce projet est à https://github.com/votrenom/todo&co et c’est ici que nous pouvons la modifier.
Vous pouvez aussi la cloner localement, créer une branche thématique, modifier le code et pousser finalement cette modification sur GitHub.
Maintenant, si vous allez sur votre projet dupliqué sur GitHub, vous pouvez voir que GitHub a remarqué que vous avez poussé une nouvelle branche thématique et affiche un gros bouton vert pour vérifier vos modifications et ouvrir une requête de tirage sur le projet original.
Vous pouvez aussi vous rendre à la page « Branches » à https://github.com/<utilisateur>/<projet>/branches pour trouver votre branche et ouvrir une requête de tirage à partir de là.
Si vous cliquez sur le bouton vert, une fenêtre vous permet de créer un titre et une description de la modification que vous souhaitez faire intégrer pour que je trouve une bonne raison de la prendre en considération. C’est généralement une bonne idée de passer un peu de temps à écrire une description aussi argumentée que possible pour que je sache pourquoi la modification est proposée et en quoi elle apporterait une amélioration au projet.
Quand vous cliquez sur le bouton « Create pull request » sur cet écran, je reçois une notification m’indiquant que quelqu’un suggère une modification et qui renvoie à la page contenant toutes les informations correspondantes.

### Itérations sur une pull request

À présent, je peux regarder les modifications suggérées et les fusionner ou les rejeter ou encore les commenter. Supposons que j’apprécie l’idée mais que je préfère une autre modification en lien avec la vôtre.
Cette conversation a lieu en ligne sur GitHub. Je peux faire une revue des différences en vue unifiées et laisser un commentaire en cliquant sur une des lignes.

Une fois que le mainteneur a commenté, vous (et en fait toute personne surveillant le dépôt) recevrez une notification par email.
N’importe qui peut aussi laisser un commentaire global sur la pull request. Sur la page de discussion d’une requête de tirage, nous pouvons voir un exemple où le propriétaire du projet commente une ligne de code puis laisse un commentaire général dans la section de discussion. Vous pouvez voir que les commentaires de code sont aussi publiés dans la conversation.

Maintenant, vous savez ce que vous devez faire pour que ses modifications soient intégrées. Heureusement, ici c’est une chose facile à faire. Alors que par courriel, il faudrait retravailler les séries de commit et les soumettre à nouveau à la liste de diffusion, avec GitHub il suffit de soumettre les correctifs sur la branche thématique et de la repousser.
Je serai notifié à nouveau des modifications du contributeur et pourra voir que les problèmes ont été réglés quand je visiterai la page de la pull request. En fait, comme la ligne de code initialement commentée a été modifiée entre temps, GitHub le remarque et fait disparaître la différence obsolète.

### Règles à respecter & Processus de qualité

- Il est obligatoire de respecter les PSR (PHP Standards Recommendations).
- Il est obligatoire de respecter l’architecture du projet. (Architecture de Symfony 5.4)
- Il est obligatoire d’utiliser la Programmation Orientée Objet. (POO)
- Partir sur une nouvelle branche quand on modifie ou ajoute une nouvelle fonctionnalité au projet est obligatoire.
- Chaque variable doit contenir plus de 3 (trois) caractères et ne pas contenir de raccourcis si ce n’est pas clair. (ex : $em pour entityManager est interdit mais $entityManager est autorisé)

- Les commentaires peuvent être écrits en français. Il ne faut pas en abuser mais il est important d’en mettre.

- Il est interdit de faire des modifications sur la branche principale.
- Le code ne doit pas être dupliqué.

- Pour chaque fonction ajoutée, un test doit être effectué. (Dans le projet, PHPUnit est utilisé pour tester le code. La couverture de code est disponible dans /coverage.php)

- Pensez à vérifier vos versions de vos bundles/librairies/Symfony/.. pour que tout soit compatible.

## Auteurs

- **Lucas Gréard** _alias_ [@LucasGreard](https://github.com/LucasGreard/)

Avec l'aide de mon mentor : Adrien Tilliard
