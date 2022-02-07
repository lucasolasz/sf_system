<?php
session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";

$id_visitante = $_POST["hidIdVisitante"];

$i = 0;


if (isset($_POST['hidIdDeletarVeiculo'])){
    
    $id_veiculo = intval($_POST['hidIdDeletarVeiculo']);

    // echo var_dump($deleta_veiculo);

    // exit();

    if($id_veiculo != 0){

        $sql = "DELETE FROM tb_veiculo WHERE id_veiculo = " . $id_veiculo;
        
        $resultsDeleteVeiculo = mysqli_query($conn, $sql) or die("Erro ao DELETAR veiculo");

    }


}





// echo $opc_adicionar;
// __halt_compiler();
// 
//Se vazio esta cadastrando novo visitante
if ($id_visitante == "") {

    $nm_visitante = "";
    $documento_visitante = "";
    $telefone_um_visitante = "";
    $telefone_dois_visitante = "";


    $titulo_tela = "Novo Visitante";
} else {

    $titulo_tela = "Editar Visitante";

    $sql = "SELECT * FROM tb_visitante tvis";
    $sql .= " WHERE id_visitante = " . $id_visitante;

    // echo $sql;
    // exit();
    $resultsVisitante = mysqli_query($conn, $sql) or die("Erro ao retornar dados do VISITANTE");

    while ($dados = mysqli_fetch_array($resultsVisitante)) {

        $nm_visitante = $dados['nm_visitante'];
        $documento_visitante = $dados['documento_visitante'];
        $telefone_um_visitante = $dados['telefone_um_visitante'];
        $telefone_dois_visitante = $dados['telefone_dois_visitante'];
    }
}

// echo $id_visitante;
// exit();
?>


<!DOCTYPE html>
<html lang="pt-br">

<?php require_once $_SESSION['caminhopadrao'] . "header.php"; ?>

<style>
    /* Remove setas do campo DOCUMENTO que tem o tipo number. 
    
        /* Chrome e outros */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    #contentLoading {
        position: absolute;
        z-index: 1;
        left: 50%;
        top: 20%;
        margin-left: -110px;
        margin-top: -40px;
    }
</style>

<script>

var arrayIDs = [];

</script>

