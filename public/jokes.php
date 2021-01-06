<?php
try{
  include __DIR__ . '/../includes/DatabaseConnection.php';
  include __DIR__ . '/../includes/DatabaseFunctions.php';
  // получаю массив с шутками
  $result = findAll($pdo, 'joke');

  $jokes = [];

  foreach($result as $joke) {
    $author = findById($pdo, 'author', 'id', $joke['authorid']);
    // добавляю в jokes массив с данными о шутке и авторе
    $jokes[] = [
      'id' => $joke['id'],
      'joketext' => $joke['joketext'],
      'jokedate' => $joke['jokedate'],
      'name' => $author['name'],
      'email' => $author['email']
    ];
  }

  $title = 'список шуток';
  $totalJokes = total($pdo, 'joke');

  ob_start();
  include __DIR__ . '/../templates/jokes.html.php';
  $output = ob_get_clean();
}
catch (PDOException $e) {
  $title = 'произошла ошибка';
  $output = 'ошибка бд: ' . $e->getMessage() . '
  в ' . $e->getFile() . ':' . $e->getLine();
}

include __DIR__ . '/../templates/layout.html.php';