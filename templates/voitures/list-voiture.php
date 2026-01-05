<h2>Liste des Voitures</h2>

<div class="action-bar">
    <a href="?page=ajout_voiture" class="btn-add">
        <i class="fas fa-plus"></i> Ajouter une voiture
    </a>
</div>

<table>
    <tr>
        <th>Châssis</th>
        <th>Marque</th>
        <th>Modèle</th>
        <th>Client</th>
        <th>Carburant</th>
        <th>Transmission</th>
        <th>Kilométrage</th>
        <th>Valeur (CHF)</th>
        <th>État</th>
        <th>Statut</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($voitures as $voiture) : ?>
        <tr>
            <td><?= htmlspecialchars($voiture['idChassis']) ?></td>
            <td><?= htmlspecialchars($voiture['marque'] ?? 'N/A') ?></td>
            <td><?= htmlspecialchars($voiture['modele'] ?? 'N/A') ?></td>
            <td><?= htmlspecialchars(($voiture['client_nom'] ?? '') . ' ' . ($voiture['client_prenom'] ?? '')) ?></td>
            <td><?= htmlspecialchars($voiture['carburant'] ?? 'N/A') ?></td>
            <td><?= htmlspecialchars($voiture['transmission'] ?? 'N/A') ?></td>
            <td><?= number_format($voiture['kilométrage'], 0) ?> km</td>
            <td><?= $voiture['valeurCHF'] ? number_format($voiture['valeurCHF'], 2) . ' CHF' : 'N/A' ?></td>
            <td><?= htmlspecialchars($voiture['etat'] ?? 'N/A') ?></td>
            <td><?= htmlspecialchars($voiture['statut'] ?? 'N/A') ?></td>
            <td>
                <a class="btn-edit" href="?page=modif_voiture&id=<?= urlencode($voiture['idChassis']) ?>">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>
                |
                <a class="btn-delete" href="?page=suppr_voiture&id=<?= urlencode($voiture['idChassis']) ?>" onclick="return confirm('Supprimer cette voiture ?')">
                    <i class="fa-solid fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>