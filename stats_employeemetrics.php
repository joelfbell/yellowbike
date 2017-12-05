<?php 
require_once('Connections/YBDB.php');
require_once('Connections/database_functions.php'); 
$page_individual_history_log = INDIVIDUAL_HISTORY_LOG; 

$page = "stats_employeemetrics.php"; 

session_start();

//CheckDetailCode     isset($_POST["MM_update"]) =========================================================
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "CheckDetailCode")) {
//if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "CheckDetailCode")) {
		
	
	if ($_POST["Submit"] == "View All Employees") {
		$employeepage = "_allemployees";
	} elseif ($_POST["Submit"] == "View Employee Details"){
		$employeepage = "_employeedetail";
	}
  		
	$error = "";
	switch ($_POST['EmployeeDetailCode']) {
	//case '3267':
	//   	$_SESSION['employee'] = "BW";
	//	$_SESSION['ContactID'] = "10019";
	//   	break;
	case '5478':
	   	$_SESSION['employee'] = "Conti";
		$_SESSION['ContactID'] = "4009";
	   	break;	
	case '2431':
	   	$_SESSION['employee'] = "James";
	   	$_SESSION['ContactID'] = "5931";
	   	break;	
	case '4312':
	   	$_SESSION['employee'] = "Joel";
	   	$_SESSION['ContactID'] = "2729";
	   	break;	
	case '5768':
	   	$_SESSION['employee'] = "Juan";
	   	$_SESSION['ContactID'] = "11317";
	   	break;	
	case '2145':
	   	$_SESSION['employee'] = "Pete";
	   	$_SESSION['ContactID'] = "107";
	   	break;
	case '8745':
	   	$_SESSION['employee'] = "Savanna";
		$_SESSION['ContactID'] = "554";
	   	break;
	default:
   		$employeepage = "";
   		$_SESSION['employee'] = "None";
		$_SESSION['timestamp'] = "None";
		$error = "error=incorrectcode";
   		break;}	
	
	$_SESSION['timestamp'] = time();
	header("Location: stats_employeemetrics$employeepage.php?$error");   //$editFormAction
  		
}

//error
switch ($_GET['error']) { 
case 'incorrectcode':
   $error_message = '<- Invalid code';
   break;
case 'timeexpired':
   $error_message = '<- Time expired - Reenter code';
   break;  
default:
   $error_message = '<- Enter Employee Code';
   break;
}

//default settings
$currency = 0;
$places = 1;

?>

<?php include("include_header.html"); ?>

        <table>
        	<tr><td><?php ?>
        	<span class="yb_heading3red">Employee Metrics</span>
        		
        	<br><br>	
        	<form id="form1" name="form1" method="post" action="">
        		Employee Code: 
        		<input name="EmployeeDetailCode" type="text" value="" size="20" maxlength="20" autocomplete="off">
        		<span class = "yb_standardred"><?php echo $error_message;?></span>
        		<br>
        		<input type="submit" name="Submit" value="View All Employees">
           		<input type="submit" name="Submit" value="View Employee Details">
                <input type="hidden" name="MM_insert" value="CheckDetailCode">
                
        	</form>
        	</td></tr>
        </table>
		
		<?php include("include_footer.html"); ?>
<?php

?>
