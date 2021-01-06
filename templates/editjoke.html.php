<!-- 
  отправляю данные в POST как массив,
  изменив имена полей на поля вида joke[id]
 -->
<form method="post">
  <input type="hidden" name="joke[id]" value="<?=$joke['id'] ?? ''?>">
  <label for="joketext">текст шутки:</label>
  <br>
  <textarea id="joketext" name="joke[joketext]" rows="3" cols="40">
    <?=$joke['joketext'] ?? '';?>
  </textarea>
  <br>
  <input type="submit" value="сохранить">
</form>