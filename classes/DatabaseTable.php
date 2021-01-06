<?php
class DatabaseTable {
private $pdo;
private $table;
private $primaryKey;

public function __construct(PDO $pdo, string $table, string $primaryKey) {
  $this->pdo = $pdo;
  $this->table = $table;
  $this->primaryKey = $primaryKey;
}
/* 
выполняю подготовленный запрос к бд

параметры:
$pdo - подключение к бд,
$sql - запрос
$parameters - массив параметров, по умолчанию пустой

возвращает результат
*/
private function query($sql, $parameters = []) {
  $query = $this->pdo->prepare($sql);
  $query->execute($parameters);
  return $query;
}
// подсчитываю количество записей
public function total() {
  $query = $this->query('SELECT COUNT(*) FROM `' . $this->table . '`');
  $row = $query->fetch();

  return $row[0];
}
// нахожу запись по id
public function findById($value) {
  $query = 'SELECT * FROM `' . $this->table . '`
  WHERE `' . $this->primaryKey . '` = :value';
  $parameters = [
    'value' => $value
  ];
  $query = $this->query($query, $parameters);

  return $query->fetch();
}
//вставляет данные в таблицы
private function insert($fields) {
  $query = 'INSERT INTO `' . $this->table . '` (';

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

  $fields = $this->processDates($fields);

  $this->query($query, $fields);
}
//обновляет данные в таблицах
private function update($fields) {
  $query = 'UPDATE `' . $this->table . '` SET ';

  foreach($fields as $key => $value) {
    $query .= '`' . $key . '` = :' . $key . ',';
  }

  $query = rtrim($query, ',');

  $query .= ' WHERE `' . $this->primaryKey . '` = :primaryKey';
  //устанавливаю первичный ключ
  $fields['primaryKey'] = $fields['id'];
  
  $fields = $this->processDates($fields);

  $this->query($query, $fields);
}
// удаление записей из таблиц
public function delete($id ) {
  $parameters = [':id' => $id];

  $this->query('DELETE FROM `' . $this->table . '` WHERE `' . $this->primaryKey . '` = :id', $parameters);
}
//поиск конкретных записей по таблицам
public function findAll() {
  $result = $this->query('SELECT * FROM `' . $this->table . '`');

  return $result->fetchAll();
}
//форматирую дату для таблицы
private function processDates($fields) {
  foreach ($fields as $key => $value) {
    if ($value instanceof DateTime) {
      $fields[$key] = $value->format('Y-m-d');
    }
  }
  return $fields;
}
//экранирование HTML
public function htmlEscape($string) {
  return htmlspecialchars($string, ENT_HTML5, 'UTF-8');
}
//выполняет вставку или обновление в таблицы
public function save($record) {
  try {
    if($record[$this->primaryKey] == '') {
      $record[$this->primaryKey] = null;
    }
    $this->insert($record);
  }
  catch(PDOException $e) {
    $this->update($record);
  }
}


}