<main>
    <h1>Liste des rendez-vous</h1>
    <?php
    if (SessionFlash::exist()) {
        echo '<p class="message">' . SessionFlash::get() . '</p>';
    }
    ?>
    <section>
        <div class="box-data">
            <span>Id</span>
            <span>Nom</span>
            <span>Prénom</span>
            <span>Rendez-vous</span>
        </div>
        <?php
        foreach ($appointments as $appointment) {
            $piecesDateHour = explode(" ", $appointment->dateHour);
            // format jour
            $day = new DateTime($piecesDateHour[0]);
            $newDay = $day->format('d-m-Y');
            // format heure
            $hour = new DateTime($piecesDateHour[1]);
            $newHour = $hour->format('H:i');
        ?>
            <div class="box-users">
                <span><?= $appointment->id ?></span>
                <span><?= $appointment->lastname ?></span>
                <span><?= $appointment->firstname ?></span>
                <span>date : <?= $newDay ?><br>heure :<?= $newHour  ?></span>
                <div class="btn-list">
                    <a href='/rendez-vous/<?= $appointment->id ?>'><i class="fa-solid fa-calendar-check"></i></a>
                    <!-- Si j'ai action & id dans mon get alors tu me delete l'item et tu header location dans la liste -->
                    <a class="btn-delete" href="/rendez-vous/<?= $appointment->id ?>?action=delete"><i class="fa-solid fa-xmark"></i></a>
                </div>
            </div>
        <?php
        }
        ?>
    </section>
</main>