# transport-logistique

```Idée
Je veux créer une plateforme marocaine appelée T9el3lina.ma (ou un autre nom), qui met en relation des chauffeurs de transport (avec camions, camionnettes, voitures utilitaires...) et des clients (particuliers ou professionnels) qui ont besoin de transporter des marchandises ou faire un déménagement.  La plateforme doit contenir deux grandes interfaces :  Interface Chauffeur : inscription, ajout de véhicule, zones desservies, disponibilité, voir les demandes de transport disponibles, contacter les clients.  Interface Client : inscription, poster une demande de transport (type d’objet, volume, départ, destination, date), consulter les chauffeurs disponibles, réserver un transport.  Le site doit inclure :  Une page d’accueil claire avec un bouton “Je suis client” et “Je suis chauffeur”  Un espace personnel (tableau de bord) pour chaque type d’utilisateur  Une base de données pour gérer les utilisateurs et les annonces  Un moteur de recherche ou système de matching simple  Un design moderne, responsive, clair et dynamique, adapté au contexte marocain  Le site sera en français dans un premier temps, mais pourra évoluer vers l’arabe et l’anglais  Le but est de faciliter le transport local de manière plus efficace, rapide et sécurisée, tout en offrant une source de revenus aux chauffeurs et un service pratique aux clients.) 

```


### ✅  la base de données

```sql
CREATE DATABASE IF NOT EXISTS t9el_ma;
USE t9el_ma;
```

---

### 🚗 Table `chauffeurs`

```sql
CREATE TABLE chauffeurs (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telephone VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    permis VARCHAR(50) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
```

---

### 👤 Table `clients`

```sql
CREATE TABLE clients (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telephone VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
```

---

### 📦 Table `demandes`

```sql
CREATE TABLE demandes (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    client_id INT(11) NOT NULL,
    titre VARCHAR(100) NOT NULL,
    description TEXT,
    type_marchandise VARCHAR(50) NOT NULL,
    volume DECIMAL(10,2) NOT NULL,
    lieu_depart VARCHAR(100) NOT NULL,
    lieu_arrivee VARCHAR(100) NOT NULL,
    date_demande DATETIME NOT NULL,
    statut VARCHAR(20) DEFAULT 'en attente',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id)
);
```

---

### 🚛 Table `vehicules`

```sql
CREATE TABLE vehicules (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    chauffeur_id INT(11) NOT NULL,
    type VARCHAR(50) NOT NULL,
    marque VARCHAR(50) NOT NULL,
    modele VARCHAR(50) NOT NULL,
    capacite DECIMAL(10,2) NOT NULL,
    immatriculation VARCHAR(20) NOT NULL,
    FOREIGN KEY (chauffeur_id) REFERENCES chauffeurs(id)
);
```

---

### 📅 Table `disponibilites`

```sql
CREATE TABLE disponibilites (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    chauffeur_id INT(11) NOT NULL,
    vehicule_id INT(11) NOT NULL,
    statut ENUM('disponible', 'indisponible', 'en mission') DEFAULT 'disponible',
    position_actuelle VARCHAR(255),
    date_maj TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (chauffeur_id) REFERENCES chauffeurs(id),
    FOREIGN KEY (vehicule_id) REFERENCES vehicules(id)
);
```

---

### 📌 Table `reservations`

```sql
CREATE TABLE reservations (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    demande_id INT(11) NOT NULL,
    chauffeur_id INT(11) NOT NULL,
    vehicule_id INT(11) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    statut VARCHAR(20) DEFAULT 'confirmé',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (demande_id) REFERENCES demandes(id),
    FOREIGN KEY (chauffeur_id) REFERENCES chauffeurs(id),
    FOREIGN KEY (vehicule_id) REFERENCES vehicules(id)
);
```

---

### 💬 Table `messages`

```sql
CREATE TABLE messages (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    reservation_id INT(11) NOT NULL,
    sender_type ENUM('client', 'chauffeur') NOT NULL,
    sender_id INT(11) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (reservation_id) REFERENCES reservations(id)
);
```

---

### 🔄 Table `public_updates`

```sql
CREATE TABLE public_updates (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    demande_id INT(11) NOT NULL,
    chauffeur_id INT(11),
    status ENUM('en_attente', 'en_cours', 'termine', 'annule') DEFAULT 'en_attente',
    position_actuelle VARCHAR(255),
    last_update TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (demande_id) REFERENCES demandes(id),
    FOREIGN KEY (chauffeur_id) REFERENCES chauffeurs(id)
);
```

---
### 💬 Structure

```
/t9el-ma/
│
├── index.html                  # Page d'accueil
├── assets/
│   ├── css/
│   │   ├── style.css           # CSS principal
│   │   └── responsive.css      # CSS responsive
│   ├── js/
│   │   ├── main.js             # JavaScript principal
│   │   ├── client.js           # JS pour l'interface client
│   │   └── driver.js           # JS pour l'interface chauffeur
│   └── img/                    # Toutes les images
│
├── includes/
│   ├── header.php              # Header commun
│   ├── footer.php              # Footer commun
│   └── db.php                  # Connexion à la base de données
│
├── client/
│   ├── register.php            # Inscription client
│   ├── login.php               # Connexion client
│   ├── dashboard.php           # Tableau de bord client
│   ├── post-request.php        # Publier une demande
│   └── search-drivers.php      # Chercher des chauffeurs
│
├── driver/
│   ├── register.php            # Inscription chauffeur
│   ├── login.php               # Connexion chauffeur
│   ├── dashboard.php           # Tableau de bord chauffeur
│   ├── add-vehicle.php         # Ajouter un véhicule
│   └── search-requests.php     # Voir les demandes
│
└── admin/
    ├── login.php               # Admin login
    └── dashboard.php           # Admin dashboard

```

--
