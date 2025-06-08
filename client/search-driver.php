

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trouver un Chauffeur | T9el.ma</title>
    <style>
        /* Nouveau style pour le header */
        .main-header {
            background-color: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo-icon {
            font-size: 2rem;
        }

        .logo-text {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2C5D8C;
        }

        .main-nav {
            display: flex;
            gap: 2rem;
        }

        .nav-link {
            text-decoration: none;
            color: #2C3E50;
            font-weight: 500;
            padding: 0.5rem 0;
            position: relative;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: #2C5D8C;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #2C5D8C;
            transition: width 0.3s;
        }

        .nav-link:hover::after {
            width: 100%;
        }
        /* Styles de base - Cohérents avec le thème */
        :root {
            --primary: #2C5D8C;
            --primary-light: #3A7DB8;
            --secondary: #E67E22;
            --light: #F5F7FA;
            --dark: #2C3E50;
            --white: #FFFFFF;
        }
        
        .search-container {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .search-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .search-title {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }
        
        .search-subtitle {
            color: var(--dark);
            opacity: 0.8;
        }
        
        /* Formulaire de recherche */
        .search-form {
            background: var(--white);
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
        
        .form-group {
            margin-bottom: 0;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark);
        }
        
        .form-select, .form-input {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #eee;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .form-select:focus, .form-input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(44, 93, 140, 0.2);
        }
        
        .search-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            align-self: flex-end;
        }
        
        .search-btn:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
        }
        
        /* Résultats */
        .results-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        .driver-card {
            background: var(--white);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        
        .driver-card:hover {
            transform: translateY(-5px);
        }
        
        .driver-header {
            background: var(--primary);
            color: white;
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .driver-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
        }
        
        .driver-info {
            flex: 1;
        }
        
        .driver-name {
            font-weight: 600;
            margin-bottom: 0.2rem;
        }
        
        .driver-rating {
            color: #FFD700;
            font-size: 0.9rem;
        }
        
        .driver-body {
            padding: 1.5rem;
        }
        
        .driver-detail {
            display: flex;
            align-items: center;
            margin-bottom: 0.8rem;
            color: var(--dark);
        }
        
        .driver-icon {
            margin-right: 0.8rem;
            color: var(--primary);
        }
        
        .driver-actions {
            padding: 0 1.5rem 1.5rem;
        }
        
        .btn-reserve {
            background: var(--secondary);
            color: white;
            border: none;
            padding: 0.8rem;
            border-radius: 8px;
            width: 100%;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-reserve:hover {
            background: #F39C12;
        }
        
        /* Filtres */
        .filter-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }
        
        .filter-tag {
            background: var(--light);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .filter-tag:hover, .filter-tag.active {
            background: var(--primary);
            color: white;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .search-form {
                grid-template-columns: 1fr;
            }
            
            .search-btn {
                width: 100%;
            }
        
        }
    </style>
</head>
<body>
    <header class="main-header">
        <div class="header-container">
            <div class="logo-container">
                <span class="logo-icon">👩🏻‍💼👨‍💼</span>
                <span class="logo-text">T9el.ma</span>
            </div>
            <nav class="main-nav">
                <a href="../index.html" class="nav-link">Accueil</a>
                <a href="register.php" class="nav-link">Inscription</a>
                <a href="login.php" class="nav-link">Connexion</a>
                <a href="search-drivers.php" class="nav-link">Chercher chaufeure</a>
            </nav>
        </div>
    </header>
    <div class="search-container">
        <div class="search-header">
            <h1 class="search-title">Trouvez votre chauffeur</h1>
            <p class="search-subtitle">Des professionnels disponibles près de chez vous</p>
        </div>
        
        <!-- Formulaire de recherche -->
        <form class="search-form">
            <div class="form-group">
                <label for="ville" class="form-label">Ville</label>
                <select id="ville" class="form-select">
                    <option value="">Toutes les villes</option>
                    <option>Casablanca</option>
                    <option>Rabat</option>
                    <option>Marrakech</option>
                    <option>Tanger</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="type-vehicule" class="form-label">Type de véhicule</label>
                <select id="type-vehicule" class="form-select">
                    <option value="">Tous types</option>
                    <option>Camionnette</option>
                    <option>Camion</option>
                    <option>Fourgon</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="date" class="form-label">Date</label>
                <input type="date" id="date" class="form-input">
            </div>
            
            <button type="submit" class="search-btn">Rechercher</button>
        </form>
        
        <!-- Filtres rapides -->
        <div class="filter-tags">
            <div class="filter-tag active">Tous</div>
            <div class="filter-tag">Disponible maintenant</div>
            <div class="filter-tag">Meilleures notes</div>
            <div class="filter-tag">Prix compétitifs</div>
        </div>
        
        <!-- Résultats -->
        <div class="results-container">
            <?php foreach($drivers as $driver): ?>
            <div class="driver-card">
                <div class="driver-header">
                    <div class="driver-avatar"><?= strtoupper(substr($driver['nom'], 0, 1)) ?></div>
                    <div class="driver-info">
                        <div class="driver-name"><?= htmlspecialchars($driver['nom']) ?></div>
                        <div class="driver-rating">★★★★☆ (4.2)</div>
                    </div>
                </div>
                
                <div class="driver-body">
                    <div class="driver-detail">
                        <span class="driver-icon">🚗</span>
                        <span><?= htmlspecialchars($driver['type_vehicule'] ?? 'Camionnette') ?></span>
                    </div>
                    
                    <div class="driver-detail">
                        <span class="driver-icon">📍</span>
                        <span><?= htmlspecialchars($driver['ville'] ?? 'Casablanca') ?></span>
                    </div>
                    
                    <div class="driver-detail">
                        <span class="driver-icon">💰</span>
                        <span>À partir de 200 DH/heure</span>
                    </div>
                </div>
                
                <div class="driver-actions">
                    <button class="btn-reserve">Réserver ce chauffeur</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        // Filtres interactifs
        document.querySelectorAll('.filter-tag').forEach(tag => {
            tag.addEventListener('click', function() {
                document.querySelector('.filter-tag.active').classList.remove('active');
                this.classList.add('active');
                // Ici vous ajouteriez le code pour filtrer les résultats
            });
        });
        
        // Animation des cartes
        document.querySelectorAll('.driver-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.boxShadow = '0 10px 25px rgba(0,0,0,0.15)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
            });
        });
    </script>
</body>
</html>
