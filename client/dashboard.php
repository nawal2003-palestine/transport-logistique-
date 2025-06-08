<?php 
include '../includes/header.php';
// Ici vous devriez avoir une vérification de session
?>

<div class="dashboard-container">
    <aside class="dashboard-sidebar">
        <div class="user-profile">
            <div class="avatar"><?= substr($user['nom'], 0, 1) ?></div>
            <h3><?= htmlspecialchars($user['nom']) ?></h3>
            <p><?= htmlspecialchars($user['email']) ?></p>
        </div>
        
        <nav class="dashboard-nav">
            <a href="dashboard.php" class="active"><i class="fas fa-home"></i> Tableau de bord</a>
            <a href="post-request.php"><i class="fas fa-plus-circle"></i> Nouvelle demande</a>
            <a href="my-requests.php"><i class="fas fa-list"></i> Mes demandes</a>
            <a href="search-drivers.php"><i class="fas fa-search"></i> Trouver un chauffeur</a>
            <a href="settings.php"><i class="fas fa-cog"></i> Paramètres</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
        </nav>
    </aside>
    
    <main class="dashboard-content">
        <h1>Tableau de bord</h1>
        
        <div class="stats-cards">
            <div class="stat-card">
                <h3>Demandes actives</h3>
                <p class="stat-value">5</p>
            </div>
            <div class="stat-card">
                <h3>Transporteurs trouvés</h3>
                <p class="stat-value">12</p>
            </div>
            <div class="stat-card">
                <h3>Économies réalisées</h3>
                <p class="stat-value">1,200 DH</p>
            </div>
        </div>
        
        <section class="recent-activity">
            <h2>Activité récente</h2>
            <div class="activity-list">
                <!-- Boucle PHP pour afficher les activités -->
                <div class="activity-item">
                    <div class="activity-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="activity-details">
                        <p>Votre demande #1234 a été acceptée par Ahmed</p>
                        <small>Aujourd'hui, 14:30</small>
                    </div>
                </div>
                <!-- Plus d'activités... -->
            </div>
        </section>
    </main>
</div>

<?php include '../includes/footer.php'; ?>
