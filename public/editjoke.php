<?php
include __DIR__ . '/../includes/DatabaseConnection.php';
include __DIR__ . '/../classes/DatabaseTable.php';

$jokesTable = new DatabaseTable($pdo, 'joke', 'id');

try {
  //форма отправлена - обновляю запись
  if (isset($_POST['joke'])) {
    $joke = $_POST['joke'];
    $joke['jokedate'] = new DateTime();
    $joke['authorId'] = 1;
    $jokesTable->save($joke);

    header('location: jokes.php');  
  }
  else {
    // переход по ссылке для редактирования
    if(isset($_GET['id'])) {
      $joke = $jokesTable->findById($_GET['id']);
    }
    
    $title = 'редактировать шутку';
    ob_start();
    include  __DIR__ . '/../templates/editjoke.html.php';
    $output = ob_get_clean();
  }
}
catch (PDOException $e) {
  $title = 'произошла ошибка';
  $output = 'ошибка бд: ' . $e->getMessage() . ' в ' .
  $e->getFile() . ':' . $e->getLine();
}

include  __DIR__ . '/../templates/layout.html.php';