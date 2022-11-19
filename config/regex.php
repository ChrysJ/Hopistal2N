<?php

// --------------------------
// ---------------------Regex
// --------------------------

// No number
define('REGEX_NO_NUMBER', "^[A-Za-z-éèêëàâäôöûüç' ]+$");

// Mail
define('REGEX_MAIL', "^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$");

// Number phone
define('REGEX_PHONE_NUMBER', "^\d{10}$");

// Date
define('REGEX_DATE', '^([0-9]{4})[\/\-]?([0-9]{2})[\/\-]?([0-9]{2})$');

// Hours
define('REGEX_HOURS', '^([0-1]?[0-9]|2[0-3])[0-5][0-9]$');
