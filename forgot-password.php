<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();

if (isset($_SESSION["cargo"])) { header("location:" . $_SESSION["last"]);
    exit;
}

require_once "config.php";

$username = $tempToken = $exparacyToken = "";
$username_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))) {
        $username_err = "Introduza o email associado á sua conta";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty($username_err) && empty($code_err)) {

        $sql = "SELECT * FROM users WHERE email = :username";
        $token = "UPDATE users set tempkey = :tempToken, expireDate = :expiracy WHERE email = :username";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $param_username = trim($_POST["username"]);
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        if ($test = $pdo->prepare($token)) {
                            $test->bindParam(":tempToken", $tempToken);
                            $test->bindParam(":username", $param_username);
                            $test->bindParam(":expiracy", $exparacyToken);
                            $tempToken = crypt($param_username . date('dmyhmsms'), rand());
                            $exparacyToken=date('y-m-d H:m:s', strtotime('+2 hours'));
                            $_SESSION["temp"]=$param_username;
                            if ($test->execute()) {
                                require 'vendor/autoload.php';
                                $mail = new PHPMailer(true);
                                header("location: forgot-password1.php");
                                try {
                                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                                    $mail->isSMTP();                                            // Send using SMTP
                                    $mail->Host = 'smtp.mailtrap.io';                    // Set the SMTP server to send through
                                    $mail->SMTPAuth = true;                                   // Enable SMTP authentication
                                    $mail->Username = '86385128ec676c';                     // SMTP username
                                    $mail->Password = 'e5c2acf649f816';                               // SMTP password
                                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                                    $mail->Port = 2525;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                                    $mail->setFrom('noreply@phonestore.pt');
                                    $mail->addAddress($param_username);
                                    $mail->addReplyTo('info@phonestore.pt', 'Phone Store');

                                    $mail->isHTML(true);                                  // Set email format to HTML
                                    $mail->Subject = 'Recuperaçao Password';
                                    $mail->Body = $tempToken; // Creates a password hash;

                                    $mail->AltBody = $tempToken;

                                    $mail->send();
                                } catch (Exception $e) {
                                }
                            }
                        }
                    }
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
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
            <h1 class="h3 mb-3 font-weight-normal">Recuperar Password</h1>
            <p class="mt-5 mb-3 text-muted text-center">Introduz o E-mail associado á conta</p>
        </div>
        <div class="form-label-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <input type="email" name="username" class="form-control">
            <span class="help-block"><?php echo $username_err; ?></span>
            <label for="inputPassword">E-mail</label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Seguinte</button>
        <p><a href="login.php">Voltar</a></p>

        <p class="mt-5 mb-3 text-muted text-center">&copy; 2017-2020</p>
    </form>
</div>

</body>

</html>