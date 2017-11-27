<!-- Conexion de la base de datos -->
<?php require_once('Connections/cnConsultorio.php'); ?>
<!-- Sesion -->
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<!-- Consultas -->
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_qUsuarios = "-1";
if (isset($_GET['nombre'])) {
  $colname_qUsuarios = $_GET['nombre'];
}
mysql_select_db($database_cnConsultorio, $cnConsultorio);
$query_qUsuarios = sprintf("SELECT idusuario, nombre, apellidos, usuario FROM usuarios WHERE nombre LIKE %s", GetSQLValueString("%" . $colname_qUsuarios . "%", "text"));
$qUsuarios = mysql_query($query_qUsuarios, $cnConsultorio) or die(mysql_error());
$row_qUsuarios = mysql_fetch_assoc($qUsuarios);
$totalRows_qUsuarios = mysql_num_rows($qUsuarios);

$colname_qFoto = "-1";
if (isset($_SESSION['usuario'])) {
  $colname_qFoto = $_SESSION['usuario'];
}
mysql_select_db($database_cnConsultorio, $cnConsultorio);
$query_qFoto = sprintf("SELECT imagen FROM usuarios WHERE usuario = '".$_SESSION['MM_Username']."' ");
$qFoto = mysql_query($query_qFoto, $cnConsultorio) or die(mysql_error());
$row_qFoto = mysql_fetch_assoc($qFoto);
$totalRows_qFoto = mysql_num_rows($qFoto);
?>
<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
<head>
<title>Consultorio ULV : Usuarios</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Minimal Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom Theme files -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href="css/font-awesome.css" rel="stylesheet"> 
<script src="js/jquery.min.js"> </script>
<!-- Mainly scripts -->
<script src="js/jquery.metisMenu.js"></script>
<script src="js/jquery.slimscroll.min.js"></script>
<!-- Custom and plugin javascript -->
<link href="css/custom.css" rel="stylesheet">
<script src="js/custom.js"></script>
<script src="js/screenfull.js"></script>
		<script>
		$(function () {
			$('#supported').text('Supported/allowed: ' + !!screenfull.enabled);

			if (!screenfull.enabled) {
				return false;
			}

			

			$('#toggle').click(function () {
				screenfull.toggle($('#container')[0]);
			});
			

			
		});
		</script>

<!----->

<!--pie-chart--->
<script src="js/pie-chart.js" type="text/javascript"></script>
 <script type="text/javascript">

        $(document).ready(function () {
            $('#demo-pie-1').pieChart({
                barColor: '#3bb2d0',
                trackColor: '#eee',
                lineCap: 'round',
                lineWidth: 8,
                onStep: function (from, to, percent) {
                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');
                }
            });

            $('#demo-pie-2').pieChart({
                barColor: '#fbb03b',
                trackColor: '#eee',
                lineCap: 'butt',
                lineWidth: 8,
                onStep: function (from, to, percent) {
                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');
                }
            });

            $('#demo-pie-3').pieChart({
                barColor: '#ed6498',
                trackColor: '#eee',
                lineCap: 'square',
                lineWidth: 8,
                onStep: function (from, to, percent) {
                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');
                }
            });

           
        });

    </script>
<!--skycons-icons-->
<script src="js/skycons.js"></script>
<!--//skycons-icons-->
</head>
<body>
<div id="wrapper">

