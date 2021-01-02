<form method="post">
  <input type="hidden" name="jokeid" value="<?=$joke['id'];?>">
  <label for="joketext">текст шутки:</label>
  <br>
  <textarea id="joketext" name="joketext" rows="3" cols="40">
    <?=$joke['joketext']?>
  </textarea>
  <br>
  <input type="submit" value="сохранить">
</form>