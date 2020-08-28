<?php

namespace App\Model;

class User
{

    private $_id;
    private $_login;
    private $_email;
    private $_passwordHash;

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->_email = $email;
    }

    /**
     * @return mixed
     */
    public function getPasswordHash()
    {
        return $this->_passwordHash;
    }

    /**
     * @param mixed $passwordHash
     */
    public function setPasswordHash($passwordHash): void
    {
        $this->_passwordHash = $passwordHash;
    }

    /**
     * @return mixed
     */
    public function getId(array $id)
    {

        return $this->_id;
    }

    /** return $_id */
    public function newvave(int $id)
    {

        echo $id;
        $ids = $id;
        $this->get($id);
        $this->getId([$ids]);
        if (isset($id) && isset($ids)) {
            $id = $ids;
        }else{
            return false;
        }
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->_id = $id;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->_login;
    }

    public function save()
    {
        $db = \Base\Context::getInstance()->getDb();
        $db->getconnection();
        $ret = $db->exec(
            "INSERT INTO newusers (`login`, email, password) VALUES (:login, :email, :pass)",
            __METHOD__,
            ['login' => $this->_login, 'email' => $this->_email, 'pass' => $this->_passwordHash]
        );
        if (!$ret) {
            return false;
        }
        $id = $db->lastInsertId();
        $this->_id = $id;
        return true;
    }

    public function get(int $id)
    {
        $db = \Base\Context::getInstance()->getDb();
        $db->getconnection();
        $data = $db->fetchOne("SELECT * FROM newusers WHERE id = :id", __METHOD__, ['id' => $id]);
        if ($data) {
            $this->loadData($data);
            return true;
        }

        return false;
    }

    public function loadData(array $data, $new = false)
    {
        if (isset($data['id'])) {
            $this->_id = $data['id'];
        }
        $this->_login = $data['login'];
        if ($new) {
            $this->_passwordHash = self::genPasswordHash($data['password']);
        } else {
            $this->_passwordHash = $data['password'];
        }
        $this->_email = $data['email'];
    }

    public static function getList(array $ids)
    {
        $db = \Base\Context::getInstance()->getDb();
        $db->getconnection();
        foreach ($ids as &$id) {
            $id = (int)$id;
        }
        $idsStr = implode(',', $ids);
        $data = $db->fetchAll(
            "SELECT * FROM newusers WHERE id IN($idsStr)",
            __METHOD__, $ids);

        if (!$data) {
            return [];
        }

        $res = [];
        foreach ($data as $elem) {
            $model = new self();
            $model->loadData($elem);
            $res[$model->getId($ids)] = $model;
        }

        return $res;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login): void
    {
        $this->_login = $login;
    }

    public static function genPasswordHash(string $password)
    {
        return sha1($password . 'd,.speu48sk');
    }

    public function check(&$error = '')
    {
        if (!$this->_login) {
            $error = 'empty name';
            return false;
        }

        return true;
    }
}