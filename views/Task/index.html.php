<?php 
use app\components\Form;

?>

<?php if($isTaskAdded): ?>
<div class="alert alert-success" role="alert">
   	<?= $isTaskAdded ?>
</div>
<?php endif; ?>

<?= $taskForm ?? "" ?>

<?= $tasks ?>