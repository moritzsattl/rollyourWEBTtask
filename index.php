<?php
require_once "vendor/autoload.php";

$view = new \TYPO3Fluid\Fluid\View\TemplateView();
$paths = $view->getTemplatePaths();
$paths->setTemplatePathAndFilename('./resources/private/templates/home.html');

$connectionParams = array(
    'dbname' => 'artgallery',
    'user' => 'root',
    'password' => '',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
);
$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);

$sql = "SELECT * FROM artpieces";
$stmt = $conn->prepare($sql);
$stmt->execute();
$artpieces = $stmt->fetchAll();

$variables['artpieces'] = $artpieces;
$view->assignMultiple($variables);

echo $view->render();