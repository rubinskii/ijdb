<?php
// если отправлена форма - добавляю шутку
if (isset($_POST['joketext'])) {
  try {
    include __DIR__ . '/../includes/DatabaseConnection.php';
    include __DIR__ . '/../includes/DatabaseFunctions.php';
    /*
      передаю ид автора самостоятельно, так как функционал
      регистрации и входа на сайт не реализован
    */
    insertJoke($pdo, $_POST['joketext'], 1);
    // перенаправляю на главную
    header('location: jokes.php');
  }
  catch (PDOException $e) {
    $title = 'произошла ошибка';
    $output = 'ошибка бд: ' . $e->getMessage() . ' в ' .
    $e->getFile() . ':' . $e->getLine();
  }
}
else {
  $title = 'добавить новую шутку';
  ob_start();
  include  __DIR__ . '/../templates/addjoke.html.php';
  $output = ob_get_clean();
}

include  __DIR__ . '/../templates/layout.html.php';