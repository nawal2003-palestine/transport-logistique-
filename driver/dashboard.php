<?php 
include '../includes/header.php';
// Vérification de session
?>

<div class="dashboard-container">
    <aside class="dashboard-sidebar">
        <div class="user-profile">
            <div class="avatar"><?= substr($driver['nom'], 0, 1) ?></div>
            <h3><?= htmlspecialchars($driver['nom']) ?></h3>
            <p>Chauffeur professionnel</p>
            <div class="rating">
                <i class="fas fa-star"></i>
                <span>4.8</span>
            </div>
        </div>
        
        <nav class="dashboard-nav">
            <a href="dashboard.php" class="active"><i class="fas fa-home"></i> Tableau de bord</a>
            <a href="search-requests.php"><i class="fas fa-search"></i> Trouver des missions</a>
            <a href="my-vehicles.php"><i class="fas fa-truck"></i> Mes véhicules</a>
            <a href="my-jobs.php"><i class="fas fa-calendar-check"></i> Mes missions</a>
            <a href="earnings.php"><i class="fas fa-money-bill-wave"></i> Revenus</a>
            <a href="settings.php"><i class="fas fa-cog"></i> Paramètres</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
        </nav>
    </aside>
    
    <main class="dashboard-content">
        <h1>Tableau de bord chauffeur</h1>
        
        <div class="stats-cards">
            <div class="stat-card">
                <h3>Missions ce mois</h3>
                <p class="stat-value">14</p>
            </div>
            <div class="stat-card">
                <h3>Revenus ce mois</h3>
                <p class="stat-value">3,450 DH</p>
            </div>
            <div class="stat-card">
                <h3>Évaluation moyenne</h3>
                <p class="stat-value">4.8/5</p>
            </div>
        </div>
        
        <section class="available-requests">
            <h2>Nouvelles demandes près de chez vous</h2>
            <div class="requests-grid">
                <!-- Boucle PHP pour afficher les demandes -->
                <div class="request-card">
                    <h3>Déménagement Casablanca</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Casablanca → Rabat</p>
                    <p><i class="fas fa-calendar"></i> 15 Juin 2025</p>
                    <p><i class="fas fa-boxes"></i> 3m³ - Meubles</p>
                    <p class="price">450 DH</p>
                    <a href="request-details.php?id=123" class="btn btn-small">Voir détails</a>
                </div>
                <!-- Plus de demandes... -->
            </div>
        </section>
    </main>
</div>

<?php include '../includes/footer.php'; ?>
