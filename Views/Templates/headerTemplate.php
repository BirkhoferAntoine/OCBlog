<?php

class Header {

    private $_headerContent = '';


}

ob_start();
?>

<header>

    <?php



    ?>

</header>

<?php
$headerTemplate = ob_get_clean();

?>
