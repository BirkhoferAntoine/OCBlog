

<!DOCTYPE html>
    <html lang="fr">
<head>
    <meta charset=UTF-8>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Blog Ecrivain">
    <meta name="keywords" content="Openclassrooms Blog Ecrivain Jean Forteroche">
    <meta name="author" content="Antoine Birkhofer">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="../Vendor/wireframe.css">
    <link rel="stylesheet" href="../Public/css/style.css">

    <script defer src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script defer src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous" style=""></script>

    <title><?= $preViews_fileTitle ?> Jean Forteroche Blog</title>

    <?php
    require_once('Templates/navbarTemplate.php');

    require_once('Templates/footerTemplate.php');
    ?>

</head>
<body>


    <?php echo $navbarTemplate?>

    <?php echo $preViews_viewContent ?>

    <?php echo $footerTemplate ?>


</body>

    </html>