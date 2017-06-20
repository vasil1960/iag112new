<?php
@session_start();
?>
<?php @session_start(); ?>
<?php require_once('php_scripts/SHA512.php'); ?>
<?php require_once("webassist/form_validations/wavt_scripts_php.php"); ?>
<?php require_once("webassist/form_validations/wavt_validatedform_php.php"); ?>
<?php require_once( "webassist/security_assist/helper_php.php" ); ?>
<?php require_once("webassist/database_management/wa_appbuilder_php.php"); ?>
<?php require_once('Connections/nug.php'); ?>
<?php 
if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_SERVER["HTTP_REFERER"]) && strpos(urldecode($_SERVER["HTTP_REFERER"]), urldecode($_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"])) > 0) && isset($_POST))  {
  $WAFV_Redirect = "login.php";
  $_SESSION['WAVT_login_053_Errors'] = "";
  if ($WAFV_Redirect == "")  {
    $WAFV_Redirect = $_SERVER["PHP_SELF"];
  }
  $WAFV_Errors = "";
  $WAFV_Errors .= WAValidateRQ(((isset($_POST["inputUser"]))?$_POST["inputUser"]:"") . "",false,1);
  $WAFV_Errors .= WAValidateRQ(((isset($_POST["inputPassword"]))?$_POST["inputPassword"]:"") . "",false,2);

  if ($WAFV_Errors != "")  {
    PostResult($WAFV_Redirect,$WAFV_Errors,"login_053");
  }
}
?>
<?php
if(($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_SERVER["HTTP_REFERER"]) && strpos(urldecode($_SERVER["HTTP_REFERER"]), urldecode($_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"])) > 0) && isset($_POST)){
	$WA_Auth_Parameter = array(
	"connection" => $nug,
	"database" => $database_nug,
	"tableName" => "users",
	"columns" => explode($WA_Auth_Separator,"username".$WA_Auth_Separator."pass_sha".$WA_Auth_Separator."Active"),
	"columnValues" => explode($WA_Auth_Separator,"".((isset($_POST["inputUser"]))?$_POST["inputUser"]:"")  ."".$WA_Auth_Separator."". SHA512_Encryption((isset($_POST["inputUser"]))?$_POST["inputUser"]:"",(isset($_POST["inputPassword"]))?$_POST["inputPassword"]:"")  ."".$WA_Auth_Separator."1"),
	"columnTypes" => explode($WA_Auth_Separator,"text".$WA_Auth_Separator."text".$WA_Auth_Separator."int"),
	"sessionColumns" => explode($WA_Auth_Separator,"ID".$WA_Auth_Separator."username".$WA_Auth_Separator."pass_sha".$WA_Auth_Separator."Name".$WA_Auth_Separator."Familia".$WA_Auth_Separator."Podelenie".$WA_Auth_Separator."Tel".$WA_Auth_Separator."GSM".$WA_Auth_Separator."Email".$WA_Auth_Separator."AccessPodelenia".$WA_Auth_Separator."Access112".$WA_Auth_Separator."Active"),
	"sessionNames" => explode($WA_Auth_Separator,"ID".$WA_Auth_Separator."username".$WA_Auth_Separator."pass_sha".$WA_Auth_Separator."Name".$WA_Auth_Separator."Familia".$WA_Auth_Separator."Podelenie".$WA_Auth_Separator."Tel".$WA_Auth_Separator."GSM".$WA_Auth_Separator."Email".$WA_Auth_Separator."AccessPodelenia".$WA_Auth_Separator."Access112".$WA_Auth_Separator."Active"),
	"successRedirect" => "index.php",
	"failRedirect" => "login.php",
	"gotoPreviousURL" => FALSE,
	"keepQueryString" => FALSE
	);
	
	WA_AuthenticateUser($WA_Auth_Parameter);
}?>
<?php 
// WA DataAssist Insert
if ($_SERVER["REQUEST_METHOD"] == "POST") // Trigger
{
  $WA_connection = $iag112new;
  $WA_table = "logos";
  $WA_sessionName = "login";
  $WA_redirectURL = "";
  if (function_exists("rel2abs")) $WA_redirectURL = $WA_redirectURL?rel2abs($WA_redirectURL,dirname(__FILE__)):"";
  $WA_keepQueryString = false;
  $WA_fieldNamesStr = "action|ip|username|name|podelenie";
  $WA_fieldValuesStr = "Вход в модула" . $WA_AB_Split . "".((isset($_SERVER["REMOTE_ADDR"]))?$_SERVER["REMOTE_ADDR"]:"")  ."" . $WA_AB_Split . "".$_SESSION['username']  ."" . $WA_AB_Split . "".$_SESSION['Name']  ." ".$_SESSION['Familia']  ."" . $WA_AB_Split . "".$_SESSION['Podelenie']  ."";
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
<link rel="stylesheet" type="text/css" href="all_css/all.css">
</head>
<body>
<div class="row"></div>
<div class="container">
  <div class="row"></div>
  <div class="row">
    <div class="panel panel-default panel-heading">
      <div class="panel-body text-center">
        <h1><span class="form-signin-heading">Вход в модул тел. 112</span></h1>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="panel panel-default">
      <div class="panel-body">
       <h4 class="text-info text-center">Въведете потребителско име и парола от system.iag.bg</h4>
        <form method="post" class="form-signin form-horizontal col-md-4 col-md-offset-4" name="login" >
          <div class="form-group">
            <label for="inputUser" class="sr-only">Потребител</label>
            <input type="text" id="inputUser" name="inputUser" class="form-control" placeholder="Потребител"  autofocus>
            <?php
if (ValidatedField('login_053','login_053'))  {
  if ((strpos((",".ValidatedField("login_053","login_053").","), "," . "1" . ",") !== false || "1" == ""))  {
    if (!(false))  {
?>
              <span class="help-block alert-danger">Полето "Потребител" е задължително</span>
              <?php //WAFV_Conditional login.php login_053(1:)
    }
  }
}?>
          </div>
          <div class="form-group">
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Парола" >
            <?php
if (ValidatedField('login_053','login_053'))  {
  if ((strpos((",".ValidatedField("login_053","login_053").","), "," . "2" . ",") !== false || "2" == ""))  {
    if (!(false))  {
?>
              <span class="help-block alert-danger">Полето "Парола" е задължително</span>
              <?php //WAFV_Conditional login.php login_053(2:)
    }
  }
}?>
          </div>
          <!--<div class="form-group ">
            <label for="user_state" class="sr-only">Постъпил от:</label>
            <select class="form-control" id="user_state" name="user_state">
              <option value="1">Потребител 112</option>
              <option value="2">Потребител 112 с право на отчитане от проверки</option>
              <option value="3">Потребител 112 с права за въвеждане на съобщения </option>
            </select>
          </div>-->
          <div class="form-group">
            <button class="btn btn-lg btn-primary btn-block" type="submit">Влез в модула</button>
          </div>
        </form>
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
</body>
<!-- InstanceEnd -->
</html>