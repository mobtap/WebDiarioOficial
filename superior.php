<?php
 include 'db.inc.php';
 session_start();
   if($_SESSION['id']=='') {
      header("Location: login.php");
  } else {
	$nom = pg_fetch_array(pg_query("select *from usuario where id=".$_SESSION['id']));	  
  }
?>

<!doctype html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Language" content="pt-br">
          <meta name = "viewport" content = "width = device-width, initial-scale = 1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Diario Oficial Online - Ibitech Software</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
        <meta name="description" content="Sistema COVID-19">
        <meta name="msapplication-tap-highlight" content="no">
        <link rel="shortcut icon" href="assets/images/mini_logo_ibitech.png" type="image/x-icon">
        <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>

        <link href="./main.css" rel="stylesheet">
    </head>
    <body>
        <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header closed-sidebar">
            <div class="app-header header-shadow bg-happy-green header-text-light">
                <div class="app-header__logo">
                    <div class="logo-src"></div>
                    <div class="header__pane ml-auto closed-sidebar">
                        <div>
                            <button type="button" class="hamburger close-sidebar-btn hamburger--elastic " data-class="closed-sidebar">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="app-header__mobile-menu">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="app-header__menu">
                    <span>
                        <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                            <span class="btn-icon-wrapper">
                                <i class="fa fa-ellipsis-v fa-w-6"></i>
                            </span>
                        </button>
                    </span>
                </div>    <div class="app-header__content">
                    <div class="app-header-left">
<!--                         <div class="search-wrapper">
                            <div class="input-holder">
                                <input type="text" class="search-input" placeholder="Type to search">
                                <button class="search-icon"><span></span></button>
                            </div>
                            <button class="close"></button>
                        </div> -->
                        <ul class="header-menu nav">
                            <li class="nav-item">
                                <a href="diario.php" class="nav-link">
                                    <i class="nav-link-icon fa pe-7s-date"> </i>
                                    Diários Oficiais
                                </a>
                            </li>
                            <li class="btn-group nav-item">
                                <a href="/diariooficial/cliente/index.php" target="_blank" class="nav-link">
                                    <i class="nav-link-icon fa pe-7s-note"></i>
                                    Minhas Publicações
                                </a>
                            </li>
                            <li class="dropdown nav-item">
                                <a href="javascript:void(0);" class="nav-link">
                                    <i class="nav-link-icon fa pe-7s-help1"></i>
                                    Ajuda
                                </a>
                            </li>
                            <li class="dropdown nav-item">
                                <a href="sair.php" class="nav-link">
                                    <i class="nav-link-icon fa pe-7s-power"></i>
                                    Sair
                                </a>
                            </li>
                        </ul>        </div>
                    <div class="app-header-right ">
                        <div class="header-btn-lg pr-0">
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="btn-group">
                                            <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                                <img width="42" class="rounded-circle" src="assets/images/avatars/avatar.jpg" alt="">
                                                <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                            </a>
                                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                                <button type="button" tabindex="0" class="dropdown-item" onclick="location.href='dadosusuario.php'">Dados do Usuario</button>
                                                <button type="button" tabindex="0" class="dropdown-item" onclick="location.href='alterarsenha.php'">Alterar Senha</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-content-left  ml-3 header-user-info">
                                        <div class="widget-heading">
                                            <?=$nom['nome']?>
                                        </div>
                                        <div class="widget-subheading">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>        </div>
                </div>
            </div>        
            <div class="app-main">
                <div class="app-sidebar sidebar-shadow bg-love-kiss sidebar-text-light">
                    <div class="app-header__logo">
                        <div class="logo-src"></div>
                        <div class="header__pane ml-auto">
                            <div>
                                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                    <span class="hamburger-box">
                                        <span class="hamburger-inner"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="app-header__mobile-menu">
                        <div>
                            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="app-header__menu">
                        <span>
                            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                                <span class="btn-icon-wrapper">
                                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                                </span>
                            </button>
                        </span>
                    </div>    <div class="scrollbar-sidebar closed-sidebar">
                        <div class="app-sidebar__inner">
                            <ul class="vertical-nav-menu">
								<li>
                                    <a href="index.php" class="mm-active">
                                        <i class="metismenu-icon pe-7s-home"></i>
                                        Página inicial
                                    </a>
                                </li>                                
                                <li class="app-sidebar__heading">Documento</li>
                                <li>
                                    <a href="diario.php">
                                        <i class="metismenu-icon pe-7s-date"></i>
                                        Diários Oficiais
                                    </a>
                                </li>
                                <li class="app-sidebar__heading">Sistema</li>
                                <li>
                                    <a href="usuarios.php">
                                        <i class="metismenu-icon pe-7s-note2"></i>
                                        Usuários
                                    </a>
                                </li>
                                <li>
                                    <a href="departamentos.php">
                                        <i class="metismenu-icon pe-7s-clock"></i>
                                        Departamentos
                                    </a>
								</li>
                                <li>
                                    <a href="tipopublicacao.php">
                                        <i class="metismenu-icon pe-7s-news-paper"></i>
                                        Tipos de Publicações
                                    </a>
                                </li>
                                <li>
                                    <a href="cadastro.php">
                                        <i class="metismenu-icon pe-7s-delete-user"></i>
                                        Informações da Entidade
                                    </a>
                                </li>								
                                <li>
                                    <a href="publicacoes.php">
                                        <i class="metismenu-icon pe-7s-comment"></i>
                                        Visualizar Publicações
                                    </a>
                                </li>								
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="app-main__outer">
                    <div class="app-main__inner">
					<?php if($_SERVER['REQUEST_URI']!="/atendimentoonline.php") { ?>
                        <div class="app-page-title">
                            <div class="page-title-wrapper">
                                <div class="page-title-heading">
                                    <div class="page-title-icon">
                                        <i class="pe-7s-users icon-gradient bg-mean-fruit">
                                        </i>
                                    </div>
                                    <div>
                                        <?=$nom[usu_nome]?>
                                        <div class="page-title-subheading">
                                        Olá, seja bem vindo ao sistema de Diario Oficial Online - Ibitech Software.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
					<?php } ?>
                        <!-- MAIN CONTENT -->
