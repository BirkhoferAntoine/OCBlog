<?php

    // Classe View des formulaires de connexion et d'inscription

class ViewUser extends View
{
    private $_title = "User";
    private $_message;

    /**
     * ViewUser constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return LoginFormTemplate
     */
    protected function generateLoginForm() {
        $this->_title = "Connexion";
        return new LoginFormTemplate($this->_message);
    }

    /**
     * @return RegisterFormTemplate
     */
    protected function generateRegisterForm() {
        $this->_title = "Inscription";
        return new RegisterFormTemplate($this->_message);
    }

    /**
     * Fonction optionelle de génération de formulaire de récupération de mots de passe; non intégrée
     *
     * @return string
     */
    protected function generateForgotForm() {
        $this->_title = "Récupération de mot de passe";
        return 'new ForgotFormTemplate($this->_message)';
    }

    /**
     * @param $form
     * @return false|string
     * @throws Exception
     */
    protected function generateContent($form)
    {
        $formGen = 'generate' . ucfirst($form) . 'Form';
        if (method_exists($this, $formGen)) {
            ob_start();

            $this->$formGen();

            return ob_get_clean();
        } else {
            throw new Exception('404 Formulaire ' . $formGen . ' introuvable');
        }
    }

    /**
     * @param $form
     * @param $message
     * @throws Exception
     * @return void
     */
    public function generate($form, $message) {

        // Récupère le contenu
        $this->_message = $message;

        $viewContent = $this->generateContent($form);

        if ($this->_title !== null) {
            $fileTitle = $this->_title;
        }
        // Incrémentation du template
        $view = $this->generateFile(TEMPLATE_PATH, array('fileTitle' => $fileTitle, 'viewContent' => $viewContent));

        echo $view;
    }


}