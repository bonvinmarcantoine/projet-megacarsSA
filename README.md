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
- **JavaScript**
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
│   │
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
