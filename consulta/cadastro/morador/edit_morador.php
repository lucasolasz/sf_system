<?php
session_start();

require_once $_SESSION['caminhopadrao'] . "conexao.php";

$id_morador = $_POST["hidIdMorador"];

//Inicio do contador global dos carros
$i = 0;


if (isset($_POST['hidIdDeletarVeiculo'])){
    
    $id_veiculo = intval($_POST['hidIdDeletarVeiculo']);


    if($id_veiculo != 0){

        $sql = "DELETE FROM tb_veiculo WHERE id_veiculo =  $id_veiculo";
        
        $resultsDeleteVeiculo = mysqli_query($conn, $sql) or die("Erro ao DELETAR veiculo");

    }

}


//Se vazio esta cadastrando novo visitante
if ($id_morador == "") {

    $titulo_tela = "Novo Morador";
    $flag_locatario = "NULL";
    $exibeDisabled = "disabled";
    
} else {

    $titulo_tela = "Editar Morador";

    $sql = "SELECT * FROM tb_morador mor";
    $sql .= " WHERE id_morador = $id_morador";

    // echo $sql;
    // exit();
    $resultsMorador = mysqli_query($conn, $sql) or die("Erro ao retornar dados do MORADOR");

    while ($dados = mysqli_fetch_array($resultsMorador)) {

        $nm_morador = $dados["nm_morador"];
        $fk_casa = $dados["fk_casa"];
        $documento_morador = $dados["documento_morador"];
        $dt_nascimento_morador = $dados["dt_nascimento_morador"];
        $tel_um_morador = $dados["tel_um_morador"];
        $tel_dois_morador = $dados["tel_dois_morador"];
        $email_morador = $dados["email_morador"];
        $tel_emergencia = $dados["tel_emergencia"];
        
        $flag_locatario = $dados["flag_locatario"];

        // echo "valor locatario" . $flag_locatario;
        // exit();
        $nm_locatario = $dados["nm_locatario"];
        $documento_locatario = $dados["documento_locatario"];
        $dt_nascimento_locatario = $dados["dt_nascimento_locatario"];
        $tel_um_locatario = $dados["tel_um_locatario"];
        $tel_dois_locatario = $dados["tel_dois_locatario"];
    }
    
    //Altera exibição do disabled dos campos de locatário na tela de edição
    if ($flag_locatario == 'S'){ $exibeDisabled = ""; } else { $exibeDisabled = "disabled"; }
}

  
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
    
    
//Inicia o array que irá receber os índices de cada veículo
var arrayIDs = [];

</script>

