<?php require_once('Connections/iag112new.php'); ?>
<?php require_once( "webassist/security_assist/helper_php.php" ); ?>
<?php require_once("webassist/database_management/wa_appbuilder_php.php"); ?>
<?php require_once( "webassist/security_assist/helper_php.php" ); 
if (!WA_Auth_RulePasses("User_and_Editor_and_InsertMessage")){
	WA_Auth_RestrictAccess("login.php");
}
?>
<?php
include('Connection.php');
include('SpravkaResult.php');

$pdo = Connection::makeconnection();

if(isset($_GET['from'])){
	$from = $_GET['from'];	
}

if(isset($_GET['to'])){
	$to = $_GET['to'];	
}

$obj = new SpravkaResult( $pdo, $from, $to, 'signalfrom' );
$signalfrom = $obj->fetchCounts();
$sum_signalfrom = $obj->sumcount($signalfrom);

$obj = new SpravkaResult( $pdo, $from, $to, 'rdg' );
$rdg = $obj->fetchCounts();
$sum_rdg = $obj->sumcount($rdg);

$obj = new SpravkaResult( $pdo, $from, $to, 'dp' );
$dp = $obj->fetchCounts();
$sum_dp = $obj->sumcount($dp);

$obj = new SpravkaResult( $pdo, $from, $to, 'iara' );
$iara = $obj->fetchCounts();
$sum_iara = $obj->sumcount($iara);

$obj = new SpravkaResult( $pdo, $from, $to, 'narushenia' );
$narushenia = $obj->fetchCounts();
$sum_narushenia = $obj->sumcount($narushenia);

$obj = new SpravkaResult( $pdo, $from, $to, 'proveren_na_mesto');
$proveren_na_mesto = $obj->fetchCounts();
$sum_proveren_na_mesto = $obj->sumcount($proveren_na_mesto);

$obj = new SpravkaResult( $pdo, $from, $to, 'falshiv' );
$falshiv = $obj->fetchCounts();
$sum_falshiv = $obj->sumcount( $falshiv );

$obj = new SpravkaResult( $pdo, $from, $to, 'otgovoreno' );
$otgovoreno = $obj->fetchCounts();
$sum_otgovoreno = $obj->sumcount( $otgovoreno );

$obj = new SpravkaResult( $pdo, $from, $to, 'vanshni_pod' );
$vanshni = $obj->fetchCounts();
$sum_vanshni = $obj->sumcount( $vanshni );

$obj = new SpravkaResult( $pdo, $from, $to, 'konstatirani' );
$konstatirani = $obj->fetchCounts();
$sum_konstatirani = $obj->sumcount( $konstatirani );

