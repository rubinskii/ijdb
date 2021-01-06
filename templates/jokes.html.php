<p>
  <?=$totalJokes?> шуток было добавлено в базу данных интернет-шуток
</p>
<!--
$jokes - массив с шутками из jokes.php
-->
<?php foreach($jokes as $joke): ?>
<blockquote>
  <p>
    <?=$joke['joketext']?>
    (
      автор: <a href="mailto:<?= $joke['email']?>">
        <?= $joke['name']; ?>
      </a>, добавлена <?php
        $date = new DateTime($joke['jokedate']);
        echo $date->format('d-m-Y');
      ?>
    )
    <a href="editjoke.php?id=<?=$joke['id']?>">редактировать</a>
    <form action="deletejoke.php" method="post">
      <input type="hidden" name="id" value="<?=$joke['id']?>">
      <input type="submit" value="удалить">
    </form>
  </p>
  <hr>
</blockquote>
<?php endforeach; ?>