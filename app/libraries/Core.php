<?php
//app core class
//-creates URL & loads core controller
// URL FORMAT - /controller/method/params

class Core
{
    //data type is string
    //by default, the current controller is pages
    protected $currentController;
    protected $currentMethod = 'index';

    //data type is array
    protected $params = [];

    public function __construct()
    {
        $this->currentController = 'Customers';

        //edit this configuration if you want to use this framework for other project
        $url = $this->getUrl();
        if (!isset($url[0])) {
            $url[0] = 'customer';
        }

        //look in controller for first value
        if (file_exists('../app/controller/' . ucwords($url[0]) . '.php')) {
            //if the file exists, then set as current controller
            $this->currentController = ucwords($url[0]);

            //unset 0 index
            //will destroy the specified variable
            unset($url[0]);
        }

        //require the controller
        require_once '../app/controller/' . $this->currentController . '.php';

        $this->currentController = new $this->currentController;
        //baasically this is Pages = new Pages;

        //check for second part of url
        if (isset($url[1])) {
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            } else {
                session_destroy();
                echo '<br> method does not exist';
            }
        }

        //taking care of the parameters
        //get params
        $this->params = $url ? array_values($url) : [];

        //call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            return $url;
        }
    }
}
