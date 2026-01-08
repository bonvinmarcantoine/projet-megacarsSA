<?php

// ==================== CLIENTS ====================
function getClient($pdo) {
    $stmt = $pdo->query("SELECT * FROM client ORDER BY nom ASC, prenom ASC");
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Convertir toutes les clés en minuscules pour uniformité
    $clients_lower = [];
    foreach ($clients as $client) {
        $clients_lower[] = array_change_key_case($client, CASE_LOWER);
    }

    return $clients_lower;
}

function getClientById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM client WHERE idClient = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addClient($pdo, $data) {
    
    $resultAdresse = VerifierUnique($pdo, $data, "adresse", ["pays", "ville", "npa", "rue", "numero"]);

    if (empty($resultAdresse)) {
        $stmtAdresse = $pdo->prepare("INSERT INTO adresse (pays, ville, npa, rue, numero) VALUES (?, ?, ?, ?, ?)");
        $stmtAdresse->execute([
            $data['pays'],
            $data['ville'],
            $data['npa'],
            $data['rue'],
            $data['numero']
        ]);
        $idAdresse = $pdo->lastInsertId();
    }
    else {
        $idAdresse = getIdAdresseByRest($pdo, $data);
    }
    
    
    
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
    $client = getClientById($pdo, $id);
    $idAdresse = $client['idAdresse'];

    $resultAdresse = VerifierUnique($pdo, $data, "adresse", ["pays", "ville", "npa", "rue", "numero"]);

    if (empty($resultAdresse)) {
        if (countAdresse($pdo, $idAdresse) > 1) {
            $stmtAdresse = $pdo->prepare("INSERT INTO adresse (pays, ville, npa, rue, numero) VALUES (?, ?, ?, ?, ?)");
            $stmtAdresse->execute([
                $data['pays'],
                $data['ville'],
                $data['npa'],
                $data['rue'],
                $data['numero']
            ]);
            $data["idAdresse"] = $pdo->lastInsertId();
        }
        else {
            $stmtAdresse = $pdo->prepare("UPDATE adresse SET pays = ?, ville = ?, npa = ?, rue = ?, numero = ? WHERE idAdresse = ?");
            $stmtAdresse->execute([
                $data['pays'],
                $data['ville'],
                $data['npa'],
                $data['rue'],
                $data['numero'],
                $idAdresse 
            ]);
            $data["idAdresse"] = $idAdresse;
        }
    }
    else {
        $data["idAdresse"] = getIdAdresseByRest($pdo, $data);
    }
    
    $stmt = $pdo->prepare("UPDATE client SET nom = ?, prenom = ?, entreprise = ?, dateNaissance = ?, nationalite = ?, email = ?, telephone = ?, idAdresse = ? WHERE idClient = ?");
    $stmt->execute([
        $data['nom'],
        $data['prenom'],
        $data['entreprise'],
        $data['dateNaissance'],
        $data['nationalite'],
        $data['email'],
        $data['telephone'],
        $data['idAdresse'],
        $id
    ]);

    if (countAdresse($pdo, $idAdresse) === 0) {
        $stmt = $pdo->prepare("DELETE FROM adresse WHERE idAdresse = ?");
        $stmt->execute([$idAdresse]);
    }
}

function deleteClient($pdo, $id) {
    // Récupérer l'idAdresse avant de supprimer le client
    $client = getClientById($pdo, $id);
    $idAdresse = $client['idAdresse'];
    
    // Supprimer le client
    $stmt = $pdo->prepare("DELETE FROM client WHERE idClient = ?");
    $stmt->execute([$id]);
    
    // Supprimer l'adresse associée
    $stmtAdresse = $pdo->prepare("DELETE FROM adresse WHERE idAdresse = ?");
    $stmtAdresse->execute([$idAdresse]);
}

