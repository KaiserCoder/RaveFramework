<?php

namespace rave\app\controller;

use rave\core\Controller;

class Main extends Controller
{

    public function __construct()
    {
        $this->setLayout('default');
    }

    public function index()
    {
        $this->loadView('main');
    }

}
