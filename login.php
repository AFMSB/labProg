<?php
session_start();

if (isset($_SESSION["cargo"])) {
    header("location: index.php");
    exit;
}

require_once "config.php";

$email = $password = "";
$email_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //validar email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Introduza um email";
    } else {
        $email = trim($_POST["email"]);
    }

    //validar password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    //validar credenciais
    if (empty($email_err) && empty($password_err)) {

        $sql = "SELECT *FROM users WHERE email = :email";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $param_email = trim($_POST["email"]);

            if ($stmt->execute()) {
                // Verifica se o email é valido
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $hashed_password = $row["password"];
                        if (password_verify($password, $hashed_password)) {
                            //atribuir sessao
                            session_start();
                            // Store data in session variables
                            $_SESSION["id"] = $row["id"];
                            $_SESSION["nome"] = $row["nome"];
                            $_SESSION["email"] = $row["email"];
                            $_SESSION["cargo"] = $row["cargo"];
                            $_SESSION["pontos"] = $row["pontos"];
                            $_SESSION["nif"] = $row["nif"];

                            if ($row["cargo"] == "ADM") {
                                $_SESSION["cargo"] = "ADM";
                            } else if ($row["cargo"] == "ROOT") {
                                $_SESSION["cargo"] = "ROOT";
                            } else {
                                $_SESSION["cargo"] = "USR";
                            }
                            if(!empty($_SESSION["last"])) header("location:" . $_SESSION["last"]);
                            else header("location: index.php");
                        } else {
                            $password_err = "A password está incorreta";
                        }
                    }
                } else {
                    $email_err = "Este e-mail não está registado";
                }
            }
            unset($stmt);
        }
    }
    unset($pdo);
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
    <title>Phone Store | Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/floating-labels/">

    <!-- Bootstrap core CSS -->
    <link href="css\login.css" rel="stylesheet">

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
<div class="container" style="padding-top: 3vh;">
    <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="text-center mb-4">
            <img class="mb-4" src="images/icons/logo.png" alt="" width="200" height="200">
            <h1 class="h3 mb-3 font-weight-normal">Login</h1>
        </div>
        <div class="form-label-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
            <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
            <span class="help-block"><?php echo $email_err; ?></span>
            <label for="inputEmail">Email</label>
        </div>
        <div class="form-label-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <input type="password" name="password" class="form-control">
            <span class="help-block"><?php echo $password_err; ?></span>
            <label for="inputPassword">Password</label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
        <p>Ainda não tens conta? <a href="register.php">Cria a tua aqui!!</a></p>
        <p><a href="forgot-password.php">Recuperar palava-chave</a></p>

        <p class="mt-5 mb-3 text-muted text-center">&copy; PhoneStore 2021</p>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
        crossorigin="anonymous"></script>
</body>