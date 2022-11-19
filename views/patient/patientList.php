<main>
    <h1>Liste des patients</h1>
    <!-- <?php
    if (SessionFlash::exist()) {
        echo '<p class="message">' . SessionFlash::get() . '</p>';
    }
    ?> -->
    <section>
        <div class="box-data">
            <span>Id</span>
            <span>Nom</span>
            <span>Prénom</span>
            <!-- Formulaire recherche -->
            <form novalidate class="form-search">
                <label for="lastname">Rechercher un patient avec son nom</label>
                <div class="js-filter-search">
                    <input value="<?= $lastname ?? '' ?>" name="lastname" type="search" pattern="<?= REGEX_NO_NUMBER ?>" id="lastname" class="form-input" autocomplete="name" required placeholder="Doe">
                    <button id="submit" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
                <?php
                if (isset($_GET['lastname'])) {
                    echo '<a href="/listePatients">Afficher tous les clients</a>';
                }
                ?>
                <p class=" input-error-text" id="lastnameTextError"><?= $error['lastname'] ?? '' ?></p>
            </form>
        </div>
        <?php

        foreach ($patients as $patient) {
        ?>
            <div class="box-users">
                <span><?= $patient->id ?></span>
                <span><?= $patient->lastname ?></span>
                <span><?= $patient->firstname ?></span>
                <div class="btn-list">
                    <a href='/patient/<?= $patient->id ?>'><i class="fa-solid fa-user"></i></a>
                    <!-- Si j'ai action & id dans mon get alors tu me delete l'item et tu header location dans la liste -->
                    <a class="btn-delete" href="/patient/<?= $patient->id ?>?action=delete"><i class="fa-solid fa-xmark"></i></a>
                </div>
            </div>
        <?php
        }
        ?>
    </section>
    <ul class="pagination">
        <?php for ($page = 1; $page <= $pages; $page++) : ?>
            <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                <a href="/listePatients?page=<?= $page ?>" class="page-link"><?= $page ?></a>
            </li>
        <?php endfor ?>
    </ul>
</main>