function getClientWithAddress($pdo, $id) {
    $stmt = $pdo->prepare("
        SELECT c.*, a.pays, a.ville, a.npa, a.rue, a.numero 
        FROM client c 
        LEFT JOIN adresse a ON c.idAdresse = a.idAdresse 
        WHERE c.idClient = ?
    ");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getAllClientsWithAddress($pdo) {
    $stmt = $pdo->query("
        SELECT c.*, a.pays, a.ville, a.npa, a.rue, a.numero 
        FROM client c 
        LEFT JOIN adresse a ON c.idAdresse = a.idAdresse 
        ORDER BY c.idClient desc
    ");
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Convertir toutes les clés en minuscules pour uniformité
    $clients_lower = [];
    foreach ($clients as $client) {
        $clients_lower[] = array_change_key_case($client, CASE_LOWER);
    }
    
    return $clients_lower;
}

// ==================== EMPLOYES ====================
function getAllEmployesWithDetails($pdo) {
    $stmt = $pdo->query("
        SELECT e.*, p.poste, tc.contrat, a.pays, a.ville, a.npa, a.rue, a.numero 
        FROM employe e
        LEFT JOIN poste p ON e.idPoste = p.idPoste
        LEFT JOIN typecontrat tc ON e.idTypeContrat = tc.idTypeContrat
        LEFT JOIN adresse a ON e.idAdresse = a.idAdresse
        ORDER BY e.idEmploye desc
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getEmployeById($pdo, $id) {
    $stmt = $pdo->prepare("
        SELECT e.*, a.pays, a.ville, a.npa, a.rue, a.numero 
        FROM employe e
        LEFT JOIN adresse a ON e.idAdresse = a.idAdresse
        WHERE e.idEmploye = ?
    ");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addEmploye($pdo, $data) {
    $resultAdresse = VerifierUnique($pdo, $data, "adresse", ["pays", "ville", "npa", "rue", "numero"]);

    if (empty($resultAdresse)) {
        $stmtAdresse = $pdo->prepare("INSERT INTO adresse (pays, ville, npa, rue, numero) VALUES (?, ?, ?, ?, ?)");
        $stmtAdresse->execute([
            $data['pays'],
            $data['ville'],
            $data['npa'],
            $data['rue'],
            $data['numero']
        ]);
        $idAdresse = $pdo->lastInsertId();
    }
    else {
        $idAdresse = getIdAdresseByRest($pdo, $data);
    }
    
    $stmt = $pdo->prepare("INSERT INTO employe (nom, prenom, idPoste, idTypeContrat, idAdresse, dateNaissance, email, telephone, salaireAnnuelle_CHF, commission_CHF, tauxActivite, dateEmbauche, DateFinContrat) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
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
    
    $stmtAdresse = $pdo->prepare("UPDATE adresse SET pays = ?, ville = ?, npa = ?, rue = ?, numero = ? WHERE idAdresse = ?");
    $stmtAdresse->execute([
        $data['pays'],
        $data['ville'],
        $data['npa'],
        $data['rue'],
        $data['numero'],
        $idAdresse
    ]);
    
    $stmt = $pdo->prepare("UPDATE employe SET nom = ?, prenom = ?, idPoste = ?, idTypeContrat = ?, dateNaissance = ?, email = ?, telephone = ?, salaireAnnuelle_CHF = ?, commission_CHF = ?, tauxActivite = ?, dateEmbauche = ?, DateFinContrat = ? WHERE idEmploye = ?");
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
    
    $stmt = $pdo->prepare("DELETE FROM employe WHERE idEmploye = ?");
    $stmt->execute([$id]);
    
    $stmtAdresse = $pdo->prepare("DELETE FROM adresse WHERE idAdresse = ?");
    $stmtAdresse->execute([$idAdresse]);
}

// ==================== VOITURES ====================
function getAllVoituresWithDetails($pdo) {
    $stmt = $pdo->query("
        SELECT v.*, mo.modele, ma.marque, c.nom as client_nom, c.prenom as client_prenom,
               ca.carburant, t.type as transmission, ev.etat, sv.statut
        FROM voiture v
        LEFT JOIN modele mo ON v.idModele = mo.idModele
        LEFT JOIN marque ma ON mo.idMarque = ma.idMarque
        LEFT JOIN client c ON v.idClient = c.idClient
        LEFT JOIN carburant ca ON v.idCarburant = ca.idCarburant
        LEFT JOIN transmission t ON v.idTransmission = t.idTransmission
        LEFT JOIN etatvoiture ev ON v.idEtatVoiture = ev.idEtatVoiture
        LEFT JOIN statutvoiture sv ON v.idStatutVoiture = sv.idStatutVoiture
        ORDER BY v.idVoiture desc
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getVoitureById($pdo, $id) {
    $stmt = $pdo->prepare("
        SELECT v.*, mo.modele, ma.marque
        FROM voiture v
        LEFT JOIN modele mo ON v.idModele = mo.idModele
        LEFT JOIN marque ma ON mo.idMarque = ma.idMarque
        WHERE v.idVoiture = ?
    ");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addVoiture($pdo, $data) {
    $stmt = $pdo->prepare("INSERT INTO voiture (chassis, idModele, idClient, idCarburant, idTransmission, idEtatVoiture, idStatutVoiture, kilometrage, valeurCHF, finGarantie, datePremiereCirculation) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $data['chassis'],
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
    $stmt = $pdo->prepare("UPDATE voiture SET chassis = ? idModele = ?, idClient = ?, idCarburant = ?, idTransmission = ?, idEtatVoiture = ?, idStatutVoiture = ?, kilometrage = ?, valeurCHF = ?, finGarantie = ?, datePremiereCirculation = ? WHERE idVoiture = ?");
    $stmt->execute([
        $data['chassis'],
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
    $stmt = $pdo->prepare("DELETE FROM voiture WHERE idVoiture = ?");
    $stmt->execute([$id]);
}

// ==================== FOURNISSEURS ====================
function getAllFournisseursWithAddress($pdo) {
    $stmt = $pdo->query("
        SELECT f.*, a.pays, a.ville, a.npa, a.rue, a.numero 
        FROM fournisseur f
        LEFT JOIN adresse a ON f.idAdresse = a.idAdresse
        ORDER BY f.idFournisseur desc
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getFournisseurById($pdo, $id) {
    $stmt = $pdo->prepare("
        SELECT f.*, a.pays, a.ville, a.npa, a.rue, a.numero 
        FROM fournisseur f
        LEFT JOIN adresse a ON f.idAdresse = a.idAdresse
        WHERE f.idFournisseur = ?
    ");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addFournisseur($pdo, $data) {
    $resultAdresse = VerifierUnique($pdo, $data, "adresse", ["pays", "ville", "npa", "rue", "numero"]);

    if (empty($resultAdresse)) {
        $stmtAdresse = $pdo->prepare("INSERT INTO adresse (pays, ville, npa, rue, numero) VALUES (?, ?, ?, ?, ?)");
        $stmtAdresse->execute([
            $data['pays'],
            $data['ville'],
            $data['npa'],
            $data['rue'],
            $data['numero']
        ]);
        $idAdresse = $pdo->lastInsertId();
    }
    else {
        $idAdresse = getIdAdresseByRest($pdo, $data);
    }
    
    $stmt = $pdo->prepare("INSERT INTO fournisseur (nom, prenom, idAdresse, entreprise, telephone, email) VALUES (?, ?, ?, ?, ?, ?)");
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
    
    $stmtAdresse = $pdo->prepare("UPDATE adresse SET pays = ?, ville = ?, npa = ?, rue = ?, numero = ? WHERE idAdresse = ?");
    $stmtAdresse->execute([
        $data['pays'],
        $data['ville'],
        $data['npa'],
        $data['rue'],
        $data['numero'],
        $idAdresse
    ]);
    
    $stmt = $pdo->prepare("UPDATE fournisseur SET nom = ?, prenom = ?, entreprise = ?, telephone = ?, email = ? WHERE idFournisseur = ?");
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
    
    $stmt = $pdo->prepare("DELETE FROM fournisseur WHERE idFournisseur = ?");
    $stmt->execute([$id]);
    
    $stmtAdresse = $pdo->prepare("DELETE FROM adresse WHERE idAdresse = ?");
    $stmtAdresse->execute([$idAdresse]);
}

// ==================== PRESTATIONS ====================
function getAllPrestationsWithDetails($pdo) {
    $stmt = $pdo->query("
        SELECT p.*, c.nom as client_nom, c.prenom as client_prenom,
               tp.type as type_prestation, sp.statut as statut_prestation
        FROM prestation p
        LEFT JOIN client c ON p.idClient = c.idClient
        LEFT JOIN typeprestation tp ON p.idTypePrestation = tp.idTypePrestation
        LEFT JOIN statutprestation sp ON p.idStatutPrestation = sp.idStatutPrestation
        ORDER BY p.dateDebut DESC
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getPrestationById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM prestation WHERE idPrestation = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addPrestation($pdo, $data) {
    $stmt = $pdo->prepare("INSERT INTO prestation (idClient, idVoiture, idStatutPrestation, idTypePrestation, description, dateDebut, dateFinPrevue, dateFin, tempPasseHeure, note, avis) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $data['idClient'],
        $data['idVoiture'],
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
    $stmt = $pdo->prepare("UPDATE prestation SET idClient = ?, idVoiture = ?, idStatutPrestation = ?, idTypePrestation = ?, description = ?, dateDebut = ?, dateFinPrevue = ?, dateFin = ?, tempPasseHeure = ?, note = ?, avis = ? WHERE idPrestation = ?");
    $stmt->execute([
        $data['idClient'],
        $data['idVoiture'],
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
    $stmt = $pdo->prepare("DELETE FROM prestation WHERE idPrestation = ?");
    $stmt->execute([$id]);
}

// ==================== FONCTIONS UTILITAIRES ====================
function getAllPostes($pdo) {
    $stmt = $pdo->query("SELECT * FROM poste ORDER BY poste");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllTypeContrats($pdo) {
    $stmt = $pdo->query("SELECT * FROM typecontrat ORDER BY contrat");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllModeles($pdo) {
    $stmt = $pdo->query("SELECT m.*, ma.marque FROM modele m LEFT JOIN marque ma ON m.idMarque = ma.idMarque ORDER BY ma.marque, m.modele");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllClients($pdo) {
    $stmt = $pdo->query("SELECT idClient, nom, prenom FROM client ORDER BY nom, prenom");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllCarburants($pdo) {
    $stmt = $pdo->query("SELECT * FROM carburant ORDER BY carburant");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllTransmissions($pdo) {
    $stmt = $pdo->query("SELECT * FROM transmission ORDER BY type");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllEtatVoitures($pdo) {
    $stmt = $pdo->query("SELECT * FROM etatvoiture ORDER BY etat");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllStatutVoitures($pdo) {
    $stmt = $pdo->query("SELECT * FROM statutvoiture ORDER BY statut");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllTypePrestations($pdo) {
    $stmt = $pdo->query("SELECT * FROM typeprestation ORDER BY type");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllStatutPrestations($pdo) {
    $stmt = $pdo->query("SELECT * FROM statutprestation ORDER BY statut");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// ==================== ADRESSE ====================

function countAdresse($pdo, $id) {
    $sql = "
        SELECT
            (SELECT COUNT(*) FROM fournisseur WHERE idAdresse = ?) +
            (SELECT COUNT(*) FROM employe WHERE idAdresse = ?) +
            (SELECT COUNT(*) FROM client WHERE idAdresse = ?)
        AS total_lignes";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id, $id, $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total_lignes'];
}

function getIdAdresseByRest($pdo, $data) {
    $sql = "SELECT idAdresse as id FROM adresse WHERE pays = ? AND ville = ? AND npa = ? AND rue = ? AND numero = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$data["pays"], $data["ville"], $data["npa"], $data["rue"], $data["numero"]]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['id'];
}

// ==================== General ====================
function VerifierUnique($pdo, $data, $table, $champs) {
    
    $sql = "SELECT * FROM `$table` WHERE";
    $valeurs = [];

    foreach ($champs as $index => $element) {
        if ($index > 0) {
            $sql .= " AND";
        }
        
        $sql .= " $element = ?";
        $valeurs[] = $data[$element];
    }
    $sql .= ";";

    $stmt = $pdo->prepare($sql);

    $stmt->execute($valeurs);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}