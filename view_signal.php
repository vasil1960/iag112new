<?php require_once('Connections/iag112new.php'); ?>
<?php @session_start();?>
<?php require_once( "webassist/security_assist/helper_php.php" ); ?>
<?php require_once("webassist/database_management/wa_appbuilder_php.php"); ?>
<?php 
if (!WA_Auth_RulePasses("User_and_Editor_and_InsertMessage")){
	WA_Auth_RestrictAccess("../login.php");
}

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

$colname_rsViewSignal = "-1";
if (isset($_GET['view'])) {
  $colname_rsViewSignal = $_GET['view'];
}
mysql_select_db($database_iag112new, $iag112new);
$query_rsViewSignal = sprintf("SELECT  dgs.Pod_NameBg AS DGS, rdg.Pod_NameBg AS RDG, dp.Pod_NameBG AS DP, s.*, sfrom.`from`, s.deistvie AS sdeistvie, r.*,s.id AS sid FROM signali AS s  LEFT JOIN nug.podelenia AS dgs ON dgs.Pod_Id = s.pod_id LEFT JOIN nug.podelenia AS rdg ON rdg.Pod_Id = dgs.Glav_Pod  LEFT JOIN nug.podelenia AS dp ON dp.Pod_Id = dgs.DP_ID LEFT JOIN report as r ON s.id = r.signal_id LEFT JOIN signalfrom AS sfrom ON sfrom.id = s.signalfrom WHERE s.id = %s", GetSQLValueString($colname_rsViewSignal, "int"));
$rsViewSignal = mysql_query($query_rsViewSignal, $iag112new) or die(mysql_error());
$row_rsViewSignal = mysql_fetch_assoc($rsViewSignal);
$totalRows_rsViewSignal = mysql_num_rows($rsViewSignal);
?>
<?php 
// WA DataAssist Insert
if ("" == "") // Trigger
{
  $WA_connection = $iag112new;
  $WA_table = "logos";
  $WA_sessionName = "view_signali";
  $WA_redirectURL = "";
  if (function_exists("rel2abs")) $WA_redirectURL = $WA_redirectURL?rel2abs($WA_redirectURL,dirname(__FILE__)):"";
  $WA_keepQueryString = false;
  $WA_fieldNamesStr = "action|ip|username|name|podelenie";
  $WA_fieldValuesStr = "Подробно разглеждане на сигнал №:". $_GET['view'] . $WA_AB_Split . "".((isset($_SERVER["REMOTE_ADDR"]))?$_SERVER["REMOTE_ADDR"]:"")  ."" . $WA_AB_Split . "".$_SESSION['username']  ."" . $WA_AB_Split . "".$_SESSION['Name']  ." ".$_SESSION['Familia']  ."" . $WA_AB_Split . "".$_SESSION['Podelenie']  ."";
  $WA_columnTypesStr = "',none,''|',none,''|',none,''|',none,''|',none,''";
  $WA_fieldNames = explode("|", $WA_fieldNamesStr);
  $WA_fieldValues = explode($WA_AB_Split, $WA_fieldValuesStr);
  $WA_columns = explode("|", $WA_columnTypesStr);
  $WA_connectionDB = $database_iag112new;
  mysql_select_db($WA_connectionDB, $WA_connection);
  @session_start();
  $insertParamsObj = WA_AB_generateInsertParams($WA_fieldNames, $WA_columns, $WA_fieldValues, -1);
  $WA_Sql = "INSERT INTO `" . $WA_table . "` (" . $insertParamsObj->WA_tableValues . ") VALUES (" . $insertParamsObj->WA_dbValues . ")";
  $MM_editCmd = mysql_query($WA_Sql, $WA_connection) or die(mysql_error());
  $_SESSION[$WA_sessionName] = mysql_insert_id($WA_connection);
  if ($WA_redirectURL != "")  {
    $WA_redirectURL = str_replace("[Insert_ID]",$_SESSION[$WA_sessionName],$WA_redirectURL);
    if ($WA_keepQueryString && $WA_redirectURL != "" && isset($_SERVER["QUERY_STRING"]) && $_SERVER["QUERY_STRING"] !== "" && sizeof($_POST) > 0) {
      $WA_redirectURL .= ((strpos($WA_redirectURL, '?') === false)?"?":"&").$_SERVER["QUERY_STRING"];
    }
    header("Location: ".$WA_redirectURL);
  }
}
?>
<!DOCTYPE html>
<html lang="en"><!-- InstanceBegin template="/Templates/main.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

