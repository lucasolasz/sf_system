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
$sql = "SELECT * FROM tb_historico_relatorio_visita"  
    . " WHERE 1 = 1 ";

//Filtra as datas
if (isset($_POST["txtDataInicioPeriodo"], $_POST["txtDataTerminoPeriodo"])){
    
    $txtDataInicioPeriodo = $_POST["txtDataInicioPeriodo"];
    $txtDataTerminoPeriodo = $_POST["txtDataTerminoPeriodo"];

    if ($txtDataInicioPeriodo != "" or $txtDataTerminoPeriodo != "" ){ 
        $sql .= " AND dt_entrada_visita_hst BETWEEN '$txtDataInicioPeriodo' AND '$txtDataTerminoPeriodo'";
    }
}

//Filtra os porteiros pelo nome
if (isset($_POST["cboNomeUsuario"])){
    $ds_nome_usuario = $_POST["cboNomeUsuario"];

    if($ds_nome_usuario != ""){
        $sql .= " AND nm_usuario_entrada_hst = '$ds_nome_usuario'";
    }
}

//Filtra tipo visita pelo nome
if (isset($_POST["cboTipoVisita"])){
    $ds_tipo_visita = $_POST["cboTipoVisita"];

    if($ds_tipo_visita != ""){
        $sql .= " AND ds_tipo_visita_hst = '$ds_tipo_visita'";
    }
}

//Filtra tipo veiculo pelo nome
if (isset($_POST["cboTipoVeiculo"])){
    $ds_tipo_veiculo = $_POST["cboTipoVeiculo"];

    if($ds_tipo_veiculo != ""){
        $sql .= " AND ds_tipo_veiculo_hst = '$ds_tipo_veiculo'";
    }
}

//Filtra descricao da casa
if (isset($_POST["cboCasa"])){
    $ds_casa_visita = $_POST["cboCasa"];

    if($ds_casa_visita != ""){
        $sql .= " AND ds_casa_visita_hst = '$ds_casa_visita'";
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

                                echo "'<option $porteiroSelected value=$ds_nome_usuario>$ds_nome_usuario</option>'";
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

                                echo "'<option $tipoVisitaSelected value=$ds_tipo_visita>$ds_tipo_visita</option>'";
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


                                echo "'<option $tipoVeiculoSelected value=$ds_tipo_veiculo>$ds_tipo_veiculo</option>'";
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
                        <th>Data Entrada</th>
                    </tr>
                </thead>
                <tbody>

                    <?php if ($resultsSqlPrincipal->num_rows) {
                        while ($dados = $resultsSqlPrincipal->fetch_array()) {
                            
                            $nm_usuario_entrada_hst = $dados['nm_usuario_entrada_hst'];
                            $nm_visitante_hst = $dados['nm_visitante_hst'];
                            $ds_tipo_visita_hst = $dados['ds_tipo_visita_hst'];
                            $ds_tipo_veiculo_hst = $dados['ds_tipo_veiculo_hst'];
                            $ds_casa_visita_hst = $dados['ds_casa_visita_hst'];
                            $dt_entrada_visita_hst = date('d/m/Y', strtotime($dados['dt_entrada_visita_hst']));
                            
                            

                    ?>       
                        <tr>
                            <td><?php echo $nm_usuario_entrada_hst ?></td>
                            <td><?php echo $nm_visitante_hst ?></td>
                            <td><?php echo $ds_tipo_visita_hst ?></td>
                            <td><?php echo $ds_tipo_veiculo_hst ?></td>
                            <td><?php echo $ds_casa_visita_hst ?></td>
                            <td><?php echo $dt_entrada_visita_hst ?></td>
                        </tr>

                  <?php      }
                    } else {
                        echo "<tr><td colspan='6' style='text-align: center'>Nenhum resultado encontrado</td></tr>";
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