<?php

require_once __DIR__ . '/../helpers/database/connexion.php';

class Patient
{
    // -----------------------Attributs
    private int $_id;
    private string $_lastname;
    private string $_firstname;
    private string $_birthdate;
    private string $_phone;
    private string $_mail;

    // -----------------------Construct
    public function __construct(string $lastname, string $firstname, string $birthdate, string $phone, string $mail)
    {
        $this->_lastname = $lastname;
        $this->_firstname = $firstname;
        $this->_birthdate = $birthdate;
        $this->_phone = $phone;
        $this->_mail = $mail;
    }

    // ---------------- method
    // Pagination
    public static function pagination($firstPatient, $perPage)
    {
        $pdo = Connexion::getInstance();
        $sql = 'SELECT `id`, `lastname`,  `firstname` 
            FROM `patients`
            LIMIT :firstPatient, :perPage;';

        $sth = $pdo->prepare($sql);
        $sth->bindValue(':firstPatient', $firstPatient, PDO::PARAM_INT);
        $sth->bindValue(':perPage', $perPage, PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetchAll();
    }

    // Vérification si mail déja présent en base
    public static function mailExist(string $mail): bool
    {
        $pdo = Connexion::getInstance();
        $sql = 'SELECT `id` FROM `patients` WHERE`mail` = :mail;';
        $sth = $pdo->prepare($sql);
        $sth->bindValue(':mail', $mail);
        $succes = $sth->execute();
        if ($succes) {
            if (empty($sth->fetch())) {
                return false;
            } else {
                return true;
            }
        }
    }

    // Vérification si l'id du patient existe
    public static function idExist($id): bool
    {
        $pdo = Connexion::getInstance();
        $sql = 'SELECT `id` FROM `patients` WHERE `id` = :id;';
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


    // ReadId
    public static function readId(string $mail): bool | object
    {
        $pdo = Connexion::getInstance();
        $sql = 'SELECT `id` FROM `patients` WHERE `mail` = :mail';
        $sth = $pdo->prepare($sql);
        $sth->bindValue(':mail', $mail);
        $sth->execute();
        return $sth->fetch();
    }

    // Create user
    public function create()
    {
        $pdo = Connexion::getInstance();
        $sql = 'INSERT INTO `patients` (`lastname`, `firstname`, `birthdate`, `phone`,  `mail`)
            VALUES (:lastname , :firstname, :birthDate, :phoneNumber, :mail);';

        $sth = $pdo->prepare($sql);
        // On passe par prepare et les marqueurs nominatif pour se protéger contre les injections SQL
        $sth->bindValue(':lastname', $this->getLastname());
        $sth->bindValue(':firstname', $this->getFirstname());
        $sth->bindValue(':birthDate', $this->getBirthdate());
        $sth->bindValue(':phoneNumber', $this->getPhone());
        $sth->bindValue(':mail', $this->getMail());
        return $sth->execute();
    }

    // Read multiple user
    public static function readAll(string $lastname = ''): array
    {
        $pdo = Connexion::getInstance();
        $sql = 'SELECT `id`, `lastname`,  `firstname` FROM `patients`';
        if ($lastname == '') {
            $sql .= ';';
            $sth = $pdo->query($sql);
        }
        if ($lastname != '') {
            $sql .= ' WHERE `lastname` LIKE  CONCAT (:lastname, "%");';
            $sth = $pdo->prepare($sql);
            $sth->bindValue(':lastname', $lastname);
            $sth->execute();
        }
        return $sth->fetchAll();
    }

    // Read 1 user
    public static function read(int $id): object | bool
    {
        $pdo = Connexion::getInstance();
        $sql = 'SELECT * FROM `patients` WHERE`id` = :id;';
        $sth = $pdo->prepare($sql);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetch();
    }

    // Update user
    public function update(int $id): bool
    {
        $pdo = Connexion::getInstance();
        $sql = 'UPDATE `patients`
            SET `lastname` = :lastname, `firstname` = :firstname,`birthdate` = :birthdate,`phone` = :phone,`mail`= :mail
            WHERE `id` = :id;';

        $sth = $pdo->prepare($sql);
        $sth->bindValue(':lastname', $this->_lastname);
        $sth->bindValue(':firstname', $this->_firstname);
        $sth->bindValue(':birthdate', $this->_birthdate);
        $sth->bindValue(':phone', $this->_phone);
        $sth->bindValue(':mail', $this->_mail);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        if ($sth->execute()) {
            return ($sth->rowCount() > 0) ? true : false;
        }
    }

    // Delete user
    public static function delete($id)
    {
        $pdo = Connexion::getInstance();
        $sql = 'DELETE FROM `patients` WHERE `id` = :id';
        $sth = $pdo->prepare($sql);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        return $sth->execute();
    }

    // ------------------id
    /** get
     * @return int
     */
    public function getId(): int
    {
        return $this->_id;
    }

    /** set
     * @param int $id
     * 
     * @return void
     */
    public function setid(int $id): void
    {
        $this->_id = $id;
    }
    // ------------------lastname
    /** get lastname
     * @return string
     */
    public function getLastname(): string
    {
        return $this->_lastname;
    }
    // set
    public function setLastname(string $lastname): void
    {
        $this->_lastname = $lastname;
    }

    // ------------------firstname
    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->_firstname;
    }
    // set
    public function setFirstname(string $firstname): void
    {
        $this->_firstname = $firstname;
    }

    // ------------------birthdate
    // get
    public function getBirthdate(): string
    {
        return $this->_birthdate;
    }
    // set
    public function setBirthdate(string $birthdate): void
    {
        $this->_birthdate = $birthdate;
    }

    // ------------------phone
    // get
    public function getPhone(): string
    {
        return $this->_phone;
    }
    // set
    public function setPhone(string $phone): void
    {
        $this->_phone = $phone;
    }

    // ------------------mail
    // get
    public function getMail(): string
    {
        return $this->_mail;
    }
    // set
    public function setMail(string $mail): void
    {
        $this->_mail = $mail;
    }
}
