<?php
    use Doctrine\ORM\Tools\Setup;
    use Doctrine\ORM\EntityManager;
    use Doctrine\ORM\Tools\SchemaTool;
    use Doctrine\ORM\Mapping as ORM;

    // Autoloader de Composer
    require_once "vendor/autoload.php";

    echo 'Bonjour ! Oui';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mon projet</title>
  <!-- Inclure jQuery depuis un CDN -->
  <script src="/node_modules/jquery/dist/jquery.min.js"></script>
</head>
<body>
  <h1>Mon projet avec jQuery</h1>
  <script>
    $(document).ready(function() {
      console.log("jQuery est prêt !");
    });
  </script>
</body>
</html>
