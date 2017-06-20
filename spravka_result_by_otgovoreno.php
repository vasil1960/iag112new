<?php require_once( "webassist/security_assist/helper_php.php" ); ?>
<?php include('Connection.php'); ?>
<?php include('SpravkaResult.php'); ?>
<?php session_start();?>
<?php require_once( "webassist/security_assist/helper_php.php" ); 
if (!WA_Auth_RulePasses("User_and_Editor_and_InsertMessage")){
	WA_Auth_RestrictAccess("login.php");
}
 

$pdo = Connection::makeconnection();

if(isset($_GET['from'])){
	$from = $_GET['from'];	
}

if(isset($_GET['to'])){
	$to = $_GET['to'];	
}

if(isset($_GET['title'])){
	$title = $_GET['title'];	
}


if(isset($_GET['naimenovanie'])){
	$naimenovanie = $_GET['naimenovanie'];	
}

$obj = new SpravkaResult($pdo, $from, $to, 'by_otgovoreno', '', '');
$otgovoreno  = $obj->fetchCounts();
$sum_otgovoreno  = $obj->sumcount($otgovoreno);

//var_dump($otgovoreno);
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
        <h3>за получени сигнали от тел. 112</h3>
        <p class="text-danger">( Справката е актуална за периоди след 01.02.2017 год. )</p>

        <div class="panel panel-default">
          <div class="panel-body text-cnter">
                        
            <div class="row">
               
                <div class="col-md-6 col-md-offset-3"><!--By type narushenia-->
                <h4 class="text-info"><?php echo "Отговорено но сигнала" ?></h4>
					<p class="text-info">за периода <?php echo date('d.m.Y',strtotime($_GET['from'])) ;?> - <?php echo date('d.m.Y',strtotime($_GET['to'])) ;?></p>
                  <table class="table table-condensed">
                    <?php foreach($otgovoreno as $otgovoreno):  ?>
                        <tr>
                            <td class="text-left col-md-5">
                            	<?php echo $otgovoreno->pname ;?>
                            </td>
                            <td class="text-right col-md-1"><?php echo $otgovoreno->counts ;?></td>
                        </tr>
                    <?php endforeach ;?> 
                        <tr class="alert-info">
                            <td class="text-left col-md-5">Всичко</td>
                            <td class="text-right col-md-1"><?php echo $sum_otgovoreno ;?></td>
                        </tr>
                   </table>
                </div><!--End By type narushenia-->
                
             </div>
            
            
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
