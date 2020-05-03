<?php
require_once "vendor/autoload.php";

$view = new \TYPO3Fluid\Fluid\View\TemplateView();

$paths = $view->getTemplatePaths();
$paths->setTemplateRootPaths(array('./resources/private/templates/'));
$paths->setLayoutRootPaths(array('./resources/private/layouts/'));
$paths->setPartialRootPaths(array('./resources/private/partials/'));

$connectionParams = array(
    'dbname' => 'artgallery',
    'user' => 'root',
    'password' => '',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
);
$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);



if(isset($_GET['search'])){
    $sql = "SELECT * FROM artpieces INNER JOIN artists a on artpieces.FK_PK_ARTIST = a.PK_ARTIST INNER JOIN museums m on artpieces.FK_PK_MUSEUM = m.PK_MUSEUM WHERE artpieces.ARTNAME LIKE ? OR a.ANAME LIKE ? OR m.MNAME LIKE ?";
    $stmt = $conn->prepare($sql);
    $value = '%'.$_GET['search'].'%';
    $stmt->bindValue(1,$value);
    $stmt->bindValue(2,$value);
    $stmt->bindValue(3,$value);
    $stmt->execute();
    $artpieces = $stmt->fetchAll();

    $variables['artpieces'] = $artpieces;
    console_log($variables);
    $view->assignMultiple($variables);

    echo $view->render('search');
}else{
    echo $view->render('home');
}
function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
}



