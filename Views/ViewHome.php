<?php

class ViewHome extends View {

    protected const FILE_TITLE = "Accueil";
    protected const CARD_TEXT_CONTENT = "A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart. I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine.";
    protected const HEADER = '/Views/Templates/headerTemplate.php';

    public function __construct()
    {
    }



}



/*foreach ($posts as $post) : ?>
<p><?= 'Hey' ?></p>
<?php print_r($post) ?>
<?= 'Je crois'?>

<?= $post->title() ?>
><?= $post->date_creation() ?>

<?= 'Que ca marche'?>
<?php endforeach; ?>*/
