<?php
include '../includes/errorHandler.proc.php';
require_once '../dataBase/dbConnect.php';

// Obtenir tots els articles
if ($_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_GET['order']) && !isset($_GET['art_id'])) {
    $resultats = $db->query("SELECT * FROM articles ORDER BY art_titol");
    while ($row = $resultats->fetchArray(SQLITE3_ASSOC))
        $articles[] = $row;
    header('Content-Type: application/json');
    echo json_encode($articles);
}
// Obtenir tots els articles 
elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['order'])){
    if($_GET['order'] == "desc") $order= "DESC";
    else $order = "ASC";
    $resultats = $db->query("SELECT * FROM articles ORDER BY art_titol $order");
    while ($row = $resultats->fetchArray(SQLITE3_ASSOC)){
        $articles[]=$row;
    } 
    header('Content-Type: application/json');
    echo json_encode($articles);
}

//Obtenir articles per ID
elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['art_id'])) {
    $id = $_GET['art_id'];
    $stmt = $db->prepare("SELECT * FROM articles WHERE art_id = :id");
    $stmt->bindValue(':id',$id,SQLITE3_INTEGER);
    $resultats = $stmt->execute();
    $articles = $resultats->fetchArray(SQLITE3_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($articles);
}


?>