<h2 class="page-title">
    <?php echo ($mode === 'add') ? 'Ajouter un fournisseur' : 'Modifier le fournisseur'; ?>
</h2>

<form class="form-client" method="POST" action="">
    <div>
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?php echo isset($fournisseur['nom']) ? htmlspecialchars($fournisseur['nom']) : ''; ?>" required>
    </div>

    <div>
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo isset($fournisseur['prenom']) ? htmlspecialchars($fournisseur['prenom']) : ''; ?>" required>
    </div>

    <div>
        <label for="entreprise">Entreprise (optionnel) :</label>
        <input type="text" id="entreprise" name="entreprise" value="<?php echo isset($fournisseur['entreprise']) ? htmlspecialchars($fournisseur['entreprise']) : ''; ?>">
    </div>

    <div>
        <label for="email">E-mail :</label>
        <input type="email" id="email" name="email" value="<?php echo isset($fournisseur['email']) ? htmlspecialchars($fournisseur['email']) : ''; ?>" required>
    </div>

    <div>
        <label for="telephone">Téléphone (optionnel) :</label>
        <input type="text" id="telephone" name="telephone" value="<?php echo isset($fournisseur['telephone']) ? htmlspecialchars($fournisseur['telephone']) : ''; ?>">
    </div>

    <div>
        <label for="pays">Pays (Code - ex: CH) :</label>
        <input type="text" id="pays" name="pays" maxlength="2" value="<?php echo isset($fournisseur['Pays']) ? htmlspecialchars($fournisseur['Pays']) : ''; ?>" required>
    </div>

    <div>
        <label for="rue">Rue :</label>
        <input type="text" id="rue" name="rue" value="<?php echo isset($fournisseur['rue']) ? htmlspecialchars($fournisseur['rue']) : ''; ?>" required>
    </div>

    <div>
        <label for="numero">Numéro :</label>
        <input type="number" id="numero" name="numero" value="<?php echo isset($fournisseur['numero']) ? htmlspecialchars($fournisseur['numero']) : ''; ?>" required>
    </div>

    <div>
        <label for="ville">Ville :</label>
        <input type="text" id="ville" name="ville" value="<?php echo isset($fournisseur['ville']) ? htmlspecialchars($fournisseur['ville']) : ''; ?>" required>
    </div>

    <div>
        <label for="npa">NPA (Code postal) :</label>
        <input type="number" id="npa" name="npa" value="<?php echo isset($fournisseur['npa']) ? htmlspecialchars($fournisseur['npa']) : ''; ?>" required>
    </div>

    <div>
        <button class="btn-submit" type="submit">
            <?php echo ($mode === 'add') ? 'Ajouter' : 'Modifier'; ?>
        </button>
    </div>
</form>