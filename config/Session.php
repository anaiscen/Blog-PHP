<?php

namespace App\config;

class Session
{
    public $session;

    public function __construct()
    {
        $this->session = &$_SESSION;
    }

    public function set($name, $value)
    {
        $this->session[$name] = $value;
    }

    public function get($name)
    {
        if(isset($this->session[$name])) {
            return $this->session[$name];
        }
    }

    public function show($name)
    {
        if(isset($this->session[$name]))
        {
            $key = $this->get($name);
            $this->remove($name);
            return $key;
        }
    }

    public function remove($name)
    {
        unset($this->session[$name]);
    }

    public function start()
    {
        session_start();
    }
    
    public function stop()
    {
        session_destroy();
    }
}