<?php
session_start();

if (!isset($_SESSION["cargo"])) {
    header("location: login.php");
    exit;
}

require_once "config.php";

$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["new_password"]))) {
        $new_password_err = "Introduz a nova password";
    } elseif (strlen(trim($_POST["new_password"])) < 8) {
        $new_password_err = "Password necessita de pelo menos 8 caracteres";
    } else {
        $new_password = trim($_POST["new_password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Confirma a password";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($new_password_err) && ($new_password != $confirm_password)) {
            $confirm_password_err = "As passwords introduzidas não coincidem";
        }
    }

    // Check input errors before updating the database
    if (empty($new_password_err) && empty($confirm_password_err)) {
        // Prepare an update statement
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $clearTempToken = "update users set tempkey=NULL, expireDate = NULL where id = :id";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);

            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];


            if ($stmt->execute()) {
                if (isset($_SESSION["temp"])) {
                    $clearTempTokensmtp = $pdo->prepare($clearTempToken);
                    $clearTempTokensmtp->bindParam(":id", $param_id);
                    $clearTempTokensmtp->execute();
                }
                $_SESSION = array();
                session_destroy();
                header("location: login.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            unset($stmt);
        }
    }
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>Desafio 1 | Reset Password</title>
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
            <?php
            if (isset($_SESSION["email"])) {
                ?>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $_SESSION["nome"] ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                        <?php
                        if ($_SESSION["cargo"] == "ADM" || $_SESSION["cargo"] == "ROOT") echo "<li><a href=\"admin.php\" class=\"dropdown-item\">Área Administração</a></li>";
                        else{
                            echo "<li><a href=\"userprofile.php\" class=\"dropdown-item\">Área Pessoal</a></li>";
                            echo "<li><a href=\"checkout.php\" class=\"dropdown-item\">Ver Carrinho</a></li>";
                        }
                        ?>
                        <li><a href="reset-password.php" class="dropdown-item">Alterar Password </a></li>
                        <li><a href="logout.php" class="dropdown-item">Terminar Sessão</a></li>
                    </ul>
                </div>
                <?php
            } else echo "<button class=\"btn btn-outline-success my-2 my-sm-0\" type=\"submit\"><a class=\"logbtn\" href=\"login.php\" style=\"text-decoration:none;color:white;\" >Entrar</a></button>";
            ?>
        </div>
    </nav>
</header>
<div class="container">
    <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="text-center mb-4">
            <img class="mb-4" src="images/icons/logo.png" alt="" width="200" height="200">
            <h1 class="h3 mb-3 font-weight-normal">Reset Password</h1>
        </div>
        <div class="form-label-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
            <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
            <span class="help-block"><?php echo $new_password_err; ?></span>
            <label for="inputEmail">Nova Password</label>
        </div>
        <div class="form-label-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <input type="password" name="confirm_password" class="form-control">
            <span class="help-block"><?php echo $confirm_password_err; ?></span>
            <label for="inputPassword">Confirmar Password</label>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <?php
            if ($_SESSION["cargo"] == "ADM" || $_SESSION["cargo"] == "ROOT")
            echo("<a class=\"btn btn-link\" href=\"admin.php\">Cancel</a>");
            else echo ('<a class="btn btn-link" href="' . $_SESSION["last"] . '">Cancel</a>');
            ?>
        </div>
        <p class="mt-5 mb-3 text-muted text-center">&copy; PhoneStore 2021</p>
    </form>
</div>
</body>

</html>