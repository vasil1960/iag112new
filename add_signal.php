<?php @session_start(); ?>
<?php require_once("webassist/form_validations/wavt_scripts_php.php"); ?>
<?php require_once("webassist/form_validations/wavt_validatedform_php.php"); ?>
<?php require_once('Connections/iag112new.php'); ?>
<?php require_once('Connections/nug.php'); ?>
<?php require_once( "webassist/security_assist/helper_php.php" ); ?>
<?php require_once("webassist/database_management/wa_appbuilder_php.php"); ?>
<?php require_once('php_scripts/myfunc.php');?>
<?php 
if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_SERVER["HTTP_REFERER"]) && strpos(urldecode($_SERVER["HTTP_REFERER"]), urldecode($_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"])) > 0) && isset($_POST))  {
  $WAFV_Redirect = "add_signal.php";
  $_SESSION['WAVT_addmessage_444_Errors'] = "";
  if ($WAFV_Redirect == "")  {
    $WAFV_Redirect = $_SERVER["PHP_SELF"];
  }
  $WAFV_Errors = "";
  $WAFV_Errors .= WAValidateRQ(((isset($_POST["signalfrom"]))?$_POST["signalfrom"]:"") . "",false,1);
  $WAFV_Errors .= WAValidateRQ(((isset($_POST["signaldate"]))?$_POST["signaldate"]:"") . "",false,2);
  $WAFV_Errors .= WAValidateRQ(((isset($_POST["identnumber"]))?$_POST["identnumber"]:"") . "",false,3);
  $WAFV_Errors .= WAValidateRQ(((isset($_POST["send_to"]))?$_POST["send_to"]:"") . "",false,4);
  $WAFV_Errors .= WAValidateRQ(((isset($_POST["opisanie"]))?$_POST["opisanie"]:"") . "",false,5);
  $WAFV_Errors .= WAValidateRQ(((isset($_POST["deistvie"]))?$_POST["deistvie"]:"") . "",false,6);
  $WAFV_Errors .= WAValidateRQ(((isset($_POST["deistvie_date"]))?$_POST["deistvie_date"]:"") . "",false,7);
  $WAFV_Errors .= WAValidateRQ(((isset($_POST["send_extra"]))?$_POST["send_extra"]:"") . "",false,8);
  $WAFV_Errors .= WAValidateRQ(((isset($_POST["narushenia"]))?$_POST["narushenia"]:"") . "",false,9);
  $WAFV_Errors .= WAValidateRQ(((isset($_POST["opisanie"]))?$_POST["opisanie"]:"") . "",false,10);
  $WAFV_Errors .= WAValidateRQ(((isset($_POST["pod_id"]))?$_POST["pod_id"]:"") . "",false,11);

  if ($WAFV_Errors != "")  {
    PostResult($WAFV_Redirect,$WAFV_Errors,"addmessage_444");
  }
}
?>
<?php
if (!WA_Auth_RulePasses("InsertMessage")){
	WA_Auth_RestrictAccess("login.php");
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

mysql_select_db($database_nug, $nug);
$query_rsPodelenia = "SELECT podelenia.Pod_Id, podelenia.Pod_NameBg FROM podelenia WHERE podelenia.Pod_Id>=101 AND podelenia.Pod_Id<=116 OR podelenia.Pod_Id>=201 AND podelenia.Pod_Id <=206";
$rsPodelenia = mysql_query($query_rsPodelenia, $nug) or die(mysql_error());
$row_rsPodelenia = mysql_fetch_assoc($rsPodelenia);
$totalRows_rsPodelenia = mysql_num_rows($rsPodelenia);

mysql_select_db($database_iag112new, $iag112new);
$query_rsNarushenia = "SELECT * FROM narushenia";
$rsNarushenia = mysql_query($query_rsNarushenia, $iag112new) or die(mysql_error());
$row_rsNarushenia = mysql_fetch_assoc($rsNarushenia);
$totalRows_rsNarushenia = mysql_num_rows($rsNarushenia);
?>
<?php 
// WA DataAssist Insert
if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_SERVER["HTTP_REFERER"]) && strpos(urldecode($_SERVER["HTTP_REFERER"]), urldecode($_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"])) > 0) && isset($_POST)) // Trigger
{
  $WA_connection = $iag112new;
  $WA_table = "signali";
  $WA_sessionName = "ins_sing_rec";
  $WA_redirectURL = "signali.php";
  if (function_exists("rel2abs")) $WA_redirectURL = $WA_redirectURL?rel2abs($WA_redirectURL,dirname(__FILE__)):"";
  $WA_keepQueryString = false;
  $WA_fieldNamesStr = "signalfrom|identnumber|pod_id|glav_pod|signaldate|name|phone|adress|send_to|send_to_extra|opisanie|deistvie|deistvie_date|notes|narushenia|policia|InsertUserID";
  $WA_fieldValuesStr = "".((isset($_POST["signalfrom"]))?$_POST["signalfrom"]:"")  ."" . $WA_AB_Split . "".((isset($_POST["identnumber"]))?$_POST["identnumber"]:"")  ."" . $WA_AB_Split . "".((isset($_POST["pod_id"]))?$_POST["pod_id"]:"")  ."" . $WA_AB_Split . "".GetGlavPodId((isset($_POST["pod_id"]))?$_POST["pod_id"]:"")  ."" . $WA_AB_Split . "".((isset($_POST["signaldate"]))?$_POST["signaldate"]:"")  ."" . $WA_AB_Split . "".((isset($_POST["name"]))?$_POST["name"]:"")  ."" . $WA_AB_Split . "".((isset($_POST["phone"]))?$_POST["phone"]:"")  ."" . $WA_AB_Split . "".((isset($_POST["adress"]))?$_POST["adress"]:"")  ."" . $WA_AB_Split . "".((isset($_POST["send_to"]))?$_POST["send_to"]:"")  ."" . $WA_AB_Split . "".((isset($_POST["send_extra"]))?$_POST["send_extra"]:"")  ."" . $WA_AB_Split . "".((isset($_POST["opisanie"]))?$_POST["opisanie"]:"")  ."" . $WA_AB_Split . "".((isset($_POST["deistvie"]))?$_POST["deistvie"]:"")  ."" . $WA_AB_Split . "".((isset($_POST["deistvie_date"]))?$_POST["deistvie_date"]:"")  ."" . $WA_AB_Split . "".((isset($_POST["notes"]))?$_POST["notes"]:"")  ."" . $WA_AB_Split . "".((isset($_POST["narushenia"]))?$_POST["narushenia"]:"")  ."" . $WA_AB_Split . "".((isset($_POST["policia"]))?$_POST["policia"]:"")  ."" . $WA_AB_Split . "".$_SESSION['ID']  ."";
  $WA_columnTypesStr = "none,none,NULL|',none,''|none,none,NULL|none,none,NULL|',none,NULL|',none,''|',none,''|',none,''|none,none,NULL|none,none,NULL|',none,''|',none,''|',none,NULL|',none,''|none,none,NULL|none,none,NULL|none,none,NULL";
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
}?>
<?php 
	$lastInsertId = mysql_insert_id() ;
?>
<?php 
include('Connection.php');
include('Logos.php');

$pdo = Connection::makeconnection();

if("" == "")
{
	$logos = new Logos($pdo);
	$logos->insertLogos('Отваряне страницата за въвеждане на нов сигнал');
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_SERVER["HTTP_REFERER"]) && strpos(urldecode($_SERVER["HTTP_REFERER"]), urldecode($_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"])) > 0) && isset($_POST))
{
	$logos = new Logos($pdo);
	$logos->insertLogos('Успешно регистриране на сигнал №: ', $lastInsertId);
}
?>

<?php 
// WA DataAssist Insert
//if ("" == "") // Trigger
{
  //$WA_connection = $iag112new;
//  $WA_table = "logos";
//  $WA_sessionName = "add_new_signal";
//  $WA_redirectURL = "";
//  if (function_exists("rel2abs")) $WA_redirectURL = $WA_redirectURL?rel2abs($WA_redirectURL,dirname(__FILE__)):"";
//  $WA_keepQueryString = false;
//  $WA_fieldNamesStr = "action|ip|username|name|podelenie";
//  $WA_fieldValuesStr = "Отваряне страницата за въвеждане на нов сигнал" . $WA_AB_Split . "".((isset($_SERVER["REMOTE_ADDR"]))?$_SERVER["REMOTE_ADDR"]:"")  ."" . $WA_AB_Split . "".$_SESSION['username']  ."" . $WA_AB_Split . "".$_SESSION['Name']  ." ".$_SESSION['Familia']  ."" . $WA_AB_Split . "".$_SESSION['Podelenie']  ."";
//  $WA_columnTypesStr = "',none,''|',none,''|',none,''|',none,''|',none,''";
//  $WA_fieldNames = explode("|", $WA_fieldNamesStr);
//  $WA_fieldValues = explode($WA_AB_Split, $WA_fieldValuesStr);
//  $WA_columns = explode("|", $WA_columnTypesStr);
//  $WA_connectionDB = $database_iag112new;
//  mysql_select_db($WA_connectionDB, $WA_connection);
//  @session_start();
//  $insertParamsObj = WA_AB_generateInsertParams($WA_fieldNames, $WA_columns, $WA_fieldValues, -1);
//  $WA_Sql = "INSERT INTO `" . $WA_table . "` (" . $insertParamsObj->WA_tableValues . ") VALUES (" . $insertParamsObj->WA_dbValues . ")";
//  $MM_editCmd = mysql_query($WA_Sql, $WA_connection) or die(mysql_error());
//  $_SESSION[$WA_sessionName] = mysql_insert_id($WA_connection);
//  if ($WA_redirectURL != "")  {
//    $WA_redirectURL = str_replace("[Insert_ID]",$_SESSION[$WA_sessionName],$WA_redirectURL);
//    if ($WA_keepQueryString && $WA_redirectURL != "" && isset($_SERVER["QUERY_STRING"]) && $_SERVER["QUERY_STRING"] !== "" && sizeof($_POST) > 0) {
//      $WA_redirectURL .= ((strpos($WA_redirectURL, '?') === false)?"?":"&").$_SERVER["QUERY_STRING"];
//    }
//    header("Location: ".$WA_redirectURL);
  }
//}?>
<?php 
// WA DataAssist Insert
//if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_SERVER["HTTP_REFERER"]) && strpos(urldecode($_SERVER["HTTP_REFERER"]), urldecode($_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"])) > 0) && isset($_POST)) // Trigger
//{
//  $WA_connection = $iag112new;
//  $WA_table = "logos";
//  $WA_sessionName = "add_signal_submit";
//  $WA_redirectURL = "";
//  if (function_exists("rel2abs")) $WA_redirectURL = $WA_redirectURL?rel2abs($WA_redirectURL,dirname(__FILE__)):"";
//  $WA_keepQueryString = false;
//  $WA_fieldNamesStr = "action|ip|username|name|podelenie";
//  $WA_fieldValuesStr = "Успешно регистриране на сигнал №: " . $lastInsertId . $WA_AB_Split . "".((isset($_SERVER["REMOTE_ADDR"]))?$_SERVER["REMOTE_ADDR"]:"")  ."" . $WA_AB_Split . "".$_SESSION['username']  ."" . $WA_AB_Split . "".$_SESSION['Name']  ." ".$_SESSION['Familia']  ."" . $WA_AB_Split . "".$_SESSION['Podelenie']  ."";
//  $WA_columnTypesStr = "',none,''|',none,''|',none,''|',none,''|',none,''";
//  $WA_fieldNames = explode("|", $WA_fieldNamesStr);
//  $WA_fieldValues = explode($WA_AB_Split, $WA_fieldValuesStr);
//  $WA_columns = explode("|", $WA_columnTypesStr);
//  $WA_connectionDB = $database_iag112new;
//  mysql_select_db($WA_connectionDB, $WA_connection);
//  @session_start();
//  $insertParamsObj = WA_AB_generateInsertParams($WA_fieldNames, $WA_columns, $WA_fieldValues, -1);
//  $WA_Sql = "INSERT INTO `" . $WA_table . "` (" . $insertParamsObj->WA_tableValues . ") VALUES (" . $insertParamsObj->WA_dbValues . ")";
//  $MM_editCmd = mysql_query($WA_Sql, $WA_connection) or die(mysql_error());
//  $_SESSION[$WA_sessionName] = mysql_insert_id($WA_connection);
//  if ($WA_redirectURL != "")  {
//    $WA_redirectURL = str_replace("[Insert_ID]",$_SESSION[$WA_sessionName],$WA_redirectURL);
//    if ($WA_keepQueryString && $WA_redirectURL != "" && isset($_SERVER["QUERY_STRING"]) && $_SERVER["QUERY_STRING"] !== "" && sizeof($_POST) > 0) {
//      $WA_redirectURL .= ((strpos($WA_redirectURL, '?') === false)?"?":"&").$_SERVER["QUERY_STRING"];
//    }
//    header("Location: ".$WA_redirectURL);
//  }
//}
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
            <h1>Въвеждане на нов сигнал</h1>
            <!-- InstanceEndEditable --></div>
      </div>
   </div>
   <div class="row">
      <div class="panel panel-default">
         <div class="panel-body">
		 <!-- InstanceBeginEditable name="MainContent" -->
            <form method="POST" action="" accept-charset="UTF-8" class="form-horizontal col-md-8 col-md-offset-2">
               <div class="form-group">
                  <label for="name" class="col-md-3 control-label">
                     <input name="_token" type="hidden" value="uCoLsNYH8s8P220u1LtAuvohPnXQzlVAyFwDjeEM">
                  </label>
               </div>
               <div class="form-group">
                  <label for="signalfrom" class="col-md-3 control-label">Постъпил от:</label>
                  <div class="col-md-9">
                     <select class="form-control" id="signalfrom" name="signalfrom">
                        <option value="" <?php if (!(strcmp("", (ValidatedField("addmessage_444","signalfrom"))))) {echo "selected=\"selected\"";} ?>>Избери от къде е постъпил сигнала</option>
                        <option value="1" <?php if (!(strcmp(1, (ValidatedField("addmessage_444","signalfrom"))))) {echo "selected=\"selected\"";} ?>>тел. 112</option>
                        <option value="2" <?php if (!(strcmp(2, (ValidatedField("addmessage_444","signalfrom"))))) {echo "selected=\"selected\"";} ?>>тел. 0800 20 800</option>
                        <option value="3">Платформа НПО</option>
                     </select>
                     <?php
if (ValidatedField('addmessage_444','addmessage_444'))  {
  if ((strpos((",".ValidatedField("addmessage_444","addmessage_444").","), "," . "1" . ",") !== false || "1" == ""))  {
    if (!(false))  {
?>
                        <span class="text-danger">Полето "Постъпил от" е задължително</span>
                        <?php //WAFV_Conditional add_message.php addmessage_444(1:)
    }
  }
}?>
                  </div>
               </div>
               <div class="form-group">
                  <label for="signaldate" class="col-md-3 control-label" autocomplete="off">Дата на сигнала:</label>
                  <div class="col-md-9">
                     <input name="signaldate" type="text" class="form-control" id="signaldate" placeholder="Дата на регистриране на сигнала от служителя" value="<?php echo(ValidatedField("addmessage_444","signaldate")) ?>">
                     <?php
if (ValidatedField('addmessage_444','addmessage_444'))  {
  if ((strpos((",".ValidatedField("addmessage_444","addmessage_444").","), "," . "2" . ",") !== false || "2" == ""))  {
    if (!(false))  {
?>
                        <span class="text-danger">Полето "Дата на сигнала" е задължително</span>
                        <?php //WAFV_Conditional add_message.php addmessage_444(2:)
    }
  }
}?>
                  </div>
               </div>
               <div class="form-group">
                  <label for="identnumber" class="col-md-3 control-label">Идент. №:</label>
                  <div class="col-md-9">
                     <input name="identnumber" type="text" class="form-control" id="identnumber" placeholder="Идентификационен номер от републиканския тел. 112" value="<?php echo(ValidatedField("addmessage_444","identnumber")) ?>">
                     <?php
if (ValidatedField('addmessage_444','addmessage_444'))  {
  if ((strpos((",".ValidatedField("addmessage_444","addmessage_444").","), "," . "3" . ",") !== false || "3" == ""))  {
    if (!(false))  {
?>
                        <span class="text-danger">Полето "Идент. №" е задължително</span>
                        <?php //WAFV_Conditional add_message.php addmessage_444(3:)
    }
  }
}?>
                  </div>
               </div>
               <div class="form-group">
                  <label for="pod_id" class="col-md-3 control-label">Местоположение:</label>
                  <div class="col-md-9">
                     <select class="form-control" id="pod_id" name="pod_id">
                     </select>
                     <?php
if (ValidatedField('editsignal_710','editsignal_710'))  {
  if ((strpos((",".ValidatedField("editsignal_710","editsignal_710").","), "," . "11" . ",") !== false || "11" == ""))  {
    if (!(false))  {
?>
                        <span class="text-danger">Полето "Местоположение" е задължително</span>
                        <?php //WAFV_Conditional edit_signal.php editsignal_710(11:)
    }
  }
}?>
                  </div>
               </div>
               <div class="form-group">
                  <label for="name2" class="col-md-3 control-label">Подател:</label>
                  <div class="col-md-9">
                     <input name="name" type="text" class="form-control" id="name2" placeholder="Подател на сигнала" value="<?php echo(ValidatedField("addmessage_444","name")) ?>">
                  </div>
               </div>
               <div class="form-group">
                  <label for="phone" class="col-md-3 control-label">Телефон:</label>
                  <div class="col-md-9">
                     <input name="phone" type="text" class="form-control" id="phone" placeholder="Телефонен номер от който е подаден сигнала" value="<?php echo(ValidatedField("addmessage_444","phone")) ?>">
                  </div>
               </div>
               <div class="form-group">
                  <label for="adress" class="col-md-3 control-label">Адрес:</label>
                  <div class="col-md-9">
                     <input name="adress" type="text" class="form-control" id="adress" placeholder="Адрес на подателя на сигнала" value="<?php echo(ValidatedField("addmessage_444","adress")) ?>">
                  </div>
               </div>
               <div class="form-group">
                  <label for="opisanie" class="col-md-3 control-label">Описание:</label>
                  <div class="col-md-9">
                     <textarea name="opisanie" class="form-control" id="opisanie" placeholder="Описание на сигнала"><?php echo(ValidatedField("addmessage_444","opisanie")) ?></textarea>
                     <?php
if (ValidatedField('addmessage_444','addmessage_444'))  {
  if ((strpos((",".ValidatedField("addmessage_444","addmessage_444").","), "," . "10" . ",") !== false || "10" == ""))  {
    if (!(false))  {
?>
                        <span class="text-danger">Полето "Описание" е задължително</span>
                        <?php //WAFV_Conditional add_message.php addmessage_444(10:)
    }
  }
}?>
                  </div>
               </div>
               <div class="form-group">
                  <label for="signal_for_what" class="col-md-3 control-label">Вид нарушение:</label>
                  <div class="col-md-9">
                     <select class="form-control" id="narushenia" name="narushenia">
                       <?php
do {  
?>
                       <option value="<?php echo $row_rsNarushenia['nid']?>"<?php if (!(strcmp($row_rsNarushenia['nid'], (ValidatedField("addmessage_444","narushenia"))))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsNarushenia['naimenovanie']?></option>
                       <?php
} while ($row_rsNarushenia = mysql_fetch_assoc($rsNarushenia));
  $rows = mysql_num_rows($rsNarushenia);
  if($rows > 0) {
      mysql_data_seek($rsNarushenia, 0);
	  $row_rsNarushenia = mysql_fetch_assoc($rsNarushenia);
  }
?>
                        
                     </select>
                     <?php
if (ValidatedField('addmessage_444','addmessage_444'))  {
  if ((strpos((",".ValidatedField("addmessage_444","addmessage_444").","), "," . "9" . ",") !== false || "9" == ""))  {
    if (!(false))  {
?>
                        <span class="text-danger">Полето "Вид нарушение" е задължително</span>
                        <?php //WAFV_Conditional add_message.php addmessage_444(9:)
    }
  }
}?>
                  </div>
               </div>
               <div class="form-group">
                  <label for="signal_for" class="col-md-3 control-label">Предадено на:</label>
                  <div class="col-md-9"><!--Сигналът е за-->
                     <select class="form-control" id="send_to" name="send_to">
                       <option value="" <?php if (!(strcmp("", (ValidatedField("addmessage_444","signal_for"))))) {echo "selected=\"selected\"";} ?>>Избери на кого е предадено съобщението</option>
                       <?php
do {  
?>
<option value="<?php echo $row_rsPodelenia['Pod_Id']?>"<?php if (!(strcmp($row_rsPodelenia['Pod_Id'], (ValidatedField("addmessage_444","signal_for"))))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsPodelenia['Pod_NameBg']?></option>
                       <?php
} while ($row_rsPodelenia = mysql_fetch_assoc($rsPodelenia));
  $rows = mysql_num_rows($rsPodelenia);
  if($rows > 0) {
      mysql_data_seek($rsPodelenia, 0);
	  $row_rsPodelenia = mysql_fetch_assoc($rsPodelenia);
  }
?>
                       <option value="8888">ИАРА</option>
                     </select>
                     <?php
if (ValidatedField('addmessage_444','addmessage_444'))  {
  if ((strpos((",".ValidatedField("addmessage_444","addmessage_444").","), "," . "4" . ",") !== false || "4" == ""))  {
    if (!(false))  {
?>
                        <span class="text-danger">Полето "Предадено на" е задължително</span>
                        <?php //WAFV_Conditional add_message.php addmessage_444(4:)
    }
  }
}?>
                  </div>
               </div>
               <div class="form-group">
                  <label for="send_extra" class="col-md-3 control-label">Предадено още на:</label>
                  <div class="col-md-9">
                    <input <?php if (!(strcmp(((isset($_POST["send_extra"]))?$_POST["send_extra"]:""),"0"))) {echo "checked=\"checked\"";} ?> type="radio" name="send_extra" id="send_extra" value="0" checked />На никой
                    <input <?php if (!(strcmp(((isset($_POST["send_extra"]))?$_POST["send_extra"]:""),"1"))) {echo "checked=\"checked\"";} ?> type="radio" name="send_extra" id="send_extra" value="1" />Полиция
                    <input <?php if (!(strcmp(((isset($_POST["send_extra"]))?$_POST["send_extra"]:""),"2"))) {echo "checked=\"checked\"";} ?> type="radio" name="send_extra" id="send_extra" value="2" />Пожарна
                    <input <?php if (!(strcmp(((isset($_POST["send_extra"]))?$_POST["send_extra"]:""),"3"))) {echo "checked=\"checked\"";} ?> type="radio" name="send_extra" id="send_extra" value="3" />БАБХ
                                      </div>
               </div>
               <div class="form-group">
                  <label for="deistvie" class="col-md-3 control-label">Предприети действия:</label>
                  <div class="col-md-9">
                     <textarea rows="2" class="form-control" placeholder="Предприети действия от регистриращия сигнала" name="deistvie" cols="50" id="deistvie"><?php echo(ValidatedField("addmessage_444","deistvie")) ?></textarea>
                     <?php
if (ValidatedField('addmessage_444','addmessage_444'))  {
  if ((strpos((",".ValidatedField("addmessage_444","addmessage_444").","), "," . "6" . ",") !== false || "6" == ""))  {
    if (!(false))  {
?>
                        <span class="text-danger">Полето "Предприети действия" е задължително</span>
                        <?php //WAFV_Conditional add_message.php addmessage_444(6:)
    }
  }
}?>
                  </div>
               </div>
               <div class="form-group">
                  <label for="deistvie_date" class="col-md-3 control-label" autocomplete="off">Дата на действието:</label>
                  <div class="col-md-9">
                     <input name="deistvie_date" type="text" class="form-control" id="deistvie_date" placeholder="Дата на предприетите действия от служителя приел сигнала" value="<?php echo(ValidatedField("addmessage_444","deistvie_date")) ?>">
                     <?php
if (ValidatedField('addmessage_444','addmessage_444'))  {
  if ((strpos((",".ValidatedField("addmessage_444","addmessage_444").","), "," . "7" . ",") !== false || "7" == ""))  {
    if (!(false))  {
?>
                        <span class="text-danger">Полето "Дата на действието" е задължително</span>
                        <?php //WAFV_Conditional add_message.php addmessage_444(7:)
    }
  }
}?>
                  </div>
               </div>
               <div class="form-group">
                  <label for="notes" class="col-md-3 control-label">Забележка:</label>
                  <div class="col-md-9">
                     <textarea rows="4" class="form-control" placeholder="Забележка" name="notes" cols="50" id="notes"><?php echo(ValidatedField("addmessage_444","notes")) ?></textarea>
                  </div>
               </div>
               <div class="form-group">
                  <label for="policia" class="col-md-3 control-label">Сигнала е предаден на полицията след 22 часа</label>
                  <div class="col-md-9">
                     <input id="policia" class="checkbox1" name="policia" type="checkbox" value="1">
                  </div>
               </div>
               <div class="form-group">
                  <div class="col-md-offset-3 col-md-9">
                     <input class="btn btn-info" type="submit" value="Регистриране на сигнала">
                  </div>
               </div>
            </form>
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
<script type="text/javascript">
        $(function () {
        //////////////////////////////////////////////
            $('#signaldate').datetimepicker({
//             locale: 'bg',
                format:'YYYY-MM-DD HH:mm',
                useCurrent:true,
                sideBySide:true,
                calendarWeeks:true,
                showTodayButton:true
            });

            //////////////////////////////////////////////
            $('#deistvie_date').datetimepicker({
//            locale: 'bg',
                format:'YYYY-MM-DD HH:mm',
                useCurrent:true,
                sideBySide:true,
                calendarWeeks:true,
                showTodayButton:true
            });

        //////////////////////////////////////////////
            $("#pod_id").select2({
                tags: true,
                allowClear:true,
                multiple: false,
                minimumInputLength: 1,
                placeholder: "Избери местоположение на сигнала",
                minimumResultsForSearch: 50,
                language: "bg",
                ajax: {
                    //url: "https://system.iag.bg/iag112new/php_scripts/podelenie_autocomplete.php",
					url: "php_scripts/podelenie_autocomplete.php",
                    dataType: "json",
                    delay: 250,
					type:'POST',
                    data: function (params) {
                        return {
                            term: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    id:       item.Pod_Id,
									Glav_Pod: item.Glav_Pod,
                                    text:     item.podelenie,
                                    rdg:      item.rdg,
                                    grad:     item.grad
                                }
                            })
                        };
                    }
                },

                templateResult: formatRepo, // omitted for brevity, see the source of this page
                templateSelection: formatRepoSelection, // omitted for brevity, see the source of this page
                //dropdownCssClass: "bigdrop",
                escapeMarkup: function (markup) { return markup; } // let our custom formatter work
            });

            function formatRepo(repo)
            {
                if (!repo.id) return repo.text;

                var html  = "";
                html += "<div>";
                html += "<span style='font-weight: bold; font-size: 110%; color: #434343'>" + repo.text + "</span>" + "<br>";
//                html += "";
                html += repo.rdg;
                html += ", ";
                html += repo.grad;
                html += "</div>";
                console.log(html)
                return html;
            }

            function formatRepoSelection(repo)
            {
                var html  = "";
                html += repo.text;
           //     html += "<span style='font-size:smaller'>" + ' - ' + 'общ. ' + repo.rdg  + ", обл. " +  repo.grad + "</span>";
                html += "";
				console.log(html)
			    return html || repo.text
            }

        });
    </script> 
<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rsPodelenia);

mysql_free_result($rsNarushenia);
?>
