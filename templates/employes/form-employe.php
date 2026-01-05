<h2 class="page-title">
    <?php echo ($mode === 'add') ? 'Ajouter un employé' : 'Modifier l\'employé'; ?>
</h2>

<form class="form-client" method="POST" action="">
    <div>
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?php echo isset($employe['nom']) ? htmlspecialchars($employe['nom']) : ''; ?>" required>
    </div>

    <div>
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo isset($employe['prenom']) ? htmlspecialchars($employe['prenom']) : ''; ?>" required>
    </div>

    <div>
        <label for="idPoste">Poste :</label>
        <select id="idPoste" name="idPoste" required>
            <option value="">-- Sélectionner un poste --</option>
            <?php foreach ($postes as $poste): ?>
                <option value="<?= $poste['idPoste'] ?>" <?= (isset($employe['idPoste']) && $employe['idPoste'] == $poste['idPoste']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($poste['poste']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="idTypeContrat">Type de Contrat :</label>
        <select id="idTypeContrat" name="idTypeContrat" required>
            <option value="">-- Sélectionner un type --</option>
            <?php foreach ($typeContrats as $tc): ?>
                <option value="<?= $tc['idTypeContrat'] ?>" <?= (isset($employe['idTypeContrat']) && $employe['idTypeContrat'] == $tc['idTypeContrat']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($tc['contrat']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="dateNaissance">Date de naissance :</label>
        <input type="date" id="dateNaissance" name="dateNaissance" value="<?php echo isset($employe['dateNaissance']) ? htmlspecialchars($employe['dateNaissance']) : ''; ?>" required>
    </div>

    <div>
        <label for="email">E-mail :</label>
        <input type="email" id="email" name="email" value="<?php echo isset($employe['email']) ? htmlspecialchars($employe['email']) : ''; ?>" required>
    </div>

    <div>
        <label for="telephone">Téléphone :</label>
        <input type="text" id="telephone" name="telephone" value="<?php echo isset($employe['telephone']) ? htmlspecialchars($employe['telephone']) : ''; ?>">
    </div>

    <div>
        <label for="salaireAnnuelle_CHF">Salaire Annuel (CHF) :</label>
        <input type="number" step="0.01" id="salaireAnnuelle_CHF" name="salaireAnnuelle_CHF" value="<?php echo isset($employe['salaireAnnuelle_CHF']) ? htmlspecialchars($employe['salaireAnnuelle_CHF']) : ''; ?>" required>
    </div>

    <div>
        <label for="commission_CHF">Commission (CHF) :</label>
        <input type="number" step="0.01" id="commission_CHF" name="commission_CHF" value="<?php echo isset($employe['commission_CHF']) ? htmlspecialchars($employe['commission_CHF']) : ''; ?>">
    </div>

    <div>
        <label for="tauxActivite">Taux d'Activité (%) :</label>
        <input type="number" id="tauxActivite" name="tauxActivite" min="0" max="100" value="<?php echo isset($employe['tauxActivité_%']) ? htmlspecialchars($employe['tauxActivité_%']) : ''; ?>" required>
    </div>

    <div>
        <label for="dateEmbauche">Date d'Embauche :</label>
        <input type="date" id="dateEmbauche" name="dateEmbauche" value="<?php echo isset($employe['dateEmbauche']) ? htmlspecialchars($employe['dateEmbauche']) : ''; ?>" required>
    </div>

    <div>
        <label for="DateFinContrat">Date Fin de Contrat (optionnel) :</label>
        <input type="date" id="DateFinContrat" name="DateFinContrat" value="<?php echo isset($employe['DateFinContrat']) ? htmlspecialchars($employe['DateFinContrat']) : ''; ?>">
    </div>

    <div>
        <label for="pays">Pays (Code - ex: CH) :</label>
        <input type="text" id="pays" name="pays" maxlength="2" value="<?php echo isset($employe['Pays']) ? htmlspecialchars($employe['Pays']) : ''; ?>" required>
    </div>

    <div>
        <label for="rue">Rue :</label>
        <input type="text" id="rue" name="rue" value="<?php echo isset($employe['rue']) ? htmlspecialchars($employe['rue']) : ''; ?>" required>
    </div>

    <div>
        <label for="numero">Numéro :</label>
        <input type="number" id="numero" name="numero" value="<?php echo isset($employe['numero']) ? htmlspecialchars($employe['numero']) : ''; ?>" required>
    </div>

    <div>
        <label for="ville">Ville :</label>
        <input type="text" id="ville" name="ville" value="<?php echo isset($employe['ville']) ? htmlspecialchars($employe['ville']) : ''; ?>" required>
    </div>

    <div>
        <label for="npa">NPA (Code postal) :</label>
        <input type="number" id="npa" name="npa" value="<?php echo isset($employe['npa']) ? htmlspecialchars($employe['npa']) : ''; ?>" required>
    </div>

    <div>
        <button class="btn-submit" type="submit">
            <?php echo ($mode === 'add') ? 'Ajouter' : 'Modifier'; ?>
        </button>
    </div>
</form>