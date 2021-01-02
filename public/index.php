<?php
// устанавливаю тайтл страницы
$title = 'база данных интернет-шуток';
// включаю буферизацию ввода
ob_start();
// подключаю шаблон с заголовком и описанием
include  __DIR__ . '/../templates/home.html.php';
// передаю вывод в переменную
$output = ob_get_clean();
// подключаю основной шаблон, где вывожу $output
include  __DIR__ . '/../templates/layout.html.php';