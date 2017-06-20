<?php require_once('Connections/iag112new.php'); ?>
<?php @session_start();?>
<?php require_once( "webassist/security_assist/helper_php.php" ); ?>
<?php require_once("webassist/database_management/wa_appbuilder_php.php"); ?>
<?php
if (!WA_Auth_RulePasses("User_and_Editor_and_InsertMessage")){
	WA_Auth_RestrictAccess("login.php");
}?>
<?php 
// WA DataAssist Insert
if ("" == "") // Trigger
{
  $WA_connection = $iag112new;
  $WA_table = "logos";
  $WA_sessionName = "spravka_logos";
  $WA_redirectURL = "";
  if (function_exists("rel2abs")) $WA_redirectURL = $WA_redirectURL?rel2abs($WA_redirectURL,dirname(__FILE__)):"";
  $WA_keepQueryString = false;
  $WA_fieldNamesStr = "action|ip|username|name|podelenie";
  $WA_fieldValuesStr = "Отваряне страницата за справка." . $WA_AB_Split . "".((isset($_SERVER["REMOTE_ADDR"]))?$_SERVER["REMOTE_ADDR"]:"")  ."" . $WA_AB_Split . "".$_SESSION['username']  ."" . $WA_AB_Split . "".$_SESSION['Name']  ." ".$_SESSION['Familia']  ."" . $WA_AB_Split . "".$_SESSION['Podelenie']  ."";
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
  $WA_sessionName = "spravka_submit";
  $WA_redirectURL = "";
  if (function_exists("rel2abs")) $WA_redirectURL = $WA_redirectURL?rel2abs($WA_redirectURL,dirname(__FILE__)):"";
  $WA_keepQueryString = false;
  $WA_fieldNamesStr = "action|ip|username|name|podelenie";
  $WA_fieldValuesStr = "Успешно изпращане на формата за изготвяне на справката за период от до" . $WA_AB_Split . "".((isset($_SERVER["REMOTE_ADDR"]))?$_SERVER["REMOTE_ADDR"]:"")  ."" . $WA_AB_Split . "".$_SESSION['username']  ."" . $WA_AB_Split . "".$_SESSION['Name']  ." ".$_SESSION['Familia']  ."" . $WA_AB_Split . "".$_SESSION['Podelenie']  ."";
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
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="all_css/datepicker.css">
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
           <h1>Справка</h1>
        <!-- InstanceEndEditable --></div>
      </div>
   </div>
   <div class="row">
      <div class="panel panel-default">
         <div class="panel-body">
		 <!-- InstanceBeginEditable name="MainContent" -->
           <div class="panel panel-default">
           	<div class="panel-body text-center">
                <!--<h4>Hello</h4>-->
                <form action="spravka_result.php" method="get" class="form-inline" id="frmSpravka">
                  <div class="form-group">
                    <label for="from_date">От</label>
                    <input type="text" class="form-control" id="from" name="from" autocomplete="off" value="<?php echo date("Y-m-d", strtotime("2017-02-01"));?>">
                  </div>
                  <div class="form-group">
                    <label for="to_date">до</label>
                    <input type="text" class="form-control" id="to" name="to" autocomplete="off" value="<?php echo date('Y-m-d') ;?>">
                  </div>
                  <button type="submit" class="btn btn-default">Справка</button>
                </form>
            </div>
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
<script type="text/javascript" src="ScriptLibrary/bootstrap-datepicker.js" charset="UTF-8"></script>
<script src="ScriptLibrary/locales/bootstrap-datepicker.bg.js"></script>
<script type="text/javascript">
        $(function () {
        //////////////////////////////////////////////
            $('#from').datepicker({
				language:'bg', 
				format:'yyyy-mm-dd',
				todayBtn: true,
				autoclose:true,
				setStartDate:'2017-01-01'
            });

            //////////////////////////////////////////////
            $('#to').datepicker({
				language:'bg', 
				format:'yyyy-mm-dd',
				todayBtn: true,
				autoclose:true
            });
       });
    </script> 
<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>