<body>

    <?php require_once $_SESSION['caminhopadrao'] . "nav.php"; ?>

    <form name="form_sf_system" id="form_sf_system" method="POST">

        <input type="hidden" name="hidIdMorador" id="hidIdMorador" value="<?php echo $id_morador ?>">
        <input type="hidden" name="hidIdOperacaoDeletar" id="hidIdOperacaoDeletar" value="">
        <input type="hidden" name="hidIdDeletarVeiculo" id="hidIdDeletarVeiculo" value="">
        <input type="hidden" name="hidContadorVeiculos" id="hidContadorVeiculos" value="">
        <input type="hidden" name="hidArrayIdCamposVeiculos" id="hidArrayIdCamposVeiculos" value="">
        <input type="hidden" name="hidIncluiVeiculoEdicao" id="hidIncluiVeiculoEdicao" value="">


        <div class="container" id="containeralert"></div>

        <div class="container py-3">

            <h2><?php echo $titulo_tela ?></h2>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="txtNomeMorador">Nome Completo Morador</label>
                    <input type="text" class="form-control" name="txtNomeMorador" id="txtNomeMorador" 
                           value="<?php if (isset($nm_morador)){ echo $nm_morador; } ?>" placeholder="Digite o nome">      
                </div>
                
                <div class="form-group col-md-4">
                    <label for="cboNumeroDaCasa">N° da casa</label>
                        <select class="form-select" name="cboNumeroDaCasa" id="cboNumeroDaCasa">
                            <option value="NULL"></option>
                            <?php
                                $sql = "SELECT * FROM tb_casa ORDER BY ds_numero_casa";

                                $results = mysqli_query($conn, $sql) or die("Erro ao retornar CASA");

                                if ($results->num_rows) {
                                    while ($dados = $results->fetch_array()) {    
                                    
                                        $id_casa = $dados['id_casa'];
                                        $ds_numero_casa = $dados['ds_numero_casa'];
                                        $casaSelected = "";
                                            
                                        if($fk_casa == $id_casa){
                                            $casaSelected = "selected";
                                        }                                      
                                        echo "<option $casaSelected value=$id_casa>$ds_numero_casa</option>";
                                    }
                                } else
                                    echo "Nenhuma casa encontrada";
                            ?>
                        </select>
                </div>
                                 
                <div class="form-group col-md-4">
                    <label for="txtDocumentoMorador">Documento Morador</label>
                    <input type="text" class="form-control" name="txtDocumentoMorador" id="txtDocumentoMorador" 
                           value="<?php if (isset($documento_morador)){ echo $documento_morador; } ?>" 
                           maxlength="11" placeholder="(RG ou CPF) Somente Números">
                </div>
                
            </div>

            <div class="row">
                
                <div class="form-group col-md-4">
                    <label for="txtDataNascimentoMorador">Data Nascimento</label>
                    <input type="date" class="form-control" name="txtDataNascimentoMorador" id="txtDataNascimentoMorador" 
                           value="<?php if (isset($dt_nascimento_morador)){ echo $dt_nascimento_morador; } ?>">  
                </div>
                
                
                <div class="form-group col-md-4">
                    <label for="txtTelefoneUmMorador">Telefone 1</label>
                    <input type="text" class="form-control" name="txtTelefoneUmMorador" id="txtTelefoneUmMorador" 
                           value="<?php if (isset($tel_um_morador)){ echo $tel_um_morador; } ?>"
                           maxlength="11" pattern="([0-9]{3})" placeholder="Digite o Telefone (Somente Números)">               
                </div>


                <div class="form-group col-md-4">
                    <label for="txtTelefoneDoisMorador">Telefone 2</label>
                    <input type="text" class="form-control" name="txtTelefoneDoisMorador" id="txtTelefoneDoisMorador" 
                           value="<?php if (isset($tel_dois_morador)){ echo $tel_dois_morador; } ?>"
                            maxlength="11" placeholder="Digite o telefone (Somente Números)">             
                </div>
                
            </div>

            <div class="row">
                
               <div class="form-group col-md-4">
                    <label for="txtEmailMorador">Email</label>
                    <input type="text" class="form-control" name="txtEmailMorador" id="txtEmailMorador" 
                           value="<?php if (isset($email_morador)) { echo $email_morador; } ?>" placeholder="Digite o email">      
                </div> 
                
                
                 <div class="form-group col-md-4">
                    <label for="txtTelefoneEmergenciaMorador">Telefone Emergência</label>
                    <input type="text" class="form-control" name="txtTelefoneEmergenciaMorador" id="txtTelefoneEmergenciaMorador" 
                           value="<?php if (isset($tel_emergencia)) { echo $tel_emergencia;  } ?>" 
                           maxlength="11" pattern="([0-9]{3})" placeholder="Digite o Telefone (Somente Números)">             
                </div>
                
                
                
            </div>

            <br>
            
            <div class="row">
                <div class="form-group col-md-4">
                    <label class="form-check-label" for="chkLocatario"></label>
                    <input class="form-check-input" type="checkbox" id="chkLocatario" name="chkLocatario" 
                           <?php $locatarioChecked = ""; if ($flag_locatario == 'S') { $locatarioChecked = "checked"; }?>
                           <?php echo $locatarioChecked ?> value="S"> Imóvel Locado?               
                </div>
            </div>
            
            <br>
            
            <div class="row">
                
                <div class="form-group col-md-4">
                    <label for="txtNomeLocatario">Nome Completo Locatário</label>
                    <input type="text" class="form-control" name="txtNomeLocatario" id="txtNomeLocatario" 
                           value="<?php if (isset($nm_locatario)){echo $nm_locatario; } ?>" placeholder="Digite o nome" <?php echo $exibeDisabled ?>>       
                </div>
                
                 <div class="form-group col-md-4">
                    <label for="txtDocumentoLocatario">Documento Locatário</label>
                    <input type="text" class="form-control" name="txtDocumentoLocatario" id="txtDocumentoLocatario" 
                           value="<?php if (isset($documento_locatario)){ echo $documento_locatario;  }?>"
                           maxlength="11" placeholder="(RG ou CPF) Somente Números" <?php echo $exibeDisabled ?>>      
                </div>
                
                <div class="form-group col-md-4">
                    <label for="txtDataNascimentoLocatario">Data Nascimento Locatário</label>
                    <input type="date" class="form-control" name="txtDataNascimentoLocatario" id="txtDataNascimentoLocatario" 
                           value="<?php if (isset($dt_nascimento_locatario)){ echo $dt_nascimento_locatario;  }?>" <?php echo $exibeDisabled ?>>  
                </div>
                
                
            </div>
            
            <div class="row">
                
                <div class="form-group col-md-4">
                    <label for="txtTelefoneUmLocatario">Telefone 1 Locatário</label>
                    <input type="text" class="form-control" name="txtTelefoneUmLocatario" id="txtTelefoneUmLocatario" 
                           value="<?php if (isset($tel_um_locatario)){ echo $tel_um_locatario; } ?>"
                           maxlength="11" pattern="([0-9]{3})" placeholder="Digite o Telefone (Somente Números)" <?php echo $exibeDisabled ?>>           
                </div>


                <div class="form-group col-md-4">
                    <label for="txtTelefoneDoisLocatario">Telefone 2 Locatário</label>
                    <input type="text" class="form-control" name="txtTelefoneDoisLocatario" id="txtTelefoneDoisLocatario" 
                           value="<?php if (isset($tel_dois_locatario)) { echo $tel_dois_locatario; } ?>"
                           maxlength="11" placeholder="Digite o telefone (Somente Números)" <?php echo $exibeDisabled ?>>                       
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

            //Carrega os veiculos cadastrados ao editar morador
            if ($id_morador != "") {

                $sql = "SELECT * FROM tb_morador mor";
                $sql .= " JOIN tb_veiculo tvei ON tvei.fk_morador = mor.id_morador";
                $sql .= " WHERE mor.id_morador = $id_morador";


                $result = mysqli_query($conn, $sql) or die("Erro ao retornar dados do VEICULO do morador.");

                //Atribui valor retornado para a variavel
                while ($dados = mysqli_fetch_array($result)) {

                    $id_veiculo = $dados['id_veiculo'];
                    $ds_placa_veiculo = $dados['ds_placa_veiculo'];
                    $fk_cor_veiculo = $dados['fk_cor_veiculo'];
                    $fk_tipo_veiculo = $dados['fk_tipo_veiculo']; ?>

                    <input type="hidden" name="hidIdVeiculo<?php echo $i ?>" id="hidIdVeiculo<?php echo $i ?>" value="<?php echo $id_veiculo ?>">


                    <div class="row" id="linhacarro<?php echo $i ?>">
                        <div class="form-group col-md-4">
                            <label for="cboTipoVeiculo<?php echo $i ?>">Tipo Veículo</label>
                            <select class="form-select" id="cboTipoVeiculo<?php echo $i ?>" name="cboTipoVeiculo<?php echo $i ?>"  onchange="placaBicicleta(<?php echo $i ?>)" >
                                <option value="NULL"></option>
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
                            <label for="txtPlacaVeiculoMorador<?php echo $i ?>">Placa do Veículo</label>
                            <input type="text" class="form-control" name="txtPlacaVeiculoMorador<?php echo $i ?>" id="txtPlacaVeiculoMorador<?php echo $i ?>" value="<?php echo $ds_placa_veiculo ?>" maxlength="11">
                        </div>


                        <div class="form-group col-md-3">
                            <label for="cboCorVeiculo<?php echo $i ?>">Cor Veículo</label>
                            <select class="form-select" name="cboCorVeiculo<?php echo $i ?>" id="cboCorVeiculo<?php echo $i ?>">
                                <option value="NULL"></option>
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
                            <a class="btn btn-danger" href="javascript:void(0)" id="remInput<?php echo $i ?>" onclick="removeLinhaVeiculoEdit(<?php echo $id_veiculo ?>, <?php echo $id_morador ?>)">
                            <img src="../../../bootstrap-icons/trash.svg" alt="">                                
                            </a>
                        </div>
                    </div>

                    <script>
                        arrayIDs.push(<?php echo $i ?>)
//                        console.log(arrayIDs);
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

            <button type="button" class="btn btn-success btn-lg" name="btnCancelarNovoMorador" id="btnCancelarNovoMorador" onClick="">Cancelar</button>

            <?php if ($id_morador == "") { ?>
                <button type="button" class="btn btn-success btn-lg" name="btnSalvarNovoMorador" id="btnSalvarNovoMorador" onClick="">
                    <img src="../../../bootstrap-icons/check-square-fill.svg" alt="" > Salvar&nbsp;
                </button>
            <?php } else { ?>
                <button type="button" class="btn btn-success btn-lg" name="btnEditarMorador" id="btnEditarMorador" onClick="">
                    <img src="../../../bootstrap-icons/check-square-fill.svg" alt=""> Salvar Edição&nbsp;
                </button>
            <?php } ?>


            <!--Só exibe o botão de excluir na tela de edição-->
            <?php if ($id_morador != "") { ?>
                <button type="button" class="btn btn-danger btn-lg" name="btnExcluir" id="btnExcluir" onClick="exlcuirMorador(<?php echo $id_morador ?>)">
                    <img src="../../../bootstrap-icons/trash.svg" alt=""> Excluir&nbsp;
                </button>
            <?php } ?>

        </div>
    </form>


    <script>
        
        //Atribui o mesmo valor da varival i em PHP a variavel i em JS
        var i = <?php echo $i ?>;
        
        $(document).ready(function() {

            //Força usuário a digitar somente números
            $("#txtTelefoneUmMorador").keyup(function() {
                $("#txtTelefoneUmMorador").val(this.value.match(/[0-9]*/));
            });

            $("#txtTelefoneDoisMorador").keyup(function() {
                $("#txtTelefoneDoisMorador").val(this.value.match(/[0-9]*/));
            });

            $("#txtDocumentoMorador").keyup(function() {
                $("#txtDocumentoMorador").val(this.value.match(/[0-9]*/));
            });

            $("#txtTelefoneEmergenciaMorador").keyup(function() {
                $("#txtTelefoneEmergenciaMorador").val(this.value.match(/[0-9]*/));
            });

            $("#txtDocumentoLocatario").keyup(function() {
                $("#txtDocumentoLocatario").val(this.value.match(/[0-9]*/));
            });

            $("#txtTelefoneUmLocatario").keyup(function() {
                $("#txtTelefoneUmLocatario").val(this.value.match(/[0-9]*/));
            });

            $("#txtTelefoneDoisLocatario").keyup(function() {
                $("#txtTelefoneDoisLocatario").val(this.value.match(/[0-9]*/));
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
                    '<option value="NULL"></option>' +
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
                    '<label for="txtPlacaVeiculoMorador' + i + '">Placa do Veículo</label>' +
                    '<input type="text" class="form-control" name="txtPlacaVeiculoMorador' + i + '" id="txtPlacaVeiculoMorador' + i + '" value="" maxlength="11" placeholder="Digite a placa (Somente Número e Letra)">' +
                    '</div>' +
                    // '</div>'+
                    '<div class="form-group col-md-3">' +
                    '<label for="cboCorVeiculo' + i + '">Cor Veículo</label>' +
                    '<select class="form-select" name="cboCorVeiculo' + i + '" id="cboCorVeiculo' + i + '">' +
                    '<option value="NULL"></option>' +
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
                $("#txtPlacaVeiculoMorador" + linha_da_placa).val("S/PLACA");
                $("#txtPlacaVeiculoMorador" + linha_da_placa).prop('readonly', true);
            } else{
                $("#txtPlacaVeiculoMorador" + linha_da_placa).val("");
                $("#txtPlacaVeiculoMorador" + linha_da_placa).prop('readonly', false);
            }
            
        }


        function removeLinhaVeiculoEdit(id_veiculo, id_morador){

            $("#hidIdDeletarVeiculo").val(id_veiculo);
            $("#hidIdMorador").val(id_morador);
            
            var form = document.getElementById("form_sf_system");
            form.action = "edit_morador.php";
            form.submit();

            //---Funcionalidade copiada do visitante. Ainda não é necessário este tipo de validação para morador --

            //Invoca função para validar a deleção dos veículos
            // validaDelecaoVeiculo(id_veiculo);
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

        $("#btnEditarMorador").click(function() {

            var contadorCarros = i;

            /*Necessário, pois quando o usuario excluia algum carro da lista dinamica
            dava erro no insert*/
            if (arrayIDs.length > 0){
                $("#hidArrayIdCamposVeiculos").val(arrayIDs);
            } else {
                $("#hidArrayIdCamposVeiculos").val(-1);
            }

            validaCamposMorador();

        });

        //Invoca mensagem personalizada para deleção de veículos
        function exibeMensagemVeiculo(msg) {
        mensagem = "<div class='alert alert-danger text-center' role='alert'>" + msg + "</div>";
        return mensagem
        }

        //Invoca mensagem personalizada para deleção de morador
        function exibeMensagem(msg) {
            mensagem = "<div class='alert alert-danger text-center' role='alert'>Falha ao criar morador: " + msg + "</div>";
            return mensagem
        }

        function validaCamposMorador() {

            var isChkLocatario = $("#chkLocatario").is(":checked");
            var txtNomeMorador = $("#txtNomeMorador").val();
            var cboNumeroDaCasa = $("#cboNumeroDaCasa").val();
            var txtDocumentoMorador = $("#txtDocumentoMorador").val();
            var txtTelefoneUmMorador = $("#txtTelefoneUmMorador").val();

            var contadorCarros = i;

            //Verifica se campos estão vazios para salvar
            $("#txtNomeMorador").html("");
            if (txtNomeMorador == "") {
                msg = "<b>Digite um NOME</b>";
                $("#containeralert").html(exibeMensagem(msg));
                alert("Um ou mais campos com erros. Por favor revise-os");
                return false;
            }

            //Verifica se campos estão vazios para salvar
            if (cboNumeroDaCasa == "NULL") {
                msg = "<b>Escolha uma CASA</b>";
                $("#containeralert").html(exibeMensagem(msg));
                alert("Um ou mais campos com erros. Por favor revise-os");
                return false;
            }

            //Verifica se campos estão vazios para salvar
            $("#txtDocumentoMorador").html("");
            if (txtDocumentoMorador == "") {
                msg = "<b>Digite um DOCUMENTO</b>";
                $("#containeralert").html(exibeMensagem(msg));
                alert("Um ou mais campos com erros. Por favor revise-os");
                return false;
            }

            //Verifica se campos estão vazios para salvar
            $("#txtTelefoneUmMorador").html("");
            if (txtTelefoneUmMorador == "") {
                msg = "<b>Digite um TELEFONE 1</b>";
                $("#containeralert").html(exibeMensagem(msg));
                alert("Um ou mais campos com erros. Por favor revise-os");
                return false;
            }

            if (isChkLocatario) {

                var txtNomeLocatario = $("#txtNomeLocatario").val();
                var txtDocumentoLocatario = $("#txtDocumentoLocatario").val();
                // var txtDataNascimentoLocatario = $("#txtDataNascimentoLocatario").val();

                
                $("#txtNomeLocatario").html("");
                if (txtNomeLocatario == "") {
                    msg = "<b>Digite um NOME para o locatário</b>";
                    $("#containeralert").html(exibeMensagem(msg));
                    alert("Um ou mais campos com erros. Por favor revise-os");
                    return false;
                }
                
                $("#txtDocumentoLocatario").html("");
                if (txtDocumentoLocatario == "") {
                    msg = "<b>Digite um DOCUMENTO para o locatário</b>";
                    $("#containeralert").html(exibeMensagem(msg));
                    alert("Um ou mais campos com erros. Por favor revise-os");
                    return false;
                }
                
            }

            //Loop para validar os campos dos veículos cadastrados do visitante
            for (j = 0; j < contadorCarros; j++) {

                if ($("#cboTipoVeiculo" + j).val() == "NULL") {
                    msg = "<b>Escolha um TIPO VEÍCULO do veículo " + (j + 1) + "</b>";
                    $("#containeralert").html(exibeMensagem(msg));
                    alert("Um ou mais campos com erros. Por favor revise-os");
                    return false;
                }

                if ($("#txtPlacaVeiculoMorador" + j).val() == "") {
                    msg = "<b>Digite a PLACA do veículo " + (j + 1) + "</b>";
                    $("#containeralert").html(exibeMensagem(msg));
                    alert("Um ou mais campos com erros. Por favor revise-os");
                    return false;
                }

                if ($("#cboCorVeiculo" + j).val() == "NULL") {
                    msg = "<b>Escolha a COR VEÍCULO do veículo " + (j + 1) + "</b>";
                    $("#containeralert").html(exibeMensagem(msg));
                    alert("Um ou mais campos com erros. Por favor revise-os");
                    return false;
                }

            }

            var form = document.getElementById("form_sf_system");
            form.action = "grava_morador.php";
            form.submit();

        }
        
        
        //Habilita e desabilita os campos de locatário
        $("#chkLocatario").click(function(){
            
            if ( $("#chkLocatario").is(":checked")) {
        
                $("#txtNomeLocatario").prop('disabled', false);
                $("#txtDocumentoLocatario").prop('disabled', false);             
                $("#txtDataNascimentoLocatario").prop('disabled', false);             
                $("#txtTelefoneUmLocatario").prop('disabled', false);             
                $("#txtTelefoneDoisLocatario").prop('disabled', false);             
            
        } else {
                $("#txtNomeLocatario").prop('disabled', true);
                $("#txtDocumentoLocatario").prop('disabled', true);               
                $("#txtDataNascimentoLocatario").prop('disabled', true);               
                $("#txtTelefoneUmLocatario").prop('disabled', true);               
                $("#txtTelefoneDoisLocatario").prop('disabled', true);               
            }
            
        })
        
        

        $("#btnSalvarNovoMorador").click(function() {

            var txtDocumentoMorador = $("#txtDocumentoMorador").val();

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
            validaMorador(txtDocumentoMorador);

        });

        //---Funcionalidade copiada do visitante. Ainda não é necessário este tipo de validação para morador --

        //Ajax para deletar e apresentar a mensagem de erro caso nao possa deletar veículo vinculado a alguma visita 
        // function validaDelecaoVeiculo(id_veiculo) {

        //     $.ajax({
        //         url: 'delete_veiculo_morador.php',
        //         type: 'POST',
        //         data: "id_veiculo=" + id_veiculo,
        //         beforeSend: function() {
        //             // loading_show();
        //         },
        //         success: function(data) {
        //             // loading_hide();
        //             $mensagem = data;
        //             $("#containeralert").html($mensagem);
        //             if ($mensagem != "") {
        //                 msg = $mensagem;
        //                 $("#containeralert").html(exibeMensagemVeiculo(msg));
        //                 return false;
        //             }

        //             var form = document.getElementById("form_sf_system");
        //             form.action = "edit_morador.php";
        //             form.submit();
        //             //Define um tempo para o elemento sumir da tela.
        //             // setTimeout(function(){
        //             //     $("#containeralert").fadeOut('Slow');
        //             // },4000)
        //         },
        //         error: function(data) {
        //             console.log("Ocorreu erro ao VALIDAR usuário via AJAX.");
        //             // $('#cboCidade').html("Houve um erro ao carregar");
        //         }
        //     });

        // }

        function validaMorador(txtDocumentoMorador) {


            $.ajax({
                url: '/pesquisas_ajax/verifica_se_morador_existe.php',
                type: 'POST',
                data: "documento_morador=" + txtDocumentoMorador,
                beforeSend: function() {
                    // loading_show();
                },
                success: function(data) {
                    
                    var mensagem = data;
                    
                    if (mensagem == "") {

                        validaCamposMorador();

                    } 
                    else {
                        $("#containeralert").html(mensagem);
                        alert("Um ou mais campos com erros. Por favor revise-os");
                    }
                    // }
                    //Define um tempo para o elemento sumir da tela.
                    // setTimeout(function(){
                    //     $("#containeralert").fadeOut('Slow');
                    // },4000)
                },
                error: function(data) {
                    console.log("Ocorreu erro ao VALIDAR documento morador via AJAX.");
                    // $('#cboCidade').html("Houve um erro ao carregar");
                }
            });

        }

        function exlcuirMorador(id_morador) {

            $("#hidIdMorador").val(id_morador);
            $("#hidIdOperacaoDeletar").val(true);
            var form = document.getElementById("form_sf_system");
            form.action = "cad_morador.php";
            form.submit();

        }


        $("#btnCancelarNovoMorador").click(function() {

            var form = document.getElementById("form_sf_system");
            form.action = "cad_morador.php";
            form.submit();

        });
    </script>

</body>

</html>