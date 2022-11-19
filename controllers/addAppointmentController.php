<?php
// Require Once
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/regex.php';
require_once __DIR__ . '/../models/Appointment.php';

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

    // Mail du client
    // Nettoyage
    $mail = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL);
    $patientId = Appointment::getPatientId($mail);

    // Validation
    if (empty($mail)) {
        $error['mail'] =  'Ce champ est obligatoire';
    }
    if (empty($patientId)) {
        $error['mail'] = 'Ce patient n\'existe pas en base de données';
    } else {
        $isOk = filter_var($mail, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => '/' . REGEX_MAIL . '/')));
        if (!$isOk) {
            $error['mail'] =  'L\'email n\'est pas valide';
        }
    }

    if (empty($error)) {
        $dateHour = $newAppointmentDateObj . ' ' . $newAppointmentHoursObj;

        $createAppointment = new Appointment(
            $dateHour,
            $patientId->id
        );

        $appointmentIsCreated = $createAppointment->create();
        if (!$appointmentIsCreated) {
            $error['add'] = 'Le rendez-vous n\'a pas pus être crée';
        } else {
            $error['add'] = 'Le rendez-vous a bien étais crée';
        }
    }
}

$script = '<script defer src="../../public/assets/js/script.js"></script>';

$title = 'Ajouter un rendez-vous | hospitale2n';

// Include
include __DIR__ . './../views/layout/header.php';
include __DIR__ . './../views/appointment/addAppointment.php';
include __DIR__ . './../views/layout/footer.php';
