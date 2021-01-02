<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?=$title?></title>
</head>
<body>
<nav>
  <header>
    <h1>база данных интернет-шуток</h1>
  </header>
  <ul>
    <li><a href="index.php">главная</a></li>
    <li><a href="jokes.php">список шуток</a></li>
    <li><a href="addjoke.php">добавить шутку</a></li>
  </ul>
</nav>
<main>
  <?=$output?>
</main>
<footer>
&copy; БДИШ <?= date('Y'); ?>
</footer>
</body>
</html>