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

if(isset($_GET['DP_ID'])){
	$DP_ID = $_GET['DP_ID'];	
}

if(isset($_GET['title'])){
	$title = $_GET['title'];	
}

# RDG
$s8     = new SpravkaResult($pdo, $from, $to);
$rdg    = $s8->fetchAllSignals('RDG','AND dgs.DP_ID = '.$DP_ID);
$rdgallcnt = $s8->sumcount($rdg);
//var_dump($rdg);

# DGS
$s1        = new SpravkaResult($pdo, $from, $to);
$dgs       = $s1->fetchAllSignals('DGS','AND dgs.DP_ID = '.$DP_ID);
$dgsallcnt = $s1->sumcount($dgs);


# DP
$s2       = new SpravkaResult($pdo, $from, $to);
$dp       = $s2->fetchAllSignals('DP','AND dgs.DP_ID = '.$DP_ID);
$dpallcnt = $s1->sumcount($dp);

# Vid narushenia
$s3      = new SpravkaResult($pdo, $from, $to);
$n       = $s3->fetchAllSignals('Naimenovahie','AND dgs.DP_ID = '.$DP_ID);
$nallcnt = $s3->sumcount($n);

# vanshni podelenia
$s4      = new SpravkaResult($pdo, $from, $to);
$v       = $s4->fetchAllSignals('vanshni','AND dgs.DP_ID = '.$DP_ID);
$vallcnt = $s4->sumcount($n);

# vanshni podelenia
$s5      = new SpravkaResult($pdo, $from, $to);
$p       = $s5->fetchAllSignals('r.proveren','AND r.proveren = 1 AND dgs.DP_ID = '.$DP_ID);
$pallcnt = $s5->sumcount($p);

# falshivi
$s6      = new SpravkaResult($pdo, $from, $to);
$f       = $s6->fetchAllSignals('r.falshiv','AND r.falshiv = 1  AND dgs.DP_ID = '.$DP_ID);
$fallcnt = $s6->sumcount($f);

# Kfnstatirani narushenia
$s7      = new SpravkaResult($pdo, $from, $to);
$cn       = $s7->fetchAllSignals('r.const_narushenia','AND r.const_narushenia = 1  AND dgs.DP_ID = '.$DP_ID);
$cnallcnt = $s7->sumcount($cn);



//# DP
//$s2 = new SpravkaResult($pdo, $from, $to);
//$dp = $s2->fetchAllSignals('DP');
//$sumdp = $s2->sumAllSignals();
////var_dump($dp);
//
//# Vid narushenia
//$s3 = new SpravkaResult($pdo, $from, $to);
//$n = $s3->fetchAllSignals('Naimenovanie');
//$sumn = $s3->sumAllSignals();
//
//# Vanshni podelenia - Policia, Pojarna ...
//$s4 = new SpravkaResult($pdo, $from, $to);
//$v = $s4->fetchAllSignals('vanshni');
//$sumv = $s4->sumAllSignals();
//
//# Provereni signali
//$s5 = new SpravkaResult($pdo, $from, $to);
//$p = $s5->fetchAllSignals('s.proveren','AND s.proveren = 1');
//
//# Falshivi signali
//$s6 = new SpravkaResult($pdo, $from, $to);
//$f = $s6->fetchAllSignals('r.falshiv','AND r.falshiv = 1');
//
//# Konstatirani narushenia
//$s7 = new SpravkaResult($pdo, $from, $to);
//$cn = $s7->fetchAllSignals('const_narushenia','AND const_narushenia = 1');
////die(var_dump($sumdp));
//

