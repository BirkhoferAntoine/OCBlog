<?php

class ControllerSecurity
{
    private $_sessionHandler;
    private $_add_empty;
    private $_filteredUri;
    private $_filteredPost;
    private $_filteredGet;


    public function __construct($argsGet, $argsPost)
    {
        $this->_init($argsGet, $argsPost);
    }

    private function _init($argsGet, $argsPost) {
        $this->_sessionHandler = new SessionHandler();

        $this->_argsGet = $argsGet;
        $this->_argsPost = $argsPost;
        //TODO REMOVE
       /* print_r($_SERVER['REQUEST_URI']);
        $testUri = urlencode($_SERVER['REQUEST_URI']);
        print_r('n1' . $testUri);
        print_r('n2' . urldecode($testUri));*/
        $this->_filteredUri = array_slice(explode('/', urldecode(filter_var(urlencode($_SERVER['REQUEST_URI']),FILTER_SANITIZE_URL))), 0);

    }
    // $key = int , @param, if is_int filtered[0]
    public function getFilteredUri($key=null) {
        if ($key === null)                          return $this->_filteredUri;
        if (isset($this->_filteredUri[$key]))       return $this->_filteredUri[$key];
        return null;
    }
    public function getFilteredPost($key=null) {
        if (!isset($this->_filteredPost))      $this->_filteredPost = filter_input_array(trim(INPUT_POST), $this->_argsPost , $this->_add_empty);
        if ($key === null)                     return $this->_filteredPost;
        if (isset($this->_filteredPost[$key])) return $this->_filteredPost[$key];
        return null;
    }
    public function getFilteredGet($key=null) {
        if (!isset($this->_filteredGet))       $this->_filteredGet = filter_input_array(INPUT_GET, $this->_argsGet, $this->_add_empty);
        if ($key === null)                     return $this->_filteredGet;
        if (isset($this->_filteredGet[$key]))  return $this->_filteredGet[$key];
        return null;
    }
}