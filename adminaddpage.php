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

$nome = $stock = $cor = $armazenamento = $preco = $categoria =$display=$cameratras=$faceid=$processador=$sim=$bluetooth=$carregamento=$rede=$resistenciaagua=$bateria=$dimensoes=$peso=$quantidade= "";
$nomeErr = $stockErr = $corErr = $armazenamentoErr = $precoErr = $categoriaErr = $file_err = $file_err1 = $product_idErr = "";

$jaexiste = $jacriei ="";

$destino = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {



    if (empty(trim($_POST["nome"]))) {
        $nomeErr = "Introduza um nome";
    } else {
        $find = "select produtos.nome, especificacoes.cor, especificacoes.armazenamento from produtos inner join especificacoes on produtos.id = especificacoes.product_id where produtos.nome = :nome and especificacoes.cor = :cor and especificacoes.armazenamento = :armazenamento";
        if ($look = $pdo->prepare($find)) {
            $look->bindParam(":nome", $_POST["nome"], PDO::PARAM_STR);
            $look->bindParam(":cor", $_POST["cor"], PDO::PARAM_STR);
            $look->bindParam(":armazenamento", $_POST["armazenamento"], PDO::PARAM_STR);
            if ($look->execute()) {
                if ($look->rowCount() == 1) {
                    $nomeErr = "Este produto já se encontra registado";
                } else {
                    $nome = trim($_POST["nome"]);
                }
            }
            unset($look);
        }
    }

    $sqlT = "SELECT nome FROM produtos WHERE nome = :nome";
    if ($find = $pdo->prepare($sqlT)) {
        $find->bindParam(":nome", $_POST["nome"], PDO::PARAM_STR);
        if ($find->execute()) 
        {
            $fetchee1 = $find->fetch(PDO::FETCH_OBJ);
            $jaexiste=$fetchee1->nome; 
        }
        unset($find);
    }     

    if (empty($_POST["cor"])) {
        $corErr = "Introduza uma cor";
    } else {
        $cor = trim($_POST["cor"]);
    }

    if (empty($_POST["armazenamento"])) {
        $armazenamentoErr = "Introduza uma capacidade de armazenamento";
    } else if($_POST["armazenamento"] != '32' && $_POST["armazenamento"] != '64' && $_POST["armazenamento"] != '128' && $_POST["armazenamento"] != '256' && $_POST["armazenamento"] != '512'){
        $armazenamentoErr = "Apenas sao aceites as seguintes capacidades de armazenamento (32, 64, 128, 256, 512)";
    }else {
        $armazenamento = trim($_POST["armazenamento"]);
    }
  
    if (empty(trim($_POST["stock"])) || trim($_POST["stock"]) <= 0) {
        $stockErr = "Introduza no minimo 1";
    } else {
        $stock = trim($_POST["stock"]);
    }

    if (empty(trim($_POST["preco"]))) {
        $precoErr = "introduza um valor  ";
    } else {
        $preco = trim($_POST["preco"]);
    }

    if (empty(trim($_POST["categoria"]))) {
        $categoriaErr = "Introduz uma categoria";
    } else {
        $categoria = trim($_POST["categoria"]);
    }

    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $arquivo_tmp = $_FILES['file']['tmp_name'];
        $nomeficheiro = $_FILES['file']['name'];

        $extensao = pathinfo($nomeficheiro, PATHINFO_EXTENSION);

        $extensao = strtolower($extensao);

        if (strstr('.jpg;.jpeg;.gif;.png', $extensao)) {
            $novoNome = uniqid(time()) . '.' . $extensao;

            $destino = 'images/submited/' . $novoNome;

            if (move_uploaded_file($arquivo_tmp, $destino)) {
            } else {
                $file_err = "Erro ao salvar o arquivo.";
            }
        } else {
            $file_err = "Você poderá enviar apenas arquivos .jpg;*.jpeg;*.gif;*.png";
        }
    } else {
        $file_err = "Você não enviou nenhum arquivo!";
    }


    $display = trim($_POST["display"]);


