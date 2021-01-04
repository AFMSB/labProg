<?php
session_start();
require_once "config.php";
$_SESSION["last"] = "products.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors"/>
    <meta name="generator" content="Jekyll v4.1.1"/>
    <title>Phone Store | Products</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous"/>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/album/"/>

    <!-- Bootstrap core CSS -->
    <link href="css\products.css" rel="stylesheet"/>

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
                        else echo "<li><a href=\"userprofile.php\" class=\"dropdown-item\">Área Pessoal</a></li>";
                        ?>
                        <li><a href="reset-password.php" class="dropdown-item">Alterar Password</a></li>
                        <li><a href="logout.php" class="dropdown-item">Terminar Sessão</a></li>
                    </ul>
                </div>
                <?php
            } else echo "<button class=\"btn btn-outline-success my-2 my-sm-0\" type=\"submit\"><a class=\"logbtn\" href=\"login.php\" style=\"text-decoration:none;color:white;\" >Entrar</a></button>";
            ?>
        </div>
    </nav>
</header>

<section class="jumbotron text-center">

    <div class="container">
        <h1>Phone Store </h1>
        <p class="lead text-muted">Todos os nossos telemoveis sao completamente desbloqueados,para que qualquer um possa
            ter acesso imediato!Confiança, preços baixos e satisfaçao do cliente sao a nossa principal
            responsabilidade </p>

        <h8> Temos uma política de 14 dias com direito a devolução no caso de estar insatisfeito/a com a sua compra.
        </h8>
        </p>

    </div>
</section>

<div class="album py-5 bg-light">

    <div class="container">
        <td>Ordenar por:</td>

        <div class="d-flex bd-highlight mb-3">
            <div class="mr-auto p-2 bd-highlight">
                <div class="dropdown">
                    <select class="form-control  " name="select">
                        <option value="">Mais barato</option>
                        <option value="">Mais caro</option>
                    </select>
                </div>
            </div>

            <div class="p-2 bd-highlight"></div>
            <div class="p-2 bd-highlight">
                <nav aria-label="...">
                    <ul class="pagination ">
                        <li class="page-item"><a class="page-link" href="#" tabindex="-1">Previous</a>

                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item active">
                            <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="row">
            <?php
      
            $maiscaro = $pdo->query("select id, nome, preco from produtos order by preco desc");
            $maisbarato = $pdo->query("select id, nome, preco from produtos order by preco asc");
           
            $rs1 = $maisbarato;
            while ($row1 = $rs1->fetch(PDO::FETCH_OBJ)) {
              $stmt2 = $pdo->prepare("select caminho from imagens where produto_id = ? limit 1"); 
              $stmt2->execute(array($row1->id));
              $imagepath = $stmt2->fetch(PDO::FETCH_OBJ);
                echo "     <div class=\"col-md-4 text-center\">";
                echo "       <div class=\"card mb-4 shadow-sm\">";
                echo "         <img src=\"$imagepath->caminho\" class=\"img-fluid\" alt=\"Responsive image\">";
                echo "         <div class=\"card-body\">";
                echo "          <h6 class=\"card-title\">" . $row1->nome . "</h6>";
                echo "           <div class=\"d-flex justify-content-between align-items-center\">";
                echo "             <div class=\"btn-group\">";
                echo "               <a href=\"product.php?product=" . $row1->id . "\" class=\"btn btn-primary\" role=\"button\">Ver Mais</a>";
                echo "             </div>";
                echo "             <div class=\"price\">" . $row1->preco . "€</div>";
                echo "           </div>";
                echo "         </div>";
                echo "       </div>";
                echo "     </div>";
            }
            ?>
            <footer class="container-fluid">
                <p class="float-right"><a href="#">Voltar ao inicio</a></p>
                <p>&copy; 2020 Phone Store, LDA. &middot; <a href="#">Privacidade</a> &middot; <a href="#">Termos</a>
                </p>
            </footer>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script>
<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>


<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
        crossorigin="anonymous"></script>
</html>