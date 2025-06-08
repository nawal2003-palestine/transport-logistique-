 <?php
include '../includes/header.php';
include '../includes/db.php';

// Vérifier si le chauffeur est connecté
session_start();
if (!isset($_SESSION['driver_id'])) {
    header('Location: logindriver.php');
    exit();
}

$driver_id = $_SESSION['driver_id'];

// Récupération des paramètres de recherche
$ville = $_GET['ville'] ?? '';
$type_marchandise = $_GET['type_marchandise'] ?? '';
$date = $_GET['date'] ?? '';

try {
    // Construction de la requête pour trouver des demandes correspondantes
    $sql = "SELECT d.*, c.nom AS client_nom, c.telephone AS client_tel 
            FROM demandes d
            JOIN clients c ON d.client_id = c.id
            WHERE d.statut = 'en attente'";
    
    $params = [];
    
    // Filtres dynamiques
    if (!empty($ville)) {
        $sql .= " AND d.lieu_depart LIKE :ville OR d.lieu_arrivee LIKE :ville";
        $params[':ville'] = "%$ville%";
    }
    
    if (!empty($type_marchandise)) {
        $sql .= " AND d.type_marchandise = :type_marchandise";
        $params[':type_marchandise'] = $type_marchandise;
    }
    
    if (!empty($date)) {
        $sql .= " AND DATE(d.date_demande) = :date";
        $params[':date'] = $date;
    }
    
    // Exclure les demandes déjà réservées par ce chauffeur
    $sql .= " AND d.id NOT IN (
                SELECT demande_id FROM reservations 
                WHERE chauffeur_id = :driver_id
              )";
    $params[':driver_id'] = $driver_id;
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $demandes = $stmt->fetchAll();
    
} catch(PDOException $e) {
    $error_message = "Erreur de recherche: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes Disponibles | T9el.ma</title>
    <style>
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
        
        .results-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
        }
        
        .demande-card {
            background: var(--white);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s;
            border-left: 4px solid var(--secondary);
        }
        
        .demande-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .demande-header {
            background: var(--light);
            padding: 1rem;
            border-bottom: 1px solid #eee;
        }
        
        .demande-title {
            font-size: 1.2rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }
        
        .demande-client {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--dark);
            font-size: 0.9rem;
        }
        
        .client-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.8rem;
        }
        
        .demande-body {
            padding: 1.5rem;
        }
        
        .demande-detail {
            display: flex;
            margin-bottom: 1rem;
        }
        
        .detail-icon {
            margin-right: 1rem;
            color: var(--primary);
            width: 20px;
            text-align: center;
        }
        
        .detail-content {
            flex: 1;
        }
        
        .detail-label {
            font-size: 0.8rem;
            color: #666;
        }
        
        .detail-value {
            font-weight: 500;
            color: var(--dark);
        }
        
        .demande-actions {
            padding: 0 1.5rem 1.5rem;
            display: flex;
            gap: 1rem;
        }
        
        .btn-accept {
            background: var(--secondary);
            color: white;
            border: none;
            padding: 0.8rem;
            border-radius: 8px;
            flex: 1;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-accept:hover {
            background: #F39C12;
        }
        
        .btn-details {
            background: var(--white);
            color: var(--primary);
            border: 2px solid var(--primary);
            padding: 0.8rem;
            border-radius: 8px;
            flex: 1;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-details:hover {
            background: var(--primary);
            color: white;
        }
        
        .no-results {
            text-align: center;
            padding: 2rem;
            color: var(--dark);
            grid-column: 1 / -1;
        }
        
        @media (max-width: 768px) {
            .search-form {
                grid-template-columns: 1fr;
            }
            
            .search-btn {
                width: 100%;
            }
            
            .results-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="search-container">
        <div class="search-header">
            <h1 class="search-title">Demandes disponibles</h1>
            <p class="search-subtitle">Trouvez des missions correspondant à votre véhicule</p>
        </div>
        
        <form method="GET" class="search-form">
            <div class="form-group">
                <label for="ville" class="form-label">Ville</label>
                <input type="text" id="ville" name="ville" class="form-input" 
                       value="<?= htmlspecialchars($ville) ?>" placeholder="Ex: Casablanca">
            </div>
            
            <div class="form-group">
                <label for="type_marchandise" class="form-label">Type de marchandise</label>
                <select id="type_marchandise" name="type_marchandise" class="form-select">
                    <option value="">Tous types</option>
                    <option value="Meubles" <?= $type_marchandise === 'Meubles' ? 'selected' : '' ?>>Meubles</option>
                    <option value="Electroménager" <?= $type_marchandise === 'Electroménager' ? 'selected' : '' ?>>Electroménager</option>
                    <option value="Déménagement" <?= $type_marchandise === 'Déménagement' ? 'selected' : '' ?>>Déménagement</option>
                    <option value="Colis" <?= $type_marchandise === 'Colis' ? 'selected' : '' ?>>Colis</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="date" class="form-label">Date de livraison</label>
                <input type="date" id="date" name="date" class="form-input" 
                       value="<?= htmlspecialchars($date) ?>">
            </div>
            
            <button type="submit" class="search-btn">Rechercher</button>
        </form>
        
        <div class="results-container">
            <?php if (!empty($demandes)): ?>
                <?php foreach($demandes as $demande): ?>
                <div class="demande-card">
                    <div class="demande-header">
                        <h3 class="demande-title"><?= htmlspecialchars($demande['titre']) ?></h3>
                        <div class="demande-client">
                            <div class="client-avatar"><?= strtoupper(substr($demande['client_nom'], 0, 1)) ?></div>
                            <span><?= htmlspecialchars($demande['client_nom']) ?></span>
                        </div>
                    </div>
                    
                    <div class="demande-body">
                        <div class="demande-detail">
                            <span class="detail-icon">📦</span>
                            <div class="detail-content">
                                <div class="detail-label">Type de marchandise</div>
                                <div class="detail-value"><?= htmlspecialchars($demande['type_marchandise']) ?></div>
                            </div>
                        </div>
                        
                        <div class="demande-detail">
                            <span class="detail-icon">📏</span>
                            <div class="detail-content">
                                <div class="detail-label">Volume estimé</div>
                                <div class="detail-value"><?= htmlspecialchars($demande['volume']) ?> m³</div>
                            </div>
                        </div>
                        
                        <div class="demande-detail">
                            <span class="detail-icon">📍</span>
                            <div class="detail-content">
                                <div class="detail-label">Trajet</div>
                                <div class="detail-value">
                                    <?= htmlspecialchars($demande['lieu_depart']) ?> → 
                                    <?= htmlspecialchars($demande['lieu_arrivee']) ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="demande-detail">
                            <span class="detail-icon">📅</span>
                            <div class="detail-content">
                                <div class="detail-label">Date souhaitée</div>
                                <div class="detail-value">
                                    <?= date('d/m/Y', strtotime($demande['date_demande'])) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="demande-actions">
                        <form method="POST" action="accepter-demande.php" style="flex: 1;">
                            <input type="hidden" name="demande_id" value="<?= $demande['id'] ?>">
                            <button type="submit" class="btn-accept">Accepter</button>
                        </form>
                        <a href="demande-details.php?id=<?= $demande['id'] ?>" class="btn-details">Détails</a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-results">
                    <p>Aucune demande disponible ne correspond à vos critères</p>
                    <a href="search-requests.php" class="btn-accept" style="display: inline-block; width: auto; padding: 0.5rem 1rem;">Réinitialiser les filtres</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Animation des cartes
        document.querySelectorAll('.demande-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.boxShadow = '0 10px 25px rgba(0,0,0,0.15)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
            });
        });
        
        // Mise à jour dynamique de la date min
        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.getElementById('date');
            const today = new Date().toISOString().split('T')[0];
            dateInput.min = today;
            
            if(!dateInput.value) {
                dateInput.value = today;
            }
        });
    </script>
</body>
</html>