<!----->
        <nav class="navbar-default navbar-static-top" role="navigation">
             <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
               <h1> <a class="navbar-brand" href="index.php">Consultorio ULV</a></h1>         
			   </div>
			 <div class=" border-bottom">
        	<div class="full-left">
        	  <section class="full-top">
				<button id="toggle"><i class="fa fa-arrows-alt"></i></button>	
			</section>
        	  <div class="clearfix"> </div>
           </div>
     
       
            <!-- Brand and toggle get grouped for better mobile display -->
		 
		   <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="drop-men" >
		        <ul class=" nav_1">
              
					<li class="dropdown">
		              <a href="#" class="dropdown-toggle dropdown-at" data-toggle="dropdown"><span class=" name-caret"><?php echo $_SESSION['MM_Username']; ?><i class="caret"></i></span><img style="width:60px" src="uploads/<?php echo $row_qFoto['imagen']; ?>"></a>
		              <ul class="dropdown-menu " role="menu">
		                <li><a href="CerrarSesion.php" ><i class="fa fa-sign-out"></i>Cerrar Sesión</a></li>
		                
		              </ul>
		            </li>
		           
		        </ul>
		     </div><!-- /.navbar-collapse -->
			<div class="clearfix">
       
     </div>
	  
		    <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
				
                    <li>
                        <a href="index.php" class="hvr-bounce-to-right"><i class="fa fa-home nav_icon "></i><span class="nav-label">Pantalla Principal</span> </a>
                    </li>
                   
                    <li>
                        <a href="#" class=" hvr-bounce-to-right"><i class="fa fa-bed nav_icon"></i> <span class="nav-label">Pacientes</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="RegistrarPaciente.php" class=" hvr-bounce-to-right"> <i class="fa fa-pencil-square nav_icon"></i>Registrar Pacientes</a></li>
                            
                            <li><a href="BuscarPaciente.php" class=" hvr-bounce-to-right"><i class="fa fa-search nav_icon"></i>Buscar Pacientes</a></li>
			
				

					   </ul>
                    </li>
                    <li>
                        <a href="#" class=" hvr-bounce-to-right"><i class="fa fa-user-md nav_icon"></i> <span class="nav-label">Usuarios</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="AltaUsuarios.php" class=" hvr-bounce-to-right"><i class="fa fa-pencil-square nav_icon"></i>Registrar Usuarios</a></li>
                            <li><a href="BuscarUsuario.php" class=" hvr-bounce-to-right"><i class="fa fa-search nav_icon"></i>Buscar Usuarios</a></li>
                        </ul>
                    </li>
                   
                    <li>
                        <a href="#" class=" hvr-bounce-to-right"><i class="fa fa-cog nav_icon"></i> <span class="nav-label">Configuración</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="Estadisticas.php" class=" hvr-bounce-to-right"><i class="fa fa-area-chart nav_icon"></i>Estadísticas</a></li>
                           <li><a href="CerrarSesion.php" class=" hvr-bounce-to-right"><i class="fa fa-sign-out nav_icon"></i>Salir</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
			</div>
        </nav>
        <div id="page-wrapper" class="gray-bg dashbard-1">
       <div class="content-main">
 
  		<!--banner-->	
		    
		<!--//banner-->
		<!--content-->
		<div class="content-top">
			
			
			
			
		<div class="clearfix"> </div>
		</div>
		<!-- Muestra en una tabla el resultado de una busqueda -->
        <div class"x_content" >
        <div class="validation-system">
        <div class="validation-form">
        <h3 id="forms-example" class="">Usuarios</h3>
        <table border="1" cellpadding="1" cellspacing="1" class="table table-bordered">
              <tr>
                <td>Nombre</td>
                <td>Apellidos</td>
                <td>Usuario</td>
                <td>Detalles</td>
                <td>Editar</td>
                <td>Borrar</td>
              </tr>
              <?php do { ?>
              <tr>
                <td><?php echo $row_qUsuarios['nombre']; ?></td>
                <td><?php echo $row_qUsuarios['apellidos']; ?></td>
                <td><?php echo $row_qUsuarios['usuario']; ?></td>
                <td><a href="DetallesUsuario.php?id=<?php echo $row_qUsuarios['idusuario']; ?>"><i class="fa fa-exclamation-circle" title="Detalles"></i></a></td>
                <td><a href="EditarUsuario.php?id=<?php echo $row_qUsuarios['idusuario']; ?>"><i class="fa fa-edit" title="Editar Usuario"></i></a></td>
                <td><a href="EliminarUsuario.php?id=<?php echo $row_qUsuarios['idusuario']; ?>"><i class="fa fa-trash" title="Eliminar Usuario"></i></a></td>
              </tr>
              <?php } while ($row_qUsuarios = mysql_fetch_assoc($qUsuarios)); ?>
            </table>
            </div>
            </div>
		</div>
  
		<div class="content-mid">
			
			
			
			
		</div>
		<!----->
		
		<!--//content-->
	

	 
		<!---->
<div class="copy">
            <p> &copy; Universidad Linda Vista Oficial </p>
	    </div>
		</div>
		<div class="clearfix"> </div>
       </div>
     </div>
<!---->
<!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
	<script src="js/bootstrap.min.js"> </script>
</body>
</html>
<?php
mysql_free_result($qUsuarios);
?>
