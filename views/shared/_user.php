<div class="list-group">
<div class="card flex-md-row mb-3 h-md-250 list-group-item" style="display: flex; padding:0;">
    <div class="card-body d-flex flex-column align-items-start">
        <h3 class="mb-0">
            <?php $user_image = "../images/" . $user['img'] ?>
            <?php if ( file_exists( $user_image ) && ! is_dir( $user_image ) ): ?>
            <img src="<?= $this->h ( $user_image ) ?>" class="mr-2 rounded user-img">
            <?php endif; ?>
        <a class="text-dark">@<?= $this->h( $user['user_name'] ) ?></a>
        </h3>
    </div>
    <div class="flex-auto d-none d-lg-block btn-group" role="group" style="margin: auto 1.5em;">
    <?php $user_model = new User ?>
    <?php if ( ! $user_model->is_Mine( $user['id'] )
          &&  $this->session->is_Admin()  ): ?>
    <form method="POST" action = "<?= $this->h( $this->app_path ) ?>/users/delete/<?= $this->h( $user['id'] ) ?>" onsubmit="return check();">
    <input type="hidden" name="user_id" value="<?= $this->h( $user['id'] ) ?>"/>
    <button type="submit" class="btn btn-danger" name= "action">削除</button>
    <?php endif; ?>
</div>
</div>