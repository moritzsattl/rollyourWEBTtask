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


    $variables['search'] = $_GET['search'];
    console_log($variables['search']);

    $stmt->bindValue(1,$value);
    $stmt->bindValue(2,$value);
    $stmt->bindValue(3,$value);
    $stmt->execute();
    $artpieces = $stmt->fetchAll();

    $variables['artpieces'] = $artpieces;

    $sql2 = "SELECT MNAME FROM museums ORDER BY MNAME;";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->execute();
    $museums = $stmt2->fetchAll();

    $variables['museums'] = $museums;

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

if(isset($_REQUEST['format']) && $_REQUEST['format'] == 'JSON'){
    $museum = $_REQUEST['filter'] == "" ? '%' : $_REQUEST['filter'];
    $orderby = $_REQUEST['sort'] == 'A - Z' ? "ASC": "DESC";

    $doc = new DOMDocument('1.0', 'UTF-8');
    $sql3 = "SELECT * FROM artpieces INNER JOIN artists a on artpieces.FK_PK_ARTIST = a.PK_ARTIST INNER JOIN museums m on artpieces.FK_PK_MUSEUM = m.PK_MUSEUM INNER JOIN epochs e on a.FK_PK_EPOCH = e.PK_EPOCH WHERE artpieces.ARTNAME LIKE :search OR a.ANAME LIKE :search OR m.MNAME LIKE :search HAVING m.MNAME LIKE :museum ORDER BY ARTNAME ASC";
    $stmt3 = $conn->prepare($sql3);
    $stmt3->bindValue(':search','%'.$_REQUEST['searchterm'].'%');
    $stmt3->bindValue(':museum',$museum);
    //$stmt3->bindParam(':order',$orderby,\Doctrine\DBAL\ParameterType::STRING);
    $artlocator = $doc->createElement('artlocator');
    $doc->appendChild($artlocator);
    $stmt3->execute();
    foreach ($stmt3 as $row) {
        $artpiece = $doc->createElement('artpiece');
        $artlocator->appendChild($artpiece);
        $artpiece->appendChild($doc->createElement("PK_ARTPIECE", $row['PK_ARTPIECE']));
        $artpiece->appendChild($doc->createElement("ARTNAME", $row['ARTNAME']));
        $artpiece->appendChild($doc->createElement("YEAR", $row['YEAR']));
        $artpiece->appendChild($doc->createElement("ARTPICTURE", $row['ARTPICTURE']));
        $artpiece->appendChild($doc->createElement("DESCRIPTION", $row['DESCRIPTION']));

        $museum = $doc->createElement('museum');
        $artpiece->appendChild($museum);
        $museum->appendChild($doc->createElement("PK_MUSEUM", $row['PK_MUSEUM']));
        $museum->appendChild($doc->createElement("MNAME", $row['MNAME']));
        $museum->appendChild($doc->createElement("LOGO", $row['LOGO']));
        $museum->appendChild($doc->createElement("POSTALCODE", $row['POSTALCODE']));
        $museum->appendChild($doc->createElement("PLACE", $row['PLACE']));
        $museum->appendChild($doc->createElement("STREET", $row['STREET']));
        $museum->appendChild($doc->createElement("HOUSENUMBER", $row['HOUSENUMBER']));
        $museum->appendChild($doc->createElement("COUNTRY", $row['COUNTRY']));


        $artist = $doc->createElement('artist');
        $artpiece->appendChild($artist);
        $artist->appendChild($doc->createElement("PK_ARTIST", $row['PK_ARTIST']));
        $artist->appendChild($doc->createElement("ANAME", $row['ANAME']));
        $artist->appendChild($doc->createElement("APICTURE", $row['APICTURE']));
        $artist->appendChild($doc->createElement("BIRTHDATE", $row['BIRTHDATE']));
        $artist->appendChild($doc->createElement("DEATHDATE", $row['DEATHDATE']));
        $artist->appendChild($doc->createElement("BIOGRAPHY", $row['BIOGRAPHY']));

        $epoch = $doc->createElement('epoch');
        $artist->appendChild($epoch);

        $epoch->appendChild($doc->createElement("PK_EPOCH", $row['PK_EPOCH']));
        $epoch->appendChild($doc->createElement("ENAME", $row['ENAME']));
        $epoch->appendChild($doc->createElement("FROM", $row['FROM']));
        $epoch->appendChild($doc->createElement("TO", $row['TO']));
        $epoch->appendChild($doc->createElement("DESCRIPTION", $row['DESCRIPTION']));





    }
    echo '<a href="resources/public/xml/artpieces.xml" download="artpieces">';
    $doc->saveHTMLFile("resources/public/xml/artpieces.xml");
    $xml = simplexml_load_file("resources/public/xml/artpieces.xml");
    $xml->saveXML("resources/public/xml/artpieces.xml");

    die;

}



