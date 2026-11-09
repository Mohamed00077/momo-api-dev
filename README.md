# Note API

API REST éducative développée avec **Laravel 13**, conçue pour permettre aux étudiants de s'exercer aux appels API (inscription, authentification par token, CRUD) sur un cas concret : la gestion de notes.

Le projet est utilisé par des étudiants de Licence 2 de l'Université Virtuelle de Côte d'Ivoire.

- **API en ligne :** https://momo-api-dev-1.onrender.com/
- **Documentation interactive :** https://momo-api-dev-1.onrender.com/api/documentation

> L'API est hébergée sur le plan gratuit de Render : après 15 minutes d'inactivité, le service se met en veille. La première requête suivante peut prendre 30 à 50 secondes.

## Objectifs pédagogiques

En utilisant cette API, un étudiant apprend à :

- envoyer des requêtes HTTP (GET, POST, PUT, DELETE) avec Postman, Insomnia, curl ou depuis du code ;
- s'inscrire, se connecter et récupérer un token d'authentification ;
- envoyer ce token dans l'en-tête `Authorization: Bearer <token>` ;
- lire une documentation d'API et interpréter les codes de réponse (200, 201, 401, 404, 422…).

## Stack technique

- Laravel 13
- MySQL (local) / PostgreSQL (production)
- Laravel Sanctum (authentification par token)
- Docker
- PHPUnit (tests)

## Endpoints

| Méthode | Endpoint        | Description                  | Authentification   |
|---------|-----------------|------------------------------|--------------------|
| POST    | `/api/register` | Inscription d'un utilisateur | Non                |
| POST    | `/api/login`    | Connexion                    | Non                |
| GET     | `/api/profile`  | Récupérer le profil connecté | Oui (Bearer token) |
| PUT     | `/api/profile`  | Modifier le profil           | Oui (Bearer token) |
| GET     | `/api/notes`    | Voir toutes les notes        | Non                |
| POST    | `/api/notes`    | Ajouter une note             | Oui (Bearer token) |
| PUT     | `/api/notes`    | Modifier une note            | Oui (Bearer token) |
| DELETE  | `/api/notes`    | Supprimer une note           | Oui (Bearer token) |

## Exemple rapide

Inscription :

```bash
curl -X POST https://momo-api-dev-1.onrender.com/api/register \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"name": "Etudiant", "email": "etudiant@example.com", "password": "motdepasse123"}'
```

> Adapte les champs à ceux décrits dans la documentation interactive.

Utilisation du token :

```bash
curl https://momo-api-dev-1.onrender.com/api/profile \
  -H "Accept: application/json" \
  -H "Authorization: Bearer VOTRE_TOKEN"
```

## Installation locale

1. Cloner le dépôt :

   ```bash
   git clone https://github.com/Mohamed00077/momo-api-dev.git
   cd momo-api-dev
   ```

2. Installer les dépendances :

   ```bash
   composer install
   ```

3. Copier le fichier d'environnement et générer la clé :

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Configurer la base de données dans `.env` :

   ```env
   DB_CONNECTION=mysql   # pgsql en production
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=note-api
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. Créer la base de données `note-api`, puis migrer :

   ```bash
   php artisan migrate
   ```

6. Lancer le serveur :

   ```bash
   php artisan serve
   ```

## Lancer les tests

```bash
php artisan test
```

## Contribuer

Les contributions sont les bienvenues, notamment pour améliorer la documentation, ajouter des tests ou proposer des exercices pour les étudiants.

1. Forker le dépôt
2. Créer une branche (`git checkout -b ma-fonctionnalite`)
3. Commiter vos changements
4. Ouvrir une Pull Request

## Licence

Ce projet est distribué sous licence MIT. Voir le fichier [LICENSE](LICENSE).

## Auteur

**Diabagate Mohamed**