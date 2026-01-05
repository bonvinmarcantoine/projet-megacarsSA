<h2 class="page-title">
    <?php echo ($mode === 'add') ? 'Ajouter une voiture' : 'Modifier la voiture'; ?>
</h2>

<form class="form-client" method="POST" action="">
    <?php if ($mode === 'add'): ?>
    <div>
        <label for="idChassis">Numéro de Châssis (VIN - 17 caractères) :</label>
        <input type="text" id="idChassis" name="idChassis" maxlength="17" value="<?php echo isset($voiture['idChassis']) ? htmlspecialchars($voiture['idChassis']) : ''; ?>" required>
    </div>
    <?php endif; ?>

    <div>
        <label for="idModele">Modèle :</label>
        <select id="idModele" name="idModele" required>
            <option value="">-- Sélectionner un modèle --</option>
            <?php foreach ($modeles as $modele): ?>
                <option value="<?= $modele['idModele'] ?>" <?= (isset($voiture['idModele']) && $voiture['idModele'] == $modele['idModele']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($modele['marque']) ?> - <?= htmlspecialchars($modele['modele']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="idClient">Client :</label>
        <select id="idClient" name="idClient" required>
            <option value="">-- Sélectionner un client --</option>
            <?php foreach ($clients as $client): ?>
                <option value="<?= $client['idClient'] ?>" <?= (isset($voiture['idClient']) && $voiture['idClient'] == $client['idClient']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($client['nom']) ?> <?= htmlspecialchars($client['prenom']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="idCarburant">Carburant :</label>
        <select id="idCarburant" name="idCarburant" required>
            <option value="">-- Sélectionner un carburant --</option>
            <?php foreach ($carburants as $carburant): ?>
                <option value="<?= $carburant['idCarburant'] ?>" <?= (isset($voiture['idCarburant']) && $voiture['idCarburant'] == $carburant['idCarburant']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($carburant['carburant']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="idTransmission">Transmission :</label>
        <select id="idTransmission" name="idTransmission" required>
            <option value="">-- Sélectionner une transmission --</option>
            <?php foreach ($transmissions as $transmission): ?>
                <option value="<?= $transmission['idTransmission'] ?>" <?= (isset($voiture['idTransmission']) && $voiture['idTransmission'] == $transmission['idTransmission']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($transmission['type']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="idEtatVoiture">État de la Voiture :</label>
        <select id="idEtatVoiture" name="idEtatVoiture" required>
            <option value="">-- Sélectionner un état --</option>
            <?php foreach ($etatVoitures as $etat): ?>
                <option value="<?= $etat['idEtatVoiture'] ?>" <?= (isset($voiture['idEtatVoiture']) && $voiture['idEtatVoiture'] == $etat['idEtatVoiture']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($etat['etat']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="idStatutVoiture">Statut de la Voiture :</label>
        <select id="idStatutVoiture" name="idStatutVoiture" required>
            <option value="">-- Sélectionner un statut --</option>
            <?php foreach ($statutVoitures as $statut): ?>
                <option value="<?= $statut['idStatutVoiture'] ?>" <?= (isset($voiture['idStatutVoiture']) && $voiture['idStatutVoiture'] == $statut['idStatutVoiture']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($statut['statut']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="kilometrage">Kilométrage :</label>
        <input type="number" step="0.01" id="kilometrage" name="kilometrage" value="<?php echo isset($voiture['kilométrage']) ? htmlspecialchars($voiture['kilométrage']) : ''; ?>" required>
    </div>

    <div>
        <label for="valeurCHF">Valeur (CHF - optionnel) :</label>
        <input type="number" id="valeurCHF" name="valeurCHF" value="<?php echo isset($voiture['valeurCHF']) ? htmlspecialchars($voiture['valeurCHF']) : ''; ?>">
    </div>

    <div>
        <label for="finGarantie">Fin de Garantie (optionnel) :</label>
        <input type="date" id="finGarantie" name="finGarantie" value="<?php echo isset($voiture['finGarantie']) ? htmlspecialchars($voiture['finGarantie']) : ''; ?>">
    </div>

    <div>
        <label for="datePremiereCirculation">Date de Première Circulation (optionnel) :</label>
        <input type="date" id="datePremiereCirculation" name="datePremiereCirculation" value="<?php echo isset($voiture['datePremiereCirculation']) ? htmlspecialchars($voiture['datePremiereCirculation']) : ''; ?>">
    </div>

    <div>
        <button class="btn-submit" type="submit">
            <?php echo ($mode === 'add') ? 'Ajouter' : 'Modifier'; ?>
        </button>
    </div>
</form>