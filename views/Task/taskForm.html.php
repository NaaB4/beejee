<?php 
use app\components\Form;

$task = $task ?? NULL;
$edit = $edit ?? NULL;
?>


<div class="alert alert-success" role="alert" style="display: none;">
   	<?= $isTaskAdded ?>
</div>

<?php $form = Form::init($errors, $task); ?>
<form id="pAjax" data-pajax="<?= !$edit ? "new-task" : "edit-task/".$task["id"] ?>" method="post">
	<div class="col-md-12 order-md-1">
		<h4 class="mb-3">Новая задача</h4>
			<div class="row">
				<div class="col-md-6 mb-3">
					<?= $form->input(["name" => "name", "label" => "Имя пользователя"]) ?>
				</div>
				<div class="col-md-6 mb-3">
					<?= $form->email(["name" => "email", "label" => "E-mail"]) ?>
				</div>
			</div>
			<div class="mb-3">
				<?= $form->textarea(["name" => "text", "label" => "Текст задачи"]) ?>
			</div>

			<?php if($edit): ?>
				<div class="mb-3 form-check">
					<?= $form->checkbox(["name" => "completed", "label" => "Задача завершена"]) ?>
				</div>
			<?php endif; ?>



			<button class="btn btn-primary btn-lg btn-block" name="sendform" type="submit"><?= $edit ? "Изменить задачу" : "Создать задачу" ?></button>
		</div>
	</form>