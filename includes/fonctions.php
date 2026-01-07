<?php

// ==================== CLIENTS ====================
function getClient($pdo) {
    $stmt = $pdo->query("SELECT * FROM client ORDER BY nom");
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Convertir toutes les clés en minuscules pour uniformité
    $clients_lower = [];
    foreach ($clients as $client) {
        $clients_lower[] = array_change_key_case($client, CASE_LOWER);
    }

    return $clients_lower;
}

function getClientById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM Client WHERE idClient = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addClient($pdo, $data) {
    // D'abord créer l'adresse
    $stmtAdresse = $pdo->prepare("INSERT INTO Adresse (pays, ville, npa, rue, numero) VALUES (?, ?, ?, ?, ?)");
    $stmtAdresse->execute([
        $data['pays'],
        $data['ville'],
        $data['npa'],
        $data['rue'],
        $data['numero']
    ]);
    
    $idAdresse = $pdo->lastInsertId();
    
    // Ensuite créer le client avec l'idAdresse
    $stmt = $pdo->prepare("INSERT INTO client (nom, prenom, idAdresse, entreprise, dateNaissance, nationalite, email, telephone) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $data['nom'],
        $data['prenom'],
        $idAdresse,
        $data['entreprise'],
        $data['dateNaissance'],
        $data['nationalite'],
        $data['email'],
        $data['telephone']
    ]);
}

function updateClient($pdo, $id, $data) {
    // Récupérer l'idAdresse du client
    $client = getClientById($pdo, $id);
    $idAdresse = $client['idAdresse'];
    
    // Mettre à jour l'adresse
    $stmtAdresse = $pdo->prepare("UPDATE Adresse SET pays = ?, ville = ?, npa = ?, rue = ?, numero = ? WHERE idAdresse = ?");
    $stmtAdresse->execute([
        $data['pays'],
        $data['ville'],
        $data['npa'],
        $data['rue'],
        $data['numero'],
        $idAdresse
    ]);
    
    // Mettre à jour le client
    $stmt = $pdo->prepare("UPDATE client SET nom = ?, prenom = ?, entreprise = ?, dateNaissance = ?, nationalite = ?, email = ?, telephone = ? WHERE idClient = ?");
    $stmt->execute([
        $data['nom'],
        $data['prenom'],
        $data['entreprise'],
        $data['dateNaissance'],
        $data['nationalite'],
        $data['email'],
        $data['telephone'],
        $id
    ]);
}

