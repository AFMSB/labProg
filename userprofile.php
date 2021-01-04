<?php
session_start();
if (isset($_SESSION["cargo"]) && isset($_SESSION["temp"])) {
    header("location: reset-password.php");
    exit;
}
if (!isset($_SESSION["cargo"]) || $_SESSION["cargo"] != "USR") {
    header("location: login.php");
    exit;
}

require_once "config.php";

// Define variables and initialize with empty values
$nome = $email = $morada = $pais = $distrito = $codigo_postal = $nif = $zip = "";
$nomeErr = $emailErr = $moradaErr = $paisErr = $distritoErr = $codigo_postalErr = $nifErr = $zipErr = "";

$id = $_SESSION["id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // validar email
    if (empty(trim($_POST["email"]))) {
        $emailErr = "Introduza um e-mail";
    }else {
        $param_email = trim($_POST["email"]);
    }

    // Validar nome
    if (empty(trim($_POST["nome"]))) {
        $nomeErr = "Introduza um nome";
    } elseif (strlen(trim($_POST["nome"])) < 2) {
        $nomeErr = "Nome necessita de pelo menos 2 caracteres";
    } else {
        $param_nome = trim($_POST["nome"]);
    }

    // Validar Morada
    if (empty(trim($_POST["morada"]))) {
        $moradaErr = "Introduza uma morada";
    } elseif (strlen(trim($_POST["morada"])) < 10) {
        $moradaErr = "Campo morada deve conter no minimo 10 caracteres";
    } else {
        $param_morada = trim($_POST["morada"]);
    }

    // Validar NIF
    if (empty(trim($_POST["nif"]))) {
        $nifErr = "Introduza um NIF";
    } elseif (strlen(trim($_POST["nif"])) < 9) {
        $nifErr = "Numero de contribuinte inserido é invalido";
    } else {
        $param_nif = trim($_POST["nif"]);
    }

    // Validar Pais
    if (empty(trim($_POST["pais"]))) {
        $paisErr = "Introduza um pais";
    } elseif (strlen(trim($_POST["pais"])) < 5) {
        $paisErr = "Campo pais deve conter no minimo 5 caracteres";
    } else {
        $param_pais = trim($_POST["pais"]);
    }

    // Validar Distrito
    if (empty(trim($_POST["distrito"]))) {
        $distritoErr = "Introduza um distrito";
    } elseif (strlen(trim($_POST["distrito"])) < 5) {
        $distritoErr = "Campo distrito deve conter no minimo 5 caracteres";
    } else {
        $param_distrito = trim($_POST["distrito"]);
    }

    // Validar Codigo Postal
    if (empty(trim($_POST["zip"]))) {
        $zipErr = "Introduza um codigo postal";
    } elseif (!preg_match('/^[0-9]{4}([- ]?[0-9]{3})?$/', trim($_POST["zip"]))) {
        $zipErr = "Campo codigo postal não tem o formato pretendido";
    } else {
        $param_zip = trim($_POST["zip"]);
    }

    // Verificar existencia de erros antes de inserir na base de dados
    if (empty($nomeErr) && empty($emailErr) && empty($nifErr) && empty($moradaErr) && empty($paisErr) && empty($distritoErr) && empty($zipErr)) {
        $sql = "UPDATE users SET nome = :nome, email = :email, nif = :nif WHERE id = $id";
        $sql1 = "UPDATE moradas SET morada = :morada, pais = :pais, distrito = :distrito, zip = :zip WHERE user_id = $id";

        //adicionar utilizador
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":nome", $param_nome, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":nif", $param_nif, PDO::PARAM_STR);

            if ($stmt->execute()) {

            }
            unset($stmt);
        }
        if($stmt1 = $pdo->prepare($sql1)){
            $stmt1->bindParam(":morada", $param_morada, PDO::PARAM_STR);
            $stmt1->bindParam(":pais", $param_pais, PDO::PARAM_STR);
            $stmt1->bindParam(":distrito", $param_distrito, PDO::PARAM_STR);
            $stmt1->bindParam(":zip", $param_zip, PDO::PARAM_STR);

            if($stmt1->execute()){
            }
            unset($stmt);
        }
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
    <title>Phone Store | User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous"/>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/dashboard/">
    <!-- Bootstrap core CSS -->
    <link href="css/user.css" rel="stylesheet">
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
                        <a class="nav-link active" href="userprofile.php">
                            <span data-feather="users"></span>
                            Perfil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="userorders.php">
                            <span data-feather="file"></span>
                            Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="usermessages.php">
                            <span data-feather="layers"></span>
                            Mensagens
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <?php
        $rs = $pdo->query("SELECT *FROM users WHERE id = '$id'");
        $row = $rs->fetch(PDO::FETCH_OBJ);

        $rs1 = $pdo->query("SELECT *FROM moradas WHERE user_id = '$id'");
        $row1 = $rs1->fetch(PDO::FETCH_OBJ);
        ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            <h2>Perfil</h2>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8 order-md-1">
                    <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="mb-3 <?php echo (!empty($nomeErr)) ? 'has-error' : ''; ?>">
                            <label for="nome">Nome*</label>
                            <input type="text" name="nome" class="form-control" value="<?php echo $row->nome; ?>">
                            <span class="help-block"><?php echo $nomeErr; ?></span>
                        </div>
                        <div class="mb-3 <?php echo (!empty($emailErr)) ? 'has-error' : ''; ?>">
                            <label for="email">Email* </label>
                            <input type="email" name="email" class="form-control" value="<?php echo $row->email; ?>">
                            <span class="help-block"><?php echo $emailErr; ?></span>
                        </div>
                        <div class="mb-3 <?php echo (!empty($nifErr)) ? 'has-error' : ''; ?>">
                            <label for="nif">NIF*</label>
                            <input type="text" name="nif" class="form-control" value="<?php echo $row->nif; ?>">
                            <span class="help-block"><?php echo $nifErr; ?></span>
                        </div>
                        <h5>Morada principal</h5>
                        <hr class="mb-4">
                        <div class="mb-3 <?php echo (!empty($moradaErr)) ? 'has-error' : ''; ?>">
                            <label for="morada">Morada*</label>
                            <input type="text" name="morada" class="form-control" value="<?php echo $row1->morada; ?>">
                            <span class="help-block"><?php echo $moradaErr; ?></span>
                        </div>
                        <div class="row">
                            <div class="col-md-5 mb-3 <?php echo (!empty($paisErr)) ? 'has-error' : ''; ?>">
                                <label for="pais">Pais*</label>
                                <input type="text" name="pais" class="form-control" value="<?php echo $row1->pais; ?>">
                                <span class="help-block"><?php echo $paisErr; ?></span>
                            </div>
                            <div class="col-md-4 mb-3 <?php echo (!empty($distritoErr)) ? 'has-error' : ''; ?>">
                                <label for="distrito">Distrito*</label>
                                <input type="text" name="distrito" class="form-control" value="<?php echo $row1->distrito; ?>">
                                <span class="help-block"><?php echo $distritoErr; ?></span>
                            </div>
                            <div class="col-md-3 mb-3 <?php echo (!empty($zipErr)) ? 'has-error' : ''; ?>">
                                <label for="zip">Código Postal*</label>
                                <input type="text" name="zip" class="form-control" value="<?php echo $row1->zip; ?>">
                                <span class="help-block"><?php echo $zipErr; ?></span>
                            </div>
                        </div>
                        <hr class="mb-4">
                        <button class="btn btn-primary btn-lg btn-block" type="submit">Submeter</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
        crossorigin="anonymous"></script>
<script src="js/admin.js"></script>

</html>