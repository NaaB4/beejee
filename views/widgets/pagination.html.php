<?php if ($pages > 1): ?>

<nav>
	<ul class="pagination justify-content-center">
		<?php for($i = 0; $i < $pages; $i++): ?>
			<li class="page-item <?= ($i + 1) == $currentPage ? "disabled" : "" ?>"><a class="page-link" href="?page=<?= $i + 1 ?><?= $_r->sort ? "&sort=" . $_r->sort : "" ?>"><?= $i + 1 ?></a></li>
		<?php endfor; ?>
	</ul>
</nav>

<?php endif; ?>