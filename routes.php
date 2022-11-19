<?php
require_once __DIR__ . '/router.php';

try {
    // Index
    get('/', 'index.php');

    // Patient
    any('/ajouterPatient', 'controllers/addPatientController.php');
    any('/listePatients', 'controllers/patientListController.php');
    any('/patient/$id', '/controllers/patientProfileController.php');
    // any('/patient/$name', '/controllers/patientProfileController.php');

    // Appointments
    any('/ajouterRendez-vous', 'controllers/addAppointmentController.php');
    any('/listeRendez-vous', 'controllers/appointmentListController.php');
    any('/rendez-vous/$id', 'controllers/appointmentController.php');

    // Patient et rendez vous
    any('/ajouter_patient_rendez-vous', 'controllers/addPatientAppointmentController.php');

    any('/404', 'views/404.php');
} catch (PDOException $ex) {
    echo $ex->getMessage();
}
