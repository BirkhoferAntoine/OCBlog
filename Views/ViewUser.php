<?php


class ViewUser extends View
{
    private $_title = "User";

    public function __construct()
    {
        parent::__construct();
    }

    protected function generateLoginForm() {
        $this->_title = "Connexion";
        return new LoginFormTemplate;
    }
    protected function generateRegisterForm() {
        $this->_title = "Inscription";
        return new RegisterFormTemplate;
    }
    protected function generateForgotForm() {
        $this->_title = "Récupération de mot de passe";
        return 'new ForgotFormTemplate';
    }

    public function generateContent($form)
    {
        $formTest1 = 'login';
        $formTest2 = 'register';
        $formTest3 = 'forgot';

        ob_start();
        switch ($form) {
            case ($formTest1) :
                print_r($this->generateLoginForm());
                break;
            case ($formTest2) :
                print_r($this->generateRegisterForm());
                break;
            case ($formTest3) :
                print_r('WHAT YA FORGOT YAR PASSWURD?');
                print_r($this->generateForgotForm());
                break;
            default :
                throw new Exception('404 Page User ' . filter_var($form, FILTER_SANITIZE_URL) . ' introuvable.');
                break;
        }
        return ob_get_clean();
    }

    public function generate($form) {

        // Récupère le contenu
        $viewContent = $this->generateContent($form);

        if ($this->_title !== null) {
            $fileTitle = $this->_title;
        }
        // Incrémentation du template
        $view = $this->generateFile(TEMPLATE_PATH, array('fileTitle' => $fileTitle, 'viewContent' => $viewContent));

        echo $view;
    }


}