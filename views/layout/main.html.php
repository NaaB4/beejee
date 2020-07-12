<?php
use app\blocks\rightBlock;
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $title ?? "задачник" ?></title>
	<link rel="stylesheet" href="/assets/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<div class="py-5 text-center">
			<h1><a href="/">BeJee</a> - <?= $title ?? "задачник" ?></h1>
		</div>
		<div class="row">
			<div class="col-md-4 order-md-2 mb-4">
				<?= (new rightBlock)->render() ?>
			</div>
			<div class="col-md-8 order-md-1">
				<?= $content ?? "" ?>
			</div>
		</div>
	</div>
</div>

<script src="/assets/js/jquery.js"></script>
<script src="/assets/js/popper.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/main.js"></script>

</body>
</html>