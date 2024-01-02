# Améliorez une application existante de ToDo & Co
Vous venez d’intégrer une startup dont le cœur de métier est une application permettant de gérer ses tâches quotidiennes. L’entreprise vient tout juste d’être montée, et l’application a dû être développée à toute vitesse pour permettre de montrer à de potentiels investisseurs que le concept est viable (on parle de Minimum Viable Product ou MVP).

Le choix du développeur précédent a été d’utiliser le framework PHP Symfony, un framework que vous commencez à bien connaître !

Bonne nouvelle ! ToDo & Co a enfin réussi à lever des fonds pour permettre le développement de l’entreprise et surtout de l’application.

Votre rôle ici est donc d’améliorer la qualité de l’application. La qualité est un concept qui englobe bon nombre de sujets : on parle souvent de qualité de code, mais il y a également la qualité perçue par l’utilisateur de l’application ou encore la qualité perçue par les collaborateurs de l’entreprise, et enfin la qualité que vous percevez lorsqu’il vous faut travailler sur le projet.

Ainsi, pour ce dernier projet de spécialisation, vous êtes dans la peau d’un développeur expérimenté en charge des tâches suivantes :

l’implémentation de nouvelles fonctionnalités ; la correction de quelques anomalies ; et l’implémentation de tests automatisés. Il vous est également demandé d’analyser le projet grâce à des outils vous permettant d’avoir une vision d’ensemble de la qualité du code et des différents axes de performance de l’application.

Il ne vous est pas demandé de corriger les points remontés par l’audit de qualité de code et de performance. Cela dit, si le temps vous le permet, ToDo & Co sera ravi que vous réduisiez la dette technique de cette application.

## Description du projet

### Corrections d'anomalies
* Une tâche doit être attachée à un utilisateur
  Actuellement, lorsqu’une tâche est créée, elle n’est pas rattachée à un utilisateur. Il vous est demandé d’apporter les corrections nécessaires afin qu’automatiquement, à la sauvegarde de la tâche, l’utilisateur authentifié soit rattaché à la tâche nouvellement créée. Lors de la modification de la tâche, l’auteur ne peut pas être modifié. Pour les tâches déjà créées, il faut qu’elles soient rattachées à un utilisateur “anonyme”.
* Choisir un rôle pour un utilisateur
  Lors de la création d’un utilisateur, il doit être possible de choisir un rôle pour celui-ci. Les rôles listés sont les suivants : rôle utilisateur (ROLE_USER), rôle administrateur (ROLE_ADMIN). Lors de la modification d’un utilisateur, il est également possible de changer le rôle d’un utilisateur.

### Implémentation de nouvelles fonctionnalités
* Autorisation
  Seuls les utilisateurs ayant le rôle administrateur (ROLE_ADMIN) doivent pouvoir accéder aux pages de gestion des utilisateurs. Les tâches ne peuvent être supprimées que par les utilisateurs ayant créé les tâches en question. Les tâches rattachées à l’utilisateur “anonyme” peuvent être supprimées uniquement par les utilisateurs ayant le rôle administrateur (ROLE_ADMIN).
* Implémentation de tests automatisés (tests unitaires et fonctionnels)
  Il vous est demandé d’implémenter les tests automatisés nécessaires pour assurer que le fonctionnement de l’application est bien en adéquation avec les demandes. Il vous est demandé de fournir un rapport de couverture de code au terme du projet. Il faut que le taux de couverture soit supérieur à 70 %.


## Installation
Pour commencer avec ce projet PHP, suivez les étapes ci-dessous
1. Clonez le dépôt

   ```bash
   git clone hhttps://github.com/ZitaNguyen/TodoList.git
   ```

2. Accédez au répertoire du projet

   ```bash
   cd <nom du répertoire>
   ```

3. Installez les dépendances requises pour le projet

   ```bash
   composer install
   ```

4. Configurez de la base de données
- Installez MAMP ou XAMPP si besoin
- Modifiez les valeurs dans le fichier `.env.local` pour les adapter à votre configuratione locale.

   ```bash
   DATABASE_URL="mysql://USER:PASSWORD@127.0.0.1:8889/SnowTricks?serverVersion=5.7.40"
   ```

5. Exécuter la création de la base de donnée avec la commande

   ```bash
   symfony console doctrine:database:create
   ```

6. Exécuter la migration en base de donnée

   ```bash
   symfony console doctrine:migration:migrate
   ```

7. Exécuter les dataFixtures avec la commande

   ```bash
   php bin/console doctrine:fixtures:load
   ```

8. Démarrez le serveur de développement

    ```bash
    symfony server:start
    ```

9. Des tests unitaires et fonctionnels sont présents dans le projet dans le répertoire /tests, vous pouvez les lancer avec la commande suivante
    ```bash
    php bin/phpunit
    ```

## Contrôle du code

La qualité du code a été validé par [Codacy](https://codeclimate.com/). Vous pouvez accéder au rapport de contrôle en cliquant sur [ce lien](https://app.codacy.com/gh/ZitaNguyen/TodoList/dashboard).

## Licence

Ce projet est sous licence Apache License 2.0.

