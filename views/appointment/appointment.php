<main>
    <a class="btn-backto" href="/listeRendez-vous"><i class="fa-solid fa-arrow-left"></i> Retour a la liste des rendez-vous</a>

    <section class="patient-profile">
        <ul class="nav-patient-profile">
            <li class="nav-link-patient nav-patient-active">
                <span>Informations</span>
            </li>
            <li class="nav-link-patient">
                <span>Modification</span>
            </li>
        </ul>

        <?php
        $newDate = Appointment::dateTimeFormated($appointmentInfos);
        if ($appointmentInfos == false) {
            echo 'erreur';
        } else {
        ?>
            <div class="info-patient">
                <h1>Informations rendez-vous n°<?= $appointmentInfos->id ?></h1>
                <div class="patient">
                    <img src="../public/assets/img/profile-user-1.png" alt="profile-patient">
                    <div>
                        <h2>Date : <?= $newDate[0] ?></h2>
                        <h2>Heure : <?= $newDate[1] ?></h2>
                    </div>
                </div>
                <p><?= $updateMessage ?? '' ?></p>
            </div>
            <form class="form-add form-update-patient switch-box-patient" method="POST">

                <!-- Day -->
                <div>
                    <label for="appointmentDate" class="form-label">Date de rendez-vous *</label>
                    <input value="<?= $newDate[0] ?? '' ?>" name="appointmentDate" type="date" id="appointmentDate" class="form-input" min=<?= $currentDate->format('Y-d-m') ?> required>
                    <p class="input-error-text" id="appointmentDateTextError"><?= $error['appointmentDate'] ?? '' ?></p>
                </div>

                <!-- Hours -->
                <div>
                    <label for="appointmentHours" class="form-label">Heure de rendez-vous * ( entre 9h et 18h )</label>
                    <input value="<?= $newDate[1] ?? '' ?>" type="time" id="appointmentHours" name="appointmentHours" class="form-input" min="09:00" max="18:00" required>
                    <p class="input-error-text" id="appointmentHoursTextError"><?= $error['appointmentHours'] ?? '' ?></p>
                </div>
                <div class="submit">
                    <button class="btn" id="submit" type="submit">Envoyer</button>
                </div>
            </form>
    </section>
</main>
<?php
        }
?>