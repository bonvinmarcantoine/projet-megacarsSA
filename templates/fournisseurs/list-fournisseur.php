<h2>Liste des Fournisseurs</h2>

<div class="action-bar">
    <a href="?page=ajout_fournisseur" class="btn-add">
        <i class="fas fa-plus"></i> Ajouter un fournisseur
    </a>
</div>

<table>
    <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Entreprise</th>
        <th>Email</th>
        <th>Téléphone</th>
        <th>Adresse complète</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($fournisseurs as $fournisseur) : ?>
        <tr>
            <td><?= htmlspecialchars($fournisseur['nom']) ?></td>
            <td><?= htmlspecialchars($fournisseur['prenom']) ?></td>
            <td><?= htmlspecialchars($fournisseur['entreprise'] ?? 'N/A') ?></td>
            <td><?= htmlspecialchars($fournisseur['email']) ?></td>
            <td><?= htmlspecialchars($fournisseur['telephone'] ?? 'N/A') ?></td>
            <td>
                <?php 
                    $adresse = [];
                    if (!empty($fournisseur['rue']) && !empty($fournisseur['numero'])) {
                        $adresse[] = htmlspecialchars($fournisseur['rue']) . ' ' . htmlspecialchars($fournisseur['numero']);
                    }
                    if (!empty($fournisseur['npa']) && !empty($fournisseur['ville'])) {
                        $adresse[] = htmlspecialchars($fournisseur['npa']) . ' ' . htmlspecialchars($fournisseur['ville']);
                    }
                    if (!empty($fournisseur['Pays'])) {
                        $adresse[] = htmlspecialchars($fournisseur['Pays']);
                    }
                    echo implode(', ', $adresse) ?: 'N/A';
                ?>
            </td>
            <td>
                <a class="btn-edit" href="?page=modif_fournisseur&id=<?= $fournisseur['idFournisseur'] ?>">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>
                |
                <a class="btn-delete" href="?page=suppr_fournisseur&id=<?= $fournisseur['idFournisseur'] ?>" onclick="return confirm('Supprimer ce fournisseur ?')">
                    <i class="fa-solid fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>