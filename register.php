<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Jekyll v4.1.1">
  <title>Phone Store | Register</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
    integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/checkout/">

  <!-- Bootstrap core CSS -->
  <link href="css\register.css" rel="stylesheet">

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

<body class="bg-light">
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
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><a class="logbtn" href="login.php" style="text-decoration:none;color:white;" >Entrar</a></button>
      </div>
    </nav>
  </header>
  <div class="container" style="padding-top: 7vh;">
    <div class="py-5 text-center">
      <img class="d-block mx-auto mb-4" src="images\icons\logo.png" alt="" width="200" height="200">
      <h2>Registo</h2>
      <p class="lead">Cria a tua conta</p>
    </div>

    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8 order-md-1">
        <form class="needs-validation" novalidate>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="firstName">Primeiro Nome*</label>
              <input type="text" class="form-control" id="firstName" placeholder="" value="" required>
              <div class="invalid-feedback">
                Primeiro nome obrigatorio!
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="lastName">Ultimo nome*</label>
              <input type="text" class="form-control" id="lastName" placeholder="" value="" required>
              <div class="invalid-feedback">
                ULtimo nome obrigatorio!
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="firstName">Password*</label>
              <input type="password" class="form-control" id="firstName" placeholder="" value="" required>
              <div class="invalid-feedback">
                Password obrigatoria!
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="lastName">Confirmar Password*</label>
              <input type="password" class="form-control" id="lastName" placeholder="" value="" required>
              <div class="invalid-feedback">
                As palavras passe não são iguais!
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="username">Utilizador*</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">@</span>
              </div>
              <input type="text" class="form-control" id="username" placeholder="Username" required>
              <div class="invalid-feedback" style="width: 100%;">
                Utilizador obrigatorio!
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="email">Email* </label>
            <input type="email" class="form-control" id="email" placeholder="examplo@examplo.com" required>
            <div class="invalid-feedback">
              Insira um email valido!
            </div>
          </div>

          <div class="mb-3">
            <label for="address">Morada principal</label>
            <input type="text" class="form-control" id="address" placeholder="Rua Exemplo" required>
            <div class="invalid-feedback">
              Insira uma morada valida!
            </div>
          </div>

          <div class="mb-3">
            <label for="address2">Morada Secundaria <span class="text-muted">(Optional)</span></label>
            <input type="text" class="form-control" id="address2" placeholder="Apartamento">
          </div>

          <div class="row">
            <div class="col-md-5 mb-3">
              <label for="country">País</label>
              <select class="custom-select d-block w-100" id="country" required>
                <option value="">Escolha...</option>
                <option>Portugal</option>
                <option>Espanha</option>
                <option>Brazil</option>
              </select>
              <div class="invalid-feedback">
                Escolha um pais!!
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="state">Distrito</label>
              <select class="custom-select d-block w-100" id="state" required>
                <option value="">Escolha...</option>
                <option>Porto</option>
                <option>Lisboa</option>
              </select>
              <div class="invalid-feedback">
                Escolha um distrito!!
              </div>
            </div>
            <div class="col-md-3 mb-3">
              <label for="zip">Codigo-Postal</label>
              <input type="text" class="form-control" id="zip" placeholder="9999-999" required>
              <div class="invalid-feedback">
                Insira um codigo-postal valido!
              </div>
            </div>
          </div>
          <hr class="mb-4">
          <button class="btn btn-primary btn-lg btn-block" type="submit">Submeter</button>
          <br>
          <p>Já tens conta? <a href="login.php">Entra por aqui!!</a></p>
          <br> <br>
        </form>
      </div>
    </div>

    <footer class="container-fluid">
      <p class="float-right"><a href="#">Voltar ao inicio</a></p>
      <p>&copy; 2020 Phone Store, LDA. &middot; <a href="#">Privacidade</a> &middot; <a href="#">Termos</a></p>
    </footer>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script>
  <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js\register.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
    crossorigin="anonymous"></script>
</body>

</html>