# Pour télécharger l'application et l'utiliser en local

### 1. Cloner le dépôt GitHub

```sh
git clone https://github.com/votre-utilisateur/votre-repo.git
cd votre-repo
```

### 2. Installer les dépendances

Assurez-vous d'avoir Composer installé sur votre machine. Ensuite, exécutez la commande suivante pour installer les dépendances PHP :

```sh
composer install
```

### 3. Configurer les variables d'environnement

Copiez le fichier 

.env

 pour créer un fichier `.env.local` et modifiez-le selon vos besoins, notamment les informations de connexion à la base de données :

```sh
cp .env .env.local
```

Modifiez le fichier `.env.local` pour configurer votre base de données. Par exemple :

```
DATABASE_URL="mysql://root:password@127.0.0.1:3306/nom_de_votre_bdd?serverVersion=8.2.0&charset=utf8mb4"
```

### 4. Créer la base de données

Utilisez les commandes Doctrine pour créer la base de données et exécuter les migrations :

```sh
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

### 5. Peupler la base de données

Si vous avez des fixtures pour peupler la base de données, exécutez la commande suivante :

```sh
php bin/console doctrine:fixtures:load
```

### 6. Installer les dépendances JavaScript

Assurez-vous d'avoir Node.js et npm installés sur votre machine. Ensuite, exécutez les commandes suivantes pour installer les dépendances JavaScript :

```sh
npm install
npm run dev
```

### 7. Lancer le serveur local

Utilisez la commande Symfony pour lancer le serveur local :

```sh
symfony server:start
```

Votre application sera accessible à l'adresse `http://127.0.0.1:8000`.

### 8. Accéder à l'application

Ouvrez votre navigateur et accédez à l'adresse `http://127.0.0.1:8000` pour voir votre application en action.

### 9. (Optionnel) Lancer les tests

Pour exécuter les tests, utilisez la commande suivante :

```sh
php bin/phpunit
```

### Résumé des commandes

```sh
git clone https://github.com/votre-utilisateur/votre-repo.git
cd votre-repo
composer install
cp .env .env.local
# Modifier .env.local pour configurer la base de données
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
npm install
npm run dev
php bin/console server:run
```

En suivant ces étapes, vous devriez être en mesure de configurer et de lancer votre application Symfony en local.
