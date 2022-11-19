<?php

// Require Once
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/regex.php';
require_once __DIR__ . '/../models/Patient.php';
require_once __DIR__ . '/../models/Appointment.php';
require_once __DIR__ . '/../helpers/database/connexion.php';

$currentDate = new DateTime();

// Envoie formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // ------------------------------------------------
    // Patient
    // ------------------------------------------------

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
    // Netoyage
    $birthdate = filter_input(INPUT_POST, 'birthdate', FILTER_SANITIZE_NUMBER_INT);

    // Validation
    if (empty($birthdate)) {
        $eror['birthdate'] = 'Ce champ est obligatoire';
    } else {
        $isOk = filter_var($birthdate, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/' . REGEX_DATE . '/']]);
        if (!$isOk) {
            $error["birthdate"] = "La date entrée n'est pas valide!";
        } else {
            $birthdateObj = new DateTime($birthdate);
            $age = date('Y') - $birthdateObj->format('Y');

            if ($age > 120 || $age < 18) {
                $error["birthdate"] = "Votre age n'est pas conforme!";
            }
        }
    };

    // --------------------Phone
    // Nettoyage
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_NUMBER_INT);

    // Validation
    if (empty($phone)) {
        $error['phone'] =  'Ce champ est obligatoire';
    } else {
        $isOk = filter_var($phone, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => '/' . REGEX_PHONE_NUMBER . '/')));
        if ($isOk == false) {
            $error['phone'] =  'Le numéro de téléphone n\'est pas valide';
        }
    }

    // --------------------Mail
    // Nettoyage
    $mail = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL);

    // Validation
    if (empty($mail)) {
        $error['mail'] =  'Ce champ est obligatoire';
    } else {
        $isOk = filter_var($mail, FILTER_VALIDATE_EMAIL);
        if ($isOk == false) {
            $error['mail'] =  'L\'email n\'est pas valide';
        }
        if (Patient::mailExist($mail)) {
            $error['mail'] = 'L\'email existe déjà';
        }
    }

    // ------------------------------------------------
    // Rendez vous
    // ------------------------------------------------

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

        // Début transaction
        $pdo = Connexion::getInstance();
        $pdo->beginTransaction();

        $dateHour = $newAppointmentDateObj . ' ' . $newAppointmentHoursObj;

        $createPatient = new Patient(
            $lastname,
            $firstname,
            $birthdate,
            $phone,
            $mail
        );
        $isAddedPatient = $createPatient->create();

        $idPatient = $pdo->lastInsertId();


        // Aller chercher l'id du patient

        $createAppointment = new Appointment(
            $dateHour,
            $idPatient
        );

        $appointmentIsCreated = $createAppointment->create();

        if (!$isAddedPatient && !$appointmentIsCreated) {
            $error['bdd'] = 'Erreur, l\'utilisateur n\'a pas pus être ajouté à la base de donnée';
            $pdo->rollBack();
        } else {
            $message['bdd'] = 'L\'utilisateur et son rendez-vous a était ajouté à la base de donnée';
            $pdo->commit();
        }
    }
}

$script = '<script defer src="../../public/assets/js/script.js"></script>';
$title = "Ajouter un patient | hospitale2n";

// Include
include __DIR__ . './../views/layout/header.php';
include __DIR__ . './../views/patient/addPatientAppointment.php';
include __DIR__ . './../views/layout/footer.php';
