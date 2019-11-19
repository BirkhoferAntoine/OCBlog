<?php


class RegisterFormTemplate extends ViewUser
{
    public function __construct()
    {
        parent::__construct();

        echo $this->_formBuilder();
    }
    private function _testInput($input) {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }
    private function _submitInfo() {
        if (isset($_POST)) {
            var_dump($_POST);
            print_r('sukses!');
        } else {
            print_r('FAIL');
        }
    }

    private function _formBuilder() {
        ob_start();
        ?>
        <div class="py-5" style="background-image: url('https://static.pingendo.com/cover-stripes.svg'); background-position:right center; background-size: cover;">
            <div class="container">
                <div class="row">
                    <div class="p-5 col-lg-6 bg-primary d-flex flex-column align-items-center text-center">
                        <h1>Je suis tellement content, mon petit chou.</h1>
                        <p class="mb-3">Tellement absorbé par le sens excquis de la simple existence, que j'en néglige mes talents.</p>
                        <form class="w-100" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <div class="form-group"> <input type="text" class="form-control" placeholder="Entrez votre pseudo" id="form11" name="nickname" required> </div>
                            <div class="form-group"> <input type="email" class="form-control" placeholder="E-mail" id="form12" name="email" required> </div>
                            <div class="form-group"> <input type="password" class="form-control" placeholder="Mot de passe" id="form21" name="password1" required></div>
                            <div class="form-group"> <input type="password" class="form-control" placeholder="Confirmez votre mot de passe" id="form22" name="password2" required></div>

                            <button type="submit" class="btn btn-light align-items-center justify-content-center">Envoyer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}