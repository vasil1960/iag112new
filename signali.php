<?php require_once('Connections/iag112new.php'); ?>
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
  $WA_sessionName = "signali_open";
  $WA_redirectURL = "";
  if (function_exists("rel2abs")) $WA_redirectURL = $WA_redirectURL?rel2abs($WA_redirectURL,dirname(__FILE__)):"";
  $WA_keepQueryString = false;
  $WA_fieldNamesStr = "action|ip|username|name|podelenie";
  $WA_fieldValuesStr = "Отваряне на страница сигнали" . $WA_AB_Split . "".((isset($_SERVER["REMOTE_ADDR"]))?$_SERVER["REMOTE_ADDR"]:"")  ."" . $WA_AB_Split . "".$_SESSION['username']  ."" . $WA_AB_Split . "".$_SESSION['Name']  ." ".$_SESSION['Familia']  ."" . $WA_AB_Split . "".$_SESSION['Podelenie']  ."";
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
            <h1>Постъпили сигнали от тел. 112</h1>
			 	<input type="hidden" id="hidden" value="<?php echo $_SESSION['AccessPodelenia'] ?>">
         		<input type="hidden" id="hidden1" value="<?php echo $_SESSION['Access112']; ?>">
            <!-- InstanceEndEditable --></div>
      </div>
   </div>
   <div class="row">
      <div class="panel panel-default">
         <div class="panel-body">
		 <!-- InstanceBeginEditable name="MainContent" -->
            <table width="99%" class="table list_table table-responsive" id="tblSignali">
               <thead>
                  <tr>
                     <th width="76">ID</th>
                     <th width="80">Тел.</th>
                     <th width="100">Под.</th>
                     <th width="100">РДГ</th>
                     <th width="80">Дата</th>
                     <th width="100">Подател</th>
                     <th width="350">Описание</th>
                     <th width="16"></th>
                     <th width="16"></th>
                     <th width="20"></th>
                     <th width="20"></th>
                  </tr>
               </thead>
                  </tbody>
               
              
                  </tbody>
               
            </table>
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
<script type="text/javascript" language="javascript">

$(document).ready(function() {
	
    //-------------------------------------------------------
	$('#tblSignali').DataTable( {
        "processing": true,
        "serverSide": true,
		"ajax": "vasil.php",
		"order": [[ 0, "desc" ]],
		//"scrollX" : "100%",
//		"scrollY" : 600,	
		"pageLength": 25,
		"language":{
			"url":"php_scripts/BulgarianDataTables.json",
			//"sProcessing" : "<img src='/images/loading_bar.gif'>"
		},
		//"processing":true,
		"columnDefs": [
        	//---- ---------------
			{
				targets:[0],
				visible:true,
				render:function(data, type,row,meta)
				{
					return "<a class='btn btn-default' href='view_signal.php?view="+row[0]+"'>"+row[0]+"</a>";
				}
			},
			{
				targets:[1],
				sortable:false,
			},
			{
				targets:[6],
				sortable:false,
			},
			{
				targets:[7,8,9],
				visible:false,
			},
			{
				targets: [10],
				visible: true,
				searchable:false,
				sortable:false,
				render:function(data, type, row, meta)
				{
					if(access112() == 3)
					{
						return "<a class='btn btn-default' href='edit_signal.php?edit="+row[0]+"'><i class='glyphicon glyphicon-pencil'></i></a>";
					}
					
					if(access112() == 2)
					{
						if(row[7] == 1)
						{
							return "<a class='btn btn-default' href='edit_otchet_signal.php?edit_otchet="+row[0]+"'><i class='glyphicon glyphicon-pencil'></i></a>"
						} else {
							return "<a class='btn btn-default' href='otchet_signal.php?otchet="+row[0]+"'><i class='glyphicon glyphicon-list-alt'></i></a>"
						}
					}
					
					return "";
				}
			},			
		],    	
		"createdRow": function( row, data, dataIndex ) {
			console.log(data);
			if ( data[7] == 1 ) {
			  $(row).addClass( 'alert alert-success' )
			} else {
			  $(row).addClass( 'alert alert-warning' )	
			}
		}
	});	
	
	//----------------------------------------
	// 	
	function access112(){
		return $("#hidden1").val();
	}
	
});
	
</script> 
<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>

