<?php 
use app\components\Form;

?>

<?php $form = Form::init($errors); ?>
  <form id="pAjax" data-pajax="login" method="post" class="px-4 py-3">
    <div class="form-group">
      <?= $form->input(["name" => "name", "label" => "Имя пользователя"]) ?>
    </div>
    <div class="form-group">
      <?= $form->input(["name" => "password", "label" => "Пароль", "type" => "password"]) ?>
    </div>
    <button type="submit" name="sendform" class="btn btn-primary">Войти</button>
  </form>