<?php

/**
 * Class ControllerSecurity
 */
class ControllerSecurity
{
    private $_add_empty;
    private $_filteredUri;
    private $_filteredPost;
    private $_filteredGet;


    /**
     * ControllerSecurity constructor.
     * @param array $argsGet
     * @param array $argsPost
     * @return void
     */
    public function __construct($argsGet, $argsPost)
    {
        $this->_init($argsGet, $argsPost);
    }

    /**
     * @param array $argsGet
     * @param array $argsPost
     * @return void
     */
    private function _init($argsGet, $argsPost) {
        $this->_argsGet = $argsGet;
        $this->_argsPost = $argsPost;

        $this->_filteredUri = array_slice(explode('/', filter_var($_SERVER['REQUEST_URI'],FILTER_SANITIZE_URL)), 0);
        $index = count($this->_filteredUri) - 1;
        $this->_filteredUri[$index] = urldecode($this->_filteredUri[$index]);
    }

    // $key = int , @param, if is_int filtered[0]

    /**
     * @param null $key
     * @return mixed|null
     */
    public function getFilteredUri($key=null) {
        if ($key === null)                          return $this->_filteredUri;
        if (isset($this->_filteredUri[$key]))       return $this->_filteredUri[$key];
        return null;
    }

    /**
     * @param null $key
     * @return mixed|null
     */
    public function getFilteredPost($key=null) {
        if (!isset($this->_filteredPost))      $this->_filteredPost = filter_input_array(trim(INPUT_POST), $this->_argsPost , $this->_add_empty);
        if ($key === null)                     return $this->_filteredPost;
        if (isset($this->_filteredPost[$key])) return $this->_filteredPost[$key];
        return null;
    }

    /**
     * @param null|string $key
     * @return mixed|null
     */
    public function getFilteredGet($key=null) {
        if (!isset($this->_filteredGet))       $this->_filteredGet = filter_input_array(INPUT_GET, $this->_argsGet, $this->_add_empty);
        if ($key === null)                     return $this->_filteredGet;
        if (isset($this->_filteredGet[$key]))  return $this->_filteredGet[$key];
        return null;
    }
}