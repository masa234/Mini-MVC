    <?php $path = $this->request->get_pathinfo(); ?>
    
    <div class="container-fluid position-relative">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <?php if ( ! $this->session->is_Authenticated() ): ?>
              <li class="nav-item">
                <a class="nav-link <?php print $current !=  'register' ? : "active"?>" href="<?= $this->h ( $this->app_path ) ?>/users/new">
                  <span data-feather="bar-chart-2"></span>
                  新規登録
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php print $current !=  'authenticate' ? : "active"?>" href="<?= $this->h ( $this->app_path ) ?>/login">
                  <span data-feather="bar-chart-2"></span>
                  ログイン
                </a>
              </li>
              <?php endif; ?>
            </ul>
          </div>
        </nav>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="http://code.createjs.com/easeljs-0.7.1.min.js"></script>
    <script type="text/javascript" src="../js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>
      feather.replace();

      function check(){

        if( window.confirm( 'Are you sure?' ) ){

          return true;

        } else{

          return false;

        }

      }

      function countLength( text, field, count ) {
      
        document.getElementById( field ).innerHTML = text.length;

      } 

    </script>