<?php
session_start();
$message = $_SESSION['message']; ?>
<div>
    <h2>❌ Erreur</h2>
    <p>
    <?= htmlspecialchars($message) ?>
</p>
    <br> </br>
    <a href="?page=ajout_client" class="btn-add">
            <span>← Retour au formulaire</span>
        </a>
</div>