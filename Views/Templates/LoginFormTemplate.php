<?php


class LoginFormTemplate extends ViewUser
{
    private $_message;
    public function __construct($message)
    {
        parent::__construct();
        print_r('CHACHA');
        $this->_message = $message;
        print_r('CHACHA');
        echo $this->_formBuilder();
    }

    private function _formBuilder() {
        ob_start();
        ?>
            <div class="py-5" style="background-image: url('../../Vendor/assets/styleguide/cover-stripes.svg'); background-position:left center; background-size: cover;">
                <div class="container">
                    <div class="row">
                        <div class="p-5 col-lg-6 bg-primary d-flex flex-column align-items-center text-center">
                            <h1>Je suis tellement content, mon petit chou.</h1>
                            <p class="mb-3">Tellement absorbé par le sens excquis de la simple existence, que j'en néglige mes talents.</p>
                            <form class="w-100" method="post" action="Login?submit=true">
                                <div class="form-group"> <input type="text" class="form-control" placeholder="Entrez votre e-mail ou votre pseudo" id="form11" name="user_identifier"> </div>
                                <div class="form-group"> <input type="password" class="form-control" placeholder="Mot de passe" id="form12" name="user_password"> <small class="form-text text-muted text-right">
                                        <a href="User&Forgot"> Avez vous oublié votre mot de passe?</a>
                                    </small> </div> <button type="submit" class="btn btn-light align-items-center justify-content-center">Envoyer</button>
                            </form>
                            <p id="messageBox" class="form-text text-danger text-center"><?= $this->_message ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        return ob_get_clean();
    }
}