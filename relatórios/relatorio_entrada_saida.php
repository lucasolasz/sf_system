<?php
session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";



$id_usuarioLogado =  $_SESSION['usuarioID'];

//Verifica se o usuario está logado
if (!isset($_SESSION['usuarioUsuario'])) {
    header("Location: index.php");
}

//Define o timezone
date_default_timezone_set('America/Sao_Paulo');


if (isset($_POST["txtDataInicioPeriodo"])) {
    $txtDataInicioPeriodo = $_POST["txtDataInicioPeriodo"];
}

//SQL principal
$sql = "SELECT * FROM tb_visita tvis" .
    " JOIN tb_usuario tus ON tus.id_usuario = tvis.fk_usuario_entrada" .
    " JOIN tb_usuario tusa ON tusa.id_usuario = tvis.fk_usuario_saida" .
    " JOIN tb_cargo tcar ON tcar.id_cargo = tus.fk_cargo" .
    " JOIN tb_cargo tcarsa ON tcarsa.id_cargo = tusa.fk_cargo" .
    " JOIN tb_tipo_visita tvisa ON tvisa.id_tipo_visita = tvis.fk_tipo_visita" .
    " JOIN tb_veiculo tvei ON tvei.ds_placa_veiculo = tvis.ds_placa_veiculo_visitante" .
    " JOIN tb_tipo_veiculo ttivei ON ttivei.id_tipo_veiculo = tvei.fk_tipo_veiculo" .
    " JOIN tb_casa tcas ON tcas.ds_numero_casa = tvis.ds_casa_visita" .
    " JOIN tb_visitante tvista ON tvista.id_visitante = tvis.fk_visitante" .
    " WHERE 1 = 1 ";

//Filtra as datas
if (isset($_POST["txtDataInicioPeriodo"], $_POST["txtDataTerminoPeriodo"])){
    
    $txtDataInicioPeriodo = $_POST["txtDataInicioPeriodo"];
    $txtDataTerminoPeriodo = $_POST["txtDataTerminoPeriodo"];

    if ($txtDataInicioPeriodo != "" or $txtDataTerminoPeriodo != "" ){ 
        $sql .= " AND dt_entrada_visita BETWEEN '$txtDataInicioPeriodo' AND '$txtDataTerminoPeriodo'";
    }
}

//Filtra os porteiros pelo id
if (isset($_POST["cboNomeUsuario"])){
    $fk_usuario_entrada = $_POST["cboNomeUsuario"];

    if($fk_usuario_entrada != ""){
        $sql .= " AND fk_usuario_entrada = '$fk_usuario_entrada'";
    }
}

//Filtra tipo visita pelo id
if (isset($_POST["cboTipoVisita"])){
    $fk_tipo_visita = $_POST["cboTipoVisita"];

    if($fk_tipo_visita != ""){
        $sql .= " AND fk_tipo_visita = '$fk_tipo_visita'";
    }
}

//Filtra tipo veiculo pelo id
if (isset($_POST["cboTipoVeiculo"])){
    $fk_tipo_veiculo = $_POST["cboTipoVeiculo"];

    if($fk_tipo_veiculo != ""){
        $sql .= " AND fk_tipo_veiculo = '$fk_tipo_veiculo'";
    }
}

//Filtra descricao da casa
if (isset($_POST["cboCasa"])){
    $ds_casa_visita = $_POST["cboCasa"];

    if($ds_casa_visita != ""){
        $sql .= " AND ds_casa_visita = '$ds_casa_visita'";
    }
}


//Executa a query no banco    
$resultsSqlPrincipal = mysqli_query($conn, $sql) or die("Erro ao retornar SQL PRINCIPAL");




?>

<!DOCTYPE html>
<html lang="pt-br">

<?php require_once $_SESSION['caminhopadrao'] . "header.php"; ?>

