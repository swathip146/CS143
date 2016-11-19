<script src="js/jquery.min.js"></script>
<!-- <script src="../js/jquery-ui.min.js"></script> -->
<script src="js/bootstrap.min.js"></script>
<link href="css/bootstrap.min.css" type="text/css" rel="stylesheet">
<link href="css/style.css" type="text/css" rel="stylesheet">
<link href="fontawesome/css/font-awesome.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Amatic+SC" rel="stylesheet"><link href="https://fonts.googleapis.com/css?family=Amatic+SC" rel="stylesheet"><link href="https://fonts.googleapis.com/css?family=Amatic+SC" rel="stylesheet">

<nav class="navbar">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php"><span class="pull-right avatar-text">CS 143 - IMDB Movie Database
      </span>
      </a>
    </div>
    <form method="GET" action="search.php" class="navbar-form navbar-left" style="margin-top:45px;margin-left:30%">
        <div class="form-group">
          <input style="font-size:2rem" type="text" name="search_text" class="form-control" placeholder="Search for Actor/Movie">
        </div>
        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
      </form>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img style="width:100%;top:0%" class="nav-icon" src="images/svg/flags.svg"/> Movies <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="add_movie.php">Add Movie</a></li>
            <li><a href="actor_movie.php">Add Movie/Actor Data</a></li>
            <li><a href="dir_movie.php">Add Movie/Director Data</a></li>
             <li role="separator" class="divider"></li>
            <li><a href="show_movie.php">Show Movie Data</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img style="width:100%;top:0%" class="nav-icon" src="images/svg/flags.svg"/> Actors <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="add_actor_dir.php">Add Actor/Director</a></li>
             <li role="separator" class="divider"></li>
            <li><a href="show_actor.php">Show Actor Data</a></li>
          </ul>
        </li>
        
        <li><a href="about.php"><img class="nav-icon" src="images/svg/flags.svg"> About</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<div class="header-strip"></div> 

