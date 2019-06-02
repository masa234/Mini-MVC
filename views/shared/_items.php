<span class= "h1 blue-line"><?= $this->h( MESSAGE ) ?></div>

<?php foreach ( $items as $item ): ?>
    <div class="col-md-4">
        <?php $item_image = "images/" . $item['img']; ?>
        <?php if ( file_exists( $item_image ) && ! is_dir( $item_image ) ): ?>
        <img src="<?= $this->h ( $item_image ) ?>" class="mr-2 rounded-circle user-image">
        <?php endif; ?>
        <a class="text-dark">@<?= $this->h( $item['user_name'] ) ?></a>
    </div>
<?php endforeach; ?>