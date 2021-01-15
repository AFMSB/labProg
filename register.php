<?php
session_start();

require_once "config.php";

// Define variables and initialize with empty values
$nome = $password = $confirmar_psw = $email = $morada = $pais = $distrito = $codigo_postal = $nif = $zip = "";
$nomeErr = $passwordErr = $confirmar_pswErr = $emailErr = $moradaErr = $paisErr = $distritoErr = $codigo_postalErr = $nifErr = $zipErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // validar email
    if (empty(trim($_POST["email"]))) {
        $emailErr = "Introduza um e-mail";
    } else {
        $sql = "SELECT id FROM users WHERE email = :email";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $param_email = trim($_POST["email"]);
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $emailErr = "Este email já se encontra registado";
                } else {
                    $email = trim($_POST["email"]);
                }
            }
            unset($stmt);
        }
    }

    // Validar password
    if (empty(trim($_POST["password"]))) {
        $passwordErr = "Introduza uma password";
    } elseif (strlen(trim($_POST["password"])) < 5) {
        $passwordErr = "Password necessita de pelo menos 8 caracteres, uma minuscula, uma maiuscula e um numero";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validar confirmacao password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirmar_pswErr = "Confirme a password";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($passwordErr) && ($password != $confirm_password)) {
            $confirmar_pswErr = "As passwords introduzidas não coincidem";
        }
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
    $nifv = "SELECT  *FROM users WHERE nif = :nif";
    if (empty(trim($_POST["nif"]))) {
        $nifErr = "Introduza um NIF";
    } elseif (strlen(trim($_POST["nif"])) < 9) {
        $nifErr = "Numero de contribuinte inserido é invalido";
    }
    else if ($stmt = $pdo->prepare($nifv)) {
        $stmt->bindParam(":nif", $param_nif, PDO::PARAM_STR);
        $param_nif = trim($_POST["nif"]);
        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
                $nifErr = "Este nif já se encontra registado";
            } else {
                $nif = trim($_POST["nif"]);
            }
        }
        unset($stmt);
    }
    else {
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
    if (empty($nomeErr) && empty($passwordErr) && empty($confirmar_pswErr) && empty($emailErr) && empty($nifErr) && empty($moradaErr) && empty($paisErr) && empty($distritoErr) && empty($zipErr)) {

        $sql = "INSERT INTO users (nome, email, password, nif) VALUES (:nome, :email, :password, :nif)";
        $sql1 = "INSERT INTO moradas (morada, pais, distrito, zip, user_id) VALUES (:morada, :pais, :distrito, :zip, :user_id)";
        $sql2 = "SELECT id FROM users WHERE email = :email";

        //adicionar utilizador
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":nome", $param_nome, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":nif", $param_nif, PDO::PARAM_STR);
            $param_password = crypt($password, '$6$static_salt'); // Creates a password hash

            if ($stmt->execute()) {

                if($stmt1 = $pdo->prepare($sql1)){
                    $stmt1->bindParam(":morada", $param_morada, PDO::PARAM_STR);
                    $stmt1->bindParam(":pais", $param_pais, PDO::PARAM_STR);
                    $stmt1->bindParam(":distrito", $param_distrito, PDO::PARAM_STR);
                    $stmt1->bindParam(":zip", $param_zip, PDO::PARAM_STR);
                    $stmt1->bindParam(":user_id", $userIdDb, PDO::PARAM_STR);

                    $stmt2 = $pdo->prepare($sql2);
                    $stmt2->bindParam(":email", $param_email, PDO::PARAM_STR);
                    $stmt2->execute();
                    $row = $stmt2->fetch();
                    $userIdDb = $row["id"];

                    if($stmt1->execute()){
                        header("location: login.php");
                    }
                }
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
    <meta nome="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta nome="description" content="">
    <meta nome="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta nome="generator" content="Jekyll v4.1.1">
    <title>Phone Store | Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/floating-labels/">

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
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Inicio <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php#services">Serviços</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="products.php">Produtos</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div class="container" style="padding-top: 10%;">
    <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="images\icons\logo.png" alt="" width="200" height="200">
        <h2>Registo</h2>
        <p class="lead">Cria a tua conta</p>
    </div>

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8 order-md-1">
            <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="mb-3 <?php echo (!empty($nomeErr)) ? 'has-error' : ''; ?>">
                    <label for="nome">Nome*</label>
                    <input type="text" name="nome" class="form-control" value="<?php echo $nome; ?>">
                    <span class="help-block"><?php echo $nomeErr; ?></span>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3 <?php echo (!empty($passwordErr)) ? 'has-error' : ''; ?>">
                        <label for="password">Password*</label>
                        <input type="password" name="password" class="form-control"
                               value="<?php echo $password; ?>">
                        <span class="help-block"><?php echo $passwordErr; ?></span>
                    </div>
                    <div class="col-md-6 mb-3 <?php echo (!empty($confirmar_pswErr)) ? 'has-error' : ''; ?>">
                        <label for="cofirmpassword">Confirmar Password*</label>
                        <input type="password" name="confirm_password" class="form-control"
                               value="<?php echo $confirmar_psw; ?>">
                        <span class="help-block"><?php echo $confirmar_pswErr; ?></span>
                    </div>
                </div>
                <div class="mb-3 <?php echo (!empty($emailErr)) ? 'has-error' : ''; ?>">
                    <label for="email">Email* </label>
                    <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                    <span class="help-block"><?php echo $emailErr; ?></span>
                </div>
                <div class="mb-3 <?php echo (!empty($nifErr)) ? 'has-error' : ''; ?>">
                    <label for="nif">NIF*</label>
                    <input type="text" name="nif" class="form-control" value="<?php echo $nif; ?>">
                    <span class="help-block"><?php echo $nifErr; ?></span>
                </div>
                <div class="mb-3 <?php echo (!empty($moradaErr)) ? 'has-error' : ''; ?>">
                    <label for="morada">Morada*</label>
                    <input type="text" name="morada" class="form-control" value="<?php echo $morada; ?>">
                    <span class="help-block"><?php echo $moradaErr; ?></span>
                </div>
                <div class="row">
                    <div class="col-md-5 mb-3 <?php echo (!empty($paisErr)) ? 'has-error' : ''; ?>">
                        <label for="pais">Pais*</label>
                        <input type="text" name="pais" class="form-control" value="<?php echo $pais; ?>">
                        <span class="help-block"><?php echo $paisErr; ?></span>
                    </div>
                    <div class="col-md-4 mb-3 <?php echo (!empty($distritoErr)) ? 'has-error' : ''; ?>">
                        <label for="distrito">Distrito*</label>
                        <input type="text" name="distrito" class="form-control" value="<?php echo $distrito; ?>">
                        <span class="help-block"><?php echo $distritoErr; ?></span>
                    </div>
                    <div class="col-md-3 mb-3 <?php echo (!empty($zipErr)) ? 'has-error' : ''; ?>">
                        <label for="zip">Código Postal*</label>
                        <input type="text" name="zip" class="form-control" value="<?php echo $zip; ?>">
                        <span class="help-block"><?php echo $zipErr; ?></span>
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
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script>
<script src="js\register.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
        crossorigin="anonymous"></script>
</body>

</html>