// Verificar existencia de erros antes de inserir na base de dados    
    if (empty($nomeErr) && empty($stockErr) && empty($corErr) && empty($armazenamentoErr) && empty($precoErr) && empty($categoriaErr) && empty($file_err)) {
        $sql = "INSERT INTO produtos (nome, CATEGORIA, display, cameratras, faceid, processador, cartaosim, bluetooth, carregamento, rede, resistenciaagua, bateria, dimensoes, peso) VALUES (:nome, :categoria, :display, :cameratras, :faceid, :processador, :cartaosim, :bluetooth, :carregamento, :rede, :resistenciaagua, :bateria, :dimensoes, :peso)";
        $sql1 = "INSERT INTO especificacoes (product_id, quantidade, cor, armazenamento, preco) VALUES (:produto_id, :quantidade, :cor, :armazenamento, :preco)";
        $sql2 = "SELECT id FROM produtos WHERE nome = :nome";
        $sql3 = "INSERT INTO imagens (produto_id,caminho) values(:prod_id, :caminho)";

        //adicionar produto
        if(empty($jaexiste)){
            if ($stmt = $pdo->prepare($sql)) {
                $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
                $stmt->bindParam(":categoria", $categoria, PDO::PARAM_STR);

                $stmt->bindParam(":display", trim($_POST["display"]), PDO::PARAM_STR);
                $stmt->bindParam(":cameratras", trim($_POST["camera_tras"]), PDO::PARAM_STR);
                $stmt->bindParam(":faceid", trim($_POST["face_id"]), PDO::PARAM_STR);
                $stmt->bindParam(":processador", trim($_POST["processador"]), PDO::PARAM_STR);
                $stmt->bindParam(":cartaosim", trim($_POST["sim"]), PDO::PARAM_STR);
                $stmt->bindParam(":bluetooth", trim($_POST["bluetooth"]), PDO::PARAM_STR);
                $stmt->bindParam(":carregamento", trim($_POST["carregamento"]), PDO::PARAM_STR);
                $stmt->bindParam(":rede", trim($_POST["rede"]), PDO::PARAM_STR);
                $stmt->bindParam(":resistenciaagua", trim($_POST["resistencia"]), PDO::PARAM_STR);
                $stmt->bindParam(":bateria",trim($_POST["bateria"]), PDO::PARAM_STR);
                $stmt->bindParam(":dimensoes", trim($_POST["dimensoes"]), PDO::PARAM_STR);
                $stmt->bindParam(":peso", trim($_POST["peso"]), PDO::PARAM_STR);

                if ($stmt->execute()) {
                    $jacriei = 'ja criei';
                    unset($stmt);
                } else {
                echo "Something went wrong. Please try again later.";
                }
            }
        }

        if(!empty($jaexiste) || !empty($jacriei)){
            //pesquisa o id do produto inserido anteriormente
            if ($stmt2 = $pdo->prepare($sql2)) {
                $stmt2->bindParam(":nome", $nome, PDO::PARAM_STR);
                if ($stmt2->execute()) 
                {
                    $fetchee = $stmt2->fetch(PDO::FETCH_OBJ);
                    $product_id=$fetchee->id;                
                } else {
                        $product_idErr = "Produto não existente";
                }
                unset($stmt2);
            }            
        }

        if(empty($product_idErr)){
        if ($stmt4 = $pdo->prepare($sql3)) {
            $stmt4->bindParam(":prod_id", $product_id, PDO::PARAM_STR);
            $stmt4->bindParam(":caminho", $destino, PDO::PARAM_STR);

            if ($stmt4->execute()) {
                unset($stmt4);
            } else {
            echo "Something went wrong. Please try again later.";
            }
        }
    }

        if(empty($product_idErr)){
            if ($stmt3 = $pdo->prepare($sql1)) {
                $stmt3->bindParam(":produto_id", $product_id, PDO::PARAM_INT);
                $stmt3->bindParam(":quantidade", $stock, PDO::PARAM_INT);
                $stmt3->bindParam(":cor", $cor, PDO::PARAM_STR);
                $stmt3->bindParam(":armazenamento", $armazenamento, PDO::PARAM_STR);
                $stmt3->bindParam(":preco", $preco, PDO::PARAM_STR);
                $stmt3->execute();
                }    
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
                    <h6
                            class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Cupões</span>

                        <a class="plus-circle" href="adminaddvoucher.php">
                            <span data-feather="plus-circle"></span>
                        </a>

                    </h6>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4" style="margin-top: 5vh;">
                <h2>Criar Página</h2>
                <hr class="mb-4">
                <div class="container">
                    <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                        enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-4 <?= (!empty($nomeErr)) ? 'has-error' : ''; ?>">
                                <label for="nome">Nome*</label>
                                <input type="text" name="nome" class="form-control" value="<?= $nome; ?>">
                                <span class="help-block"><?= $nomeErr; ?></span>
                            </div>
                            <div class="col-md-6 mb-4 <?= (!empty($stockErr)) ? 'has-error' : ''; ?>">
                                <label for="stock">Stock* </label>
                                <input type="number" name="stock" class="form-control" value="<?= $stock; ?>">
                                <span class="help-block"><?= $stockErr; ?></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4 <?= (!empty($corErr)) ? 'has-error' : ''; ?>">
                                <label for="nome">Cor*</label>
                                <input type="text" name="cor" class="form-control" value="<?= $cor; ?>">
                                <span class="help-block"><?= $corErr; ?></span>
                            </div>
                            <div class="col-md-6 mb-4 <?= (!empty($armazenamentoErr)) ? 'has-error' : ''; ?>">
                                <label for="stock">Armazenamento* </label>
                                <input type="number" name="armazenamento" class="form-control"
                                    value="<?= $armazenamento; ?>">
                                <span class="help-block"><?= $armazenamentoErr; ?></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4 <?php echo (!empty($precoErr)) ? 'has-error' : ''; ?>">
                                <label for="preco">Preco*</label>
                                <input type="text" name="preco" class="form-control" value="<?= $preco; ?>">
                                <span class="help-block"><?php echo $precoErr; ?></span>
                            </div>
                            <div class="col-md-6 mb-4 <?php echo (!empty($categoriaErr)) ? 'has-error' : ''; ?>">
                                <label for="categoria">Categoria* </label>
                                <input type="text" name="categoria" class="form-control" value="<?= $categoria; ?>">
                                <span class="help-block"><?php echo $categoriaErr; ?></span>
                            </div>
                        </div>
                        <title>Caracteristicas</title>
                        <div class="row">
                            <div class="col-md-6 mb-4 ">
                                <label for="nome">Display</label>
                                <input type="text" name="display" class="form-control">
                            </div>
                            <div class="col-md-6 mb-4 ">
                                <label for="nome">Camera Taseira</label>
                                <input type="text" name="camera_tras" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4 ">
                                <label for="nome">Face Id</label>
                                <input type="text" name="face_id" class="form-control">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="nome">Processador</label>
                                <input type="text" name="processador" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4 ">
                                <label for="nome">Cartão sim</label>
                                <input type="text" name="sim" class="form-control">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="nome">Bluethooth</label>
                                <input type="text" name="bluetooth" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4 ">
                                <label for="nome">Carregamento</label>
                                <input type="text" name="carregamento" class="form-control"
                                    value="<?= $carregamento; ?>">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="nome">Rede</label>
                                <input type="text" name="rede" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="nome">Resistencia a agua</label>
                                <input type="text" name="resistencia" class="form-control">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="nome">Bateria</label>
                                <input type="text" name="bateria" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="nome">Dimensoes</label>
                                <input type="text" name="dimensoes" class="form-control">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="nome">Peso</label>
                                <input type="text" name="peso" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <title>Imagens</title>
                            <div class="col-md-6 mb-4 <?= (!empty($file_err)) ? 'has-error' : ''; ?> ">
                                <label for="imagens">Imagem Principal* </label>
                                <input type="file" name="file" class="form-control" id="inputGroupFile04"
                                    aria-describedby="inputGroupFileAddon04" aria-label="Upload" value="zsxdcfvgbhnj">
                                <span class="help-block"><?= $file_err; ?></span>
                            </div>
                            <div class="col-md-6 mb-4 <?= (!empty($file_err1)) ? 'has-error' : ''; ?> ">
                                <label for="imagens">Imagem Secundaria* </label>
                                <input type="file" name="file1" class="form-control" id="inputGroupFile04"
                                    aria-describedby="inputGroupFileAddon04" aria-label="Upload" value="zsxdcfvgbhnj">
                                <span class="help-block"><?= $file_err1; ?></span>
                            </div>
                        </div>
                        <hr class="mb-4">
                        <button class="btn btn-primary btn-lg btn-block" type="submit">Submeter</button>
                        <br>
                    </form>
                </div>
            </main>
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