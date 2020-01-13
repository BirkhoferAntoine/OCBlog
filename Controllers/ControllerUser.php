<?php


class ControllerUser
{
    private $_usersManager;
    private $_view;
    private $_panel;
    private $_safeUri;
    private $_safeGet;

    public function __construct($url)
    {
        if (empty($url) || count($url) > 1) {
            throw new Exception('404 Page ' . htmlspecialchars($url) . ' introuvable');
        } else {

            $this->_setSecurity();

            if ($this->_safeUri === 'Panel' && isset($_SESSION['username'])) {

                if ($_SESSION['level'] === '1') {
                    $this->_panel = new ControllerAdminPanel();
                }

            } else {
                $this->_buildForm();
            }
        }
    }

    private function _buildForm() {
        $this->_usersManager = new UsersManager();

        if (isset($this->_safeGet['submit'])) {
            $this->_usersManager->submit();
        }

        $message = $this->_usersManager->getMessageText();
        $this->_view = new ViewUser;
        $this->_view->generate($this->_safeUri, $message);
    }

    private function _setSecurity() {
        global $security;
        $this->_safeUri = explode('?', $security->getFilteredUri(2))[0];
        $this->_safeGet = $security->getFilteredGet();
    }
}