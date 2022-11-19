<main>
    <a class="btn-backto" href="/listePatients"><i class="fa-solid fa-arrow-left"></i> Retour a la liste des patients</a>

    <section class="patient-profile">
        <ul class="nav-patient-profile">
            <li class="nav-link-patient nav-patient-active">
                <span>Informations</span>
            </li>
            <li class="nav-link-patient">
                <span>Modification</span>
            </li>
            <li class="nav-link-patient">
                <span>Rendez-vous</span>
            </li>
        </ul>

        <?php
        $date = new DateTime($patientInfos->birthdate);
        $newBirthDate = $date->format('d-m-Y');
        ?>
        <div class="info-patient">
            <h1>Informations patient n°<?= $patientInfos->id ?></h1>
            <div class="patient">
                <img src="../public/assets/img/profile-user-1.png" alt="profile-patient">
                <div>
                    <h3><?= $patientInfos->lastname . ' ' . $patientInfos->firstname ?></h3>

                    <span><i class="fa-solid fa-cake-candles icons-information-patient"></i>Date de naissance :<br><?= $newBirthDate ?></span>
                    <span><a href='tel:<?= $patientInfos->phone ?>'><i class="fa-solid fa-phone icons-information-patient"></i></a>Numéro de téléphone :<br><?= $patientInfos->phone ?></span>
                    <span><a href='mailto:<?= $patientInfos->mail ?>'><i class="fa-solid fa-envelope icons-information-patient"></i></a>Email :<br><?= $patientInfos->mail ?></span>
                </div>
            </div>
            <p><?= $updateMessage ?? '' ?></p>

        </div>
        <form class="form-add  form-update-patient switch-box-patient" action="/patient/<?= $patientInfos->id ?>" method="POST">
            <!-- Lastname -->
            <div>
                <label for="lastname" class="form-label">Nom *</label>
                <input value="<?= $patientInfos->lastname ?? '' ?>" name="lastname" type="text" id="lastname" class="form-input" autocomplete="name" required placeholder="Doe">
                <p class="input-error-text" id="lastnameTextError"><?= $error['lastname'] ?? '' ?></p>
            </div>
            <!-- Firstname -->
            <div>
                <label for="firstname" class="form-label">Prénom *</label>
                <input value="<?= $patientInfos->firstname ?? '' ?>" name="firstname" type="text" id="firstname" class="form-input" autocomplete="name" required placeholder="John">
                <p class="input-error-text" id="firstnameTextError"><?= $error['firstname'] ?? '' ?></p>
            </div>
            <!-- BirthDate -->
            <div>
                <label for="birthDate" class="form-label">Date de naissance *</label>
                <input value="<?= $patientInfos->birthdate ?? ''  ?>" name="birthDate" type="date" id="birthDate" class="form-input" min="1940-01-01" required>
                <p class="input-error-text" id="birthDateTextError"><?= $error['birthDate'] ?? '' ?></p>
            </div>
            <!-- Phone -->
            <div>
                <label for="phoneNumber" class="form-label">Numéro de téléphone *</label>
                <input value="<?= $patientInfos->phone ?? '' ?>" name="phoneNumber" type="tel" id="phoneNumber" class="form-input" required placeholder="0912345678">
                <p class="input-error-text" id="phoneNumberTextError"><?= $error['phoneNumber'] ?? '' ?></p>
            </div>
            <!-- mail -->
            <div>
                <label for="mail" class="form-label">Adresse mail *</label>
                <input value="<?= $patientInfos->mail ?? '' ?>" name="mail" type="email" id="mail" class="form-input" autocomplete="email" required placeholder="doe.john@gmail.com">
                <p class="input-error-text" id="mailTextError"><?= $error['mail'] ?? '' ?></p>
            </div>
            <div class="submit">
                <button class="btn" id="submit" type="submit">Envoyer</button>
            </div>
        </form>
        <div class="patient-appointments switch-box-patient">
            <h2>Rendez-vous</h2>
            <?php
            foreach ($appointments as $key =>  $patientAppointment) {
                $newDate = Appointment::dateTimeFormated($patientAppointment);
            ?>
                <div class="appointments">
                    <span><?= $key + 1 ?></span>
                    <span>Date : <?= $newDate[0] ?></span>
                    <span>Heure : <?= $newDate[1] ?></span>
                </div>
            <?php
            }
            ?>
        </div>
    </section>
</main>