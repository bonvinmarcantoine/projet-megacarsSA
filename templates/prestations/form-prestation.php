<h2 class="page-title">
    <?php echo ($mode === 'add') ? 'Ajouter une prestation' : 'Modifier la prestation'; ?>
</h2>

<form class="form-client" method="POST" action="">
    <div>
        <label for="idClient">Client :</label>
        <select id="idClient" name="idClient" required>
            <option value="">-- Sélectionner un client --</option>
            <?php foreach ($clients as $client): ?>
                <option value="<?= $client['idClient'] ?>" <?= (isset($prestation['idClient']) && $prestation['idClient'] == $client['idClient']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($client['nom']) ?> <?= htmlspecialchars($client['prenom']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="idChassis">Numéro de Châssis (VIN - 2 caractères) :</label>
        <input type="text" id="idChassis" name="idChassis" maxlength="2" value="<?php echo isset($prestation['idChassis']) ? htmlspecialchars($prestation['idChassis']) : ''; ?>" required>
    </div>

    <div>
        <label for="idTypePrestation">Type de Prestation :</label>
        <select id="idTypePrestation" name="idTypePrestation" required>
            <option value="">-- Sélectionner un type --</option>
            <?php foreach ($typePrestations as $type): ?>
                <option value="<?= $type['idTypePrestation'] ?>" <?= (isset($prestation['idTypePrestation']) && $prestation['idTypePrestation'] == $type['idTypePrestation']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($type['type']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="idStatutPrestation">Statut :</label>
        <select id="idStatutPrestation" name="idStatutPrestation" required>
            <option value="">-- Sélectionner un statut --</option>
            <?php foreach ($statutPrestations as $statut): ?>
                <option value="<?= $statut['idStatutPrestation'] ?>" <?= (isset($prestation['idStatutPrestation']) && $prestation['idStatutPrestation'] == $statut['idStatutPrestation']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($statut['statut']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="description">Description (optionnel) :</label>
        <textarea id="description" name="description" rows="4"><?php echo isset($prestation['description']) ? htmlspecialchars($prestation['description']) : ''; ?></textarea>
    </div>

    <div>
        <label for="dateDebut">Date de Début (optionnel) :</label>
        <input type="date" id="dateDebut" name="dateDebut" value="<?php echo isset($prestation['dateDebut']) ? htmlspecialchars($prestation['dateDebut']) : ''; ?>">
    </div>

    <div>
        <label for="dateFinPrevue">Date de Fin Prévue (optionnel) :</label>
        <input type="date" id="dateFinPrevue" name="dateFinPrevue" value="<?php echo isset($prestation['dateFinPrevue']) ? htmlspecialchars($prestation['dateFinPrevue']) : ''; ?>">
    </div>

    <div>
        <label for="dateFin">Date de Fin (optionnel) :</label>
        <input type="date" id="dateFin" name="dateFin" value="<?php echo isset($prestation['dateFin']) ? htmlspecialchars($prestation['dateFin']) : ''; ?>">
    </div>

    <div>
        <label for="tempPasseHeure">Temps Passé en Heures (optionnel) :</label>
        <input type="number" step="0.1" id="tempPasseHeure" name="tempPasseHeure" value="<?php echo isset($prestation['tempPasseHeure']) ? htmlspecialchars($prestation['tempPasseHeure']) : ''; ?>">
    </div>

    <div>
        <label for="note">Note (0-5, optionnel) :</label>
        <input type="number" step="0.1" min="0" max="5" id="note" name="note" value="<?php echo isset($prestation['note']) ? htmlspecialchars($prestation['note']) : ''; ?>">
    </div>

    <div>
        <label for="avis">Avis (optionnel) :</label>
        <textarea id="avis" name="avis" rows="4"><?php echo isset($prestation['avis']) ? htmlspecialchars($prestation['avis']) : ''; ?></textarea>
    </div>

    <div>
        <button class="btn-submit" type="submit">
            <?php echo ($mode === 'add') ? 'Ajouter' : 'Modifier'; ?>
        </button>
    </div>
</form>