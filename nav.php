<?php

//Verifica se o usuario está logado
if(!isset($_SESSION['usuarioUsuario'])){
    header("Location: index.php");
    
}

?>
<div class="container">
    <span class="usuarioLogado">Usuário Logado: <?= $_SESSION['usuarioUsuario'] ?></span>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">

            <a class="navbar-brand" href="\home.php">SF SYSTEM</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="\home.php">
                            <img src="/bootstrap-icons/house.svg" alt="" height="30px" width="30px">
                            <span>Home</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/consulta/cadastro/cadastro.php">
                            <img src="/bootstrap-icons/person-plus-fill.svg" alt="" height="30px" width="30px">
                            <span>Cadastro</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/entrada_saida/visitas_em_andamento.php">
                            <img src="/bootstrap-icons/file-arrow-up-fill.svg" alt="" height="30px" width="30px">
                            <span>Registrar Entrada/Saída</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/relatórios/relatorio_entrada_saida.php">
                            <img src="/bootstrap-icons/calendar-check-fill.svg" alt="" height="30px" width="30px">
                            <span>Relatórios</span>
                        </a>
                    </li>
                </ul>

                
                <span class="navbar-text">
                    <a class="nav-link me-2" href="/sair.php">
                        <img src="/bootstrap-icons/arrow-right-square-fill.svg" alt="" height="30px" width="30px">
                        <span>Sair</span>
                    </a>
                </span>
            </div>
        </div>
    </nav>
</div>