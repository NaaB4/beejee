<?php

use app\models\Users;
use app\components\widgets\Pagination;

?>


<div class="mb-3 dropdown">
	<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Сортировка
	</button>
	<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
		<a class="dropdown-item" href="?sort=name__asc">Имя пользователя ▲</a>
		<a class="dropdown-item" href="?sort=name">Имя пользователя ▼</a>
		<a class="dropdown-item" href="?sort=email__asc">E-mail ▲</a>
		<a class="dropdown-item" href="?sort=email">E-mail ▼</a>
		<a class="dropdown-item" href="?sort=completed__asc">Статус ▲</a>
		<a class="dropdown-item" href="?sort=completed">Статус ▼</a>
	</div>
</div>

<?php if(!empty($tasks)): ?>

<div class="col-md-12 order-md-2 mb-4">
	<h4 class="d-flex justify-content-between align-items-center mb-3">
		<span class="text-muted">Все задачи</span>
	</h4>
	<ul class="list-group mb-3">
		<?php foreach($tasks as $task): ?>
			<li class="list-group-item justify-content-between lh-condensed">
				<div class="task">
					<h5 class="my-0 d-inline-block justify-content-between">
						<span class="task_status">
							<?php if($task["completed"] == 1): ?>
								✓
							<?php endif; ?>
						</span>
						<?= $task["name"] ?>
					</h5>
					<small class="text-muted">(<a href="mailto:<?= $task["email"] ?>"><?= $task["email"] ?></a>)</small>
					<?php if(Users::isAdmin()): ?>
						<small class="text-muted float-right pl-1 pr-1">
							<a class="task__change-status" data-id="<?= $task["id"]; ?>" data-current_status="<?= $task["completed"] ?>" href="/admin/task/edit/<?= $task["id"]; ?>"> 
								<?= $task["completed"] == 1 ? TASK["msg"]["not_completed"] : TASK["msg"]["completed"] ?>
							</a>
						</small>
						<small class="text-muted float-right pl-1 pr-1"><a href="/admin/task/edit/<?= $task["id"]; ?>"><?= TASK["msg"]["edit"] ?></a></small>
					<?php endif; ?>
				</div>
				<span class="text-muted d-block"><?= $task["text"] ?></span>
				<?php if($task["modified"] == 1): ?>
					<hr/>
					<small class="text-muted">🖊 изменено администратором</small>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ul>
</div>

<?php else: ?>

    Задачи не найдены

<?php endif; ?>

<?= $paginationHtml; ?>