<?php
session_start();
if (isset($_SESSION["cargo"]) && isset($_SESSION["temp"])) {
    header("location: reset-password.php");
    exit;
}
if (!isset($_SESSION["cargo"]) || $_SESSION["cargo"] != "ADM" && $_SESSION["cargo"] != "ROOT") {
    header("location: login.php");
    exit;
}

require_once "config.php";

$categoria = $desconto = $nome = $limite = "";
$categoriaErr = $descontoErr = $nomeErr = $limiteErr = "";

if (empty($_POST["nome"])) {
    $nomeErr = "Introduza um nome para o voucher";
} else {
    $sql = "SELECT id FROM vouchers WHERE nome = :nome";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":nome", $param_nome, PDO::PARAM_STR);
        $param_nome = trim($_POST["nome"]);
        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
                $nomeErr = "Este nome já existe";
            } else {
                $nome = trim($_POST["nome"]);
            }
        }
        unset($stmt);
    }
}

if(empty($_POST['categoria'])){
    $categoriaErr = "Introduza a categoria do desconto";
}elseif (strlen(trim($_POST['categoria']))>50){
    $categoriaErr = "Categoria não pode ter mais de 50 caracteres";
}else{
    $categoria = trim($_POST["categoria"]);
}

if(empty($_POST['desconto'])){
    $descontoErr = "Introduza a categoria do desconto";
}elseif (!is_numeric(trim($_POST['desconto']))){
    $descontoErr = "Desconto tem de ser um valor numerico";
}else{
    $desconto = trim($_POST["desconto"]);
}

if(empty($_POST['limite'])){
    $limiteErr = "Introduza o limite de usos do desconto";
}elseif (!is_numeric(trim($_POST['limite']))){
    $limiteErr = "Limite tem de ser um valor numerico";
}else{
    $limite = trim($_POST["limite"]);
}

if (empty($nomeErr)) {

    $sql = "insert into vouchers (categoria, desconto, limite, nome) values (:categoria, :desconto, :limite, :nome)";

    //adicionar utilizador
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":categoria", $categoria, PDO::PARAM_STR);
        $stmt->bindParam(":desconto", $desconto, PDO::PARAM_STR);
        $stmt->bindParam(":limite", $limite, PDO::PARAM_STR);
        $stmt->bindParam(":nome", $param_nome, PDO::PARAM_STR);

        if ($stmt->execute()) {
            header("location: adminvouchers.php");
        }
        unset($stmt);
    }
}

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>Phone Store | Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/checkout/">

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/dashboard/">

    <!-- Bootstrap core CSS -->
    <link href="css/admin.css" rel="stylesheet">

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
<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="index.php">Phone Store</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse"
            data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="logout.php">Terminar Sessão</a>
        </li>
    </ul>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="sidebar-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">
                            <span data-feather="shopping-cart"></span>
                            Produtos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="adminvouchers.php">
                            <span data-feather="layers"></span>
                            Vouchers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adminorders.php">
                            <span data-feather="file"></span>
                            Encomendas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adminclients.php">
                            <span data-feather="users"></span>
                            Utilizadores
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adminmessages.php">
                            <span data-feather="layers"></span>
                            Mensagens
                        </a>
                    </li>
                </ul>
                <h6
                        class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Paginas</span>

                    <a class="plus-circle" href="adminaddpage.php">
                        <span data-feather="plus-circle"></span>
                    </a>

                </h6>
                <h6
                        class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Cupões</span>

                    <a class="plus-circle" href="adminaddvoucher.php">
                        <span data-feather="plus-circle"></span>
                    </a>

                </h6>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4" style="margin-top: 5vh;">
            <h2>Criar Cupão</h2>
            <div class="container-fluid">
                <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="row">
                        <div class="col-md-6 mb-3 <?php echo (!empty($categoriaErr)) ? 'has-error' : ''; ?>">
                            <label for="text">Categoria</label>
                            <input type="text" name="categoria" class="form-control"
                                   value="<?php echo $categoria; ?>">
                            <span class="help-block"><?php echo $categoriaErr; ?></span>
                        </div>
                        <div class="col-md-6 mb-3 <?php echo (!empty($descontoErr)) ? 'has-error' : ''; ?>">
                            <label for="text">Desconto</label>
                            <input type="text" name="desconto" class="form-control"
                                   value="<?php echo $desconto; ?>">
                            <span class="help-block"><?php echo $descontoErr; ?></span>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6 mb-3 <?php echo (!empty($nomeErr)) ? 'has-error' : ''; ?>">
                            <label for="text">Nome</label>
                            <input type="text" name="nome" class="form-control"
                                   value="<?php echo $nome; ?>">
                            <span class="help-block"><?php echo $nomeErr; ?></span>
                        </div>
                        <div class="col-md-6 mb-3 <?php echo (!empty($limiteErr)) ? 'has-error' : ''; ?>">
                            <label for="text">Limite</label>
                            <input type="text" name="limite" class="form-control"
                                   value="<?php echo $limite; ?>">
                            <span class="help-block"><?php echo $limiteErr; ?></span>
                        </div>
                        <button class="btn btn-primary btn-lg btn-block" type="submit">Submeter</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script>
    window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
<script src="js/admin.js"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
</script>

</html>