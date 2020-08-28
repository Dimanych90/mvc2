<?php


namespace Base;


class Db
{

    /** @var \PDO */
    private $_pdo;
    private $_log = [];


    public function getconnection()
    {
        if (!$this->_pdo) {
            try {
                $this->_pdo = new \PDO('mysql:host=localhost;dbname=db', 'root', 'root');

            } catch (\Exception $e) {
                echo $e->getMessage();
                die();
            }
        } else {
            return $this->_pdo;
        }
    }

    public function fetchAll(string $query, $_method, array $param)
    {
        $t = microtime(1);
        $pdo = $this->getconnection();
//    var_dump($pdo);
       $prepared = $pdo->prepare($query);
//        var_dump($prepared);

        $ret = $prepared->execute($param);

        if (!$ret) {
            $errorinfo = $prepared->errorInfo();
            echo $errorinfo;
        }

        $affectedrows = $prepared->rowCount();

        $data = $prepared->fetchAll(\PDO::FETCH_ASSOC);

        $this->_log[] = [$query, microtime(1) - $t, $_method, $affectedrows];
        return $data;
    }

    public function fetchOne(string $query, $_method, array $param)
    {
        $t = microtime(1);
        $pdo = $this->getconnection();
        $prepared = $pdo->prepare($query);

        $ret = $prepared->execute($param);

        if (!$ret) {
            $errorinfo = $prepared->errorInfo();
            echo $errorinfo;
        }

        $affectedrows = $prepared->rowCount();

        $data = $prepared->fetchAll(\PDO::FETCH_ASSOC);

        $this->_log[] = [$query, microtime(1) - $t, $_method, $affectedrows];

        return reset($data);
    }

    public function exec(string $query, $_method, array $param)
    {
        $t = microtime(1);
        $pdo = $this->getconnection();
        $prepared = $pdo->prepare($query);

        $ret = $prepared->execute($param);

        if (!$ret) {
            $errorinfo = $prepared->errorInfo();
            echo $errorinfo;
        }

        $affectedrows = $prepared->rowCount();

        $this->_log[] = [$query, microtime(1) - $t, $_method, $affectedrows];

        return true;
    }

    public function lastInsertId()
    {
        return $this->getconnection()->lastInsertId();
    }

    /**
     * @return
     */
    public function getLog()
    {
        if (!$this->_log){
            return '';
        }
        $res = '';
        foreach ($this->_log as $item){
            $res = $item[1] .' ('. $item[0] .') '. $item[2] . ' '.$item[3];
        }
        return '<pre>' . $res .'</pre>';
    }
}