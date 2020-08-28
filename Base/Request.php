<?php


namespace Base;


class Request
{
    private $_contrName = '';
    private $_actionName = '';


    public function __construct()
    {
        $servac = explode('/', $_SERVER['REQUEST_URI']);

        $this->_contrName = $servac[1] ?? '';
        $this->_actionName = $servac[2] ?? '';

    }

    /**
     * @return string
     */
    public function getContrName(): string
    {
        return $this->_contrName;
    }

    /**
     * @param string $contrName
     */
    public function setContrName(string $contrName): void
    {
        $this->_contrName = $contrName;
    }

    /**
     * @return string
     */
    public function getActionName(): string
    {
        return $this->_actionName;
    }

    /**
     * @param string $actionName
     */
    public function setActionName(string $actionName): void
    {
        $this->_actionName = $actionName;
    }

}