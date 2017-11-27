<!-- Conexion de base de datos -->
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE pacientes SET fechaderegistro=%s, nombre=%s, edad=%s, sexo=%s, lugardeorigen=%s, residencia=%s, religion=%s, escuelade=%s, plandeestudios=%s, departamento=%s, nombreencasodeemergencia=%s, telparticularencasodeemergencia=%s, heredofamiliares=%s, personalespatologicos=%s, desparasitacion=%s, personalesnopatologicos=%s, ginecoobtetricos=%s, padecimientoactual=%s, tratamientoactual=%s, aparatodigestivo=%s, aparatocardiovascular=%s, aparatorespiratorio=%s, aparatourinario=%s, aparatogenital=%s, aparatohematologico=%s, sistemaendocrino=%s, sistemaosteomuscular=%s, sistemanervioso=%s, sistemasensorial=%s, psicosomatico=%s, gruposanguineo=%s, biometriahematicanormal=%s, coproparasitos=%s, reaccionesfebriles=%s, peso=%s, talla=%s, ta=%s, diagnostico=%s, plan=%s WHERE matricula=%s",
                       GetSQLValueString($_POST['fechaderegistro'], "date"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['edad'], "text"),
                       GetSQLValueString($_POST['sexo'], "text"),
                       GetSQLValueString($_POST['lugardeorigen'], "text"),
                       GetSQLValueString($_POST['residencia'], "text"),
                       GetSQLValueString($_POST['religion'], "text"),
                       GetSQLValueString($_POST['escuelade'], "text"),
                       GetSQLValueString($_POST['plandeestudios'], "text"),
                       GetSQLValueString($_POST['departamento'], "text"),
                       GetSQLValueString($_POST['nombreencasodeemergencia'], "text"),
                       GetSQLValueString($_POST['telparticularencasodeemergencia'], "text"),
                       GetSQLValueString($_POST['heredofamiliares'], "text"),
                       GetSQLValueString($_POST['personalespatologicos'], "text"),
                       GetSQLValueString($_POST['desparasitacion'], "text"),
                       GetSQLValueString($_POST['personalesnopatologicos'], "text"),
                       GetSQLValueString($_POST['ginecoobtetricos'], "text"),
                       GetSQLValueString($_POST['padecimientoactual'], "text"),
                       GetSQLValueString($_POST['tratamientoactual'], "text"),
                       GetSQLValueString($_POST['aparatodigestivo'], "text"),
                       GetSQLValueString($_POST['aparatocardiovascular'], "text"),
                       GetSQLValueString($_POST['aparatorespiratorio'], "text"),
                       GetSQLValueString($_POST['aparatourinario'], "text"),
                       GetSQLValueString($_POST['aparatogenital'], "text"),
                       GetSQLValueString($_POST['aparatohematologico'], "text"),
                       GetSQLValueString($_POST['sistemaendocrino'], "text"),
                       GetSQLValueString($_POST['sistemaosteomuscular'], "text"),
                       GetSQLValueString($_POST['sistemanervioso'], "text"),
                       GetSQLValueString($_POST['sistemasensorial'], "text"),
                       GetSQLValueString($_POST['psicosomatico'], "text"),
                       GetSQLValueString($_POST['gruposanguineo'], "text"),
                       GetSQLValueString($_POST['biometriahematicanormal'], "text"),
                       GetSQLValueString($_POST['coproparasitos'], "text"),
                       GetSQLValueString($_POST['reaccionesfebriles'], "text"),
                       GetSQLValueString($_POST['peso'], "text"),
                       GetSQLValueString($_POST['talla'], "text"),
                       GetSQLValueString($_POST['ta'], "text"),
                       GetSQLValueString($_POST['diagnostico'], "text"),
                       GetSQLValueString($_POST['plan'], "text"),
                       GetSQLValueString($_POST['matricula'], "text"));

  mysql_select_db($database_cnConsultorio, $cnConsultorio);
  $Result1 = mysql_query($updateSQL, $cnConsultorio) or die(mysql_error());

  $updateGoTo = "BuscarPaciente.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_qPacientes = "-1";