//var_dump($a);
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
                <div class="col-md-4"><!--RDG-->
                <h4 class="text-info">По РДГ</h4>
                  <table class="table table-condensed">
                    <?php foreach($rdg as $rdg):  ?>
                        <tr>
							<td class="text-left col-md-5">
                          		<a href="">
                          			<?php echo $rdg->RDG ;?>
                          		</a>
                           </td>
                            <td class="text-right col-md-1">
                            	<?php echo $rdg->count_signali ;?>
                            </td>
                        </tr>
                    <?php endforeach ;?> 
                        <tr class="alert-info">
                            <td class="text-left col-md-5">Всичко:</td>
                            <td class="text-right col-md-1"><?php echo $rdgallcnt ;?></td>
                        </tr>
                    
                  </table>
                </div><!--End RDG-->
                
                <div class="col-md-4"><!--DP-->
                <h4 class="text-info">По ДГС</h4>
                  <table class="table table-condensed">
                    <?php foreach($dgs as $dgs):  ?>
                        <tr>
							<td class="text-left col-md-5">
                          		<a href="spravka_result_rdg.php?glav_pod=<?php echo $rdg->glav_pod ;?>&from=<?php echo $_SESSION['from'] ;?>&to=<?php echo $_SESSION['to'] ;?>&title=<?php echo $dgs->DGS  ;?>">
                          			<?php echo $dgs->DGS ;?>
                          		</a>
                           </td>
                            <td class="text-right col-md-1"><?php echo $dgs->count_signali ;?></td>
                        </tr>
                    <?php endforeach ;?> 
                        <tr class="alert-info">
                            <td class="text-left col-md-5">Всичко:</td>
                            <td class="text-right col-md-1"><?php echo $dgsallcnt ;?></td>
                        </tr>
                   </table>
                </div><!--End RDG-->
                
                <div class="col-md-4"><!--DP-->
                <h4 class="text-info">По предприятия</h4>
                  <table class="table table-condensed">
                    <?php foreach($dp as $dp):  ?>
                        <tr>
                            <td class="text-left col-md-5">
								<a href="spravka_result_dp.php?DP_ID=<?php echo $dp->DP_ID ;?>&from=<?php echo $_SESSION['from'] ;?>&to=<?php echo $_SESSION['to'] ;?>&title=<?php echo $dp->DP  ;?>">
                           			<?php echo $dp->DP ;?>
                           		</a>
                            </td>
                            <td class="text-right col-md-1"><?php echo $dp->count_signali ;?></td>
                        </tr>
                    <?php endforeach ;?> 
                      <tr class="alert-info">
                    	<td class="text-left col-md-5">Всичко</td>
                        <td class="text-right col-md-1"><?php echo $dpallcnt ;?></td>
					  </tr>
                  </table>
                </div><!--End DP-->
               
                <div class="col-md-4"><!--Narushenia-->
                <h4 class="text-info">По вид нарушения</h4>
                  <table class="table table-condensed">
                    <?php foreach($n as $n):  ?>
                        <tr>
                            <td class="text-left col-md-5"><?php echo $n->Naimenovanie ;?></td>
                            <td class="text-right col-md-1"><?php echo $n->count_signali ;?></td>
                        </tr>
                    <?php endforeach ;?> 
                        <tr class="alert-info">
                            <td class="text-left col-md-5">Всичко</td>
                            <td class="text-right col-md-1"><?php echo $nallcnt ;?></td>
                        </tr>
                   </table>
                </div><!--End Narushenia-->
                
                
                <div class="col-md-4"><!--Vanshni podelenia-->
                <h4 class="text-info">Външни поделения</h4>
                  <table class="table table-condensed">
                    <?php foreach($v as $v):  ?>
                        <tr>
                            <td class="text-left col-md-5"><?php echo $v->vanshni ;?></td>
                            <td class="text-right col-md-1"><?php echo $v->count_signali ;?></td>
                        </tr>
                    <?php endforeach ;?> 
                    	<tr class="alert-info">
                            <td class="text-left col-md-5">Всичко</td>
                            <td class="text-right col-md-1"><?php echo $vallcount ;?></td>
                        </tr>
                    </table>
                </div><!--End of Konstatirani narushenia-->
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
