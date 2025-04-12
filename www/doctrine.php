<?php
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Psr16Cache;

require_once __DIR__ . '/../vendor/autoload.php';

// Configuration de la connexion PostgreSQL
$dbParams = [
    'driver'   => 'pdo_pgsql',
    'user'     => 'myuser',
    'password' => 'mypassword',
    'dbname'   => 'mydatabase',
    'host'     => 'postgres', // Correspond au service PostgreSQL dans docker-compose
    'port'     => '5432',
];

// Configuration du cache avec Symfony
$cache = new Psr16Cache(new ArrayAdapter());

$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: [__DIR__ . '/../src/Entity'],
    isDevMode: true,
    cache: $cache
);

// Création de l'EntityManager
try {
    $entityManager = new EntityManager(DriverManager::getConnection($dbParams), $config);
    echo "✅ Connexion réussie à PostgreSQL via Doctrine !";
} catch (\Exception $e) {
    echo "❌ Erreur de connexion : " . $e->getMessage();
}
