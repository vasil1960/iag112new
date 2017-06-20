<?php @session_start(); ?>
<?php require_once('Connections/iag112new.php'); ?>
<?php require_once("webassist/form_validations/wavt_scripts_php.php"); ?>
<?php require_once("webassist/form_validations/wavt_validatedform_php.php"); ?>
<?php require_once( "webassist/security_assist/helper_php.php" ); 
if (!WA_Auth_RulePasses("Editor")){
	WA_Auth_RestrictAccess("login.php");
}
?>
<?php 
if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_SERVER["HTTP_REFERER"]) && strpos(urldecode($_SERVER["HTTP_REFERER"]), urldecode($_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"])) > 0) && isset($_POST))  {
  $WAFV_Redirect = "otchet_signal.php";
  $_SESSION['WAVT_otchetsignal_967_Errors'] = "";
  if ($WAFV_Redirect == "")  {
    $WAFV_Redirect = $_SERVER["PHP_SELF"];
  }
  $WAFV_Errors = "";
  $WAFV_Errors .= WAValidateRQ(((isset($_POST["opisanie_otchet"]))?$_POST["opisanie_otchet"]:"") . "",false,1);
  $WAFV_Errors .= WAValidateRQ(((isset($_POST["date_otchet"]))?$_POST["date_otchet"]:"") . "",false,2);
  $WAFV_Errors .= WAValidateRQ(((isset($_POST["r_narushenia"]))?$_POST["r_narushenia"]:"") . "",false,3);

  if ($WAFV_Errors != "")  {
    PostResult($WAFV_Redirect,$WAFV_Errors,"otchetsignal_967");
  }
}
?>
<?php require_once( "webassist/security_assist/helper_php.php" ); ?>
<?php require_once("webassist/database_management/wa_appbuilder_php.php"); ?>
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
?>
<?php
$colname_rsOtchetSignali = "-1";
$colname_rsOtchetSignali = "-1";
if (isset($_GET['otchet'])) {
  $colname_rsOtchetSignali = $_GET['otchet'];
}
mysql_select_db($database_iag112new, $iag112new);
$query_rsOtchetSignali = sprintf("SELECT p.Pod_Grad, p.Pod_NameBg, s.*, n.naimenovanie FROM signali AS s INNER JOIN nug.podelenia AS p ON p.Pod_Id = s.pod_id LEFT JOIN narushenia AS n ON n.nid = s.narushenia WHERE s.id=%s ", GetSQLValueString($colname_rsOtchetSignali, "int"));
$rsOtchetSignali = mysql_query($query_rsOtchetSignali, $iag112new) or die(mysql_error());
$row_rsOtchetSignali = mysql_fetch_assoc($rsOtchetSignali);
$totalRows_rsOtchetSignali = mysql_num_rows($rsOtchetSignali);
?>
<?php
mysql_select_db($database_iag112new, $iag112new);
$query_rsActove = "SELECT * FROM actove";
$rsActove = mysql_query($query_rsActove, $iag112new) or die(mysql_error());
$row_rsActove = mysql_fetch_assoc($rsActove);
$totalRows_rsActove = mysql_num_rows($rsActove);?>
<?php 
// WA DataAssist Insert
if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_SERVER["HTTP_REFERER"]) && strpos(urldecode($_SERVER["HTTP_REFERER"]), urldecode($_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"])) > 0) && isset($_POST)) // Trigger
{
  $WA_connection = $iag112new;
  $WA_table = "report";
  $WA_sessionName = "report_session";
  $WA_redirectURL = "signali.php";
  if (function_exists("rel2abs")) $WA_redirectURL = $WA_redirectURL?rel2abs($WA_redirectURL,dirname(__FILE__)):"";
  $WA_keepQueryString = false;
  $WA_fieldNamesStr = "signal_id|slujitel_id|opisanie_otchet|note_otchet|date_otchet|proveren_na_mesto|falshiv|r_narushenia|const_narushenia|proveren|insert_date|insert_user_id";
  $WA_fieldValuesStr = "".((isset($_POST["txtSignalId"]))?$_POST["txtSignalId"]:"")  ."" . $WA_AB_Split . "".$_SESSION['ID']  ."" . $WA_AB_Split . "".((isset($_POST["opisanie_otchet"]))?$_POST["opisanie_otchet"]:"")  ."" . $WA_AB_Split . "".((isset($_POST["note_otchet"]))?$_POST["note_otchet"]:"")  ."" . $WA_AB_Split . "".((isset($_POST["date_otchet"]))?$_POST["date_otchet"]:"")  ."" . $WA_AB_Split . "".((isset($_POST["proveren_na_mesto"]))?$_POST["proveren_na_mesto"]:"0")  ."" . $WA_AB_Split . "".((isset($_POST["falshiv"]))?$_POST["falshiv"]:"0")  ."" . $WA_AB_Split . "".((isset($_POST["r_narushenia"]))?$_POST["r_narushenia"]:"")  ."" . $WA_AB_Split . "".((isset($_POST["const_narushenia"]))?$_POST["const_narushenia"]:"")  ."" . $WA_AB_Split . "1" . $WA_AB_Split . "".date("Y-m-d H:i:s")  ."" . $WA_AB_Split . "".$_SESSION['ID']  ."";
  $WA_columnTypesStr = "none,none,NULL|none,none,NULL|',none,''|',none,''|',none,NULL|none,none,NULL|none,none,NULL|none,none,NULL|none,none,NULL|none,none,NULL|',none,NULL|none,none,NULL";
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
// WA DataAssist Insert
if ("" == "") // Trigger
{
  $WA_connection = $iag112new;
  $WA_table = "logos";
  $WA_sessionName = "otchet_signali_logos";
  $WA_redirectURL = "";
  if (function_exists("rel2abs")) $WA_redirectURL = $WA_redirectURL?rel2abs($WA_redirectURL,dirname(__FILE__)):"";
  $WA_keepQueryString = false;
  $WA_fieldNamesStr = "action|ip|username|name|podelenie";
  $WA_fieldValuesStr = "Отваряне страницата за изготвяне на отчет №: " .$_GET['otchet'] . $WA_AB_Split . "".((isset($_SERVER["REMOTE_ADDR"]))?$_SERVER["REMOTE_ADDR"]:"")  ."" . $WA_AB_Split . "".$_SESSION['username']  ."" . $WA_AB_Split . "".$_SESSION['Name']  ." ".$_SESSION['Familia']  ."" . $WA_AB_Split . "".$_SESSION['Podelenie']  ."";
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
}?>
<?php 
// WA DataAssist Insert
if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_SERVER["HTTP_REFERER"]) && strpos(urldecode($_SERVER["HTTP_REFERER"]), urldecode($_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"])) > 0) && isset($_POST)) // Trigger
{
  $WA_connection = $iag112new;
  $WA_table = "logos";
  $WA_sessionName = "otchet_signal_submit";
  $WA_redirectURL = "";
  if (function_exists("rel2abs")) $WA_redirectURL = $WA_redirectURL?rel2abs($WA_redirectURL,dirname(__FILE__)):"";
  $WA_keepQueryString = false;
  $WA_fieldNamesStr = "action|ip|username|name|podelenie";
  $WA_fieldValuesStr = "Успешно изпрящане на формата за отчет №: " . $_GET['otchet'] . $WA_AB_Split . "".((isset($_SERVER["REMOTE_ADDR"]))?$_SERVER["REMOTE_ADDR"]:"")  ."" . $WA_AB_Split . "".$_SESSION['username']  ."" . $WA_AB_Split . "".$_SESSION['Name']  ." ".$_SESSION['Familia']  ."" . $WA_AB_Split . "".$_SESSION['Podelenie']  ."";
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
            <h1>Изготвяне на отчет от проверката по сигнал №: <?php echo $row_rsOtchetSignali['id']; ?></h1>
            <h4><?php echo $row_rsOtchetSignali['Pod_NameBg']; ?></h4>
            <h5><?php echo $row_rsOtchetSignali['Pod_Grad']; ?></h5>
             <!-- InstanceEndEditable --></div>
      </div>
   </div>
   <div class="row">
      <div class="panel panel-default">
         <div class="panel-body">
		 <!-- InstanceBeginEditable name="MainContent" -->
            <meta charset="utf-8">
            <div class="row"></div>
            <div class="panel-body col-md-8 col-md-offset-2">
               <h3 class="text-center">Описание на сигнала</h3>
               <p class="text-center">Вид нарушение: <?php echo $row_rsOtchetSignali['naimenovanie']; ?></p>
               <p class="text-center">Регистриран на <?php echo date('d.m.Y',strtotime($row_rsOtchetSignali['signaldate'])); ?> год. в <?php echo date('H:i',strtotime($row_rsOtchetSignali['signaldate'])); ?></p>
				<p class="text-left"><h4>Описание: </h4><?php echo $row_rsOtchetSignali['opisanie']; ?></p>
				<p class="text-left"><h4>Предадено на: </h4><?php echo $row_rsOtchetSignali['deistvie']; ?> на <?php echo  date('d.m.Y',strtotime($row_rsOtchetSignali['deistvie_date'])); ?> год. в <?php echo date('H:i',strtotime($row_rsOtchetSignali['deistvie_date'])); ?> ч.</p>
	   </div>
            <div class="panel-body text-center col-md-8 col-md-offset-2">
               <h3>Резултат от проверката</h3>
               <p class="text-center"></p>
               <p class="text-left"></p>
               <div class="row"></div>
               <form method="POST" action="" accept-charset="UTF-8" class="form-horizontal">
               <input name="txtSignalId" type="hidden" id="txtSignalId" value="<?php echo $row_rsOtchetSignali['id']; ?>">
                  <div class="form-group  ">
                     <label for="opisanie_otchet" class="control-label col-md-3">Описание:</label>
                     <div class="col-md-9">
                        <textarea rows="5" class="form-control" name="opisanie_otchet" id="opisanie_otchet" placeholder="Oписание на извършената проверка"><?php echo(ValidatedField("otchetsignal_967","result")) ?></textarea>
                        <?php
if (ValidatedField('otchetsignal_967','otchetsignal_967'))  {
  if ((strpos((",".ValidatedField("otchetsignal_967","otchetsignal_967").","), "," . "1" . ",") !== false || "1" == ""))  {
    if (!(false))  {
?>
                           <span class="text-danger text-left">Полето "Описание" е задължително</span>
                           <?php //WAFV_Conditional otchet_signal.php otchetsignal_967(1:)
    }
  }
}?>
                     </div>
                  </div>
                  <div class="form-group ">
                     <label for="date_otchet" class="control-label col-md-3">Дата:</label>
                     <div class="col-md-9">
                        <input name="date_otchet" type="text" class="form-control" id="date_otchet" placeholder="Дата на извършване на проверката" value="<?php echo(ValidatedField("otchetsignal_967","onsignalplace_date")) ?>">
                        <?php
if (ValidatedField('otchetsignal_967','otchetsignal_967'))  {
  if ((strpos((",".ValidatedField("otchetsignal_967","otchetsignal_967").","), "," . "2" . ",") !== false || "2" == ""))  {
    if (!(false))  {
?>
                           <span class="text-danger text-left">Полето "Дата на извършване на проверката" е задължително</span>
                           <?php //WAFV_Conditional otchet_signal.php otchetsignal_967(2:)
    }
  }
}?>
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="r_narushenia" class="col-md-3 control-label">Актове за:</label>
                     <div class="col-md-9">
                        <select class="form-control" id="r_narushenia" name="r_narushenia">
                           <?php
do {  
?>
                           <option value="<?php echo $row_rsActove['nid']?>"<?php if (!(strcmp($row_rsActove['nid'], (ValidatedField("otchetsignal_967","actove"))))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsActove['naimenovanie']?></option>
                           <?php
} while ($row_rsActove = mysql_fetch_assoc($rsActove));
  $rows = mysql_num_rows($rsActove);
  if($rows > 0) {
      mysql_data_seek($rsActove, 0);
	  $row_rsActove = mysql_fetch_assoc($rsActove);
  }
?>
                        </select>
                        <?php
if (ValidatedField('otchetsignal_967','otchetsignal_967'))  {
  if ((strpos((",".ValidatedField("otchetsignal_967","otchetsignal_967").","), "," . "3" . ",") !== false || "3" == ""))  {
    if (!(false))  {
?>
                           <span class="text-danger text-left">Полето "Актове за" е задължително</span>
                           <?php //WAFV_Conditional otchet_signal.php otchetsignal_967(3:)
    }
  }
}?>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-md-5 col-md-offset-3">
                        <div class="checkbox">
                           <label>
                              <input <?php if (!(strcmp(((isset($_POST["const_narushenia"]))?$_POST["const_narushenia"]:""),1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="const_narushenia" name="const_narushenia" value="1">
                              Констатирани нарушения </label>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-md-5 col-md-offset-3">
                        <div class="checkbox">
                           <label>
                              <input <?php if (!(strcmp(((isset($_POST["proveren_na_mesto"]))?$_POST["proveren_na_mesto"]:""),1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="proveren_na_mesto" name="proveren_na_mesto" value="1">
                              Сигналът е проверен на място </label>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-md-5 col-md-offset-3">
                        <div class="checkbox">
                           <label>
                              <input <?php if (!(strcmp(((isset($_POST["falshiv"]))?$_POST["falshiv"]:""),1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="falshiv" name="falshiv" value="1">
                              Подаденият сигнал е фалшив </label>
                        </div>
                     </div>
                  </div>
                  <div class="form-group ">
                     <label for="note_otchet" class="control-label col-md-3"> Забележка: </label>
                     <div class="col-md-9">
                        <textarea rows="3" class="form-control" name="note_otchet" id="note_otchet" placeholder="Забележка"><?php echo(ValidatedField("otchetsignal_967","note")) ?></textarea>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-md-9">
                        <input class="btn btn-info" type="submit" value="Отчет от проверката">
                        </div>
                  </div>
               </form>
            </div>
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
            $('#date_otchet').datetimepicker({
//             locale: 'bg',
                format:'YYYY-MM-DD HH:mm',
                useCurrent:true,
                sideBySide:true,
                calendarWeeks:true,
                showTodayButton:true
            });

            //////////////////////////////////////////////
		})
</script> 
<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rsOtchetSignali);

mysql_free_result($rsActove);
?>
