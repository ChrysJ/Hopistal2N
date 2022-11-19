<main>
    <h1>Ajouter un patient et son rendez-vous</h1>
    <form class="form-add" method="POST">

        <!-- Lastname -->
        <div>
            <label for="lastname" class="form-label">Nom *</label>
            <input value="<?= $lastname ?? '' ?>" name="lastname" type="text" pattern="<?= REGEX_NO_NUMBER ?>" id="lastname" class="form-input" required placeholder="Doe">
            <p class="input-error-text" id="lastnameTextError"><?= $error['lastname'] ?? '' ?></p>
        </div>

        <!-- Firstname -->
        <div>
            <label for="firstname" class="form-label">Prénom *</label>
            <input value="<?= $firstname ?? '' ?>" name="firstname" type="text" pattern="<?= REGEX_NO_NUMBER ?>" id="firstname" class="form-input" required placeholder="John">
            <p class="input-error-text" id="firstnameTextError"><?= $error['firstname'] ?? '' ?></p>
        </div>

        <!-- BirthDate -->
        <div>
            <label for="birthdate" class="form-label">Date de naissance *</label>
            <input value="<?= $birthdate ?? '' ?>" name="birthdate" type="date" id="birthdate" class="form-input" required>
            <p class="input-error-text" id="birthdateTextError"><?= $error['birthdate'] ?? '' ?></p>
        </div>

        <!-- Phone -->
        <div>
            <label for="phone" class="form-label">Numéro de téléphone *</label>
            <input value="<?= $phone ?? '' ?>" name="phone" type="tel" pattern="<?= REGEX_PHONE_NUMBER ?>" id="phone" class="form-input" required placeholder="0912345678">
            <p class="input-error-text" id="phoneTextError"><?= $error['phone'] ?? '' ?></p>
        </div>

        <!-- mail -->
        <div>
            <label for="mail" class="form-label">Adresse mail *</label>
            <input value="<?= $mail ?? '' ?>" name="mail" type="email" id="mail" class="form-input" autocomplete="email" required placeholder="doe.john@gmail.com">
            <p class="input-error-text" id="mailTextError"><?= $error['mail'] ?? '' ?></p>
        </div>

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


    </form>
</main>