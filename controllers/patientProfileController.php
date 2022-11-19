<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/regex.php';
require_once __DIR__ . '/../models/Patient.php';
require_once __DIR__ . '/../models/Appointment.php';
require_once __DIR__ . '/../helpers/session/SessionStart.php';

// Nettoyage créer avec la routes
$patientId =  filter_var($id, FILTER_SANITIZE_NUMBER_INT);
// Récupération des données du patient
$patientInfos = Patient::read($patientId);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // --------------------Lastname
    // Netoyage
    $lastname = trim(filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS));

    // Validation
    if (empty($lastname)) {
        $error['lastname'] = 'Ce champ est obligatoire';
    } else {
        $isOk = filter_var($lastname, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => '/' . REGEX_NO_NUMBER . '/')));
        if (!$isOk) {
            $error['lastname'] = 'Le nom de famille n\'est pas valide';
        }
    }

    // --------------------Firstname
    // Netoyage
    $firstname = trim(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS));

    // Validation
    if (empty($firstname)) {
        $error['firstname'] = 'Ce champ est obligatoire';
    } else {
        $isOk = filter_var($firstname, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => '/' . REGEX_NO_NUMBER . '/')));
        if (!$isOk) {
            $error['firstname'] = 'Le prénom n\'est pas valide';
        }
    }

    // --------------------BirthDate
    // Nettoyage
    $birthDate = filter_input(INPUT_POST, 'birthDate', FILTER_SANITIZE_NUMBER_INT);

    // Validation
    if (!empty($birthDate)) {
        $isOk = filter_var($birthDate, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/' . REGEX_DATE . '/']]);
        if (!$isOk) {
            $error["birthDate"] = "La date entrée n'est pas valide!";
        } else {
            $birthDateObj = new DateTime($birthDate);
            $age = date('Y') - $birthDateObj->format('Y');

            if ($age > 120 || $age < 18) {
                $error["birthDate"] = "Votre age n'est pas conforme!";
            }
        }
    };

    // --------------------Phone
    // Nettoyage
    $phoneNumber = filter_input(INPUT_POST, 'phoneNumber', FILTER_SANITIZE_NUMBER_INT);

    // Validation
    if (empty($phoneNumber)) {
        $error['phoneNumber'] =  'Ce champ est obligatoire';
    } else {
        $isOk = filter_var($phoneNumber, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => '/' . REGEX_PHONE_NUMBER . '/')));
        if ($isOk == false) {
            $error['phoneNumber'] =  'Le numéro de téléphone n\'est pas valide';
        }
    }

    // --------------------Mail
    // Nettoyage
    $mail = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL);

    // Validation
    if (empty($mail)) {
        $error['mail'] =  'Ce champ est obligatoire';
    } else {
        if (Patient::mailExist($mail) && $mail != $patientInfos->mail) {
            $error['mail'] = 'L\'email existe déjà';
        } else {
            $isOk = filter_var($mail, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => '/' . REGEX_MAIL . '/')));
            if ($isOk == false) {
                $error['mail'] =  'L\'email n\'est pas valide';
            }
        }
    }

    if (empty($error)) {
        $updatePatient = new Patient(
            $lastname,
            $firstname,
            $birthDate,
            $phoneNumber,
            $mail
        );

        // Modification patient
        // On stock le retour de la methode update

        // Message erreur / message OK
        $patientIsUpdated = $updatePatient->update($patientId);
        if ($patientIsUpdated == false) {
            $updateMessage = 'Les modifications n\'ont pas étais pris en compte';
        } else {
            $updateMessage = 'Les modifications ont étais pris en compte';
            $patientInfos = Patient::read($patientInfos->id);
        }
    };
}

// Appel des rendez vous du client
// $patientAppointments = Appointment::readAppointmentPatient($patientInfos->id);

$appointments = Appointment::readAll($patientId);
// Variable pour conditions de suppression
$action = $_GET['action'] ?? '';

// Suppresion d'une ligne de la table appointments
if ($action ==  "delete") {
    Appointment::deleteWithPatient($patientInfos->id);
    Patient::delete($patientInfos->id);
    SessionFlash::set('Le patient a bien été supprimé');
    header('Location: /listePatients');
    exit;
}

// ScriptJS
$script = '
<script defer src="../../public/assets/js/script.js"></script>
<script defer src="../../public/assets/js/patientProfile.js"></script>
';

// Title
$title = "Informations patient | hospitale2n";

// Include
include __DIR__ . './../views/layout/header.php';
if (!Patient::idExist($patientInfos->id)) {
    header('Location: /listePatients');
    exit;
} else {
    include __DIR__ . './../views/patient/patientProfile.php';
    // include __DIR__ . './../views/appointment/appointmentList.php';
}
include __DIR__ . './../views/layout/footer.php';
