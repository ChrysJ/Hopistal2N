<main>
    <h1>Ajouter un rendez-vous</h1>
    <form class="form-add" method="POST">

        <!-- Date appointment -->
        <div>
            <label for="appointmentDate" class="form-label">Date de rendez-vous *</label>
            <input value="<?= $appointmentDate ?? '' ?>" name="appointmentDate" type="date" id="appointmentDate" class="form-input" min=<?= $currentDate->format('Y-d-m') ?> required>
            <p class="input-error-text" id="appointmentDateTextError"><?= $error['appointmentDate'] ?? '' ?></p>
        </div>

        <!-- Hours appointment -->
        <div>
            <label for="appointmentHours" class="form-label">Heure de rendez-vous * ( entre 9h et 18h )</label>
            <input value="<?= $newAppointmentHoursObj  ?? '' ?>" type="time" id="appointmentHours" name="appointmentHours" class="form-input" min="09:00" max="18:00" required>
            <p class="input-error-text" id="appointmentHoursTextError"><?= $error['appointmentHours'] ?? '' ?></p>
        </div>

        <!-- Mail du client -->
        <div>
            <label for="mail" class="form-label">Adresse mail *</label>
            <input value="<?= $mail ?? '' ?>" name="mail" type="email" id="mail" class="form-input" autocomplete="email" required placeholder="doe.john@gmail.com">
            <p class="input-error-text" id="mailTextError"><?= $error['mail'] ?? '' ?></p>
        </div>


        <!-- submit -->
        <div class="submit">
            <button class="btn" id="submit" type="submit">Envoyer</button>
        </div>
        <p><?= $error['add'] ?? '' ?></p>

    </form>

</main>