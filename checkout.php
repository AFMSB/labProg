<?php
session_start();


$_SESSION["last"] = "checkout.php";

if (!isset($_SESSION["cargo"]) || isset($_SESSION["temp"])) {
    header("location: login.php");
    exit;
}

require_once "config.php";

$total = 0.0;
$promo = 0;
$promoLim = 0;
$promoDesc = 0;
$promoId = 0;
$promoQnt = 0;
$promoNome=0;
$erroCheck = "";

$nomeErr = $nifErr = $moradaErr = $paisErr = $distritoErr = $zipErr = "";

$paramId = $_SESSION["id"];
$rs1 = $pdo->query("select *from users inner join moradas on users.id = moradas.user_id and users.id = $paramId");
$userInfo = $rs1->fetch(PDO::FETCH_OBJ);

$i = 0;

if (isset($_POST['promocode'])) {
    $procuraVoucher = $pdo->prepare("select *from vouchers where nome = :vnome;");
    $procuraVoucher->bindParam(":vnome", $_POST['promocode'], PDO:: PARAM_STR);
    $procuraVoucher->execute();
    $voucher = $procuraVoucher->fetch(PDO::FETCH_OBJ);

    $promoId = $voucher->id;
    $promoDesc = $voucher->desconto;
    $promoLim = $voucher->limite;
    $promoNome=$voucher->nome;
}
if(isset($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $arr) {
        $procuraStock = $pdo->prepare("select quantidade from especificacoes where product_id = :productId and cor = :cor and armazenamento = :armazenamento");
        $procuraStock->bindParam(":productId", $arr['id'], PDO:: PARAM_STR);
        $procuraStock->bindParam(":cor", $arr['cor'], PDO:: PARAM_STR);
        $procuraStock->bindParam(":armazenamento", $arr['armazenamento'], PDO:: PARAM_STR);
        $procuraStock->execute();
        $stock = $procuraStock->fetch(PDO::FETCH_OBJ);

        $nomeproduto = $pdo->prepare("select e.preco from produtos as p inner join especificacoes as e on p.id = e.product_id where p.id = :id and e.cor = :cor and e.armazenamento = :armazenamento");
        $nomeproduto->bindParam(":id", $arr['id'], PDO:: PARAM_STR);
        $nomeproduto->bindParam(":cor", $arr['cor'], PDO:: PARAM_STR);
        $nomeproduto->bindParam(":armazenamento", $arr['armazenamento'], PDO:: PARAM_STR);
        $nomeproduto->execute();
        $nomeprodutof = $nomeproduto->fetch(PDO::FETCH_OBJ);

        if ($stock->quantidade < $arr['quantidade']) {
            $_SESSION['carrinho'][$i]['preco'] = $nomeprodutof->preco * $stock->quantidade;
            $erroCheck = "Alguns dos produtos selecionados não estão disponiveis nas quantidades pretendidas!";
        } else {
            $_SESSION['carrinho'][$i]['preco'] = $nomeprodutof->preco * $arr['quantidade'];
        }
        $total += $_SESSION['carrinho'][$i]['preco'];

        if ($promoLim > 0 && $arr['quantidade'] <= $promoLim && isset($_POST['promocode'])) {
            $promo += $promoDesc * ($arr['quantidade'] * $nomeprodutof->preco);
            $promoQnt += $arr['quantidade'];

            $atualizarvoucher = $pdo->prepare("update vouchers set limite = limite - :quantidade where id = :voucherId");
            $atualizarvoucher->bindParam(":quantidade", $arr['quantidade'], PDO:: PARAM_STR);
            $atualizarvoucher->bindParam(":voucherId", $promoId, PDO:: PARAM_STR);
            $atualizarvoucher->execute();

        } else if ($promoLim > 0 && $arr['quantidade'] > $promoLim && isset($_POST['promocode'])) {
            $promo += $promoDesc * ($promoLim * $nomeprodutof->preco);
            $promoQnt += $promoLim;

            $atualizarvoucher = $pdo->prepare("update vouchers set limite = 0 where id = :voucherId");
            $atualizarvoucher->bindParam(":voucherId", $promoId, PDO:: PARAM_STR);
            $atualizarvoucher->execute();
        }

        $total -= $promo;

        $i++;
    }
}
$_SESSION['total'] = $total;
$_SESSION['desconto'] = $promo;
$_SESSION['descontoQnt'] = $promoQnt;

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>Phone Store | Checkout</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/checkout/">

    <!-- Bootstrap core CSS -->
    <link href="css/checkout.css" rel="stylesheet">

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

    <script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
    <script src="https://js.stripe.com/v3/"></script>

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
<div class="container" style="padding-top:5vh;">
    <div class="py-5 text-center">

        <img class="d-block mx-auto mb-4" src="images/icons/logo.png" alt="" width="200" height="200">
        <h2>Checkout </h2>
        <p class="lead">Confirmação de compras</p>
    </div>
    <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Carrinho</span>
            </h4>
            <ul class="list-group mb-3">
                <?php
                if(isset($_SESSION['carrinho'])) {
                    foreach ($_SESSION['carrinho'] as $arr) {
                        echo "<li class=\"list-group-item d-flex justify-content-between lh-condensed\">";
                        echo "<div>";
                        $teste = $arr['nome'];
                        $teste1 = $arr['quantidade'];
                        echo "<h6 class=\"my-0\">$teste (x $teste1)</h6>";
                        $teste2 = $arr['cor'];
                        $teste3 = $arr['armazenamento'];
                        echo "<small class=\"text-muted\">$teste2 $teste3 GB</small>";
                        echo "</div>";
                        $teste4 = $arr['preco'];
                        echo "<span class=\"text-muted\">$teste4 €</span>";
                    }
                }
                echo"</li>";
                ?>
                <li class="list-group-item d-flex justify-content-between bg-light">
                    <div class="text-success">
                        <h6 class="my-0">Promo Code </h6>
                        <small><?php if($promoNome!=0) $promoNome.' x'. $promoQnt ?></small>
                    </div>
                    <span class="text-success">-<?= $promo ?>€</span>
                </li>
                <li class="list-group-item d-flex justify-content-between bg-light">
                    <div class="text-danger">
                        <small><?= $erroCheck?></small>
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total (EUR)</span>
                    <?php echo"<strong>$total €</strong>"?>
                </li>
            </ul>
            <form class="card p-2" m action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                  enctype="multipart/form-data">
                <div class="input-group">
                    <input type="text" class="form-control" name="promocode" placeholder="Código">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary">Aplicar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Dados Faturacao</h4>
            <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="text">Nome*</label>
                        <input type="text" name="nome" class="form-control"
                               value="<?php echo $userInfo->nome; ?>">
                        <span class="help-block"><?php echo $nomeErr; ?></span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="text">NIF*</label>
                        <input type="text" name="nif" class="form-control"
                               value="<?php echo $userInfo->nif; ?>">
                        <span class="help-block"><?php echo $nifErr; ?></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="text">Morada*</label>
                    <input type="text" name="morada" class="form-control"
                           value="<?php echo $userInfo->morada; ?>">
                    <span class="help-block"><?php echo $moradaErr; ?></span>
                </div>
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label for="text">Pais*</label>
                        <input type="text" name="pais" class="form-control"
                               value="<?php echo $userInfo->pais; ?>">
                        <span class="help-block"><?php echo $paisErr; ?></span>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="text">Distrito*</label>
                        <input type="text" name="distrito" class="form-control"
                               value="<?php echo $userInfo->distrito; ?>">
                        <span class="help-block"><?php echo $distritoErr; ?></span>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="text">Código-Postal*</label>
                        <input type="text" name="zip" class="form-control"
                               value="<?php echo $userInfo->zip; ?>">
                        <span class="help-block"><?php echo $zipErr; ?></span>
                    </div>
                </div>
                <hr class="mb-4">
            </form>
            <button class="btn btn-primary btn-lg btn-block" id="checkout-button">Confirmar</button>
            <br><br>
        </div>
    </div>
</div>
</body>

<script type="text/javascript">
    // Create an instance of the Stripe object with your publishable API key
    var stripe = Stripe("pk_test_51I5sGvG6ZrDa2rDvKT1dKWmzoANuv6yf3XgWivjx15jHbbzJpXBBRJQjSCf7Knos29BCV44erexXM91CBOO3v0dn0000E7e7Of");
    var checkoutButton = document.getElementById("checkout-button");

    checkoutButton.addEventListener("click", function () {
        fetch("http://homestead.test/projetolab1/create-checkout-session.php", {
            method: "POST",
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (session) {
                return stripe.redirectToCheckout({ sessionId: session.id });
            })
            .then(function (result) {
                // If redirectToCheckout fails due to a browser or network
                // error, you should display the localized error message to your
                // customer using error.message.
                if (result.error) {
                    alert(result.error.message);
                }
            })
            .catch(function (error) {
                console.error("Error:", error);
            });
    });
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script>
    window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')
</script>
<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
<script src="js\checkout.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
</script>

</html>