if (isset($_GET['m'])) {
  $colname_qPacientes = $_GET['m'];
}
mysql_select_db($database_cnConsultorio, $cnConsultorio);
$query_qPacientes = sprintf("SELECT * FROM pacientes WHERE matricula = %s", GetSQLValueString($colname_qPacientes, "text"));
$qPacientes = mysql_query($query_qPacientes, $cnConsultorio) or die(mysql_error());
$row_qPacientes = mysql_fetch_assoc($qPacientes);
$totalRows_qPacientes = mysql_num_rows($qPacientes);

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
<title>Consultorio ULV : Editar Paciente</title>
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
 
  		<!-- Se ocupa un formulario para hacer un select al igual que update en labase de datos -->
		<div class="content-top">
          <div class="validation-system">
    <div class="validation-form">
    
    <h3 id="forms-example" class="">Editar Paciente</h3>
    
          <form method="post" name="form2" action="<?php echo $editFormAction; ?>">
            <table align="center">
              <tr valign="baseline">
                <div class="col-md-6 form-group1">
              <label class="control-label">INTERROGATORIO</label> 
              <div class="clearfix"> </div>
              <label class="control-label">Nombre</label>
              <input type="text" name="nombre" value="<?php echo htmlentities($row_qPacientes['nombre'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Nombre">
              </div>
              </div>
              </tr>
              <tr valign="baseline">
         
                
                 <div class="col-md-6 form-group1 group-mail">
              <label class="control-label"></label>
              <div class="clearfix"> </div>
              <label class="control-label">Edad</label>
              <input type="text" name="edad" value="<?php echo htmlentities($row_qPacientes['edad'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Edad">
              </div>  
                
              </tr>
              <tr valign="baseline">
 
                   <div class="col-md-6 form-group2 group-mail">
              <label class="control-label ">Sexo</label>
              <select name="sexo" >
                <option value="Hombre" <?php if (!(strcmp("Hombre", $row_qPacientes['sexo']))) {echo "selected=\"selected\"";} ?>>Hombre</option>
                <option value="Mujer" <?php if (!(strcmp("Mujer", $row_qPacientes['sexo']))) {echo "selected=\"selected\"";} ?>>Mujer</option>
                </select>  
              </div> 
              </tr>
              <tr valign="baseline">
                   <div class="col-md-6 form-group1">
              <label class="control-label">Lugar de Origen</label>
              <input type="text" name="lugardeorigen" value="<?php echo htmlentities($row_qPacientes['lugardeorigen'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Lugar de Origen">
              </div>     
              </tr>
              <tr valign="baseline">           
                   <div class="col-md-12 form-group1">
              <label class="control-label">Residencia</label>
              <input type="text" name="residencia" value="<?php echo htmlentities($row_qPacientes['residencia'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Residencia">
              </div>
                
              </tr>
              <tr valign="baseline">
            
                  <div class="col-md-6 form-group1">
              <label class="control-label">Religión</label>
              <input type="text" name="religion" value="<?php echo htmlentities($row_qPacientes['religion'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Religión">
              </div>
                
              </tr>
              <tr valign="baseline">  
                  <div class="col-md-6 form-group1">
              <label class="control-label">Escuela de</label>
              <input type="text" name="escuelade" value="<?php echo htmlentities($row_qPacientes['escuelade'], ENT_COMPAT, 'utf-8'); ?>"  placeholder="Escuela">
              </div>
                
              </tr>
              <tr valign="baseline">
                   <div class="col-md-6 form-group1">
              <label class="control-label">Plan de Estudios</label>
              <input type="text" name="plandeestudios" value="<?php echo htmlentities($row_qPacientes['plandeestudios'], ENT_COMPAT, 'utf-8'); ?>"  placeholder="Plan de Estudios">
              </div>
                
              </tr>
              <tr valign="baseline">      
                 <div class="col-md-6 form-group1">
              <label class="control-label">Departamento</label>
              <input type="text" name="departamento" value="<?php echo htmlentities($row_qPacientes['departamento'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Departamento">
              </div>
              </tr>
              <tr valign="baseline">

                 <div class="col-md-6 form-group1">
              <label class="control-label">Nombre en caso de emergencia</label>
              <input type="text" name="nombreencasodeemergencia" value="<?php echo htmlentities($row_qPacientes['nombreencasodeemergencia'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Nombre en caso de emergencia">
              </div>
                
              </tr>
              <tr valign="baseline">
       
                 <div class="col-md-6 form-group1">
              <label class="control-label">Tel. Particular</label>
              <input type="text" name="telparticularencasodeemergencia" value="<?php echo htmlentities($row_qPacientes['telparticularencasodeemergencia'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Tel. Particular">
              </div>
                
              </tr>
              <tr valign="baseline">
        
                <div class="col-md-6 form-group1">
              <label class="control-label">Antecedentes</label> 
              <div class="clearfix"> </div>
              <label class="control-label">Heredo Familiares</label>
              <input type="text" name="heredofamiliares" value="<?php echo htmlentities($row_qPacientes['heredofamiliares'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Diabetes Mellitus, Hipertensión, Carsiomas, Cardiopatías, Hepatopatías, etc.">
              </div>
                
              </tr>
              <tr valign="baseline">
                 <div class="col-md-6 form-group1">
              <label class="control-label"></label> 
              <div class="clearfix"> </div>
              <label class="control-label">Personales Patológicos</label>
              <input type="text" name="personalespatologicos" value="<?php echo htmlentities($row_qPacientes['personalespatologicos'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Enfermedades infecciosas de la infancia, Intervenciones Quirúrgicas, etc.">
              </div>
                
              </tr>
              <tr valign="baseline">
    
                 <div class="col-md-6 form-group1">
              <label class="control-label">Desparasitación</label>
              <input type="text" name="desparasitacion" value="<?php echo htmlentities($row_qPacientes['desparasitacion'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Desparasitación">
              </div> 
                
              </tr>
              <tr valign="baseline">
                <div class="col-md-6 form-group1">
              <label class="control-label">Personales No Patológicos</label>
              <input type="text" name="personalesnopatologicos" value="<?php echo htmlentities($row_qPacientes['personalesnopatologicos'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Toxicomanía: Tabaco, Alcohol y Drogas">
              </div>         
              </tr>
              <tr valign="baseline">
                 <div class="col-md-12 form-group1">
              <label class="control-label">Gineco - obstétricos</label>
              <input type="text" name="ginecoobtetricos" value="<?php echo htmlentities($row_qPacientes['ginecoobtetricos'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Eu-Dismenorrea / Tx">
              </div> 
              </tr>
              <tr valign="baseline">
     			 <div class="col-md-12 form-group1">
              <label class="control-label">Padecimiento</label> 
              <div class="clearfix"> </div>
              <label class="control-label">Padecimiento Actual</label>
              <input type="text" name="padecimientoactual" value="<?php echo htmlentities($row_qPacientes['padecimientoactual'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Padecimiento Actual">
              </div>
              </tr>
              <tr valign="baseline">  
                 <div class="col-md-12 form-group1">
              <label class="control-label">Tratamiento Actual</label>
              <input type="text" name="tratamientoactual" value="<?php echo htmlentities($row_qPacientes['tratamientoactual'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Tratamiento Actual">
              </div> 
                
              </tr>
              <tr valign="baseline"> 
                 <div class="col-md-12 form-group1">
              <label class="control-label">Interrogatorio por Aparatos y Sistemas</label> 
              <div class="clearfix"> </div>
              <label class="control-label">Aparato Digestivo</label>
              <input type="text" name="aparatodigestivo" value="<?php echo htmlentities($row_qPacientes['aparatodigestivo'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Halitosis, boca seca o amarga, naúseas, vomito, dolor abdominal, meteorismo, y flatulencias, constipación o diarrea">
              </div>                
              </tr>
              <tr valign="baseline">
                    <div class="col-md-12 form-group1">
              <label class="control-label">Aparato Cardiovascular</label>
              <input type="text" name="aparatocardiovascular" value="<?php echo htmlentities($row_qPacientes['aparatocardiovascular'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Disnea, tos, palpitaciones, edema, dolor precordial, cianosis o manifestaciones periféricas">
              </div> 
              </tr>
              <tr valign="baseline">
                  <div class="col-md-12 form-group1">
              <label class="control-label">Aparato Respiratorio</label>
              <input type="text" name="aparatorespiratorio" value="<?php echo htmlentities($row_qPacientes['aparatorespiratorio'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Tos, rinorrea, disnea, dolor torácico, hemoptisis o alteraciones de la voz">
              </div>     
              </tr>
              <tr valign="baseline">
                <div class="col-md-12 form-group1">
              <label class="control-label">Aparato Urinario</label>
              <input type="text" name="aparatourinario" value="<?php echo htmlentities($row_qPacientes['aparatourinario'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Alteraciones de la micción, características de la orina normales">
              </div>   
              </tr>
              <tr valign="baseline">
                <div class="col-md-12 form-group1">
              <label class="control-label">Aparato Genital</label>
              <input type="text" name="aparatogenital" value="<?php echo htmlentities($row_qPacientes['aparatogenital'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Dolor, prurito, sangradp, secreción (flujo)">
              </div>           
              </tr>
              <tr valign="baseline">  
                 <div class="col-md-12 form-group1">
              <label class="control-label">Aparato Hematológico</label>
              <input type="text" name="aparatohematologico" value="<?php echo htmlentities($row_qPacientes['aparatohematologico'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Datos clinicos de anemia (palidez, astenia, adinamia), hemorragias, adenopatías, esplenomegalia">
              </div> 
              </tr>
              <tr valign="baseline">
                <div class="col-md-12 form-group1">
              <label class="control-label">Sistema Endocrino</label>
              <input type="text" name="sistemaendocrino" value="<?php echo htmlentities($row_qPacientes['sistemaendocrino'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Datos clinicos de anemia (palidez, astenia, adinamia), hemorragias, adenopatías, esplenomegalia">
              </div>
              </tr>
              <tr valign="baseline">   
                 <div class="col-md-12 form-group1">
              <label class="control-label">Sistema Osteomuscular</label>
              <input type="text" name="sistemaosteomuscular" value="<?php echo htmlentities($row_qPacientes['sistemaosteomuscular'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Debilidad muscular, artralgias, Mialgias, sig. Reyunad">
              </div>   
              </tr>
              <tr valign="baseline">
                 <div class="col-md-12 form-group1">
              <label class="control-label">Sistema Nervioso</label>
              <input type="text" name="sistemanervioso" value="<?php echo htmlentities($row_qPacientes['sistemanervioso'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Cefalea, sincope, convulsiones, vértigo, déficit transitorio, confusión, marcha y equilibrio sin alteraciones">
              </div> 
                
              </tr>
              <tr valign="baseline"> 
                <div class="col-md-12 form-group1">
              <label class="control-label">Sistema Sensorial</label>
              <input type="text" name="sistemasensorial" value="<?php echo htmlentities($row_qPacientes['sistemasensorial'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Visión borrosa, dolor ocular, diplopia, amaurosis, fotfobia, otalgia, otorrea, otorgaría, hipoacusia, tinitos, epitaxis, secreción nasal, odinofagea, fonación">
              </div>        
              </tr>
              <tr valign="baseline">
                <div class="col-md-12 form-group1">
              <label class="control-label">Psicosomático</label>
              <input type="text" name="psicosomatico" value="<?php echo htmlentities($row_qPacientes['psicosomatico'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Ansiedad, depresión, amnesia, ideación suicida, delirios, personalidad, efectividad, emotividad, voluntad, pensamiento normales">
              </div>  
              </tr>
              <tr valign="baseline">
                <div class="col-md-6 form-group1">
              <label class="control-label">Exámenes de Laboratorio</label> 
              <div class="clearfix"> </div>
              <label class="control-label">Grupo Sanguíneo y RH</label>
              <input type="text" name="gruposanguineo" value="<?php echo htmlentities($row_qPacientes['gruposanguineo'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Grupo Sanguíneo / RH">
              </div>
              </tr>
              <tr valign="baseline">
                <div class="col-md-6 form-group1">
              <label class="control-label"></label> 
              <div class="clearfix"> </div>
              <label class="control-label">Biometría Hemática Normal</label>
              <input type="text" name="biometriahematicanormal" value="<?php echo htmlentities($row_qPacientes['biometriahematicanormal'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Si / No">
              </div>     
              </tr>
              <tr valign="baseline">
                 <div class="col-md-6 form-group1">
              <label class="control-label">COPRO (Parásitos)</label>
              <input type="text" name="coproparasitos" value="<?php echo htmlentities($row_qPacientes['coproparasitos'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Si / No">
              </div>   
              </tr>
              <tr valign="baseline">   
                <div class="col-md-6 form-group1">
              <label class="control-label">Reacciones Febriles Normal</label>
              <input type="text" name="reaccionesfebriles" value="<?php echo htmlentities($row_qPacientes['reaccionesfebriles'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Si / No">
              </div>   
              </tr>
              <tr valign="baseline">  
                    <div class="col-md-6 form-group1">
              <label class="control-label">Peso</label>
              <input type="text" name="peso" value="<?php echo htmlentities($row_qPacientes['peso'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Peso">
              </div>          
              </tr>
              <tr valign="baseline">   
                 <div class="col-md-6 form-group1">
              <label class="control-label">Talla</label>
              <input type="text" name="talla" value="<?php echo htmlentities($row_qPacientes['talla'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Talla">
              </div>
                
              </tr>
              <tr valign="baseline">
                 <div class="col-md-6 form-group1">
              <label class="control-label">T/A</label>
              <input type="text" name="ta" value="<?php echo htmlentities($row_qPacientes['ta'], ENT_COMPAT, 'utf-8'); ?>" placeholder="T/A">
              </div>  
              </tr>
              <tr valign="baseline">
                 <div class="col-md-6 form-group1">
              <label class="control-label">Diagnóstico</label>
              <input type="text" name="diagnostico" value="<?php echo htmlentities($row_qPacientes['diagnostico'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Diagnóstico">
              </div>        
              </tr>
              <tr valign="baseline">
                <div class="col-md-6 form-group1">
              <label class="control-label">Plan</label>
              <input type="text" name="plan" value="<?php echo htmlentities($row_qPacientes['plan'], ENT_COMPAT, 'utf-8'); ?>" placeholder="Plan">
              </div>  
              </tr>
              <tr valign="baseline">
                <td nowrap align="right">&nbsp;</td>
                <td><input type="submit" value="Actualizar Datos del Paciente" class="btn btn-default"></td>
              </tr>
            </table>
            <input type="hidden" name="MM_update" value="form2">
            <input type="hidden" name="matricula" value="<?php echo $row_qPacientes['matricula']; ?>">
          </form>
          <p>&nbsp;</p>
          </div>
          </div>
<div class="content-mid">
 </div>
         
         
         
          
<div class="clearfix"> </div>
		</div>
		<!---->
	
  
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
mysql_free_result($qPacientes);

mysql_free_result($qFoto);
?>
