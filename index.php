<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Jekyll v4.1.1">
  <title>Phone Store | Index</title>

  <!-- Font Awesome icons (free version)-->
  <script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
    integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/carousel/">

  <!-- Bootstrap core CSS -->
  <link href="css/index.css" rel="stylesheet">

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <a class="navbar-brand" href="index.php">Phone Store</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
        aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="index.php">Inicio <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php#services">Serviços</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="products.php">Produtos</a>
          </li>
        </ul>
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><a class="logbtn" href="login.php" style="text-decoration:none;color:white;" >Entrar</a></button>
      </div>
    </nav>
  </header>

  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="images/caroussel/iphone11-gallery4-2019.jfif" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="images/caroussel/download.jfif" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="images/caroussel/caroussel1.jpg" class="d-block w-100" alt="...">
      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>

  <!-- Marketing messaging and featurettes
    ================================================== -->
  <!-- Wrap the rest of the page in another container to center all the content. -->

  <div class="container marketing">
    <!-- Three columns of text below the carousel -->

    <section class="page-section" id="services">
      <div class="row">
        <div class="col-lg-4">
          <img src="images/icons/serviceBuy.png" class="img-fluid" alt="Responsive image">
          <h2>Venda</h2>
          <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies
            vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus
            magna.</p>
          <p><a class="btn btn-secondary" href="product.php" role="button">View details &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img src="images/icons/serviceRepair.png" class="img-fluid" alt="Responsive image">
          <h2>Aquisição</h2>
          <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras
            mattis consectetur purus sit amet fermentum. Fusce dapibus, tellus ac cursus commodo, tortor mauris
            condimentum nibh.</p>
          <p><a class="btn btn-secondary" href="product.php" role="button">View details &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img src="images/icons/serviceSell.png" class="img-fluid" alt="Responsive image">
          <h2>Reparação</h2>
          <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta
            felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum
            massa justo sit amet risus.</p>
          <p><a class="btn btn-secondary" href="product.php" role="button">View details &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
      </div><!-- /.row -->
    </section>

    <!-- START THE FEATURETTES -->

    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7">
        <h2 class="featurette-heading">Iphone <span class="text-muted">11 Pro</span></h2>
        </h2>
        <ul class="features">
          <li class="features-item">
            <p class="lead">6,5" display</p>
          </li>
          <li class="features-item">
            <p class="lead">Triple-camera system</p>
          </li>
          <li class="features-item">
            <p class="lead">A13 Bionic chip</p>
          </li>
          <li class="features-item">
            <p class="lead">12-month warranty</p>
          </li>
        </ul>
      </div>
      <div class="col-md-5">
        <div class="col-md-12">
          <img src="images/products/sspaceGrey.jpg" alt="..."
            class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500"
            height="500">
        </div>
      </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7 order-md-2">
        <h2 class="featurette-heading">Iphone <span class="text-muted">11 Pro</span></h2>
        <ul class="features">
          <li class="features-item">
            <p class="lead">6,5" display</p>
          </li>
          <li class="features-item">
            <p class="lead">Triple-camera system</p>
          </li>
          <li class="features-item">
            <p class="lead">A13 Bionic chip</p>
          </li>
          <li class="features-item">
            <p class="lead">12-month warranty</p>
          </li>
        </ul>
      </div>
      <div class="col-md-5 order-md-1">
        <div class="col-md-12">
          <img src="images/products/sroseGold.jpg" alt="..."
            class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500"
            height="500">
        </div>
      </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7">
        <h2 class="featurette-heading">Iphone <span class="text-muted">11 Pro</span></h2>
        <ul class="features">
          <li class="features-item">
            <p class="lead">6,5" display</p>
          </li>
          <li class="features-item">
            <p class="lead">Triple-camera system</p>
          </li>
          <li class="features-item">
            <p class="lead">A13 Bionic chip</p>
          </li>
          <li class="features-item">
            <p class="lead">12-month warranty</p>
          </li>
        </ul>
      </div>
      <div class="col-md-5">
        <img src="images/products/sgreen.jpg" alt="..."
          class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500">
      </div>
    </div>

    <hr class="featurette-divider">

    <!-- /END THE FEATURETTES -->

  </div><!-- /.container -->


  <!-- FOOTER -->
  <footer class="container-fluid">
    <p class="float-right"><a href="#">Voltar ao inicio</a></p>
    <p>&copy; 2020 Phone Store, LDA. &middot; <a href="#">Privacidade</a> &middot; <a href="#">Termos</a></p>
  </footer>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script>
  <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
    crossorigin="anonymous"></script>

</html>