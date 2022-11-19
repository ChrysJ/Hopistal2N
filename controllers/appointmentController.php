<?php
// Require once
require_once __DIR__ . './../config/config.php';
require_once __DIR__ . './../config/regex.php';
require_once __DIR__ . './../models/Appointment.php';
require_once __DIR__ . '/../helpers/session/SessionStart.php';

// Nettoyage variable créer avec la routes
$appointmentId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
// Récupération des données du rendez vous
$appointmentInfos = Appointment::read($appointmentId);
$currentDate = new DateTime();

// Envoie formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Date rendez-vous
    $appointmentDate = filter_input(INPUT_POST, 'appointmentDate', FILTER_SANITIZE_NUMBER_INT);

    if (empty($appointmentDate)) {
        $error["appointmentDate"] = "Ce champs est obligatoire";
    }

    if (!empty($appointmentDate)) {
        $isOk = filter_var($appointmentDate, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/' . REGEX_DATE . '/']]);
        if (!$isOk) {
            $error["appointmentDate"] = "La date n'est pas valide!";
        } else {
            $appointmentDateObj = new DateTime($appointmentDate);
            $newAppointmentDateObj = $appointmentDateObj->format('Y-m-d');
        }
        if ($appointmentDateObj < $currentDate) {
            $error["appointmentDate"] = "Vous ne pouvez pas assigner une date passé";
        }
    };

    // Heure rendez-vous
    $appointmentHours = filter_input(INPUT_POST, 'appointmentHours', FILTER_SANITIZE_NUMBER_INT);
    $checkHour = date_parse($appointmentHours);

    if (empty($appointmentHours)) {
        $error["appointmentHours"] = "Ce champs est obligatoire";
    }

    if (!empty($appointmentHours)) {
        $isOk = filter_var($appointmentHours, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/' . REGEX_HOURS . '/']]);
        if (!$isOk) {
            $error["appointmentHours"] = "L'heure n'est pas valide!";
        }
        if ($checkHour['hour'] < 9 || ($checkHour['hour'] > 18)) {
            $error["appointmentHours"] = "Les heures de rendez-vous sont entre 9h et 18h";
        } else {
            $appointmentHoursObj = new DateTime($appointmentHours);
            $newAppointmentHoursObj = $appointmentHoursObj->format('H:i');
        }
    }

    if (empty($error)) {
        $dateHour =  $newAppointmentDateObj . ' ' . $newAppointmentHoursObj;

        $updateAppointment = new Appointment(
            $dateHour,
            $appointmentInfos->idPatients
        );

        $appointmentIsUpdated = $updateAppointment->update($appointmentInfos->id);
        if ($appointmentIsUpdated == false) {
            $updateMessage = 'Les modifications n\'ont pas étais pris en compte';
        } else {
            $updateMessage = 'Les modifications ont étais pris en compte';
            $appointmentInfos = Appointment::read($appointmentId);
        }
    }
}

// Variable pour conditions de suppression
$action = $_GET['action'] ?? '';

// Suppresion d'une ligne de la table appointments
if ($action ==  "delete") {
    Appointment::delete($appointmentInfos->id);
    SessionFlash::set('Le rendez vous a bien été supprimé');
    header('Location: /listeRendez-vous');
    exit;
}

$script = '
<script defer src="../../public/assets/js/script.js"></script>
<script defer src="../../public/assets/js/patientProfile.js"></script>
';

$title = "Informations rendez-vous | hospitale2n";

// Include
include __DIR__ . './../views/layout/header.php';
if (!Appointment::idExist($appointmentInfos->id)) {
    header('Location: /listeRendez-vous');
    exit;
} else {
    include __DIR__ . './../views/appointment/appointment.php';
}
include __DIR__ . './../views/layout/footer.php';
