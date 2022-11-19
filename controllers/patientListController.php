<?php

// Require Once
require_once __DIR__ . '/../config/regex.php';
require_once __DIR__ . '/../models/Patient.php';
require_once __DIR__ . '/../helpers/session/SessionStart.php';

$patients = Patient::readAll();

// Pagination
if (isset($_GET['page'])) {
    $currentPage = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
} else {
    $currentPage = 1;
}
$nbPatients  = count($patients);
$perPage = 1;
$pages = intval(ceil($nbPatients / $perPage));
$firstPatient = ($currentPage * $perPage) - $perPage;
$patients = Patient::pagination($firstPatient, $perPage);

// Recherche
if (isset($_GET['lastname'])) {
    $searchs = trim(filter_input(INPUT_GET, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS));
    $patients = Patient::readAll($searchs);
}

// Script js
$script = '
<script defer src="../../public/assets/js/script.js"></>
<script defer src="../../public/assets/js/search.js"></script>
<script defer src="../../public/assets/js/filter.js"></script>
';

$title = "Liste des patients | hospitale2n";

// Include
include __DIR__ . './../views/layout/header.php';
include __DIR__ . './../views/patient/patientList.php';
include __DIR__ . './../views/layout/footer.php';
