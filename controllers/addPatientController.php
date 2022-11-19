<?php

// Require Once
require_once __DIR__ . './../config/config.php';
require_once __DIR__ . './../config/regex.php';
require_once __DIR__ . './../models/Patient.php';


// Envoie formulaire
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

    if (empty($error)) {
        $createPatient = new Patient(
            $lastname,
            $firstname,
            $birthdate,
            $phone,
            $mail
        );
        $isAddedPatient = $createPatient->create();
        if (!$isAddedPatient) {
            $error['bdd'] = 'Erreur, l\'utilisateur n\'a pas pus être ajouté à la base de donnée';
        } else {
            $message['bdd'] = 'L\'utilisateur a était ajouté à la base de donnée';
            var_dump($createPatient);
            // Condition
        }
    }
}

$script = '<script defer src="../../public/assets/js/script.js"></script>';
$title = "Ajouter un patient | hospitale2n";

// Include
include __DIR__ . './../views/layout/header.php';
include __DIR__ . './../views/patient/addPatient.php';
include __DIR__ . './../views/layout/footer.php';







// Methodologie plus simple sans construct car si on a une valeur null c'est plus facile a gérer
// $createPatient = new Patient();
// $createPatient->setLastname($lastname);
// $createPatient->setFirstname($firstname);
// $createPatient->setBirthdate($birthdate);
// $createPatient->setPhone($phone);
// $createPatient->setMail($mail);