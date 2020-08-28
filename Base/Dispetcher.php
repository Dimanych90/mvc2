<?php


namespace Base;


class Dispetcher
{
    const DEFAULT_CONTROLLER = 'index';
    const DEFAULT_ACTION = 'index';

    private $_contrname = '';

    private $_actionname = '';


    protected function routes()
    {
        return ['Login' =>
            ['index' =>
                'Huser.login'],
         'Register' =>
            ['index' =>
                'Huser.register'],
        'Huy'=>
        ['index'=>'Huser.huy']];

    }

    public function dispatch()
    {
        $request = Context::getInstance()->getRequest();

        $contrname = $request->getContrName();

        $actionname = $request->getActionName();


        if (!$contrname || !$this->check($contrname)) {
            $this->_contrname = self::DEFAULT_CONTROLLER;
        } else {
            $this->_contrname = ucfirst(strtolower($contrname));
        }
        if (!$actionname || !$this->check($actionname)) {
            $this->_actionname = self::DEFAULT_ACTION;
        } else {
            $this->_actionname = strtolower($actionname);
        }
        $this->routes();

        if (isset($this->routes()[$this->_contrname][$this->_actionname])) {
            list($this->_contrname,$this->_actionname) = explode('.', $this->routes()[$this->_contrname]
            [$this->_actionname]);
        }
    }


    private function check(string $key)
    {
        return preg_match('/[a-zA-Z0-9]+/', $key);

    }

    /**
     * @return string
     */
    public function getContrname(): string
    {
        return $this->_contrname;
    }


    /**
     * @return string
     */
    public function getActionname(): string
    {
        return $this->_actionname . 'Action';
    }

    public function getActionToken(): string
    {
        return $this->_actionname;
    }


}