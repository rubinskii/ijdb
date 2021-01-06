<?php
try {
  include __DIR__ . '/../includes/DatabaseConnection.php';
  include __DIR__ . '/../classes/DatabaseTable.php';

  $jokesTable = new DatabaseTable($pdo, 'joke', 'id');

  $jokesTable->delete($_POST['id']);

  header('location: jokes.php');
}
catch (PDOException $e) {
  $title = 'произошла ошибка';
  $output = 'невозможно подключиться к субд: ' . $e->getMessage() . ' в ' .
  $e->getFile() . ':' . $e->getLine();
}

include  __DIR__ . '/../templates/layout.html.php';