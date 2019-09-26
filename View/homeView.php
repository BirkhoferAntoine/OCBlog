<?php

foreach ($posts as $post): ?>
<?= $post->title() ?>
<? $date_creation->date_creation() ?>

<?php endforeach; ?>
