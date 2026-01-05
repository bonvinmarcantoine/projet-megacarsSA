<h2>Liste des Employés</h2>

<div class="action-bar">
    <a href="?page=ajout_employe" class="btn-add">
        <i class="fas fa-plus"></i> Ajouter un employé
    </a>
</div>

<table>
    <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Poste</th>
        <th>Type Contrat</th>
        <th>Email</th>
        <th>Téléphone</th>
        <th>Salaire Annuel</th>
        <th>Taux Activité</th>
        <th>Date Embauche</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($employes as $employe) : ?>
        <tr>
            <td><?= htmlspecialchars($employe['nom']) ?></td>
            <td><?= htmlspecialchars($employe['prenom']) ?></td>
            <td><?= htmlspecialchars($employe['poste'] ?? 'N/A') ?></td>
            <td><?= htmlspecialchars($employe['contrat'] ?? 'N/A') ?></td>
            <td><?= htmlspecialchars($employe['email']) ?></td>
            <td><?= htmlspecialchars($employe['telephone'] ?? 'N/A') ?></td>
            <td><?= number_format($employe['salaireAnnuelle_CHF'], 2) ?> CHF</td>
            <td><?= htmlspecialchars($employe['tauxActivité_%']) ?>%</td>
            <td><?= htmlspecialchars($employe['dateEmbauche']) ?></td>
            <td>
                <a class="btn-edit" href="?page=modif_employe&id=<?= $employe['idEmploye'] ?>">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>
                |
                <a class="btn-delete" href="?page=suppr_employe&id=<?= $employe['idEmploye'] ?>" onclick="return confirm('Supprimer cet employé ?')">
                    <i class="fa-solid fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>