$obj = new SpravkaResult( $pdo, $from, $to, 'policia_after_22' );
$policia_after_22 = $obj->fetchCounts();
$sum_policia_after_22 = $obj->sumcount( $policia_after_22 );
?>
<?php
@session_start();
if ("" == "")     {
  $_SESSION["from"] = "".$_GET['from']  ."";
}
?>
<?php
@session_start();
if ("" == "")     {
  $_SESSION["to"] = "".$_GET['to']  ."";
}?>
<?php 
// WA DataAssist Insert
if ("" == "") // Trigger
{
  $WA_connection = $iag112new;
  $WA_table = "logos";
  $WA_sessionName = "spravka_result_logos";
  $WA_redirectURL = "";
  if (function_exists("rel2abs")) $WA_redirectURL = $WA_redirectURL?rel2abs($WA_redirectURL,dirname(__FILE__)):"";
  $WA_keepQueryString = false;
  $WA_fieldNamesStr = "action|ip|username|name|podelenie";
  $WA_fieldValuesStr = "Отваряне на страницата с резултат от справката за период от ".$_GET['from']." до ".$_GET['to']."." . $WA_AB_Split . "".((isset($_SERVER["REMOTE_ADDR"]))?$_SERVER["REMOTE_ADDR"]:"")  ."" . $WA_AB_Split . "".$_SESSION['username']  ."" . $WA_AB_Split . "".$_SESSION['Name']  ." ".$_SESSION['Familia']  ."" . $WA_AB_Split . "".$_SESSION['Podelenie']  ."";
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

//include('spravka_rsult.view.php');

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
        <h3>за получените и предадени сигнали от тел. 112</h3>
	    <p class="text-danger">( Справката е актуална за периоди след 01.02.2017 год. )</p>
        <h4>( <?php echo date('d.m.Y',strtotime($_GET['from'])) ;?> - <?php echo date('d.m.Y',strtotime($_GET['to'])) ;?> )</h4>
        <div class="panel panel-default">
          <div class="panel-body text-cnter">
            <div class="row">
               
               
              <div class="col-md-6 col-md-offset-3"><!--Signalfrom-->
                <h4 class="text-info">ПОСТЪПИЛИ ОТ:</h4>
                  <table class="table table-condensed">
                    <?php foreach($signalfrom as $signalfrom):  ?>
                        <tr>
							<td class="text-left col-md-5">
                          		<?php echo $signalfrom->from ;?>
                          	</td>
                            <td class="text-right col-md-1"><?php echo $signalfrom->counts ;?></td>
                        </tr>
                    <?php endforeach ;?> 
                        <tr class="alert-info">
                            <td class="text-left col-md-5">Всичко:</td>
                            <td class="text-right col-md-1"><?php echo $sum_signalfrom ;?></td>
                        </tr>
                   </table>
                </div><!--End RDG-->
                
                <div class="col-md-6 col-md-offset-3"><!--Signalfrom-->
                <h4 class="text-info">ПО РЕГИОНАЛНИ ДИРЕКЦИИ НА ГОРИТЕ:</h4>
                  <table class="table table-condensed">
                    <?php foreach($rdg as $rdg):  ?>
                        <tr>
							<td class="text-left col-md-5">
                          		<a href="spravka_result_rdg.php?send_to=<?php echo $rdg->glav_pod ;?>&from=<?php echo $_SESSION['from'] ;?>&to=<?php echo $_SESSION['to'] ;?>&title=<?php echo $rdg->pname  ;?>">
                          			<?php echo $rdg->pname ;?>
                          		</a>
                           </td>
                            <td class="text-right col-md-1"><?php echo $rdg->counts ;?></td>
                        </tr>
                    <?php endforeach ;?> 
                        <tr class="alert-info">
                            <td class="text-left col-md-5">Всичко:</td>
                            <td class="text-right col-md-1"><?php echo $sum_rdg ;?></td>
                        </tr>
                   </table>
                </div><!--End RDG-->
                
                <div class="col-md-6 col-md-offset-3"><!--DP-->
                <h4 class="text-info">ПО ДЪРЖАВНИ ПРЕДПРИЯТИЯ:</h4>
                  <table class="table table-condensed">
                    <?php foreach($dp as $dp):  ?>
                        <tr>
							<td class="text-left col-md-5">
                          		<a href="spravka_result_rdg.php?send_to=<?php echo $dp->glav_pod ;?>&from=<?php echo $_SESSION['from'] ;?>&to=<?php echo $_SESSION['to'] ;?>&title=<?php echo $dp->pname  ;?>">
                          			<?php echo $dp->pname ;?>
                          		</a>
                           </td>
                            <td class="text-right col-md-1"><?php echo $dp->counts ;?></td>
                        </tr>
                    <?php endforeach ;?> 
                        <tr class="alert-info">
                            <td class="text-left col-md-5">Всичко:</td>
                            <td class="text-right col-md-1"><?php echo $sum_dp ;?></td>
                        </tr>
                   </table>
                </div><!--End DP-->
                
                <div class="col-md-6 col-md-offset-3"><!--IARA-->
                <h4 class="text-info">КЪМ ИАРА:</h4>
                  <table class="table table-condensed">
                    <?php foreach($iara as $iara):  ?>
                        <tr>
							<td class="text-left col-md-5">
                         		<?php echo $iara->pname ;?>
                           </td>
                            <td class="text-right col-md-1"><?php echo $iara->counts ;?></td>
                        </tr>
                    <?php endforeach ;?> 
                        <tr class="alert-info">
                            <td class="text-left col-md-5">Всичко:</td>
                            <td class="text-right col-md-1"><?php echo $sum_iara ;?></td>
                        </tr>
                   </table>
                </div><!--End IARA-->
                
                <div class="col-md-6 col-md-offset-3"><!--Narushenia-->
                <h4 class="text-info">ПО ВИД НАРУШЕНИЯ:</h4>
                  <table class="table table-condensed">
                    <?php foreach($narushenia as $narushenia):  ?>
                        <tr>
							<td class="text-left col-md-5">
                         		<a href="spravka_result_by_narush.php?from=<?php echo $_SESSION['from'] ;?>&to=<?php echo $_SESSION['to'] ;?>&type_narush=<?php echo $narushenia->narushenia ?>&naimenovanie=<?php echo $narushenia->naimenovanie ?>">
                          			<?php echo $narushenia->naimenovanie ;?>
                          		</a>	
                          	</td>
                            <td class="text-right col-md-1"><?php echo $narushenia->counts ;?></td>
                        </tr>
                    <?php endforeach ;?> 
                        <tr class="alert-info">
                            <td class="text-left col-md-5">Всичко:</td>
                            <td class="text-right col-md-1"><?php echo $sum_narushenia ;?></td>
                        </tr>
                   </table>
                </div><!--End Narushenia-->
                  
                
                <div class="col-md-6 col-md-offset-3"><!--Proveren na mesto-->
                <h4 class="text-info">ПРОВЕРЕНИ НА МЕСТО:</h4>
                  <table class="table table-condensed">
                    <?php foreach($proveren_na_mesto as $proveren_na_mesto):  ?>
                        <tr>
                            <td class="text-left col-md-5">
								<a href="spravka_result_by_proveren_na_mesto.php?from=<?php echo $_SESSION['from'] ;?>&to=<?php echo $_SESSION['to'] ;?>">
                          			<?php echo "Проверени на место" ;?>
                          		</a>	
                           	</td>
                            <td class="text-right col-md-1"><?php echo $proveren_na_mesto->counts ;?></td>
                        </tr>
                    <?php endforeach ;?>
                    	<tr class="alert-info">
                            <td class="text-left col-md-5">Всичко:</td>
                            <td class="text-right col-md-1"><?php echo $sum_proveren_na_mesto ;?></td>
                        </tr> 
                  </table>
                </div><!--End Proveren na mesto-->
                
                <div class="col-md-6 col-md-offset-3"><!--Otgovoreno-->
                <h4 class="text-info">ОТГОВОРЕНО:</h4>
                  <table class="table table-condensed">
                    <?php foreach($otgovoreno as $otgovoreno):  ?>
                        <tr>
                            <td class="text-left col-md-5">
								<a href="spravka_result_by_otgovoreno.php?from=<?php echo $_SESSION['from'] ;?>&to=<?php echo $_SESSION['to'] ;?>">
                          			<?php echo "Отговорено" ;?>
                          		</a>	
                           	</td>
                            <td class="text-right col-md-1"><?php echo $otgovoreno->counts ;?></td>
                        </tr>
                    <?php endforeach ;?>
                    	<tr class="alert-info">
                            <td class="text-left col-md-5">Всичко:</td>
                            <td class="text-right col-md-1"><?php echo $sum_otgovoreno ;?></td>
                        </tr> 
                  </table>
                </div><!--End Otgovoreno-->
                
                <div class="col-md-6 col-md-offset-3"><!--Falsivi signalr-->
                <h4 class="text-info">ФАЛШИВИ СИГНАЛИ:</h4>
                  <table class="table table-condensed">
                    <?php foreach($falshiv as $falshiv):  ?>
                        <tr>
                            <td class="text-left col-md-5">
								<a href="spravka_result_by_falshiv.php?from=<?php echo $_SESSION['from'] ;?>&to=<?php echo $_SESSION['to'] ;?>">
                          			<?php echo "Фалшиви" ;?>
                          		</a>	
                           	</td>
                            <td class="text-right col-md-1"><?php echo $falshiv->counts ;?></td>
                        </tr>
                    <?php endforeach ;?>
                    	<tr class="alert-info">
                            <td class="text-left col-md-5">Всичко:</td>
                            <td class="text-right col-md-1"><?php echo $sum_falshiv ;?></td>
                        </tr> 
                  </table>
                </div><!--End Falsivi signalr-->
                
                <div class="col-md-6 col-md-offset-3"><!--Vanshni podelenia-->
                <h4 class="text-info">ПОДАДЕНИ СИГНАЛИ КЪМ:</h4>
                  <table class="table table-condensed">
                    <?php foreach($vanshni as $vanshni):  ?>
                        <tr>
                            <td class="text-left col-md-5">
                            	<a href="spravka_result_by_send_to_extra.php?from=<?php echo $_SESSION['from'] ;?>&to=<?php echo $_SESSION['to'] ;?>&send_to_extra=<?php echo $vanshni->send_to_extra; ?>">
                            		<?php echo $vanshni->vanshni ;?>
                            	</a>	
                            </td>
                            <td class="text-right col-md-1"><?php echo $vanshni->counts ;?></td>
                        </tr>
                    <?php endforeach ;?>      
                        <tr class="alert-info">
                            <td class="text-left col-md-5">Всичко:</td>
                            <td class="text-right col-md-1"><?php echo $sum_vanshni ;?></td>
                        </tr>
                     
                    </table>              
                 </div><!--End of Vanshni podelenia-->
                 
-   </div>
            
            
          </div>
        </div>
        <!-- InstanceEndEditable --></div>
      </div>
   </div>
   <div class="row">
      <div class="panel panel-default">
         <div class="panel-body">
		 <!-- InstanceBeginEditable name="MainContent" --> <!-- InstanceEndEditable -->
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