function deleteClient($pdo, $id) {
    // Récupérer l'idAdresse avant de supprimer le client
    $client = getClientById($pdo, $id);
    $idAdresse = $client['idAdresse'];
    
    // Supprimer le client
    $stmt = $pdo->prepare("DELETE FROM Client WHERE idClient = ?");
    $stmt->execute([$id]);
    
    // Supprimer l'adresse associée
    $stmtAdresse = $pdo->prepare("DELETE FROM Adresse WHERE idAdresse = ?");
    $stmtAdresse->execute([$idAdresse]);
}
/*
function searchByName($pdo, $data) {
    $stmt = $pdo->prepare("SELECT nom, prenom, email FROM client WHERE nom = ? AND prenom = ? AND email = ?");
    $stmt->execute([
        $data['nom'],
        $data['prenom'],
        $data['email'],
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
*/
function getClientWithAddress($pdo, $id) {
    $stmt = $pdo->prepare("
        SELECT c.*, a.pays, a.ville, a.npa, a.rue, a.numero 
        FROM Client c 
        LEFT JOIN Adresse a ON c.idAdresse = a.idAdresse 
        WHERE c.idClient = ?
    ");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getAllClientsWithAddress($pdo) {
    $stmt = $pdo->query("
        SELECT c.*, a.pays, a.ville, a.npa, a.rue, a.numero 
        FROM Client c 
        LEFT JOIN Adresse a ON c.idAdresse = a.idAdresse 
        ORDER BY c.nom
    ");
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Convertir toutes les clés en minuscules pour uniformité
    $clients_lower = [];
    foreach ($clients as $client) {
        $clients_lower[] = array_change_key_case($client, CASE_LOWER);
    }
    
    return $clients_lower;
}

function searchNom($pdo, $data, $table) {
    // Liste des tables autorisées pour éviter les injections SQL
    $allowedTables = ['Client', 'Fournisseur', 'Employe'];

    if (!in_array($table, $allowedTables)) {
        throw new Exception("Table non autorisée !");
    }

    // Pas de quotes simples, mais quotes backtick pour l'identifiant
    $sql = "SELECT * FROM `$table` WHERE nom = ? AND prenom = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $data['nom'],
        $data['prenom']
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
/*function searchEmail($pdo, $data, $table) {
    $sql = "SELECT * FROM '$table' WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $data['email']
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}*/

function searchEmail($pdo, $data, $table) {
    // Liste des tables autorisées pour éviter les injections SQL
    $allowedTables = ['Client', 'Fournisseur', 'Employe'];

    if (!in_array($table, $allowedTables)) {
        throw new Exception("Table non autorisée !");
    }

    // Pas de quotes simples, mais quotes backtick pour l'identifiant
    $sql = "SELECT * FROM `$table` WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $data['email']
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// ==================== EMPLOYES ====================
function getAllEmployesWithDetails($pdo) {
    $stmt = $pdo->query("
        SELECT e.*, p.poste, tc.contrat, a.pays, a.ville, a.npa, a.rue, a.numero 
        FROM Employe e
        LEFT JOIN Poste p ON e.idPoste = p.idPoste
        LEFT JOIN TypeContrat tc ON e.idTypeContrat = tc.idTypeContrat
        LEFT JOIN Adresse a ON e.idAdresse = a.idAdresse
        ORDER BY e.nom
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getEmployeById($pdo, $id) {
    $stmt = $pdo->prepare("
        SELECT e.*, a.pays, a.ville, a.npa, a.rue, a.numero 
        FROM Employe e
        LEFT JOIN Adresse a ON e.idAdresse = a.idAdresse
        WHERE e.idEmploye = ?
    ");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addEmploye($pdo, $data) {
    $stmtAdresse = $pdo->prepare("INSERT INTO Adresse (pays, ville, npa, rue, numero) VALUES (?, ?, ?, ?, ?)");
    $stmtAdresse->execute([
        $data['pays'],
        $data['ville'],
        $data['npa'],
        $data['rue'],
        $data['numero']
    ]);
    
    $idAdresse = $pdo->lastInsertId();
    
    $stmt = $pdo->prepare("INSERT INTO Employe (nom, prenom, idPoste, idTypeContrat, idAdresse, dateNaissance, email, telephone, salaireAnnuelle_CHF, commission_CHF, tauxActivite, dateEmbauche, DateFinContrat) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $data['nom'],
        $data['prenom'],
        $data['idPoste'],
        $data['idTypeContrat'],
        $idAdresse,
        $data['dateNaissance'],
        $data['email'],
        $data['telephone'],
        $data['salaireAnnuelle_CHF'],
        $data['commission_CHF'] ?? null,
        $data['tauxActivite'],
        $data['dateEmbauche'],
        $data['DateFinContrat'] ?? null
    ]);
}

function updateEmploye($pdo, $id, $data) {
    $employe = getEmployeById($pdo, $id);
    $idAdresse = $employe['idAdresse'];
    
    $stmtAdresse = $pdo->prepare("UPDATE Adresse SET pays = ?, ville = ?, npa = ?, rue = ?, numero = ? WHERE idAdresse = ?");
    $stmtAdresse->execute([
        $data['pays'],
        $data['ville'],
        $data['npa'],
        $data['rue'],
        $data['numero'],
        $idAdresse
    ]);
    
    $stmt = $pdo->prepare("UPDATE Employe SET nom = ?, prenom = ?, idPoste = ?, idTypeContrat = ?, dateNaissance = ?, email = ?, telephone = ?, salaireAnnuelle_CHF = ?, commission_CHF = ?, tauxActivite = ?, dateEmbauche = ?, DateFinContrat = ? WHERE idEmploye = ?");
    $stmt->execute([
        $data['nom'],
        $data['prenom'],
        $data['idPoste'],
        $data['idTypeContrat'],
        $data['dateNaissance'],
        $data['email'],
        $data['telephone'],
        $data['salaireAnnuelle_CHF'],
        $data['commission_CHF'] ?? null,
        $data['tauxActivite'],
        $data['dateEmbauche'],
        $data['DateFinContrat'] ?? null,
        $id
    ]);
}

function deleteEmploye($pdo, $id) {
    $employe = getEmployeById($pdo, $id);
    $idAdresse = $employe['idAdresse'];
    
    $stmt = $pdo->prepare("DELETE FROM Employe WHERE idEmploye = ?");
    $stmt->execute([$id]);
    
    $stmtAdresse = $pdo->prepare("DELETE FROM Adresse WHERE idAdresse = ?");
    $stmtAdresse->execute([$idAdresse]);
}

// ==================== VOITURES ====================
function getAllVoituresWithDetails($pdo) {
    $stmt = $pdo->query("
        SELECT v.*, mo.modele, ma.marque, c.nom as client_nom, c.prenom as client_prenom,
               ca.carburant, t.type as transmission, ev.etat, sv.statut
        FROM Voiture v
        LEFT JOIN Modele mo ON v.idModele = mo.idModele
        LEFT JOIN Marque ma ON mo.idMarque = ma.idMarque
        LEFT JOIN Client c ON v.idClient = c.idClient
        LEFT JOIN Carburant ca ON v.idCarburant = ca.idCarburant
        LEFT JOIN Transmission t ON v.idTransmission = t.idTransmission
        LEFT JOIN EtatVoiture ev ON v.idEtatVoiture = ev.idEtatVoiture
        LEFT JOIN StatutVoiture sv ON v.idStatutVoiture = sv.idStatutVoiture
        ORDER BY ma.marque, mo.modele
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getVoitureById($pdo, $id) {
    $stmt = $pdo->prepare("
        SELECT v.*, mo.modele, ma.marque
        FROM Voiture v
        LEFT JOIN Modele mo ON v.idModele = mo.idModele
        LEFT JOIN Marque ma ON mo.idMarque = ma.idMarque
        WHERE v.idChassis = ?
    ");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addVoiture($pdo, $data) {
    $stmt = $pdo->prepare("INSERT INTO Voiture (idChassis, idModele, idClient, idCarburant, idTransmission, idEtatVoiture, idStatutVoiture, kilométrage, valeurCHF, finGarantie, datePremiereCirculation) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $data['idChassis'],
        $data['idModele'],
        $data['idClient'],
        $data['idCarburant'],
        $data['idTransmission'],
        $data['idEtatVoiture'],
        $data['idStatutVoiture'],
        $data['kilometrage'],
        $data['valeurCHF'] ?? null,
        $data['finGarantie'] ?? null,
        $data['datePremiereCirculation'] ?? null
    ]);
}

function updateVoiture($pdo, $id, $data) {
    $stmt = $pdo->prepare("UPDATE Voiture SET idModele = ?, idClient = ?, idCarburant = ?, idTransmission = ?, idEtatVoiture = ?, idStatutVoiture = ?, kilométrage = ?, valeurCHF = ?, finGarantie = ?, datePremiereCirculation = ? WHERE idChassis = ?");
    $stmt->execute([
        $data['idModele'],
        $data['idClient'],
        $data['idCarburant'],
        $data['idTransmission'],
        $data['idEtatVoiture'],
        $data['idStatutVoiture'],
        $data['kilometrage'],
        $data['valeurCHF'] ?? null,
        $data['finGarantie'] ?? null,
        $data['datePremiereCirculation'] ?? null,
        $id
    ]);
}

function deleteVoiture($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM Voiture WHERE idChassis = ?");
    $stmt->execute([$id]);
}

// ==================== FOURNISSEURS ====================
function getAllFournisseursWithAddress($pdo) {
    $stmt = $pdo->query("
        SELECT f.*, a.pays, a.ville, a.npa, a.rue, a.numero 
        FROM Fournisseur f
        LEFT JOIN Adresse a ON f.idAdresse = a.idAdresse
        ORDER BY f.nom
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getFournisseurById($pdo, $id) {
    $stmt = $pdo->prepare("
        SELECT f.*, a.pays, a.ville, a.npa, a.rue, a.numero 
        FROM Fournisseur f
        LEFT JOIN Adresse a ON f.idAdresse = a.idAdresse
        WHERE f.idFournisseur = ?
    ");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addFournisseur($pdo, $data) {
    $stmtAdresse = $pdo->prepare("INSERT INTO Adresse (pays, ville, npa, rue, numero) VALUES (?, ?, ?, ?, ?)");
    $stmtAdresse->execute([
        $data['pays'],
        $data['ville'],
        $data['npa'],
        $data['rue'],
        $data['numero']
    ]);
    
    $idAdresse = $pdo->lastInsertId();
    
    $stmt = $pdo->prepare("INSERT INTO Fournisseur (nom, prenom, idAdresse, entreprise, telephone, email) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $data['nom'],
        $data['prenom'],
        $idAdresse,
        $data['entreprise'] ?? null,
        $data['telephone'] ?? null,
        $data['email']
    ]);
}

function updateFournisseur($pdo, $id, $data) {
    $fournisseur = getFournisseurById($pdo, $id);
    $idAdresse = $fournisseur['idAdresse'];
    
    $stmtAdresse = $pdo->prepare("UPDATE Adresse SET pays = ?, ville = ?, npa = ?, rue = ?, numero = ? WHERE idAdresse = ?");
    $stmtAdresse->execute([
        $data['pays'],
        $data['ville'],
        $data['npa'],
        $data['rue'],
        $data['numero'],
        $idAdresse
    ]);
    
    $stmt = $pdo->prepare("UPDATE Fournisseur SET nom = ?, prenom = ?, entreprise = ?, telephone = ?, email = ? WHERE idFournisseur = ?");
    $stmt->execute([
        $data['nom'],
        $data['prenom'],
        $data['entreprise'] ?? null,
        $data['telephone'] ?? null,
        $data['email'],
        $id
    ]);
}

function deleteFournisseur($pdo, $id) {
    $fournisseur = getFournisseurById($pdo, $id);
    $idAdresse = $fournisseur['idAdresse'];
    
    $stmt = $pdo->prepare("DELETE FROM Fournisseur WHERE idFournisseur = ?");
    $stmt->execute([$id]);
    
    $stmtAdresse = $pdo->prepare("DELETE FROM Adresse WHERE idAdresse = ?");
    $stmtAdresse->execute([$idAdresse]);
}

// ==================== PRESTATIONS ====================
function getAllPrestationsWithDetails($pdo) {
    $stmt = $pdo->query("
        SELECT p.*, c.nom as client_nom, c.prenom as client_prenom,
               tp.type as type_prestation, sp.statut as statut_prestation
        FROM Prestation p
        LEFT JOIN Client c ON p.idClient = c.idClient
        LEFT JOIN TypePrestation tp ON p.idTypePrestation = tp.idTypePrestation
        LEFT JOIN StatutPrestation sp ON p.idStatutPrestation = sp.idStatutPrestation
        ORDER BY p.dateDebut DESC
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getPrestationById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM Prestation WHERE idPrestation = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addPrestation($pdo, $data) {
    $stmt = $pdo->prepare("INSERT INTO Prestation (idClient, idChassis, idStatutPrestation, idTypePrestation, description, dateDebut, dateFinPrevue, dateFin, tempPasseHeure, note, avis) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $data['idClient'],
        $data['idChassis'],
        $data['idStatutPrestation'],
        $data['idTypePrestation'],
        $data['description'] ?? null,
        $data['dateDebut'] ?? null,
        $data['dateFinPrevue'] ?? null,
        $data['dateFin'] ?? null,
        $data['tempPasseHeure'] ?? null,
        $data['note'] ?? null,
        $data['avis'] ?? null
    ]);
}

function updatePrestation($pdo, $id, $data) {
    $stmt = $pdo->prepare("UPDATE Prestation SET idClient = ?, idChassis = ?, idStatutPrestation = ?, idTypePrestation = ?, description = ?, dateDebut = ?, dateFinPrevue = ?, dateFin = ?, tempPasseHeure = ?, note = ?, avis = ? WHERE idPrestation = ?");
    $stmt->execute([
        $data['idClient'],
        $data['idChassis'],
        $data['idStatutPrestation'],
        $data['idTypePrestation'],
        $data['description'] ?? null,
        $data['dateDebut'] ?? null,
        $data['dateFinPrevue'] ?? null,
        $data['dateFin'] ?? null,
        $data['tempPasseHeure'] ?? null,
        $data['note'] ?? null,
        $data['avis'] ?? null,
        $id
    ]);
}

function deletePrestation($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM Prestation WHERE idPrestation = ?");
    $stmt->execute([$id]);
}

// ==================== FONCTIONS UTILITAIRES ====================
function getAllPostes($pdo) {
    $stmt = $pdo->query("SELECT * FROM Poste ORDER BY poste");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllTypeContrats($pdo) {
    $stmt = $pdo->query("SELECT * FROM TypeContrat ORDER BY contrat");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllModeles($pdo) {
    $stmt = $pdo->query("SELECT m.*, ma.marque FROM Modele m LEFT JOIN Marque ma ON m.idMarque = ma.idMarque ORDER BY ma.marque, m.modele");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllClients($pdo) {
    $stmt = $pdo->query("SELECT idClient, nom, prenom FROM Client ORDER BY nom, prenom");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllCarburants($pdo) {
    $stmt = $pdo->query("SELECT * FROM Carburant ORDER BY carburant");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllTransmissions($pdo) {
    $stmt = $pdo->query("SELECT * FROM Transmission ORDER BY type");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllEtatVoitures($pdo) {
    $stmt = $pdo->query("SELECT * FROM EtatVoiture ORDER BY etat");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllStatutVoitures($pdo) {
    $stmt = $pdo->query("SELECT * FROM StatutVoiture ORDER BY statut");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllTypePrestations($pdo) {
    $stmt = $pdo->query("SELECT * FROM TypePrestation ORDER BY type");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllStatutPrestations($pdo) {
    $stmt = $pdo->query("SELECT * FROM StatutPrestation ORDER BY statut");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}