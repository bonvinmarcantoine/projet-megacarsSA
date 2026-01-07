<?php
session_start();
$message = $_SESSION['message'];
$type = $_GET['type'] ?>
<div>
    <h2>❌ Erreur</h2>
    <p>
    <?= htmlspecialchars($message) ?>
</p>
    <br> </br>
    <a href="?page=ajout_<?= htmlspecialchars($type) ?>" class="btn-add">
            <span>← Retour au formulaire</span>
        </a>
</div>