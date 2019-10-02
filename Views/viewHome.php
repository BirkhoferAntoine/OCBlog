<?php

class viewHome {

    private $_cardTextContent = "A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine.";
    private $_card;

    public function __construct()
    {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/Views/Templates/CardTemplate.php');
        //$this->_getHomeCard();

    }

    public function getCardTextContent(): string
    {
        return htmlspecialchars($this->_cardTextContent);
    }

    /*public function setHomeCardText() {
        $this->_card = new CardTemplate($this->_getCardTextContent());
        return print_r($this->_card);
    }*/



}



foreach ($posts as $post) : ?>
<p><?= 'Hey' ?></p>
<?php print_r($post) ?>
<?= 'Je crois'?>

<?= $post->title() ?>
><?= $post->date_creation() ?>

<?= 'Que ca marche'?>
<?php endforeach; ?>