<title>ИАГ Модул тел.112</title>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<link rel="stylesheet" type="text/css" href="all_css/all.css">
<link rel="stylesheet" type="text/css" href="all_css/my.css">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="all_css/datepicker.css">
<!-- InstanceBeginEditable name="head" -->

<!-- InstanceEndEditable -->
</head>
<body>

<nav class="navbar navbar-default">
   <div class="container">
      <div class="navbar-header"> 
        <!--<a class="navbar-brand" href="https://sa.iag.bg"> <img alt="Brand" src="https://112.iag.bg/images/logo.png"></a>-->
         <ul class="nav navbar-nav">
            <li><a href="index.php" >
               <h4>Начална</h4>
               </a></li>
            <li> <a href="signali.php">
               <h4>Сигнали</h4>
               </a></li>
            <li>
              <?php if(WA_Auth_RulePasses("InsertMessage")){ // Begin Show Region ?> 
              <a href="add_signal.php">
                 <h4>Нов сигнал</h4>
               </a> 
               <?php } // End Show Region ?>
            </li>
            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
               <h4> Справки <span class="caret"></span></h4>
               </a>
               <ul class="dropdown-menu">
                  <li> <a href="spravka.php" > Справка </a></li>
                  <!--<li> <a href="#" > РДГ-та </a></li>
                  <li> <a href="#"> ДП-та </a></li>
                  <li> <a href="#"> Справка 3 </a></li>
                  <li role="separator" class="divider"> </li>
                  <li> <a href="#"> Separated link </a></li>
                  <li role="separator" class="divider"> </li>
                  <li> <a href="#"> One more separated link </a></li>-->
               </ul>
            </li>
            <li> <a href="logout.php">
          <h4>Изход</h4>
        </a></li>
         </ul>
      </div>
      <div class="navbar-header navbar-right">
         <h4> <small> Потребител: ( <?php echo $_SESSION['Name']; ?> <?php echo $_SESSION['Familia']; ?> <?php echo $_SESSION['Podelenie']; ?> (<?php echo $_SESSION['Email']; ?>) )</small> </h4>
      </div>
   </div>
