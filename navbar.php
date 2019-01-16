<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>App</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- GoogleMapApi 3wordsApi -->
    <script>
      var wordkey = "";
    </script>
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=&libraries=places"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href= "<?= $this->h ( $this->app_path ) ?>/css/dashboard.css" rel="stylesheet">
    <link href= "<?= $this->h ( $this->app_path ) ?>/css/style1.css" rel="stylesheet">
    <link href= "<?= $this->h ( $this->app_path ) ?>/css/auther2.css" rel="stylesheet">
    <style>
      .container-fluid {
        padding-top: 50px !important; 
      }
    </style>
  </head>
  
  <body>
    <!-- Sidebar navigation-->
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Management App</a>
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="<?= $this->h ( $this->app_path ) ?>/signout">サインアウト</a>
        </li>
      </ul>
    </nav>

    <?php $path = $this->request->get_pathinfo(); ?>
    
    <div class="container-fluid">
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