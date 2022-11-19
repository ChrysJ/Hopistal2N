<?php

require_once __DIR__ . '/../helpers/database/connexion.php';

class Appointment
{
    // -----------------------Attributs
    private string $_dateHour;
    private int $_idPatients;
    private $pdo;

    // -----------------------Construct
    public function __construct(string $dateHour, int $idPatients)
    {
        $this->pdo = Connexion::getInstance();
        $this->_dateHour = $dateHour;
        $this->_idPatients = $idPatients;
    }

    // Get patient ID
    public static function getPatientId(string $mail): object | bool
    {
        $pdo = Connexion::getInstance();
        $sql = 'SELECT `id` FROM `patients` WHERE `mail` = :mail';
        $sth = $pdo->prepare($sql);
        $sth->bindValue(':mail', $mail);
        $sth->execute();
        return $sth->fetch();
    }

    // IdExist
    public static function idExist($id): bool
    {
        $pdo = Connexion::getInstance();
        $sql = 'SELECT `id` FROM `appointments` WHERE `id` = :id;';
        $sth = $pdo->prepare($sql);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $succes = $sth->execute();
        if ($succes) {
            if (empty($sth->fetch())) {
                return false;
            } else {
                return true;
            }
        }
    }

    // Format dateHours 
    // Date
    public static function dateTimeFormated($object): array
    {
        $arrayDateFormated = [];
        $piecesDateHour = explode(" ", $object->dateHour);
        // format jour
        $day = new DateTime($piecesDateHour[0]);
        $newDay = $day->format('d-m-Y');

        // format heure
        $hour = new DateTime($piecesDateHour[1]);
        $newHour = $hour->format('H:i');
        array_push($arrayDateFormated, $newDay, $newHour);
        return $arrayDateFormated;
    }

    // Display appointment client
    public static function readAppointmentPatient($id): array
    {

        $pdo = Connexion::getInstance();
        $sql = 'SELECT `appointments`.`dateHour`
                FROM `appointments`
                JOIN `patients`
                ON `appointments`.`idPatients` = `patients`.`id`
                WHERE `patients`.`id` = :id;';
        $sth = $pdo->prepare($sql);
        $sth->bindParam(':id', $id);
        $sth->execute();
        return $sth->fetchAll();
    }

    // ------------------method Crud
    // Create appointment
    public function create()
    {
        $sql = 'INSERT INTO `appointments` (`dateHour`, `idPatients`) VALUES (:datehour, :id);';
        $sth = $this->pdo->prepare($sql);
        $sth->bindValue(':datehour', $this->getDateHour());
        $sth->bindValue(':id', $this->getIdPatients(), PDO::PARAM_INT);
        if ($sth->execute()) {
            return ($sth->rowCount() > 0) ? true : false;
        };
    }

    // Read multiple appointment
    public static function readAll(int $idPatients = 0): array
    {
        $pdo = Connexion::getInstance();
        $sql = 'SELECT `appointments`.`id`, `patients`.`lastname`, `patients`.`firstname`, `appointments`.`dateHour`
            FROM `patients`
            RIGHT JOIN `appointments`
            ON `patients`.`id` = `appointments`.`idPatients`';
        if ($idPatients != 0) {
            $sql .= ' WHERE `patients`.`id` = :id';
        }
        $sql .= ';';
        $sth = $pdo->prepare($sql);
        if ($idPatients != 0) {
            $sth->bindParam(':id', $idPatients);
        }
        $sth->execute();
        return $sth->fetchAll();
    }

    // Read appointment
    public static function read(int $id): object | bool
    {
        $pdo = Connexion::getInstance();
        $sql = 'SELECT * FROM `appointments` WHERE `appointments`.`id` = :id;';
        $sth = $pdo->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        return ($sth->execute()) ?  $sth->fetch() : false;
    }

    // Update appointment
    public function update($id)
    {
        $sql = 'UPDATE `appointments`
            SET `dateHour` = :dateHour 
            WHERE `id` = :id;';

        $sth = $this->pdo->prepare($sql);
        $sth->bindValue(':dateHour', $this->_dateHour);
        $sth->bindValue(':id', $id,  PDO::PARAM_INT);
        if ($sth->execute()) {
            return ($sth->rowCount() > 0) ? true : false;
        }
    }

    // Delete appointment
    public static function delete($id): bool
    {
        $pdo = Connexion::getInstance();
        $sql = 'DELETE FROM `appointments`
            WHERE `id` = :id';
        $sth = $pdo->prepare($sql);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        if ($sth->execute()) {
            return ($sth->rowCount() == 1);
        }
        return false;
    }

    // Delete appointment withPatient
    public static function deleteWithPatient($id)
    {
        $pdo = Connexion::getInstance();
        $sql = 'DELETE FROM `appointments`
            WHERE `appointments`.`idPatients` = :id';
        $sth = $pdo->prepare($sql);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        return $sth->execute();
    }

    // Getter setter
    // ------------------dateHour
    /** get
     * @return string
     */
    public function getDateHour(): string
    {
        return $this->_dateHour;
    }

    /** set
     * @param string $dateHour
     * 
     * @return void
     */
    public function setDateHour(string $dateHour): void
    {
        $this->_dateHour = $dateHour;
    }

    // ------------------idPatients
    /** get
     * @return int
     */
    public function getIdPatients(): int
    {
        return $this->_idPatients;
    }

    /** set
     * @param int $idPatients
     * 
     * @return void
     */
    public function setIdPatients(int $idPatients): void
    {
        $this->_idPatients = $idPatients;
    }
}
