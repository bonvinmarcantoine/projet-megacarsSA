<h2>Liste des Prestations</h2>

<div class="action-bar">
    <a href="?page=ajout_prestation" class="btn-add">
        <i class="fas fa-plus"></i> Ajouter une prestation
    </a>
</div>

<table>
    <tr>
        <th>ID</th>
        <th>Client</th>
        <th>Châssis</th>
        <th>Type</th>
        <th>Statut</th>
        <th>Date Début</th>
        <th>Date Fin Prévue</th>
        <th>Date Fin</th>
        <th>Temps Passé (h)</th>
        <th>Note</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($prestations as $prestation) : ?>
        <tr>
            <td><?= htmlspecialchars($prestation['idPrestation']) ?></td>
            <td><?= htmlspecialchars(($prestation['client_nom'] ?? '') . ' ' . ($prestation['client_prenom'] ?? '')) ?></td>
            <td><?= htmlspecialchars($prestation['idChassis']) ?></td>
            <td><?= htmlspecialchars($prestation['type_prestation'] ?? 'N/A') ?></td>
            <td><?= htmlspecialchars($prestation['statut_prestation'] ?? 'N/A') ?></td>
            <td><?= htmlspecialchars($prestation['dateDebut'] ?? 'N/A') ?></td>
            <td><?= htmlspecialchars($prestation['dateFinPrevue'] ?? 'N/A') ?></td>
            <td><?= htmlspecialchars($prestation['dateFin'] ?? 'N/A') ?></td>
            <td><?= $prestation['tempPasseHeure'] ? number_format($prestation['tempPasseHeure'], 2) : 'N/A' ?></td>
            <td><?= $prestation['note'] ? number_format($prestation['note'], 1) . '/5' : 'N/A' ?></td>
            <td>
                <a class="btn-edit" href="?page=modif_prestation&id=<?= $prestation['idPrestation'] ?>">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>
                |
                <a class="btn-delete" href="?page=suppr_prestation&id=<?= $prestation['idPrestation'] ?>" onclick="return confirm('Supprimer cette prestation ?')">
                    <i class="fa-solid fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>