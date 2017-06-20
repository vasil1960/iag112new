<?php require_once('Connections/iag112new.php'); ?>
<?php require_once("webassist/database_management/wa_appbuilder_php.php"); ?>
<?php 
// WA DataAssist Insert
if ("" == "") // Trigger
{
  $WA_connection = $iag112new;
  $WA_table = "logos";
  $WA_sessionName = "logout";
  $WA_redirectURL = "";
  if (function_exists("rel2abs")) $WA_redirectURL = $WA_redirectURL?rel2abs($WA_redirectURL,dirname(__FILE__)):"";
  $WA_keepQueryString = false;
  $WA_fieldNamesStr = "action|ip|username|name|podelenie";
  $WA_fieldValuesStr = "Изход от модула" . $WA_AB_Split . "".((isset($_SERVER["REMOTE_ADDR"]))?$_SERVER["REMOTE_ADDR"]:"")  ."" . $WA_AB_Split . "".$_SESSION['username']  ."" . $WA_AB_Split . "".$_SESSION['Name']  ." ".$_SESSION['Familia']  ."" . $WA_AB_Split . "".$_SESSION['Podelenie']  ."";
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
<?php
 
@session_start();
if ("" == ""){
  // WA_ClearSession
	$clearAll = TRUE;
	$clearThese = explode(",","");
	if($clearAll){
		foreach ($_SESSION as $key => $value){
			unset($_SESSION[$key]);
		}
	}
	else{
		foreach($clearThese as $value){
			unset($_SESSION[$value]);
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

<title>ИАГ Модул тел.112</title>
<style type="text/css">
.btn1 {
	display: inline;
	margin-left: .3em;
	zoom: 1;
	white-space: nowrap;
}
.checkbox1 {
	display: inline;
}
.radio1 {
	display: inline;
}
.uneditable-input1 {
	display: inline;
}
</style>

<!-- Bootstrap -->

<style type="text/css">
body, td, th {
	font-family: Verdana, Geneva, sans-serif;
}
</style>
<link rel="stylesheet" type="text/css" href="all_css/all.css">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<meta charset="utf-8">
</head>
<body>
<div class="container">
  <div class="row"></div>
  <div class="row">
    <div class="panel panel-default panel-heading">
      <div class="panel-body text-center">
        <h1 class="text-success">Вие излязохте успешно от модул 112</h1>
        
      </div>
    </div>
  </div>
  <div class="row">
    <div class="panel panel-default">
      <div class="panel-body">
        <meta charset="utf-8">
        <div class="row text-center"><p><a class="btn btn-info" href="index.php">Вход</a></p> </div>
        <div class="row">
          <div class="panel panel-default">
            <div class="panel-body">
              <div class="img-rounded"> <img class="img-rounded center-block" src="images/112.jpg"> </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-body">
        <p class="text-center"> &copy; ИАГ - Дирекция ИОВО </p>
        <p class="text-center">2015 - <?php echo(date('Y'));?></p>
      </div>
    </div>
  </div>
</div>
</div>
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<!-- Other scripts for select2 and DataTable -->

</body>
<!-- InstanceEnd -->
</html>