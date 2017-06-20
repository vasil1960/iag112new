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

if(isset($_GET['send_to'])){
	$send_to = $_GET['send_to'];	
}

if(isset($_GET['title'])){
	$title = $_GET['title'];	
}

$obj = new SpravkaResult($pdo, $from, $to, 'signalfrom', ' AND send_to = ' . $send_to);
$signalfrom  = $obj->fetchCounts();
$sum_signalfrom = $obj->sumcount($signalfrom);

$obj = new SpravkaResult($pdo, $from, $to, 'narushenia', ' AND send_to = ' . $send_to);
$narushenia  = $obj->fetchCounts();
$sum_narushenia = $obj->sumcount($narushenia);

$obj = new SpravkaResult($pdo, $from, $to, 'proveren_na_mesto', ' AND send_to = ' . $send_to);
$proveren_na_mesto  = $obj->fetchCounts();
$sum_proveren_na_mesto = $obj->sumcount($proveren_na_mesto);

$obj = new SpravkaResult($pdo, $from, $to, 'vanshni_pod', ' AND send_to = ' . $send_to);
$vanshni_pod  = $obj->fetchCounts();
$sum_vanshni_pod = $obj->sumcount($vanshni_pod);

$obj = new SpravkaResult($pdo, $from, $to, 'falshiv', ' AND send_to = ' . $send_to);
$falshiv  = $obj->fetchCounts();
$sum_falshiv = $obj->sumcount($falshiv);

$obj = new SpravkaResult($pdo, $from, $to, 'konstatirani', ' AND send_to = ' . $send_to);
$konstatirani  = $obj->fetchCounts();
$sum_konstatirani = $obj->sumcount($konstatirani);

$obj = new SpravkaResult($pdo, $from, $to, 'policia_after_22', ' AND send_to = ' . $send_to);
$policia_after_22  = $obj->fetchCounts();
$sum_policia_after_22 = $obj->sumcount($policia_after_22);

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
			 <h3>( <?php echo $title; ?> )</h3>
        <h4>( <?php echo date('d.m.Y',strtotime($_GET['from'])) ;?> - <?php echo date('d.m.Y',strtotime($_GET['to'])) ;?> )</h4>
        <div class="panel panel-default">
          <div class="panel-body text-cnter">
            
              
            
            <div class="row">
               
                <div class="col-md-6 col-md-offset-3"><!--Narushenia-->
                <h4 class="text-info">ПО ВИД НАРУШЕНИЯ</h4>
                  <table class="table table-condensed">
                    <?php foreach($narushenia as $narushenia):  ?>
                        <tr>
                            <td class="text-left col-md-5">
                            	<?php echo $narushenia->naimenovanie ;?>
                            </td>
                            <td class="text-right col-md-1"><?php echo $narushenia->counts ;?></td>
                        </tr>
                    <?php endforeach ;?> 
                        <tr class="alert-info">
                            <td class="text-left col-md-5">Всичко</td>
                            <td class="text-right col-md-1"><?php echo $sum_narushenia ;?></td>
                        </tr>
                   </table>
                </div><!--End Narushenia-->
                
                <div class="col-md-6 col-md-offset-3"><!--Provereni na mesto-->
                <h4 class="text-info">ПРОВЕРЕНИ НА МЕСТО</h4>
                  <table class="table table-condensed">
                    <?php foreach($proveren_na_mesto as $proveren_na_mesto):  ?>
                        <tr>
                            <td class="text-left col-md-5">
                            	<?php echo "Проверени" ;?>
                            </td>
                            <td class="text-right col-md-1"><?php echo $proveren_na_mesto->counts ;?></td>
                        </tr>
                    <?php endforeach ;?> 
                        <tr class="alert-info">
                            <td class="text-left col-md-5">Всичко</td>
                            <td class="text-right col-md-1"><?php echo $sum_proveren_na_mesto ;?></td>
                        </tr>
                   </table>
                </div><!--End Provereni na mesto-->
                
                 <div class="col-md-6 col-md-offset-3"><!--Vanshni podelenia-->
                <h4 class="text-info">ВЪНШНИ ПОДЕЛЕНИЯ</h4>
                  <table class="table table-condensed">
                    <?php foreach($vanshni_pod as $vanshni_pod):  ?>
                        <tr>
                            <td class="text-left col-md-5">
                           		<?php echo $vanshni_pod->vanshni ;?>
                            </td>
                            <td class="text-right col-md-1"><?php echo $vanshni_pod->counts ;?></td>
                        </tr>
                    <?php endforeach ;?> 
                        <tr class="alert-info">
                            <td class="text-left col-md-5">Всичко</td>
                            <td class="text-right col-md-1"><?php echo $sum_vanshni_pod ;?></td>
                        </tr>
                   </table>
                </div><!--End Vanshni podelenia-->
                
                 <div class="col-md-6 col-md-offset-3"><!--Ptedadeno na policiata sled 22 chasa-->
                <h4 class="text-info">КЪМ ПОЛИЦИЯ:</h4>
                  <table class="table table-condensed">
                    <?php foreach($policia_after_22 as $policia_after_22):  ?>
                        <tr>
                            <td class="text-left col-md-5">
                            	<?php echo "След 22 ч." ;?>
                            </td>
                            <td class="text-right col-md-1"><?php echo $policia_after_22->counts ;?></td>
                        </tr>
                    <?php endforeach ;?>      
                        <tr class="alert-info">
                            <td class="text-left col-md-5">Всичко:</td>
                            <td class="text-right col-md-1"><?php echo $sum_policia_after_22 ;?></td>
                        </tr>
                     
                    </table>              
                 </div><!--End of Ptedadeno na policiata sled 22 chasa-->
                

				<div class="col-md-6 col-md-offset-3"><!--Falshivi-->
                <h4 class="text-info">ФАЛШИВИ СИГНАЛИ:</h4>
                  <table class="table table-condensed">
                    <?php foreach($falshiv as $falshiv):  ?>
                        <tr>
                            <td class="text-left col-md-5">
								<?php echo "Фалшиви" ;?>
                           	</td>
                            <td class="text-right col-md-1"><?php echo $falshiv->counts ;?></td>
                        </tr>
                    <?php endforeach ;?> 
                        <tr class="alert-info">
                            <td class="text-left col-md-5">Всичко:</td>
                            <td class="text-right col-md-1"><?php echo $sum_falshiv ;?></td>
                        </tr>
                  </table>
                </div><!--End Falshivi-->
                     
               
               
     			<div class="col-md-6 col-md-offset-3"><!--Kfnstatirani narushenia pri proverka-->
                <h4 class="text-info">КОНСТАТИРАНИ НАРУШЕНИЯ ПРИ ПРОВЕРКИТЕ:</h4>
                  <table class="table table-condensed">
                    <?php foreach($konstatirani as $konstatirani):  ?>
                        <tr>
                            <td class="text-left col-md-5">
                            	<?php echo $konstatirani->naimenovanie ;?>
                            </td>
                            <td class="text-right col-md-1"><?php echo $konstatirani->counts ;?></td>
                        </tr>
                    <?php endforeach ;?> 
                        <tr class="alert-info">
                            <td class="text-left col-md-5">Всичко:</td>
                            <td class="text-right col-md-1"><?php echo $sum_konstatirani ;?></td>
                        </tr>
                    </table>
                </div><!--End of Kfnstatirani narushenia pri proverka-->
         
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