</nav>
<div class="container">
   <div class="row"></div>
   <div class="row">
      <div class="panel panel-default panel-heading">
         <div class="panel-body text-center">
		 <!-- InstanceBeginEditable name="EditTittle" -->
           <h1>Преглед на сигнали</h1>
         <!-- InstanceEndEditable --></div>
      </div>
   </div>
   <div class="row">
      <div class="panel panel-default">
         <div class="panel-body">
		 <!-- InstanceBeginEditable name="MainContent" -->
		  <!-- Default panel contents -->
			 <div class="panel-heading text-center"><h3>Сигнал №: <?php echo $row_rsViewSignal['sid']; ?></h3></div>
		  <div class="panel-body">
			<p>...</p>
		  </div>

		  <!-- List group -->
		  <ul class="list-group  col-md-8 col-xs-offset-2">
			  <li class="list-group-item">
				  <h4>Постъпил от:</h4>
				  <p class="text-right"><?php echo $row_rsViewSignal['from']; ?></p>
			  </li>
			  <li class="list-group-item">
				  <h4>Идентификационен №:</h4>
				  <p class="text-right"><?php echo $row_rsViewSignal['identnumber']; ?></p>
			  </li>
			  <li class="list-group-item">
				  <h4>От телефон:</h4>
				  <p class="text-right"><?php echo $row_rsViewSignal['phone']; ?></p>
			  </li>
			  <li class="list-group-item">
				  <h4>Дата на постъпване на сигнала:</h4>
				  <p class="text-right"><?php echo date('d.m.Y',strtotime($row_rsViewSignal['signaldate'])); ?> год. в <?php echo date('H:i',strtotime($row_rsViewSignal['signaldate'])); ?> ч.</p>
			  </li>
			  <li class="list-group-item">
				  <h4>Описание на сигнала:</h4>
				  <p class="text-justify"><?php echo $row_rsViewSignal['opisanie']; ?></p>
			  </li>
			  <li class="list-group-item">
				  <h4>Подател на сигнала:</h4>
				  <p class="text-right"><?php echo $row_rsViewSignal['name'] ?  $row_rsViewSignal['name'] : 'Анонимен' ?></p>
			  </li>
			  <li class="list-group-item">
				  <h4>Адрес на подателя:</h4>
				  <p class="text-right"><?php echo $row_rsViewSignal['adress'] ?  $row_rsViewSignal['adress'] : 'Не е посочен' ?></p>
			  </li>
			  <li class="list-group-item">
				  <h4>Предприето действие от регистратора:</h4>
				  <p class="text-right text-justify"><?php echo $row_rsViewSignal['sdeistvie']; ?></p>
			  </li>
			  <li class="list-group-item">
				  <h4>Обхват на местоположението на сигнала:</h4>
				  <p class="text-right"><?php echo $row_rsViewSignal['DGS']; ?></p>
				  <p class="text-right"><?php echo $row_rsViewSignal['RDG']; ?></p>
				  <p class="text-right"><?php echo $row_rsViewSignal['DP']; ?></p>
			  </li>
			  <li class="list-group-item">
				  <h4>Забележка при регистрацията на сигнала:</h4>
				  <p class="text-right"><?php echo $row_rsViewSignal['notes'] ?  $row_rsViewSignal['notes'] : 'Няма' ?></p>
			  </li>
			  <li class="list-group-item">
				  <h4>Отчет на сигнала след проверката:</h4>
				  <p class="text-right"><?php echo $row_rsViewSignal['proveren'] ?  "Има изготвен отчет" : 'Няма изготвен отчет' ?></p>
			  </li>
			  <li class="list-group-item">
				  <h4>Описание на отчета:</h4>
				  <p class="text-justify"><?php echo $row_rsViewSignal['opisanie_otchet']; ?></p>
			  </li>
			  <li class="list-group-item">
				  <h4>Дата на отчета:</h4>
				  <p class="text-right"><?php echo date('d.m.Y',strtotime($row_rsViewSignal['date_otchet'])); ?> год. в <?php echo date('H:i', strtotime($row_rsViewSignal['date_otchet'])); ?> ч.</p>
			  </li>
			  <li class="list-group-item">
				  <h4>Сигналът е проверен на место:</h4>
				  <p class="text-right"><?php echo $row_rsViewSignal['proveren_na_mesto'] == 1 ?  "Да" : "" ?></p>
			  </li>
			  <li class="list-group-item">
				  <h4>Сигналът е фалшив:</h4>
				  <p class="text-right"><?php echo $row_rsViewSignal['falshiv'] == 1 ?  "Да" : "" ?></p>
			  </li>
			  <li class="list-group-item">
				  <h4>Констатирани нарушения:</h4>
				  <p class="text-right"><?php echo $row_rsViewSignal['falshiv'] == 1 ?  "Да" : "" ?></p>
			  </li>
			</ul>
		
         <!-- InstanceEndEditable -->
         </div>
      </div>
      <div class="panel panel-default">
         <div class="panel-body">
            <p class="text-center"> &copy; ИАГ - Дирекция ИОВО</p>
            <p class="text-center">2015 - <?php echo(date('Y'));?></p>
         </div>
      </div>
   </div>
</div>
</div>
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<!-- Other scripts for select2 and DataTable --> 
<!-- InstanceBeginEditable name="OtherScripts" -->
<script type="text/javascript" src="all_js/all.js"></script>
<script type="text/javascript" src="ScriptLibrary/bootstrap-datepicker.js" charset="UTF-8"></script>
<script src="ScriptLibrary/locales/bootstrap-datepicker.bg.js"></script>
<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rsViewSignal);
?>
