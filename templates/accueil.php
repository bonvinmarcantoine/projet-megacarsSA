<div class="hero">
    <h1 class="hero-title">Domaine Mega Cars Sa</h1>
    <p class="hero-subtitle">Excellence & Tradition depuis 1892</p>
</div>

<div class="stats-container">
    <div class="stat-card">
        <div class="stat-icon">👥</div>
        <div class="stat-content">
            <h3 class="stat-number"><?= $clientCount ?></h3>
            <p class="stat-label">Clients</p>
        </div>
        <a href="?page=clients" class="stat-link">Voir tous →</a>
    </div>

    <div class="stat-card">
        <div class="stat-icon">💼</div>
        <div class="stat-content">
            <h3 class="stat-number"><?= $employeCount ?></h3>
            <p class="stat-label">Employés</p>
        </div>
        <a href="?page=employes" class="stat-link">Voir tous →</a>
    </div>

    <div class="stat-card">
        <div class="stat-icon">🚗</div>
        <div class="stat-content">
            <h3 class="stat-number"><?= $voitureCount ?></h3>
            <p class="stat-label">Voitures</p>
        </div>
        <a href="?page=voitures" class="stat-link">Voir tous →</a>
    </div>

    <div class="stat-card">
        <div class="stat-icon">🔧</div>
        <div class="stat-content">
            <h3 class="stat-number"><?= $prestationCount ?></h3>
            <p class="stat-label">Prestations</p>
        </div>
        <a href="?page=prestations" class="stat-link">Voir tous →</a>
    </div>
</div>

<div class="quick-actions">
    <h2>Actions Rapides</h2>
    <div class="action-buttons">
        <a href="?page=ajout_client" class="action-btn">
            <i class="fas fa-user-plus"></i>
            <span>Nouveau Client</span>
        </a>
        <a href="?page=ajout_employe" class="action-btn">
            <i class="fas fa-briefcase"></i>
            <span>Nouvel Employé</span>
        </a>
        <a href="?page=ajout_voiture" class="action-btn">
            <i class="fas fa-car"></i>
            <span>Nouvelle Voiture</span>
        </a>
        <a href="?page=ajout_prestation" class="action-btn">
            <i class="fas fa-wrench"></i>
            <span>Nouvelle Prestation</span>
        </a>
    </div>
</div>