<main>
    <h1>Ajouter un patient</h1>
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

        <!-- submit -->
        <div class="submit">
            <button class="btn" id="submit" type="submit">Envoyer</button>
        </div>
    </form>
</main>