<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors" />
  <meta name="generator" content="Jekyll v4.1.1" />
  <title>Phone Store | Products</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
    integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous" />
  <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/album/" />

  <!-- Bootstrap core CSS -->
  <link href="css\products.css" rel="stylesheet" />

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
            <a class="nav-link" href="index.php">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php#services">Serviços</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="products.php">Produtos</a>
          </li>
        </ul>
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><a class="logbtn" href="login.php"
            style="text-decoration:none;color:white;">Entrar</a></button>
      </div>
    </nav>
  </header>

  <section class="jumbotron text-center">

    <div class="container">
      <h1>Phone Store </h1>
      <p class="lead text-muted">Todos os nossos telemoveis sao completamente desbloqueados,para que qualquer um possa
        ter acesso imediato!Confiança, preços baixos e satisfaçao do cliente sao a nossa principal responsabilidade </p>

      <h8> Temos uma política de 14 dias com direito a devolução no caso de estar insatisfeito/a com a sua compra.</h8>
      </p>

    </div>
  </section>

  <div class="album py-5 bg-light">

    <div class="container">
      <td>Ordenar por:</td>

      <div class="d-flex bd-highlight mb-3">
        <div class="mr-auto p-2 bd-highlight">
          <div class="dropdown">
            <select class="form-control  " name="select">
              <option value="">Mais Vendido</option>
              <option value="">Mais barato</option>
              <option value="">Mais caro</option>
            </select>
          </div>
        </div>

        <div class="p-2 bd-highlight"></div>
        <div class="p-2 bd-highlight">
          <nav aria-label="...">
            <ul class="pagination ">
              <li class="page-item"><a class="page-link" href="#" tabindex="-1">Previous</a>

              </li>
              <li class="page-item"><a class="page-link" href="#">1</a></li>
              <li class="page-item active">
                <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
              </li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item">
                <a class="page-link" href="#">Next</a>
              </li>
            </ul>
          </nav>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <img src="images/products/spaceGrey.jpg" class="img-fluid" alt="Responsive image">
            <div class="card-body">
              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional
                content. This content is a little bit longer.</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="product.php" class="btn btn-primary" role="button">Ver Mais</a>
                </div>
                <div class="price">399.99€</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <img src="images/products/green.jpg" class="img-fluid" alt="Responsive image">
            <div class="card-body">
              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional
                content. This content is a little bit longer.</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="product.php" class="btn btn-primary" role="button">Ver Mais</a>
                </div>
                <div class="price">399.99€</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <img src="images/products/roseGold.jpg" class="img-fluid" alt="Responsive image">
            <div class="card-body">
              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional
                content. This content is a little bit longer.</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="product.php" class="btn btn-primary" role="button">Ver Mais</a>
                </div>
                <div class="price">399.99€</div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <img src="images/products/spaceGrey.jpg" class="img-fluid" alt="Responsive image">
            <div class="card-body">
              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional
                content. This content is a little bit longer.</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="product.php" class="btn btn-primary" role="button">Ver Mais</a>
                </div>
                <div class="price">399.99€</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <img src="images/products/green.jpg" class="img-fluid" alt="Responsive image">
            <div class="card-body">
              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional
                content. This content is a little bit longer.</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="product.php" class="btn btn-primary" role="button">Ver Mais</a>
                </div>
                <div class="price">399.99€</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <img src="images/products/roseGold.jpg" class="img-fluid" alt="Responsive image">
            <div class="card-body">
              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional
                content. This content is a little bit longer.</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="product.php" class="btn btn-primary" role="button">Ver Mais</a>
                </div>
                <div class="price">399.99€</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <img src="images/products/spaceGrey.jpg" class="img-fluid" alt="Responsive image">
            <div class="card-body">
              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional
                content. This content is a little bit longer.</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="product.php" class="btn btn-primary" role="button">Ver Mais</a>
                </div>
                <div class="price">399.99€</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <img src="images/products/green.jpg" class="img-fluid" alt="Responsive image">
            <div class="card-body">
              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional
                content. This content is a little bit longer.</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="product.php" class="btn btn-primary" role="button">Ver Mais</a>
                </div>
                <div class="price">399.99€</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <img src="images/products/roseGold.jpg" class="img-fluid" alt="Responsive image">
            <div class="card-body">
              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional
                content. This content is a little bit longer.</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="product.php" class="btn btn-primary" role="button">Ver Mais</a>
                </div>
                <div class="price">399.99€</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <footer class="container-fluid">
    <p class="float-right"><a href="#">Voltar ao inicio</a></p>
    <p>&copy; 2020 Phone Store, LDA. &middot; <a href="#">Privacidade</a> &middot; <a href="#">Termos</a></p>
  </footer>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
  integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script>
<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>


<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
  integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</html>