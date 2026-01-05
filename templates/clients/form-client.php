<h2 class="page-title">
    <?php echo ($mode === 'add') ? 'Ajouter un client' : 'Modifier le client'; ?>
</h2>

<form class="form-client" method="POST" action="">
    <div>
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?php echo isset($client['nom']) ? htmlspecialchars($client['nom']) : ''; ?>" required>
    </div>

    <div>
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo isset($client['prenom']) ? htmlspecialchars($client['prenom']) : ''; ?>" required>
    </div>

    <div>
        <label for="entreprise">Entreprise :</label>
        <input type="text" id="entreprise" name="entreprise" value="<?php echo isset($client['entreprise']) ? htmlspecialchars($client['entreprise']) : ''; ?>">
    </div>

    <div>
        <label for="nationalite">Nationalité (Code pays - ex: CH) :</label>
        <input type="text" id="nationalite" name="nationalite" maxlength="2" value="<?php echo isset($client['nationalite']) ? htmlspecialchars($client['nationalite']) : ''; ?>" required>
    </div>

    <div>
        <label for="dateNaissance">Date de naissance :</label>
        <input type="date" id="dateNaissance" name="dateNaissance" value="<?php echo isset($client['dateNaissance']) ? htmlspecialchars($client['dateNaissance']) : ''; ?>" required>
    </div>

    <div>
        <label for="email">E-mail :</label>
        <input type="email" id="email" name="email" value="<?php echo isset($client['email']) ? htmlspecialchars($client['email']) : ''; ?>" required>
    </div>

    <div>
        <label for="telephone">Téléphone :</label>
        <input type="text" id="telephone" name="telephone" value="<?php echo isset($client['telephone']) ? htmlspecialchars($client['telephone']) : ''; ?>">
    </div>

    <div>
        <label for="pays">Pays (Code - ex: CH) :</label>
        <input type="text" id="pays" name="pays" maxlength="2" value="<?php echo isset($client['pays']) ? htmlspecialchars($client['pays']) : ''; ?>" required>
    </div>

    <div>
        <label for="rue">Rue :</label>
        <input type="text" id="rue" name="rue" value="<?php echo isset($client['rue']) ? htmlspecialchars($client['rue']) : ''; ?>" required>
    </div>

    <div>
        <label for="numero">Numéro :</label>
        <input type="number" id="numero" name="numero" value="<?php echo isset($client['numero']) ? htmlspecialchars($client['numero']) : ''; ?>" required>
    </div>

    <div>
        <label for="ville">Ville :</label>
        <input type="text" id="ville" name="ville" value="<?php echo isset($client['ville']) ? htmlspecialchars($client['ville']) : ''; ?>" required>
    </div>

    <div>
        <label for="npa">NPA (Code postal) :</label>
        <input type="number" id="npa" name="npa" value="<?php echo isset($client['npa']) ? htmlspecialchars($client['npa']) : ''; ?>" required>
    </div>

    <div>
        <button class="btn-submit" type="submit">
            <?php echo ($mode === 'add') ? 'Ajouter' : 'Modifier'; ?>
        </button>
    </div>
</form>