# transport-logistique
Je veux créer une plateforme marocaine appelée T9el.ma (ou un autre nom), qui met en relation des chauffeurs de transport (avec camions, camionnettes, voitures utilitaires...) et des clients (particuliers ou professionnels) qui ont besoin de transporter des marchandises ou faire un déménagement.  La plateforme doit contenir deux grandes interfaces :  Interface Chauffeur : inscription, ajout de véhicule, zones desservies, disponibilité, voir les demandes de transport disponibles, contacter les clients.  Interface Client : inscription, poster une demande de transport (type d’objet, volume, départ, destination, date), consulter les chauffeurs disponibles, réserver un transport.  Le site doit inclure :  Une page d’accueil claire avec un bouton “Je suis client” et “Je suis chauffeur”  Un espace personnel (tableau de bord) pour chaque type d’utilisateur  Une base de données pour gérer les utilisateurs et les annonces  Un moteur de recherche ou système de matching simple  Un design moderne, responsive, clair et dynamique, adapté au contexte marocain  Le site sera en français dans un premier temps, mais pourra évoluer vers l’arabe et l’anglais  Le but est de faciliter le transport local de manière plus efficace, rapide et sécurisée, tout en offrant une source de revenus aux chauffeurs et un service pratique aux clients.) telle que : Structure des fichiers
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
