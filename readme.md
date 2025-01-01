# Projet Docker Conteneurisé

## Table des matières

-   [Description](#description)
-   [Prérequis](#prérequis)
-   [Installation](#installation)
-   [Commandes Utiles](#commandes-utiles)
    -   [Lancement en Environnement de Développement](#lancement-en-environnement-de-développement)
    -   [Construction de l’Image pour la Production](#construction-de-limage-pour-la-production)
    -   [Lancement en Environnement de Production](#lancement-en-environnement-de-production)
-   [Dépôt Docker](#dépôt-docker)
-   [Références](#références)

## Description

Ce projet met en œuvre une architecture conteneurisée pour une application web comprenant :

-   Un service `client` pour héberger une application front-end statique.
-   Un service `server` pour gérer la logique métier.
-   Une base de données relationnelle `database` pour la persistance des données.
-   Des outils pour le développement : `adminer` pour l'administration de la base de données et `mailhog` pour tester l'envoi d'emails (en environnement de développement uniquement).

## Prérequis

-   [Docker](https://www.docker.com/) et [Docker Compose](https://docs.docker.com/compose/) installés.
-   Accès à un terminal.

## Installation

1. Clonez le dépôt :

    ```bash
    git clone https://github.com/huntercobra18/docker-tp-c-antoine.git
    cd docker-tp-c-antoine
    ```

1. Copiez le fichier .env.example en .env pour la configuration de l’environnement :
    ```
    cp .env.example .env
    ```

## Commandes Utiles

### Lancement en Environnement de Développement

```bash
docker-compose -f docker-compose.yml -f docker-compose.dev.yml up -d
```

### Construction de l’Image pour la Production

```bash
docker-compose -f docker-compose.yml -f docker-compose.prod.yml up -d
```

### Lancement en Environnement de Production

1.  Construire les images :

    ```bash
    docker-compose -f docker-compose.yml -f docker-compose.prod.yml build
    ```

1.  Lancer les services en production :

    ```bash
    docker-compose -f docker-compose.yml -f docker-compose.prod.yml up
    ```

## Dépôt Docker

La pipeline Ci push une image sur le [dépot antoine_exam_server](https://hub.docker.com/r/acywip/antoine_exam_server/tags)

## Références

Documentation officielle de [Docker](https://docs.docker.com/).
\
Documentation officielle de [Docker Compose](https://docs.docker.com/compose/).
