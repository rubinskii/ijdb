<?php
/* 
выполняю подготовленный запрос к бд

параметры:
$pdo - подключение к бд,
$sql - запрос
$parameters - массив параметров, по умолчанию пустой

возвращает результат
*/
function query($pdo, $sql, $parameters = []) {
  $query = $pdo->prepare($sql);
  $query->execute($parameters);
  return $query;
}
// подсчитываю количество записей
function total($pdo, $table) {
  $query = query($pdo, 'SELECT COUNT(*) FROM `' . $table . '`');
  $row = $query->fetch();

  return $row[0];
}
// нахожу запись по id
function findById($pdo, $table, $primaryKey, $value) {
  $query = 'SELECT * FROM `' . $table . '`
  WHERE `' . $primaryKey . '` = :value';
  $parameters = [
    'value' => $value
  ];
  $query = query($pdo, $query, $parameters);

  return $query->fetch();
}
//вставляет данные в таблицы
function insert($pdo, $table, $fields) {
  $query = 'INSERT INTO `' . $table . '` (';

  foreach($fields as $key => $value) {
    $query .= '`' . $key . '`,';
  }

  $query = rtrim($query, ',');

  $query .= ') VALUES (';

  foreach($fields as $key => $value) {
    $query .= ':' . $key . ',';
  }

  $query = rtrim($query, ',');

  $query .= ')';

  $fields = processDates($fields);

  query($pdo, $query, $fields);
}
//обновляет данные в таблицах
function update($pdo, $table, $primaryKey, $fields) {
  $query = 'UPDATE `' . $table . '` SET ';

  foreach($fields as $key => $value) {
    $query .= '`' . $key . '` = :' . $key . ',';
  }

  $query = rtrim($query, ',');

  $query .= ' WHERE `' . $primaryKey . '` = :primaryKey';
  //устанавливаю первичный ключ
  $fields['primaryKey'] = $fields['id'];
  
  $fields = processDates($fields);

  query($pdo, $query, $fields);
}
// удаление записей из таблиц
function delete($pdo, $table, $primaryKey, $id ) {
  $parameters = [':id' => $id];

  query($pdo, 'DELETE FROM `' . $table . '` WHERE `' . $primaryKey . '` = :id', $parameters);
}
//поиск конкретных записей по таблицам
function findAll($pdo, $table) {
  $result = query($pdo, 'SELECT * FROM `' . $table . '`');

  return $result->fetchAll();
}
//форматирую дату для таблицы
function processDates($fields) {
  foreach ($fields as $key => $value) {
    if ($value instanceof DateTime) {
      $fields[$key] = $value->format('Y-m-d');
    }
  }
  return $fields;
}
//экранирование HTML
function htmlEscape($string) {
  return htmlspecialchars($string, ENT_HTML5, 'UTF-8');
}
//выполняет вставку или обновление в таблицы
function save($pdo, $table, $primaryKey, $record) {
  try {
    if($record[$primaryKey] == '') {
      $record[$primaryKey] = null;
    }
    insert($pdo, $table, $record);
  }
  catch(PDOException $e) {
    update($pdo, $table, $primaryKey, $record);
  }
}