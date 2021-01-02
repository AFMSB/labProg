<?php
session_start();

$_SESSION["last"] = "product.php";
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>Phone Store | Product</title>
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
            if (isset($_SESSION["email"])){?>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $_SESSION["nome"] ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                        <?php
                        if($_SESSION["cargo"]=="ADM" || $_SESSION["cargo"]=="ROOT") echo"<li><a href=\"admin.php\" class=\"dropdown-item\">Área Administração</a></li>";
                        else echo"<li><a href=\"userprofile.php\" class=\"dropdown-item\">Área Pessoal</a></li>";
                        ?>
                        <li><a href="reset-password.php" class="dropdown-item">Alterar Password</a></li>
                        <li><a href="logout.php" class="dropdown-item">Terminar Sessão</a></li>
                    </ul>
                </div>
                <?php
            }
            else echo "<button class=\"btn btn-outline-success my-2 my-sm-0\" type=\"submit\"><a class=\"logbtn\" href=\"login.php\" style=\"text-decoration:none;color:white;\" >Entrar</a></button>";
            ?>
        </div>
    </nav>
</header>
<div class="container" style="margin-top: 10vh;">
    <div class="row">
        <div class="col-6">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="images/products/green.jpg" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="images/products/roseGold.jpg" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="images/products/spaceGrey.jpg" class="d-block w-100" alt="...">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="col">
            <h3>Iphone 11</h3>
            <div class="row " style="margin-top: 20px;">
                <div class="col">
                    <select class="form-control btn btn-outline-secondary" name="select">
                        <option value="">Cor</option>
                        <option value="">Green</option>
                        <option value="">spaceGrey</option>
                        <option value="">roseGold</option>
                    </select>
                </div>
            </div>
            <p>Armazenamento</p>
            <div class="row ">
                <div class="col">
                    <select class="form-control btn btn-outline-secondary" name="select">
                        <option value="">Capacity</option>
                        <option value="">64GB</option>
                        <option value="">128GB</option>
                        <option value="">256GB</option>
                    </select>
                </div>
            </div>
            <p>Quantidade</p>
            <div class="row ">
                <div class="col">
                    <div class="btn-group" role="group" id="carrinho" aria-label="Basic example">
                        <button type="button" class="btn btn-outline-primary">-</button>
                        <button type="button" class="btn btn-outline-secondary" disabled>1</button>
                        <button type="button" class="btn btn-outline-primary">+</button>
                    </div>
                </div>
                <div class="col">
                    <button type="button" class="btn btn-outline-primary">Adicionar ao carrinho</button>
                </div>
            </div>

        </div>
    </div>
    <div class="container" style="margin-top: 5vh; background-color: #ebebeb; height: 10%;">
        <div class="row">
            <div class="col-md">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-truck" fill="currentColor"
                     xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                </svg>
                <p>Entregas e coletas rápidas
                    Você receberá a sua encomenda dentro de 1–4 dias úteis
                </p>
            </div>
            <div class="col-md">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-wallet2" fill="currentColor"
                     xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z"/>
                </svg>
                <p>Pagamentos seguros
                    Usamos apenas os provedores de pagamento locais mais confiáveis
                </p>
            </div>
            <div class="col-md">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-clock-history" fill="currentColor"
                     xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z"/>
                    <path fill-rule="evenodd" d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z"/>
                    <path fill-rule="evenodd"
                          d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"/>
                </svg>
                <p>Garantia e devoluções
                    Garantia Phone Store de 24 meses e devoluções gratuitas de 14 dias
                </p>
            </div>
        </div>
    </div>
    <div class="container">
        <div style="padding-top: 5vh;">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade active show " id="phone2" role="tabpanel" aria-labelledby="pills-plans-tab">
                    <ul>
                        <li><b>Display:</b> 6.5” Super Retina OLED display with HDR and True Tone</li>
                        <li><b>Rear camera:</b> Triple 12 MP cameras with wide angle, ultra-wide angle and telescope
                            lenses, portrait mode and lighting, and 4K video quality
                        </li>
                        <li><b>Front camera:</b> 12 MP TrueDepth
                        </li>
                        <li><b>Face ID:</b> Protect your privacy with facial recognition
                        </li>
                        <li><b>Processor:</b> Super powerful and intelligent A13 Bionic chip
                        </li>
                        <li><b>SIM card:</b> Dual SIM - nano-SIM and eSIM
                        </li>
                        <li><b>Bluetooth:</b> 5.0
                        </li>
                        <li><b>Connectors:</b> Lightning connector
                        </li>
                        <li><b>Network:</b> 4G / LTE, Wi-Fi
                        </li>
                        <li><b>Battery:</b> Li-ion battery, wireless charging, compatible with Qi chargers
                        </li>
                        <li><b>Water resistance:</b> The original waterproof seal IP68 cannot be guaranteed due to
                            the
                            refurbishing process Read more
                        </li>
                        <li><b>Size and weight:</b> 158.0 x 77.8 x 8.1 mm
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer class="container-fluid" style="padding-top: 10vh;">
    <p class="float-right"><a href="#">Voltar ao inicio</a></p>
    <p>&copy; 2020 Phone Store, LDA. &middot; <a href="#">Privacidade</a> &middot; <a href="#">Termos</a></p>
</footer>

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
        crossorigin="anonymous"></script>
</body>
</html>