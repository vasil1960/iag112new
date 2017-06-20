<!DOCTYPE html>
<html lang="en">
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
<link rel="stylesheet" type="text/css" href="../all_css/all.css">
<link rel="stylesheet" type="text/css" href="../all_css/my.css">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../all_css/datepicker.css">
<!-- InstanceBeginEditable name="head" -->

<!-- InstanceEndEditable -->
</head>
<body>

<div class="container">
   <div class="row"></div>
   <div class="row">
      <div class="panel panel-default panel-heading">
         <div class="panel-body text-center">
		 <!-- InstanceBeginEditable name="EditTittle" -->
			 
         <!-- InstanceEndEditable --></div>
      </div>
   </div>
   <div class="row">
      <div class="panel panel-default">
         <div class="panel-body">
		 <!-- InstanceBeginEditable name="MainContent" -->
          <h1 class="text-center">Логове</h1>
           <table width="99%" class="table list_table table-responsive" id="tblLogos">
               <thead>
                  <tr>
                     <th width="5">id:</th>
                     <th width="40">Действие:</th>
                     <th width="10">IP:</th>
                     <th width="5">Потребител:</th>
                     <th width="5">Дата:</th>
                     <th width="20">Име:</th>
                     <th width="20">Поделение:</th>

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
<script type="text/javascript" src="../all_js/all.js"></script>
<!--
<script type="text/javascript" src="ScriptLibrary/bootstrap-datepicker.js" charset="UTF-8"></script>
<script src="ScriptLibrary/locales/bootstrap-datepicker.bg.js"></script>
-->
<script type="text/javascript" language="javascript">

$(document).ready(function() {
	
    //-------------------------------------------------------
	$('#tblLogos').DataTable( {
        "processing": true,
        "serverSide": true,
		"ajax": "helper.php",
		"order": [[ 0, "desc" ]],
		//"scrollX" : "100%",
//		"scrollY" : 600,	
		"pageLength": 25,
		"language":{
			"url":"../php_scripts/BulgarianDataTables.json",
			//"sProcessing" : "<img src='/images/loading_bar.gif'>"
		},
	});
});
	
</script> 
<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>