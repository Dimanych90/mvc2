<?php


namespace Base;


use Base\Exception\Error404;

class Application
{
    /** @var Context */
    private $_context;

    protected function _init()
    {

        $this->_context = Context::getInstance();
        $request = new Request();
        $db = new Db();
        $dispetcher = new Dispetcher();

        $this->_context->setRequest($request);
        $this->_context->setDispetcher($dispetcher);
        $this->_context->setDb($db);

    }

    public function run()
    {
        try {
            $this->_init();
            $this->_context->getDispetcher()->dispatch();
            $dispetcher = $this->_context->getDispetcher();


            $supercontr = 'App\Controller\\' . $dispetcher->getContrname();

            if (!class_exists($supercontr)) {
                throw new Error404("Class " . $supercontr . " is not exists");

            }
            /** @var Controller $objectcontr */
            $objectcontr = new $supercontr();


            $contraction = $dispetcher->getActionname();

            if (!method_exists($objectcontr, $contraction)) {
                throw new Error404("Method " . $contraction . " is not found in " . $supercontr);
            }


            $tpl = "App/templates/" . $dispetcher->getContrname() . '/' . $dispetcher->getActionToken() . '.phtml';


            $view = new View();

            $objectcontr->view = $view;
            $objectcontr->preAction();
            $objectcontr->$contraction();

            if ($objectcontr->needRender()){
               $html = $view->render($tpl);
               echo $html;
        }

        } catch (Error404 $e) {
            header("HTTP/1.0 404 Not Found");
            trigger_error($e->getMessage());
        }
    }

}