<body>

    <?php require_once $_SESSION['caminhopadrao'] . "nav.php"; ?>

    <div class="container" id="containeralert"> </div>

    <br>

    <div class="container">
        <div class="alert alert-<?php echo $corMensagem; ?> text-center" role="alert">
            <?php
            if (isset($_SESSION['mensagem'])) {
                echo $_SESSION['mensagem'];
                unset(
                    $_SESSION['mensagem'],
                    $_SESSION['corMensagem']
                );
            }
            ?>
        </div>
    </div>

    <div class="container">
        <h2>Relatório Entrada e Saída</h2>
        <br>
    </div>





    <br>

    <form name="form_sf_system" id="form_sf_system" method="POST">

        <input type="hidden" name="hidIDataInicioPeriodo" id="hidIDataInicioPeriodo" value="">
        <input type="hidden" name="hidIdDataTerminoPeriodo" id="hidIdDataTerminoPeriodo" value="">

        <div class="container">
            <div class="row">

                <div class="form-group col-md-4">
                    <label for="txtDataInicioPeriodo">Data Início Período</label>
                    <input type="date" class="form-control" name="txtDataInicioPeriodo" id="txtDataInicioPeriodo" value="<?php echo $txtDataInicioPeriodo ?>">  
                </div>
                
                <div class="form-group col-md-4">
                    <label for="txtDataTerminoPeriodo">Data Término Período</label>
                    <input type="date" class="form-control" name="txtDataTerminoPeriodo" id="txtDataTerminoPeriodo" value="<?php echo $txtDataTerminoPeriodo ?>">
                </div>

                <div class="form-group col-md-4">
                    <label for="cboNomeUsuario">Porteiros</label>
                    <select class="form-select" id="cboNomeUsuario" name="cboNomeUsuario">
                        <option value=""></option>
                        <?php

                        $sql = "SELECT * FROM tb_usuario WHERE fk_cargo = 3";
                        $results = mysqli_query($conn, $sql) or die("Erro ao retornar PORTEIROS");

                        if ($results->num_rows) {
                            while ($dados = $results->fetch_array()) {

                                $id_usuario = $dados['id_usuario'];
                                $ds_nome_usuario = $dados['ds_nome_usuario'];

                                $porteiroSelected = "";
                                if ($fk_usuario_entrada == $id_usuario){
                                    $porteiroSelected = "selected";
                                }

                                echo "'<option $porteiroSelected value=$id_usuario>$ds_nome_usuario</option>'";
                            }
                        } else {
                            echo "'Nenhum porteiro encontrado'";
                        }
                        ?>
                    </select>
                </div>

            </div>

        </div>

        <div class="container">
            <div class="row">

                

                <div class="form-group col-md-4">
                    <label for="cboTipoVisita">Tipo Visita</label>
                    <select class="form-select" id="cboTipoVisita" name="cboTipoVisita">
                        <option value=""></option>
                        <?php

                        $sql = "SELECT * FROM tb_tipo_visita";
                        $results = mysqli_query($conn, $sql) or die("Erro ao retornar TIPO VISITA");

                        if ($results->num_rows) {
                            while ($dados = $results->fetch_array()) {

                                $id_tipo_visita = $dados['id_tipo_visita'];
                                $ds_tipo_visita = $dados['ds_tipo_visita'];

                                $tipoVisitaSelected = "";
                                if ($fk_tipo_visita == $id_tipo_visita){
                                    $tipoVisitaSelected = "selected";
                                }

                                echo "'<option $tipoVisitaSelected value=$id_tipo_visita>$ds_tipo_visita</option>'";
                            }
                        } else {
                            echo "'Nenhum tipo visita encontrado'";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="cboTipoVeiculo">Tipo Veículo</label>
                    <select class="form-select" id="cboTipoVeiculo" name="cboTipoVeiculo">
                        <option value=""></option>
                        <?php

                        $sql = "SELECT * FROM tb_tipo_veiculo";
                        $results = mysqli_query($conn, $sql) or die("Erro ao retornar TIPO VEICULO");

                        if ($results->num_rows) {
                            while ($dados = $results->fetch_array()) {

                                $id_tipo_veiculo = $dados['id_tipo_veiculo'];
                                $ds_tipo_veiculo = $dados['ds_tipo_veiculo'];

                                $tipoVeiculoSelected = "";
                                if ($fk_tipo_veiculo == $id_tipo_veiculo){
                                    $tipoVeiculoSelected = "selected";
                                }


                                echo "'<option $tipoVeiculoSelected value=$id_tipo_veiculo>$ds_tipo_veiculo</option>'";
                            }
                        } else {
                            echo "'Nenhum tipo veiculo encontrado'";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="cboCasa">Casa</label>
                    <select class="form-select" id="cboCasa" name="cboCasa">
                        <option value=""></option>
                        <?php

                        $sql = "SELECT * FROM tb_casa";
                        $results = mysqli_query($conn, $sql) or die("Erro ao retornar CASA");

                        if ($results->num_rows) {
                            while ($dados = $results->fetch_array()) {

                                $ds_numero_casa = $dados['ds_numero_casa'];

                                $casaSelected = "";
                                if ($ds_casa_visita == $ds_numero_casa){
                                    $casaSelected = "selected";
                                }

                                echo "'<option $casaSelected value=$ds_numero_casa>$ds_numero_casa</option>'";
                            }
                        } else {
                            echo "'Nenhuma casa encontrada'";
                        }
                        ?>
                    </select>
                </div>

            </div>

        </div>

        <br>
        <br>

        <div class="container">

            <button type="button" class="btn btn-success btn-sm" name="btnGeraRelatorio" id="btnGeraRelatorio" onClick="">
                <img src="../../../bootstrap-icons/clipboard-data.svg" alt="" height="30px" width="30px"> Filtrar Relatório&nbsp;
            </button>

            <button type="button" class="btn btn-success btn-sm" name="btnGeraRelatorio" id="btnGeraRelatorio" onClick="">
                <img src="../../../bootstrap-icons/arrow-up-circle-fill.svg" alt="" height="30px" width="30px"> Exportar Relatório&nbsp;
            </button>

        </div>



        <br>
        <br>

        <div class="container">

            <table class="table table-success table-bordered" id="tableVisitaEmAndamento">
                <thead>
                    <tr>
                        <th>Porteiro</th>
                        <th>Nome Visitante</th>
                        <th>Tipo Visita</th>
                        <th>Tipo Veículo</th>
                        <th>Casa</th>
                    </tr>
                </thead>
                <tbody>

                    <?php if ($resultsSqlPrincipal->num_rows) {
                        while ($dados = $resultsSqlPrincipal->fetch_array()) {
                            
                            $ds_nome_usuario = $dados['ds_nome_usuario'];
                            $nm_visitante = $dados['nm_visitante'];
                            $ds_tipo_visita = $dados['ds_tipo_visita'];
                            $ds_tipo_veiculo = $dados['ds_tipo_veiculo'];
                            $ds_numero_casa = $dados['ds_numero_casa'];
                            
                            

                    ?>       
                        <tr>
                            <td><?php echo $ds_nome_usuario ?></td>
                            <td><?php echo $nm_visitante ?></td>
                            <td><?php echo $ds_tipo_visita ?></td>
                            <td><?php echo $ds_tipo_veiculo ?></td>
                            <td><?php echo $ds_numero_casa ?></td>
                        </tr>

                  <?php      }
                    } else {
                        echo "<tr><td colspan='5' style='text-align: center'>Nenhum resultado encontrado</td></tr>";
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </form>

    <script>
        function exibeMensagem(msg) {
            mensagem = "<div class='alert alert-danger text-center' role='alert'>Falha ao filtrar relatório: " + msg + "</div>";
            return mensagem
        }

        $("#btnGeraRelatorio").click(function() {

            var txtDataInicioPeriodo = $("#txtDataInicioPeriodo").val();
            var txtDataTerminoPeriodo = $("#txtDataTerminoPeriodo").val();

            if (txtDataInicioPeriodo != "") {

                //Verifica se campos estão vazios para salvar
                $("#txtDataTerminoPeriodo").html("");
                if (txtDataTerminoPeriodo == '') {
                    msg = "<b>Escolha a DATA TÉRMINO PERÍODO</b>";
                    $("#containeralert").html(exibeMensagem(msg));
                    return false;
                }

            }

            submeterFormulario();

        });


        function submeterFormulario() {


            var form = document.getElementById("form_sf_system");
            form.action = "relatorio_entrada_saida.php";
            form.submit();
        }

        function exibeMensagem(msg) {
            mensagem = "<div class='alert alert-danger text-center' role='alert'>Falha ao criar visitante: " + msg + "</div>";
            return mensagem
        }
    </script>

</body>

</html>