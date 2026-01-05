<h2>Liste des clients</h2>

<div class="action-bar">
    <a href="?page=ajout_client" class="btn-add">
        <i class="fas fa-plus"></i> Ajouter un client
    </a>
</div>

<table>
    <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Entreprise</th>
        <th>Nationalité</th>
        <th>Date de naissance</th>
        <th>E-mail</th>
        <th>Téléphone</th>
        <th>Adresse complète</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($clients as $client) : ?>
        
        <tr>
            <td><?= htmlspecialchars($client['nom']) ?></td>
            <td><?= htmlspecialchars($client['prenom']) ?></td>
            <td><?= htmlspecialchars($client['entreprise'] ?? 'N/A') ?></td>
            <td><?= htmlspecialchars($client['nationalite'] ?? 'N/A') ?></td>
            <td><?= htmlspecialchars($client['datenaissance'] ?? 'N/A') ?></td>
            <td><?= htmlspecialchars($client['email']) ?></td>
            <td><?= htmlspecialchars($client['telephone'] ?? 'N/A') ?></td>
            <td>
                <?php 
                    $adresse = [];
                    if (!empty($client['rue']) && !empty($client['numero'])) {
                        $adresse[] = htmlspecialchars($client['rue']) . ' ' . htmlspecialchars($client['numero']);
                    }
                    if (!empty($client['npa']) && !empty($client['ville'])) {
                        $adresse[] = htmlspecialchars($client['npa']) . ' ' . htmlspecialchars($client['ville']);
                    }
                    if (!empty($client['pays'])) {
                        $adresse[] = htmlspecialchars($client['pays']);
                    }
                    echo implode(', ', $adresse) ?: 'N/A';
                ?>
            </td>
            <td>
                <a class="btn-edit" href="?page=modif_client&id=<?= $client['idclient'] ?>">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>
                |
                <a class="btn-delete" href="?page=suppr_client&id=<?= $client['idclient'] ?>" onclick="return confirm('Supprimer ce client ?')">
                    <i class="fa-solid fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>