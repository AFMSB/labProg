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

if (isset($_GET['page1'])) {
    $pageno1 = $_GET['page1'];
} else {
    $pageno1 = 1;
}


if(isset($_GET['eliminar'])){
    $eliminaespecificcacao = $pdo->prepare("delete from especificacoes where product_id = :id_eliminar");
    $eliminaespecificcacao->bindParam(":id_eliminar", $_GET['eliminar'], PDO:: PARAM_STR);
    $eliminaespecificcacao->execute();

    //$eliminaproduto = $pdo->prepare("delete from produtos where product_id = :id_eliminar");
    //$eliminaproduto->bindParam(":id_eliminar", $_GET['eliminar'], PDO:: PARAM_STR);
    //$eliminaproduto->execute();
}

$numItens1 = 20;
$shift1 = ($pageno1 - 1) * $numItens1;
$paramId = $_SESSION["id"];
$rsAll1 = $pdo->query("select produtos.id, produtos.nome, produtos.preco, especificacoes.quantidade, produtos.categoria, especificacoes.cor, especificacoes.armazenamento from produtos inner join especificacoes on produtos.id = especificacoes.product_id");
$total_pages1 = ceil($rsAll1->rowCount() / $numItens1);
$rs1 = $pdo->query("select produtos.id, produtos.nome, produtos.preco, especificacoes.quantidade, produtos.categoria, especificacoes.cor, especificacoes.armazenamento from produtos inner join especificacoes on produtos.id = especificacoes.product_id LIMIT $shift1, $numItens1;");

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
                        <a class="nav-link active" href="admin.php">
                            <span data-feather="shopping-cart"></span>
                            Produtos
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
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Index
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="file-text"></span>
                            Produtos
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4" style="margin-top: 5vh;">

            <h2>Produtos</h2>
            <div class="p-2 bd-highlight">
                <nav aria-label="...">
                    <ul class="pagination ">
                        <?php
                        $pages1 = 0;
                        if ($rsAll1->rowCount() <= $numItens1 || isset($_GET['sortear'])) $total_pages1 = 0;
                        for ($i = 1; $i <= $total_pages1; $i++) echo "<li class=\"page-item\"><a class=\"page-link\" href=\"?page1=$i\">$i</a></li>";
                        ?>
                    </ul>
                </nav>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Stock Existente</th>
                        <th>Categoria</th>
                        <th>Armazenamento</th>
                        <th>Cor</th>
                        <th>Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row1 = $rs1->fetch(PDO::FETCH_OBJ)) {
                        echo "<tr>";
                        echo "<td>" . $row1->id . "</td>";
                        echo "<td>" . $row1->nome . "</td>";
                        echo "<td>" . $row1->preco . "</td>";
                        echo "<td>" . $row1->quantidade . "</td>";
                        echo "<td>" . $row1->categoria . "</td>";
                        echo "<td>" . $row1->armazenamento . " Gb</td>";
                        echo "<td>" . $row1->cor . "</td>";
                        echo "<td>" . "<a href=\"?eliminar=$row1->id\" class=\"danger\">Remover</a>" . "</td>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Criar Pagina</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>

        </div>
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