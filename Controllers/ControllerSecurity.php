<?php


    /**
     * *
 *  sessionhandlerinterface
 * trim before filter
 * mysql_real_escape_string()
 *      // post donc faut vérifier token
 *
 *
     */
//TODO ARGS()
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

        $this->_argsGet = $argsGet; $this->_argsPost = $argsPost;
        $this->_filteredUri = array_slice(explode('/', filter_var($_SERVER['REQUEST_URI'],FILTER_SANITIZE_URL)), 0);

    }
    // $key = int , @param, if is_int filtered[0]
    public function getFilteredUri($key=null) {
        if ($key === null)                          return $this->_filteredUri;
        if (isset($this->_filteredUri[$key]))       return $this->_filteredUri[$key];
        $this->errorManager->log($key . 'n\'est pas une valeur valide pour l\'uri filtrée');
        return null;
    }
    public function getFilteredPost($key=null) {
        if (!isset($this->_filteredPost))      $this->_filteredPost = filter_input_array(trim(INPUT_POST), $this->_argsPost , $this->_add_empty);
        if ($key === null)                     return $this->_filteredPost;
        if (isset($this->_filteredPost[$key])) return $this->_filteredPost[$key];
        $this->errorManager->log($key . ' n\'est pas planifié dans les filtres ControllerSecurity Post');
        return null;
    }
    public function getFilteredGet($key=null) {
        if (!isset($this->_filteredGet))       $this->_filteredGet = filter_input_array(INPUT_GET, $this->_argsGet, $this->_add_empty);
        if ($key === null)                     return $this->_filteredGet;
        if (isset($this->_filteredGet[$key]))  return $this->_filteredGet[$key];
        $this->errorManager->log($key . ' n\'est pas planifié dans les filtres ControllerSecurity Get');
        return null;
    }
}