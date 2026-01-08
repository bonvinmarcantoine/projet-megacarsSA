# 🚗 MegaCars SA – Application de Gestion de Concessionnaire

## 📌 Description

**MegaCars SA** est une application web développée en **PHP** permettant de gérer les différentes activités d’une concession automobile.  
Elle permet la gestion des **voitures**, **clients**, **employés**, **fournisseurs** et **prestations**, à l’aide de formulaires et de listes dynamiques connectés à une base de données.

Projet réalisé dans un **cadre scolaire**.

---

## ✨ Fonctionnalités

- 🏠 Page d’accueil
- 🚘 Gestion des voitures
  - Ajout (formulaire)
  - Liste des voitures
- 👤 Gestion des clients
  - Ajout
  - Liste
- 🧑‍💼 Gestion des employés
  - Ajout
  - Liste
- 🏭 Gestion des fournisseurs
  - Ajout
  - Liste
- 🛠️ Gestion des prestations
  - Ajout
  - Liste
- 🗄️ Connexion à une base de données MySQL
- ♻️ Templates réutilisables (header / footer)
- ❌ Page d’erreur personnalisée

---

## 🛠️ Technologies utilisées

- **PHP**
- **MySQL**
- **HTML / CSS**
- **Apache** (XAMPP / WAMP / MAMP)

---

## 📂 Structure du projet

```bash
projet-megacarsSA/
│
├── includes/
│   ├── db.php                # Connexion à la base de données
│   └── functions.php         # Fonctions utilitaires
│
├── public/
│   └── style.css             # Feuille de style principale
│
├── templates/
│   ├── clients/
│   │   ├── form-client.php
│   │   └── list-client.php
│   │
│   ├── employes/
│   │   ├── form-employe.php
│   │   └── list-employe.php
│   │
│   ├── fournisseurs/
│   │   ├── form-fournisseur.php
│   │   └── list-fournisseur.php
│   │
│   ├── prestations/
│   │   ├── form-prestation.php
│   │   └── list-prestation.php
│   │tr
│   ├── voitures/
│   │   ├── form-voiture.php
│   │   └── list-voiture.php
│   │
│   ├── accueil.php           # Page d’accueil
│   ├── header.php            # En-tête commun
│   ├── footer.php            # Pied de page commun
│   └── error.php             # Page d’erreur
│
├── index.php                 # Point d’entrée de l’application
├── .gitignore
└── README.md

1) XAMPP Control Panel
2) http://localhost/phpmyadmin/
3) http://localhost/mini-app-megacarssa/

taches:
# addresse: 

taches pour claude:
# add employer:
- button add poste
- button add type de contrat

# ajouter la gestion des modeles

# add voiture:
- button add modèle (formulaire modele et quand tu add sela retourne sur le formulaire voiture)
- button add Carburant 
- button add Transmission
- button add État
- button add Statut
- vérifier que le chassi ne soi pas déjat utiliser

# add modèle: 
- button add Type
- button add Marque

# add prestation
- button add Type
- button add Statut
- je veut que je puisse choisir le client et que cela me propose parmi les voitures du client (nom du modèl + chassi)
