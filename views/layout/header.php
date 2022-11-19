<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <link rel="icon" type="image/png" href="../../public/assets/img/logo.svg" />
    <title><?= $title ?></title>
    <?= $script ?>

</head>

<body>
    <nav>
        <ul>
            <li>
                <img src="../../public/assets/img/logo.svg" alt="logo hospitale2n">
            </li>
            <li>
                <a class="nav-link" href="/ajouterPatient"><i class="fa-solid fa-user-plus"></i></a>
            </li>
            <li>
                <a class="nav-link" href="/listePatients"><i class="fa-solid fa-address-book"></i></a>
            </li>
            <li>
                <a class="nav-link" href="/ajouterRendez-vous"><i class=" fa-regular fa-calendar-plus"></i></a>
            </li>
            <li>
                <a class="nav-link" href="/listeRendez-vous"><i class="fa-solid fa-calendar-check"></i></a>
            </li>
            <li>
                <a class="nav-link" href="/ajouter_patient_rendez-vous"><i class="fa-solid fa-file-circle-plus"></i></a>
            </li>
        </ul>
    </nav>