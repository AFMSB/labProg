<?php
session_start();
require_once "config.php";


try{
    $pdo->beginTransaction();
    $inserirEncomenda = $pdo->prepare("insert into encomenda (total, estado, data_pagamento, user_id) values (:total, 'Pagamento Confirmado', :dataPagamento, :userId)");
    $inserirEncomenda->bindParam(":total", $_SESSION['total'], PDO:: PARAM_STR);
    $inserirEncomenda->bindParam(":dataPagamento", $expiracyToken, PDO:: PARAM_STR);
    $inserirEncomenda->bindParam(":userId", $_SESSION['id'], PDO:: PARAM_STR);
    $expiracyToken=date('y-m-d H:m:s');
    $inserirEncomenda->execute();

    $procuraEncomenda = $pdo->prepare("select id from encomenda where user_id = :idUser order by data desc limit 1");
    $procuraEncomenda->bindParam(":idUser", $_SESSION['id'], PDO:: PARAM_STR);
    $procuraEncomenda->execute();
    $encomenda = $procuraEncomenda->fetch(PDO::FETCH_OBJ);
    $encomendaID = $encomenda->id;

    foreach($_SESSION['carrinho'] as $arr){
        $teste=$arr['nome']." ".$arr['cor']." ".$arr['armazenamento'];
        $teste1 = $arr['quantidade'];
        $teste4 = $arr['preco'];

        $procuraStock = $pdo->prepare("select quantidade from especificacoes where product_id = :productId and cor = :cor and armazenamento = :armazenamento");
        $procuraStock->bindParam(":productId", $arr['id'], PDO:: PARAM_STR);
        $procuraStock->bindParam(":cor", $arr['cor'], PDO:: PARAM_STR);
        $procuraStock->bindParam(":armazenamento", $arr['armazenamento'], PDO:: PARAM_STR);
        $procuraStock->execute();
        $stock = $procuraStock->fetch(PDO::FETCH_OBJ);

        if($teste1 <= $stock->quantidade){
            $atualizarstock = $pdo->prepare("update especificacoes set quantidade = quantidade - :quantidade where product_id = :produtoId and cor = :cor and armazenamento = :armazenamento");
            $atualizarstock->bindParam(":quantidade", $arr['quantidade'], PDO:: PARAM_STR);
            $atualizarstock->bindParam(":produtoId", $arr['id'], PDO:: PARAM_STR);
            $atualizarstock->bindParam(":cor", $arr['cor'], PDO:: PARAM_STR);
            $atualizarstock->bindParam(":armazenamento", $arr['armazenamento'],PDO:: PARAM_STR);
            $atualizarstock->execute();

            $inserirProdutoEncomenda = $pdo->prepare("insert into encomenda_produto (infoproduto, quantidade, preco, encomenda_id, estado) values (:infoproduto, :quantidade, :preco, :encomenda_id, 'Em Preparacão')");
            $inserirProdutoEncomenda->bindParam(":infoproduto", $teste, PDO:: PARAM_STR);
            $inserirProdutoEncomenda->bindParam(":quantidade", $teste1, PDO:: PARAM_STR);
            $inserirProdutoEncomenda->bindParam(":preco", $teste4, PDO:: PARAM_STR);
            $inserirProdutoEncomenda->bindParam(":encomenda_id", $encomendaID, PDO:: PARAM_STR);
            $inserirProdutoEncomenda->execute();
        }else{
            $diferenca = $teste1 - $stock->quantidade;

            $atualizarstock = $pdo->prepare("update especificacoes set quantidade = 0 where product_id = :produtoId and cor = :cor and armazenamento = :armazenamento");
            $atualizarstock->bindParam(":produtoId", $arr['id'], PDO:: PARAM_STR);
            $atualizarstock->bindParam(":cor", $arr['cor'], PDO:: PARAM_STR);
            $atualizarstock->bindParam(":armazenamento", $arr['armazenamento'],PDO:: PARAM_STR);
            $atualizarstock->execute();

            if($stock->quantidade > 0){
                $inserirProdutoEncomenda = $pdo->prepare("insert into encomenda_produto (infoproduto, quantidade, preco, encomenda_id, estado) values (:infoproduto, :quantidade, :preco, :encomenda_id, 'Em Preparacão')");
                $inserirProdutoEncomenda->bindParam(":infoproduto", $teste, PDO:: PARAM_STR);
                $inserirProdutoEncomenda->bindParam(":quantidade", $stock->quantidade, PDO:: PARAM_STR);
                $inserirProdutoEncomenda->bindParam(":preco", $teste4, PDO:: PARAM_STR);
                $inserirProdutoEncomenda->bindParam(":encomenda_id", $encomendaID, PDO:: PARAM_STR);
                $inserirProdutoEncomenda->execute();
            }
            $inserirProdutoEncomenda = $pdo->prepare("insert into encomenda_produto (infoproduto, quantidade, preco, encomenda_id, estado) values (:infoproduto, :quantidade, 0, :encomenda_id, 'Stock Esgotado')");
            $inserirProdutoEncomenda->bindParam(":infoproduto", $teste, PDO:: PARAM_STR);
            $inserirProdutoEncomenda->bindParam(":quantidade", $diferenca, PDO:: PARAM_STR);
            $inserirProdutoEncomenda->bindParam(":encomenda_id", $encomendaID, PDO:: PARAM_STR);
            $inserirProdutoEncomenda->execute();
        }
    }
    $pdo->commit();
}catch (Exception $e){
    $pdo->rollBack();
}




$_SESSION['carrinho'] = array();

header("location: fatura.php");
?>