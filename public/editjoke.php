<?php
include __DIR__ . '/../includes/DatabaseConnection.php';
include __DIR__ . '/../includes/DatabaseFunctions.php';

try {
  //форма отправлена - обновляю запись
  if (isset($_POST['joketext'])) {
    updateJoke($pdo, $_POST['jokeid'], $_POST['joketext'], 1);

    header('location: jokes.php');  
  }
  else {
    /*
      получаю запись из бд
      ид записи получаю по ссылке из списка шуток 
    */
    $joke = getJoke($pdo, $_GET['id']);

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