<body>

    <?php require_once $_SESSION['caminhopadrao'] . "nav.php"; ?>

    <form name="form_sf_system" id="form_sf_system" method="POST">

        <input type="hidden" name="hidIdVisitante" id="hidIdVisitante" value="<?php echo $id_visitante ?>">
        <input type="hidden" name="hidIdOperacaoDeletar" id="hidIdOperacaoDeletar" value="">
        <input type="hidden" name="hidIdDeletarVeiculo" id="hidIdDeletarVeiculo" value="">
        <input type="hidden" name="hidContadorVeiculos" id="hidContadorVeiculos" value="">
        <input type="hidden" name="hidArrayIdCamposVeiculos" id="hidArrayIdCamposVeiculos" value="">
        <input type="hidden" name="hidIncluiVeiculoEdicao" id="hidIncluiVeiculoEdicao" value="">


        <div class="container" id="containeralert"></div>

        <div class="container py-3">

            <!-- Div para mostrar o loading do ajax -->
            <div id="contentLoading">
                <div id="loading"></div>
            </div>

            <h2><?php echo $titulo_tela ?></h2>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="txtNomeVisitante">Nome Completo Visitante</label>
                    <input type="text" class="form-control" name="txtNomeVisitante" id="txtNomeVisitante" value="<?php
                                                                                                                    if (isset($nm_visitante)) {
                                                                                                                        echo $nm_visitante;
                                                                                                                    }
                                                                                                                    ?>" placeholder="Digite o nome">
                </div>
                <div class="form-group col-md-4">
                    <label for="txtDocumento">Documento</label>
                    <input type="text" class="form-control" name="txtDocumento" id="txtDocumento" value="<?php
                                                                                                            if (isset($documento_visitante)) {
                                                                                                                echo $documento_visitante;
                                                                                                            }
                                                                                                            ?>" maxlength="11" placeholder="(RG ou CPF) Somente Números">
                </div>


            </div>

            <div class="row">

                <div class="form-group col-md-4">
                    <label for="txtTelefoneUm">Telefone 1</label>
                    <input type="text" class="form-control" name="txtTelefoneUm" id="txtTelefoneUm" value="<?php
                                                                                                            if (isset($telefone_um_visitante)) {
                                                                                                                echo $telefone_um_visitante;
                                                                                                            }
                                                                                                            ?>" maxlength="11" pattern="([0-9]{3})" placeholder="Digite o Telefone (Somente Números)">
                </div>


                <div class="form-group col-md-4">
                    <label for="txtTelefoneDois">Telefone 2</label>
                    <input type="text" class="form-control" name="txtTelefoneDois" id="txtTelefoneDois" value="<?php
                                                                                                                if (isset($telefone_dois_visitante)) {
                                                                                                                    echo $telefone_dois_visitante;
                                                                                                                }
                                                                                                                ?>" maxlength="11" placeholder="Digite o telefone (Somente Números)">
                </div>



            </div>

            <br>

            <div class="row">

                <div class="form-group col-md-4">
                    <a class="btn btn-primary" href="javascript:void(0)" id="addInput">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        + Adicionar Veiculo
                    </a>
                </div>

            </div>

            <br>

            <?php

            //Carrega os veiculos cadastrados ao editar visitante
            if ($id_visitante != "") {

                $sql = "SELECT * FROM tb_visitante tvi";
                $sql .= " JOIN tb_veiculo tvei ON tvei.fk_visitante = tvi.id_visitante";
                $sql .= " WHERE tvi.id_visitante = " . $id_visitante;


                $result = mysqli_query($conn, $sql) or die("Erro ao retornar dados do VEICULO");

                //Atribui valor retornado para a variavel
                while ($dados = mysqli_fetch_array($result)) {

                    $id_veiculo = $dados['id_veiculo'];
                    $ds_placa_veiculo = $dados['ds_placa_veiculo'];
                    $fk_cor_veiculo = $dados['fk_cor_veiculo'];
                    $fk_tipo_veiculo = $dados['fk_tipo_veiculo']; ?>

                    <div class="row" id="linhacarro<?php echo $i ?>">
                        <div class="form-group col-md-4">
                            <label for="cboTipoVeiculo<?php echo $i ?>">Tipo Veículo</label>
                            <select class="form-select" id="cboTipoVeiculo<?php echo $i ?>" name="cboTipoVeiculo<?php echo $i ?>"  onchange="placaBicicleta(<?php echo $i ?>)" >
                                <option value="0"></option>
                                <?php
                                $sql = "SELECT * FROM tb_tipo_veiculo ORDER BY ds_tipo_veiculo";
                                $results = mysqli_query($conn, $sql) or die("Erro ao retornar TIPOS DE VEICULO");

                                if ($results->num_rows) {
                                    while ($dados = $results->fetch_array()) {

                                        $id_tipo_veiculo = $dados['id_tipo_veiculo'];
                                        $ds_tipo_veiculo = $dados['ds_tipo_veiculo'];

                                        $tipoSelected = "";

                                        if ($fk_tipo_veiculo == $id_tipo_veiculo) {
                                            $tipoSelected = "selected";
                                        }

                                        echo "'<option $tipoSelected value=$id_tipo_veiculo>$ds_tipo_veiculo</option>'";
                                    }
                                } else {
                                    echo "'Nenhum Tipo encontrado'";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="txtPlacaVeiculoVisitante<?php echo $i ?>">Placa do Veículo</label>
                            <input type="text" class="form-control" name="txtPlacaVeiculoVisitante<?php echo $i ?>" id="txtPlacaVeiculoVisitante<?php echo $i ?>" value="<?php echo $ds_placa_veiculo ?>" maxlength="11">
                        </div>


                        <div class="form-group col-md-3">
                            <label for="cboCorVeiculo<?php echo $i ?>">Cor Veículo</label>
                            <select class="form-select" name="cboCorVeiculo<?php echo $i ?>" id="cboCorVeiculo<?php echo $i ?>">
                                <option value="0"></option>
                                <?php

                                $sql = "SELECT * FROM tb_cor_veiculo ORDER BY ds_cor_veiculo";
                                $results = mysqli_query($conn, $sql) or die("Erro ao retornar CORES DE VEICULO");

                                if ($results->num_rows) {
                                    while ($dados = $results->fetch_array()) {

                                        $id_cor_veiculo = $dados['id_cor_veiculo'];
                                        $ds_cor_veiculo = $dados['ds_cor_veiculo'];

                                        $corSelected = "";

                                        if ($fk_cor_veiculo == $id_cor_veiculo) {
                                            $corSelected = "selected";
                                        }

                                        echo "'<option $corSelected value=$id_cor_veiculo>$ds_cor_veiculo</option>'";
                                    }
                                } else {
                                    echo "'Nenhuma Cor encontrada'";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-1">
                            <label for="remInput<?php echo $i ?>">Remover</label>
                            <a class="btn btn-danger" href="javascript:void(0)" id="remInput<?php echo $i ?>" onclick="removeLinhaVeiculoEdit(<?php echo $id_veiculo ?>, <?php echo $id_visitante ?>)">
                            <img src="../../../bootstrap-icons/trash.svg" alt="">                                
                            </a>
                        </div>
                    </div>

                    <script>
                        arrayIDs.push(<?php echo $i ?>)
                        console.log(arrayIDs);
                    </script>
            <?php 
                /*Incrementa o valor de i depois de exibir os campos. 
                Tive que fazer desta forma, pois o contador das linhas estava
                iniciando com 1 e nao com 0.*/
                $i++; 
                }
            } 
            ?>

            <div class="container p-0" id="dynamicDiv">

            </div>

            <br>
            <br>
            <br>

            <button type="button" class="btn btn-success btn-lg" name="btnCancelarNovoVisitante" id="btnCancelarNovoVisitante" onClick="">Cancelar</button>

            <?php if ($id_visitante == "") { ?>
                <button type="button" class="btn btn-success btn-lg" name="btnSalvarNovoVisitante" id="btnSalvarNovoVisitante" onClick="">
                    <img src="../../../bootstrap-icons/check-square-fill.svg" alt="" > Salvar&nbsp;
                </button>
            <?php } else { ?>
                <button type="button" class="btn btn-success btn-lg" name="btnEditarVisitante" id="btnEditarVisitante" onClick="">
                    <img src="../../../bootstrap-icons/check-square-fill.svg" alt=""> Salvar&nbsp;
                </button>
            <?php } ?>



            <?php if ($id_visitante != "") { ?>
                <button type="button" class="btn btn-danger btn-lg" name="btnExcluir" id="btnExcluir" onClick="exlcuirVisitante(<?php echo $id_visitante ?>)">
                    <img src="../../../bootstrap-icons/trash.svg" alt=""> Excluir&nbsp;
                </button>
            <?php } ?>

        </div>
    </form>


    <script>
        var i = <?php echo $i ?>;
        

        $(document).ready(function() {

            //Força usuário a digitar somente números
            $("#txtTelefoneUm").keyup(function() {
                $("#txtTelefoneUm").val(this.value.match(/[0-9]*/));
            });

            $("#txtTelefoneDois").keyup(function() {
                $("#txtTelefoneDois").val(this.value.match(/[0-9]*/));
            });

            $("#txtDocumento").keyup(function() {
                $("#txtDocumento").val(this.value.match(/[0-9]*/));
            });
            
            
        });


        //inclui dinamicamente os campos para adicionar carros
        $(function() {
            var scntDiv = $('#dynamicDiv');

            $(document).on('click', '#addInput', function() {
                
                $('<div class="row" id="linhacarro' + i + '">' +
                    '<div class="form-group col-md-4">' +
                    '<label for="cboTipoVeiculo' + i + '">Tipo Veículo</label>' +
                    '<select class="form-select" id="cboTipoVeiculo' + i + '" name="cboTipoVeiculo' + i + '" onchange="placaBicicleta(' + i + ')">' +
                    '<option value="0"></option>' +
                    <?php
                    $sql = "SELECT * FROM tb_tipo_veiculo ORDER BY ds_tipo_veiculo";
                    $results = mysqli_query($conn, $sql) or die("Erro ao retornar dados");

                    if ($results->num_rows) {
                        while ($dados = $results->fetch_array()) {

                            $id_tipo_veiculo = $dados['id_tipo_veiculo'];
                            $ds_tipo_veiculo = $dados['ds_tipo_veiculo'];

                            echo "'<option value=$id_tipo_veiculo>$ds_tipo_veiculo</option>'+";
                        }
                    } else {
                        echo "'Nenhuma cor encontrada'";
                    }
                    ?> '</select>' +
                    '</div>' +
                    '<div class="form-group col-md-4">' +
                    '<label for="txtPlacaVeiculoVisitante' + i + '">Placa do Veículo</label>' +
                    '<input type="text" class="form-control" name="txtPlacaVeiculoVisitante' + i + '" id="txtPlacaVeiculoVisitante' + i + '" value="" maxlength="11" placeholder="Digite a placa (Somente Número e Letra)">' +
                    '</div>' +
                    // '</div>'+
                    '<div class="form-group col-md-3">' +
                    '<label for="cboCorVeiculo' + i + '">Cor Veículo</label>' +
                    '<select class="form-select" name="cboCorVeiculo' + i + '" id="cboCorVeiculo' + i + '">' +
                    '<option value="0"></option>' +
                    <?php
                    $sql = "SELECT * FROM tb_cor_veiculo ORDER BY ds_cor_veiculo";
                    $results = mysqli_query($conn, $sql) or die("Erro ao retornar dados");

                    if ($results->num_rows) {
                        while ($dados = $results->fetch_array()) {

                            $id_cor_veiculo = $dados['id_cor_veiculo'];
                            $ds_cor_veiculo = $dados['ds_cor_veiculo'];

                            echo "'<option value=$id_cor_veiculo>$ds_cor_veiculo</option>'+";
                        }
                    } else {
                        echo "'Nenhuma cor encontrada'";
                    }
                    ?> '</select>' +
                    '</div>' +
                    '<div class="form-group col-md-1">' +
                    '<label for="remInput' + i + '">Remover</label>' +
                    '<a class="btn btn-danger" href="javascript:void(0)" id="remInput' + i + '" onclick="removeLinhaVeiculo(' + i + ')">' +
                    '<img src="../../../bootstrap-icons/trash.svg" alt="">' +
                    '</a>' +
                    '</div>' +
                    '</div>').appendTo(scntDiv);

                    /*Função que Adiciona valor ao final do array.
                    Evitou a necessidade de criar variavel de controle da posicao do array*/
                    arrayIDs.push(i);

//                    console.log("fora do edit:" + arrayIDs);
                    
                    /*Incrementa o valor de i depois de exibir os campos. 
                    Tive que fazer desta forma, pois o contador das linhas estava
                    iniciando com 1 e nao com 0.*/
                    i++;

                return false;
            });

            
        });
        
        
        
        function placaBicicleta(linha_da_placa) {
        
            id_tipo_veiculo = $("#cboTipoVeiculo" + linha_da_placa).val();
            
            if (id_tipo_veiculo == 4){
                $("#txtPlacaVeiculoVisitante" + linha_da_placa).val("S/PLACA");
                $("#txtPlacaVeiculoVisitante" + linha_da_placa).prop('readonly', true);
            } else{
                $("#txtPlacaVeiculoVisitante" + linha_da_placa).val("");
                $("#txtPlacaVeiculoVisitante" + linha_da_placa).prop('readonly', false);
            }
            
        }


        function removeLinhaVeiculoEdit(id_veiculo, id_visitante){

            console.log("valor do id passado remocao edit: " + id_veiculo)
            console.log("valor do visitante: " + id_visitante);


            $("#hidIdVisitante").val(id_visitante);
            $("#hidIdDeletarVeiculo").val(id_veiculo);


            var form = document.getElementById("form_sf_system");
            form.action = "edit_visitante.php";
            form.submit();
        }

        function removeLinhaVeiculo(id){

            // console.log("valor do id passado: " + id)
            
            /*Remove valor do array pelo indice.
            Informe a posicao que sera removido e em seguida a quantidade de itens 
            a partir da posicao indicada*/
            arrayIDs.splice(id, 1);

            // console.log("Array : " + arrayIDs)

            //Remove a linha do HTML via Jquery
            $("#remInput"+ id).parents('#linhacarro'+ id).remove();   
           
            return false;
        }


        $("#btnEditarVisitante").click(function() {

            var contadorCarros = i;

            /*Necessário, pois quando o usuario excluia algum carro da lista dinamica
            dava erro no insert*/
            if (arrayIDs.length > 0){
                $("#hidArrayIdCamposVeiculos").val(arrayIDs);
            } else {
                $("#hidArrayIdCamposVeiculos").val(-1);
            }

            //Atribui valor ao campo hiden para ser resgatado no grava via post
            // $("#hidArrayIdCamposVeiculos").val(i);

            var form = document.getElementById("form_sf_system");
            form.action = "grava_visitante.php";
            form.submit();
        });

        function exibeMensagem(msg) {
            mensagem = "<div class='alert alert-danger text-center' role='alert'>Falha ao criar visitante: " + msg + "</div>";
            return mensagem
        }


        $("#btnSalvarNovoVisitante").click(function() {

            var txtNomeVisitante = $("#txtNomeVisitante").val();
            var txtDocumento = $("#txtDocumento").val();
            var contadorCarros = i;

            //Verifica se campos estão vazios para salvar
            $("#txtNomeVisitante").html("");
            if (txtNomeVisitante == "") {
                msg = "<b>Digite um NOME</b>";
                $("#containeralert").html(exibeMensagem(msg));
                return false;
            }

            $("#txtDocumento").html("");
            if (txtDocumento == "") {
                msg = "<b>Digite um DOCUMENTO</b>";
                $("#containeralert").html(exibeMensagem(msg));
                return false;
            }
            

            /*Necessário, pois quando o usuario excluia algum carro da lista dinamica
            dava erro no insert*/
            if (arrayIDs.length > 0){
                $("#hidArrayIdCamposVeiculos").val(arrayIDs);
            } else {
                $("#hidArrayIdCamposVeiculos").val(-1);
            }

            //Atribui valor ao campo hiden para ser resgatado no grava via post
            $("#hidContadorVeiculos").val(i);
            
            

            // Invoca a função via Ajax para verificar se existe visitante semelhante
            validaVisitante(txtNomeVisitante);

        });

        function validaVisitante(txtNomeVisitante) {

            $.ajax({
                url: '/pesquisas_ajax/verifica_se_visitante_existe.php',
                type: 'POST',
                data: "nm_visitante=" + txtNomeVisitante,
                beforeSend: function() {
                    // loading_show();
                },
                success: function(data) {
                    // loading_hide();
                    $mensagem = data;
                    $("#containeralert").html($mensagem);
                    if ($mensagem == "") {
                        var form = document.getElementById("form_sf_system");
                        form.action = "grava_visitante.php";
                        form.submit();
                    }
                    //Define um tempo para o elemento sumir da tela.
                    // setTimeout(function(){
                    //     $("#containeralert").fadeOut('Slow');
                    // },4000)
                },
                error: function(data) {
                    console.log("Ocorreu erro ao VALIDAR usuário via AJAX.");
                    // $('#cboCidade').html("Houve um erro ao carregar");
                }
            });

        }

        function exlcuirVisitante(id_visitante) {

            console.log(id_visitante);

            $("#hidIdVisitante").val(id_visitante);
            $("#hidIdOperacaoDeletar").val(true);
            var form = document.getElementById("form_sf_system");
            form.action = "cad_visitante.php";
            form.submit();

        }


        $("#btnCancelarNovoVisitante").click(function() {

            var form = document.getElementById("form_sf_system");
            form.action = "cad_visitante.php";
            form.submit();

        });
    </script>

</body>

</html>