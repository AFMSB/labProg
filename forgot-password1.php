<?php
session_start();

if (isset($_SESSION["cargo"])) {
    header("location:" . $_SESSION["last"]);
    exit;
}

require_once "config.php";

$username = $code = "";
$username_err = $code_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["code"]))) {
        $code_err = "Introduza o codigo enviado por email";
    } else {
        $code = trim($_POST["code"]);
    }

    if (empty($username_err) && empty($code_err)) {
        $sql = "SELECT id, nome, email, cargo, pontos, nif, tempkey, expireDate FROM users WHERE email = :username";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":username", $_SESSION["temp"], PDO::PARAM_STR);

            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $tempToken = $row["tempkey"];
                        $expireDate = $row["expireDate"];
                        if ($code == $tempToken && date('Y-m-d H:m:s') <= $expireDate) {
                            $_SESSION["id"] = $row["id"];
                            $_SESSION["nome"] = $row["nome"];
                            $_SESSION["email"] = $row["email"];
                            $_SESSION["cargo"] = $row["cargo"];
                            $_SESSION["pontos"] = $row["pontos"];
                            $_SESSION["nif"] = $row["nif"];

                            header("location: reset-password.php");
                        } else {
                            $code_err = "O codigo introduzido nãol é válido";
                        }
                    }
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
    <title>Desafio 1 | Forgot Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/floating-labels/">

    <!-- Bootstrap core CSS -->
    <link href="css/login.css" rel="stylesheet">

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
<div class="container">
    <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="text-center mb-4">
            <img class="mb-4" src="images/icons/logo.png" alt="" width="200" height="200">
            <h1 class="h3 mb-3 font-weight-normal">Verificação</h1>
            <p class="mt-5 mb-3 text-muted text-center">Introduza o código enviado por e-mail</p>
        </div>
        <div class="form-label-group <?php echo (!empty($code_err)) ? 'has-error' : ''; ?>">
            <input type="text" name="code" class="form-control">
            <span class="help-block"><?php echo $code_err; ?></span>
            <label for="inputPassword">Código de verificação</label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Seguinte</button>
        <p><a href="forgot-password.php">Voltar</a></p>

        <p class="mt-5 mb-3 text-muted text-center">&copy; 2017-2020</p>
    </form>
</div>

</body>

</html>