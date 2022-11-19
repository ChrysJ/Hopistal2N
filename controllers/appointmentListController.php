<?php

// Require Once
require_once __DIR__ . './../config/config.php';
require_once __DIR__ . './../models/Appointment.php';
require_once __DIR__ . '/../helpers/session/SessionStart.php';

$title = 'Liste des rendez-vous | hospitale2n';

$appointments = Appointment::readAll();

$script = '
<script defer src="../../public/assets/js/script.js"></script>
';

// Include
include __DIR__ . './../views/layout/header.php';
include __DIR__ . './../views/appointment/appointmentList.php';
include __DIR__ . './../views/layout/footer.php';
