<?php


class UsersManager extends MainModel
{
    // Lien entre la BDD (MainModel) et le controller pour vérifier les données
    public function logIn($username, $password) {
        return $this->checkUserInfo(($username), $password);
    }

    public function getInfo() {
        print_r('TESTPOST');
        var_dump($_POST);
        print_r('TESTPOST');
    }

}
/*
<pre>
     <?php
     print_r($_SESSION);
     ?>
 </pre>

 <?php
        if (isset($_POST['passInput']))
        {
            $infoTxt = htmlspecialchars($_POST['passInput']);
            if ($infoTxt === "kangourou")
            {
                echo 'Patatate!';
            } else {
                echo 'Ehbahnon!';
            }

        }
     ?>*/