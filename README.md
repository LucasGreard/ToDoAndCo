# Améliorez une application existante de ToDo & Co (V1)

Project 8 : Améliorez une application existante de ToDo & Co

Vous venez d’intégrer une startup dont le cœur de métier est une application permettant de gérer ses tâches quotidiennes.

Votre rôle ici est donc d’améliorer la qualité de l’application. La qualité est un concept qui englobe bon nombre de sujets : on parle souvent de qualité de code, mais il y a également la qualité perçue par l’utilisateur de l’application ou encore la qualité perçue par les collaborateurs de l’entreprise, et enfin la qualité que vous percevez lorsqu’il vous faut travailler sur le projet.

## Pour commencer

J'utilise Symfony 5.4 comme FrameWork et Visual Studio Code pour le code et le maintien sur GitHub.

### Pré-requis

Ce qu'il est requis pour commencer avec le projet

```
PHP 7.4.27
MySql 5.7.31
Symfony 5.4.0
Composer version 2.1.9
PHPUnit 9.5.13
Xdebug v3.1.3
Blackfire v1.74.1~win-x64-zts74
```

### Installation

```
$ git clone https://github.com/LucasGreard/ToDoAndCo
$ symfony server:start
```

- Lancer Wamp en local
- Accéder à your-localhost/

Pour le profiler de Blackfire :
Ce mettre sur son dossier de blackfire et lancer l'agent

```
$ cd C:\"\program files"\blackfire
$ ./blackfire-agent.exe
```

Pour lancer les fixtures

```
$ php bin/console doctrine:fixtures:load
```

Pour lancer les tests

```
$ vendor/bin/phpunit
```

Pour voir le rapport de couverture de code :
Accéder à your-localhost/coverage.php/

## Fabriqué avec

- Symfony 5
- Visual Studio Code
- WampServer (Faire tourner le serveur en local)
- Blackfire (Pour la performance du code)
- PHPUnit (Pour créer et lancer les tests avant mise en production)
- PhpMyAdmin (Gérer la BDD)

## Auteurs

- **Lucas Gréard** _alias_ [@LucasGreard](https://github.com/LucasGreard/)

Avec l'aide de mon mentor : Adrien Tilliard
