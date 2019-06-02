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

    <!-- Custom styles for this template -->
    <link href= "<?= $this->h ( $this->app_path ) ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href= "<?= $this->h ( $this->app_path ) ?>/css/dashboard.css" rel="stylesheet">
    <link href="<?= $this->h( $this->app_path ) ?>/css/signin.css" rel="stylesheet">
    <link href= "<?= $this->h ( $this->app_path ) ?>/css/style1.css" rel="stylesheet">
    <link href= "<?= $this->h ( $this->app_path ) ?>/css/auther2.css" rel="stylesheet">

    <style>
  </style>
  </head>

<body>
    <!-- Sidebar navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">EC App</a>
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="<?= $this->h ( $this->app_path ) ?>/signout">サインアウト</a>
        </li>
      </ul>
    </nav>