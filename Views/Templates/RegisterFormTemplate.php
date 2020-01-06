<?php


class RegisterFormTemplate extends ViewUser
{
    private $_message;
    public function __construct($message)
    {
        parent::__construct();

        $this->_message = $message;
        echo $this->_formBuilder();
    }

    private function _formBuilder() {
        ob_start();
        ?>
        <section id="registerPage" class="formPage">
        <div class="py-5" style="background-image: url('../../Vendor/assets/styleguide/cover-stripes.svg'); background-position:right center; background-size: cover;">
            <div class="container">
                <div class="row">
                        <div class="p-5 col-lg-6 bg-primary d-flex flex-column align-items-center text-center">
                            <h1>Je suis tellement content, mon petit chou.</h1>
                            <p class="mb-3">Tellement absorbé par le sens excquis de la simple existence, que j'en néglige mes talents.</p>
                            <form class="w-100" method="post" id="registerForm" action="Register?submit=true">
                                <div class="form-group"> <input type="text" class="form-control" placeholder="Entrez votre pseudo" id="form11" name="register_user_name" required> </div>
                                <div class="form-group"> <input type="email" class="form-control" placeholder="E-mail" id="form12" name="register_user_email" required> </div>
                                <div class="form-group"> <input type="password" class="form-control" placeholder="Mot de passe" id="form21" name="register_password" required></div>
                                <div class="form-group"> <input type="password" class="form-control" placeholder="Confirmez votre mot de passe" id="form22" name="register_confirm_password" required></div>

                                <button type="submit" class="btn btn-light align-items-center justify-content-center">Envoyer</button>
                            </form>
                            <p id="messageBox" class="form-text text-danger text-center"><?= $this->_message ?></p>
                        </div>
                </div>
            </div>
        </div>
        </section>
        <?php
        return ob_get_clean();
    }
}