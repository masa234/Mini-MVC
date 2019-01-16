
<?php $page = $this->request->get_Get( 'page' ) ?>

<ul class="pagination pagination-lg">
    <?php for ( $p = 1; $p <= $max_page; $p++ ): ?>
        <?php if ( $p != $page ): ?>
        <li class="page-item">
        <?php else: ?>
        <li class="page-item disabled">
        <?php endif; ?>
            <a class="page-link" href="?page=<?= $p ?>"><?= $p; ?></a>
        </li>
    <?php endfor; ?> 
</ul>