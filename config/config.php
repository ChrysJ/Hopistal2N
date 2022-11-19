<?php

define('DSN',  'mysql:host=localhost;dbname=hospitale2n');
define('USER',  'root');
define('PWD',  '');

// Format date en francais
$formatShortFr = new IntlDateFormatter(
    locale: 'fr_Fr',
    pattern: "dd LLLL Y",
);

$formatLongFr = new IntlDateFormatter(
    locale: 'fr_Fr',
    pattern: "dd LLLL Y HH:mm (EEEE)",
);
