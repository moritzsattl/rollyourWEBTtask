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




if(isset($_GET['search']) && !isset($_GET['painting']) && !isset($_GET['add'])){
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

if(isset($_GET['add'])){
    $sql = "SELECT * FROM museums ORDER BY MNAME;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $museums = $stmt->fetchAll();

    $variables['museums'] = $museums;

    $sql2 = "SELECT * FROM artists ORDER BY ANAME;";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->execute();
    $artists = $stmt2->fetchAll();

    $variables['artists'] = $artists;

    $view->assignMultiple($variables);

    echo $view->render('add');

}

if(!isset($_GET['add']) && !isset($_GET['search']) && !isset($_GET['painting'])){



    echo $view->render('home');
}
if(isset($_GET['store'])){
    console_log($_FILES['uploadPainting']);

    $info = pathinfo($_FILES['uploadPainting']['name']);
    $ext = $info['extension'];
    $newname = $_POST['name'].".".$ext;
    $path = 'resources/public/artworks/'.$newname;
    $path = 'resources/public/artworks/'.$newname;
    move_uploaded_file($_FILES['uploadPainting']['tmp_name'],$path);

    $sql = "INSERT INTO artpieces (ARTNAME, ALT, YEAR, ARTPICTURE, DESCRIPTION, FK_PK_ARTIST, FK_PK_MUSEUM) VALUES (:name,:alt,:year,:path,:description,:artist,:museum)";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':name',$_POST['name']);
    $stmt->bindValue(':year',$_POST['year']);
    $stmt->bindValue(':alt',$_POST['alt']);
    $stmt->bindValue(':path',$path);
    $stmt->bindValue(':description',$_POST['description']);
    $stmt->bindValue(':artist',$_POST['artist'],PDO::PARAM_INT);
    $stmt->bindValue(':museum',$_POST['museum'],PDO::PARAM_INT);
    $stmt->execute();


}
if(isset($_GET['painting'])){

    $sql = "SELECT * FROM artpieces INNER JOIN museums m on artpieces.FK_PK_MUSEUM = m.PK_MUSEUM INNER JOIN artists a on artpieces.FK_PK_ARTIST = a.PK_ARTIST INNER JOIN epochs e on a.FK_PK_EPOCH = e.PK_EPOCH WHERE artname = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1,$_GET['painting']);
    $stmt->execute();
    $painting = $stmt->fetch();
    $variables['painting'] = $painting;
    $view->assignMultiple($variables);


    echo $view->render('painting');
}



