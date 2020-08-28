<?php


namespace Base;


class Context
{
    private static $_instance;

    /** @var Dispetcher */
    private $_dispetcher;
    /** @var Request */
    private $_request;
    /** @var Db */
    private $_db;

    private function __construct()
    {
    }

    private function __clone()
    {
        // TODO: Implement __clone() method.
    }


    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @return Dispetcher
     */
    public function getDispetcher(): Dispetcher
    {
        return $this->_dispetcher;
    }

    /**
     * @param Dispetcher $dispetcher
     */
    public function setDispetcher(Dispetcher $dispetcher): void
    {
        $this->_dispetcher = $dispetcher;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->_request;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request): void
    {
        $this->_request = $request;
    }

    /**
     * @return Db
     */
    public function getDb(): Db
    {
        return $this->_db;
    }

    /**
     * @param Db $db
     */
    public function setDb(Db $db): void
    {
        $this->_db = $db;
    }

}