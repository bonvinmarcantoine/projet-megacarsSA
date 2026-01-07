<?php
$page = $_GET['page'] ?? 'accueil';
echo $page;

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/fonctions.php';

include __DIR__ . '/templates/header.php';

switch ($page) {
    // ==================== CLIENTS ====================
    case 'clients':
        $clients = getAllClientsWithAddress($pdo);
        include __DIR__ . '/templates/clients/list-client.php';
        break;

    case 'ajout_client':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resultNom = VerifierUnique($pdo, $_POST, "Client", ["nom", "prenom"]);
            $resultEmail = VerifierUnique($pdo, $_POST, "Client", ["email"]);
            if (!empty($resultNom)) {
                session_start();
                $_SESSION['message'] = "erreur dans le nom";
                header("Location: ?page=error&type=client");
                exit;
            }
            else if (!empty($resultEmail)) {
                session_start();
                $_SESSION['message'] = "erreur dans l'email";
                header("Location: ?page=error&type=client");
                exit;
            }
            else {
                addClient($pdo, $_POST);
                header("Location: ?page=clients");
                exit;
            }
        }
        $mode = 'add';
        $client = []; 
        include __DIR__ . '/templates/clients/form-client.php';
        break;

    case 'modif_client':
        if (!isset($_GET['id'])) {
            header("Location: ?page=clients");
            exit;
        }
        $client = getClientWithAddress($pdo, $_GET['id']);
        if (!$client) {
            header("Location: ?page=clients");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            updateClient($pdo, $_GET['id'], $_POST);
            header("Location: ?page=clients");
            exit;
        }
        $mode = 'edit';
        include __DIR__ . '/templates/clients/form-client.php';
        break;

    case 'suppr_client':
        if (isset($_GET['id'])) {
            deleteClient($pdo, $_GET['id']);
        }
        header("Location: ?page=clients");
        exit;



    // ==================== EMPLOYES ====================
    
    case 'employes':
        $employes = getAllEmployesWithDetails($pdo);
        include __DIR__ . '/templates/employes/list-employe.php';
        break;

    case 'ajout_employe':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resultEmail = VerifierUnique($pdo, $_POST, "Employe", ["nom", "prenom"]);
            $resultEmail = VerifierUnique($pdo, $_POST, "Employe", ["email"]);
            if (!empty($resultNom)) {
                session_start();
                $_SESSION['message'] = "erreur dans le nom";
                header("Location: ?page=error&type=employe");
                exit;
            }
            else if (!empty($resultEmail)) {
                session_start();
                $_SESSION['message'] = "erreur dans l'email";
                header("Location: ?page=error&type=employe");
                exit;
            }
            else {
                addEmploye($pdo, $_POST);
                header("Location: ?page=Employe");
                exit;
            }
        }
        $mode = 'add';
        $employe = [];
        $postes = getAllPostes($pdo);
        $typeContrats = getAllTypeContrats($pdo);
        include __DIR__ . '/templates/employes/form-employe.php';
        break;

    case 'modif_employe':
        if (!isset($_GET['id'])) {
            header("Location: ?page=employes");
            exit;
        }
        $employe = getEmployeById($pdo, $_GET['id']);
        if (!$employe) {
            header("Location: ?page=employes");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            updateEmploye($pdo, $_GET['id'], $_POST);
            header("Location: ?page=employes");
            exit;
        }
        $mode = 'edit';
        $postes = getAllPostes($pdo);
        $typeContrats = getAllTypeContrats($pdo);
        include __DIR__ . '/templates/employes/form-employe.php';
        break;

    case 'suppr_employe':
        if (isset($_GET['id'])) {
            deleteEmploye($pdo, $_GET['id']);
        }
        header("Location: ?page=employes");
        exit;

    // ==================== VOITURES ====================
    case 'voitures':
        $voitures = getAllVoituresWithDetails($pdo);
        include __DIR__ . '/templates/voitures/list-voiture.php';
        break;

    case 'ajout_voiture':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            addVoiture($pdo, $_POST);
            header("Location: ?page=voitures");
            exit;
        }
        $mode = 'add';
        $voiture = [];
        $modeles = getAllModeles($pdo);
        $clients = getAllClients($pdo);
        $carburants = getAllCarburants($pdo);
        $transmissions = getAllTransmissions($pdo);
        $etatVoitures = getAllEtatVoitures($pdo);
        $statutVoitures = getAllStatutVoitures($pdo);
        include __DIR__ . '/templates/voitures/form-voiture.php';
        break;

    case 'modif_voiture':
        if (!isset($_GET['id'])) {
            header("Location: ?page=voitures");
            exit;
        }
        $voiture = getVoitureById($pdo, $_GET['id']);
        if (!$voiture) {
            header("Location: ?page=voitures");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            updateVoiture($pdo, $_GET['id'], $_POST);
            header("Location: ?page=voitures");
            exit;
        }
        $mode = 'edit';
        $modeles = getAllModeles($pdo);
        $clients = getAllClients($pdo);
        $carburants = getAllCarburants($pdo);
        $transmissions = getAllTransmissions($pdo);
        $etatVoitures = getAllEtatVoitures($pdo);
        $statutVoitures = getAllStatutVoitures($pdo);
        include __DIR__ . '/templates/voitures/form-voiture.php';
        break;

    case 'suppr_voiture':
        if (isset($_GET['id'])) {
            deleteVoiture($pdo, $_GET['id']);
        }
        header("Location: ?page=voitures");
        exit;

    // ==================== FOURNISSEURS ====================
    case 'fournisseurs':
        $fournisseurs = getAllFournisseursWithAddress($pdo);
        include __DIR__ . '/templates/fournisseurs/list-fournisseur.php';
        break;

    case 'ajout_fournisseur':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resultEmail = VerifierUnique($pdo, $_POST, "Fournisseur", ["nom", "prenom"]);
            $resultEmail = VerifierUnique($pdo, $_POST, "Fournisseur", ["email"]);
            if (!empty($resultNom)) {
                session_start();
                $_SESSION['message'] = "erreur dans le nom";
                header("Location: ?page=error&type=fournisseur");
                exit;
            }
            else if (!empty($resultEmail)) {
                session_start();
                $_SESSION['message'] = "erreur dans l'email";
                header("Location: ?page=error&type=fournisseur");
                exit;
            }
            else {
                addFournisseur($pdo, $_POST);
                header("Location: ?page=fournisseurs");
                exit;
            }
        }
        $mode = 'add';
        $fournisseur = [];
        include __DIR__ . '/templates/fournisseurs/form-fournisseur.php';
        break;

    case 'modif_fournisseur':
        if (!isset($_GET['id'])) {
            header("Location: ?page=fournisseurs");
            exit;
        }
        $fournisseur = getFournisseurById($pdo, $_GET['id']);
        if (!$fournisseur) {
            header("Location: ?page=fournisseurs");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            updateFournisseur($pdo, $_GET['id'], $_POST);
            header("Location: ?page=fournisseurs");
            exit;
        }
        $mode = 'edit';
        include __DIR__ . '/templates/fournisseurs/form-fournisseur.php';
        break;

    case 'suppr_fournisseur':
        if (isset($_GET['id'])) {
            deleteFournisseur($pdo, $_GET['id']);
        }
        header("Location: ?page=fournisseurs");
        exit;

    // ==================== PRESTATIONS ====================
    case 'prestations':
        $prestations = getAllPrestationsWithDetails($pdo);
        include __DIR__ . '/templates/prestations/list-prestation.php';
        break;

    case 'ajout_prestation':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            addPrestation($pdo, $_POST);
            header("Location: ?page=prestations");
            exit;
        }
        $mode = 'add';
        $prestation = [];
        $clients = getAllClients($pdo);
        $typePrestations = getAllTypePrestations($pdo);
        $statutPrestations = getAllStatutPrestations($pdo);
        include __DIR__ . '/templates/prestations/form-prestation.php';
        break;

    case 'modif_prestation':
        if (!isset($_GET['id'])) {
            header("Location: ?page=prestations");
            exit;
        }
        $prestation = getPrestationById($pdo, $_GET['id']);
        if (!$prestation) {
            header("Location: ?page=prestations");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            updatePrestation($pdo, $_GET['id'], $_POST);
            header("Location: ?page=prestations");
            exit;
        }
        $mode = 'edit';
        $clients = getAllClients($pdo);
        $typePrestations = getAllTypePrestations($pdo);
        $statutPrestations = getAllStatutPrestations($pdo);
        include __DIR__ . '/templates/prestations/form-prestation.php';
        break;

    case 'suppr_prestation':
        if (isset($_GET['id'])) {
            deletePrestation($pdo, $_GET['id']);
        }
        header("Location: ?page=prestations");
        exit;

    // ==================== ERREUR ====================
    case 'error':
        $type = $_GET['type'] ?? 'general';
        include __DIR__ . '/templates/error.php';
        break;

    // ==================== ACCUEIL ====================

    default:
        $clients = getAllClientsWithAddress($pdo);
        $employes = getAllEmployesWithDetails($pdo);
        $voitures = getAllVoituresWithDetails($pdo);
        $prestations = getAllPrestationsWithDetails($pdo);
        
        $clientCount = count($clients);
        $employeCount = count($employes);
        $voitureCount = count($voitures);
        $prestationCount = count($prestations);
        
        include __DIR__ . '/templates/accueil.php';
        break;
}

include __DIR__ . '/templates/footer.php';