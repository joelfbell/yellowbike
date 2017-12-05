<?php 
require_once('Connections/YBDB.php');
require_once('Connections/database_functions.php'); 
$page_individual_history_log = INDIVIDUAL_HISTORY_LOG; 

$page = "stats_employeemetrics_allemployees.php"; 

session_start();

//check for correct code
if((time() <= $_SESSION['timestamp'] + ( 3 * 60) ) && (time() >= $_SESSION['timestamp']) && ($_SESSION['employee'] <> "None")) { // 3 mins; 0 secs) 
	$message = "Show Page";
	$employee = $_SESSION['employee'];
	$ContactID = $_SESSION['ContactID'];
	} 
	else {
	$message = "Hide Page";	
	$employeepage = "";
	$employee = "None";
	$error = "&error=timeexpired";
	header("Location: stats_employeemetrics$employeepage.php?employee=$employee$error");   //$editFormAction
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

switch ($_GET['metric']) {
//Main Stats	
//case 'NetProductionPerHour':   This is the default
//   $metric = $_GET['metric'];
//   $title = "Net Production Value Per Hour ([Value of Fixed Bikes and Wheels - Pay] / Regular Hours)";
//   break;
case 'NetProductionToPayValueRatio':
   $metric = $_GET['metric'];
   $title = "Value Ratio - (Value of Bikes + Wheels Completed)/Regular Pay";
   break;   
case 'HoursPerBikeFixed':	//this is a sample error message.  insert error case here		
   $metric = $_GET['metric'];
   $title = "Hours Per Bike Fixed";
   break;
case 'HoursPerBikeSold':	//this is a sample error message.  insert error case here		
   $metric = $_GET['metric'];
   $title = "Hours Per Bike Sold";
   break;
case 'SalesPerHour':	//this is a sample error message.  insert error case here		
   $metric = $_GET['metric'];
   $title = "Sales Per Hour";
   $currency = 1;
   $places = 0;
   break;
//Hours
case 'Hours_All':	//this is a sample error message.  insert error case here		
   $metric = $_GET['metric'];
   $title = "Total Hours";
   break;
case 'Hours_NoSpec':	//this is a sample error message.  insert error case here		
   $metric = $_GET['metric'];
   $title = "Regular Hours";
   break;
case 'Hours_Spec':	//this is a sample error message.  insert error case here		
   $metric = $_GET['metric'];
   $title = "Special Hours";
   break;   
//Production Stats      
case 'AverageValueBikesFixed':	//this is a sample error message.  insert error case here		
   $metric = $_GET['metric'];
   $title = "Average Value of Bikes Fixed";
   $currency = 1;
   $places = 0;
   break;
case 'AverageValueNewPartsOnBikes':	//this is a sample error message.  insert error case here		
   $metric = $_GET['metric'];
   $title = "Average Value of New Parts on Bikes";
   $currency = 1;
   $places = 0;
   break;
case 'AverageNetValueBikesFixed':	//this is a sample error message.  insert error case here		
   $metric = $_GET['metric'];
   $title = "Average Net Balue of Bikes Fixed (Bike Price - New Parts)";
   $currency = 1;
   $places = 0;
   break;
case 'NetValueBikesFixedPerHour':	//this is a sample error message.  insert error case here		
   $metric = $_GET['metric'];
   $title = "Net Value of Bikes Fixed Per Hour";
   $currency = 1;
   break;   
case 'NumBikesFixed':	//this is a sample error message.  insert error case here		
   $metric = $_GET['metric'];
   $title = "Number of Bikes Fixed";
   $places = 0;
   break;
case 'AverageValueWheelsFixed':	//this is a sample error message.  insert error case here		
   $metric = $_GET['metric'];
   $title = "Average Value of Wheels Fixed";
   $currency = 1;
   $places = 0;
   break;
case 'NumWheelsFixed':	//this is a sample error message.  insert error case here		
   $metric = $_GET['metric'];
   $title = "Total Number of Wheels Fixed";
   $places = 0;
   break;
//Sales
case 'HoursPerBikeSold':	//this is a sample error message.  insert error case here		
   $metric = $_GET['metric'];
   $title = "Hours Per Bike Sold";
   $places = 0;
   break;
case 'NumBikesSold':	//this is a sample error message.  insert error case here		
   $metric = $_GET['metric'];
   $title = "Number of Bikes Sold";
   $places = 0;
   break;
case 'GrossProductionPerHour':
   $metric = 'GrossProductionPerHour';
   $title = "Gross Per Hour ([Value of Fixed Bikes and Wheels Fixed + Sales of Used Parts + Net Sales of New Parts] / Regular Hours).";
   $currency = 1;
   break;
default:
   $metric = 'NetProductionPerHour';
   $title = "Net Per Hour ([Value of Fixed Bikes and Wheels Fixed + Sales of Used Parts + Net Sales of New Parts - Pay Regular] / Regular Hours).";
   $currency = 1;
   break;
}

switch ($_GET['period']) {
case 'Year':
   $period = $_GET['period'];
   break;	
case 'Quarter':
   $period = $_GET['period'];
   break;	
//case 'Month':
//   $period = $_GET['period'];
//   break;
//case 'Week':	//this is a sample error message.  insert error case here		
//   $period = $_GET['period'];
//   break;
default:
   $period = 'Quarter';
   break;
}




mysql_select_db($database_YBDB, $YBDB);
$query_Recordset1 = "select v.Year AS Year,v.$period AS $period,
sum(if((v.ContactID = 4009),v.$metric,0)) AS Conti,
sum(if((v.ContactID = 107),v.$metric,0)) AS Pete,
sum(if((v.ContactID = 554),v.$metric,0)) AS Savanna, 
sum(if((v.ContactID = 5931),v.$metric,0)) AS James, 
sum(if((v.ContactID = 2729),v.$metric,0)) AS Joel, 
sum(if((v.ContactID = 11317),v.$metric,0)) AS Juan 
from view_EmployeeMetrics5_by$period" . "_HoursCalc v
group by `v`.`Year` DESC,`v`.`$period` DESC;";
$Recordset1 = mysql_query($query_Recordset1, $YBDB) or die(mysql_error());
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$row_Recordset1 = mysql_fetch_assoc($Recordset1); //Loads first record so latest date is not visable.  Statistics available at close of period.

?>

<?php include("include_header.html"); ?>

        <table>
        	<tr><td>
        	<a href="stats_employeemetrics.php">Back to Main Employee Metrics Main Page</a><br><br>
        	<?php echo "Main Stats: 
        	<a href=\"$page?metric=GrossProductionPerHour&period=$period\">Gross Per Reg Hour</a>,
        	<a href=\"$page?metric=NetProductionPerHour&period=$period\">Net Per Reg Hour</a>,
        	<a href=\"$page?metric=HoursPerBikeFixed&period=$period\">Hours Per Bike Fixed</a>, 
        	<a href=\"$page?metric=SalesPerHour&period=$period\">Sales Per Hour</a><br>
        	Hours: 
        	<a href=\"$page?metric=Hours_All&period=$period\">Total Hours</a>,
        	<a href=\"$page?metric=Hours_NoSpec&period=$period\">Regular Hours</a>,
        	<a href=\"$page?metric=Hours_Spec&period=$period\">Special Hours</a><br>
        	Production Figures:
        	<!--<a href=\"$page?metric=AverageValueBikesFixed&period=$period\">Average Value Bikes Fixed</a>,
        	<!--<a href=\"$page?metric=AverageValueNewPartsOnBikes&period=$period\">Avg Value New Parts on Bikes</a>,-->
        	<a href=\"$page?metric=AverageNetValueBikesFixed&period=$period\">Avg Net Value Bikes Fixed</a>,
        	<a href=\"$page?metric=NetValueBikesFixedPerHour&period=$period\">Net Value of Bikes Fixed Per Hour</a>,
        	<a href=\"$page?metric=NumBikesFixed&period=$period\">Number of Bikes Fixed</a>,
        	<a href=\"$page?metric=AverageValueWheelsFixed&period=$period\">Average Value of Wheels Fixed</a>,
        	<a href=\"$page?metric=NumWheelsFixed&period=$period\">Number of Wheels Fixed</a><br>
        	Sales Stats:
        	<a href=\"$page?metric=HoursPerBikeSold&period=$period\">Hours Per Bike Sold</a>,
        	<a href=\"$page?metric=NumBikesSold&period=$period\">Number of Bikes Sold</a><br><br>
        	
        	View by: 
        	<a href=\"$page?metric=$metric&period=Year\">Year</a>
        	<a href=\"$page?metric=$metric&period=Quarter\">Quarter</a>
        	<!--,<a href=\"$page?metric=$metric&period=Month\">Month</a>
        	<!--,<a href=\"$page?metric=$metric&period=Week\">Week</a>-->"?>
        	
        	</td></tr>
        	<tr valign="top"><td><span class="yb_heading3red"><?php echo $title; ?></span></td></tr>
        <tr>
          <td>
          	
            <table id="metrics"  border="1" cellpadding="1" cellspacing="0">
              <tr valign="top" bgcolor="#99CC33" class="yb_standardCENTER">
                <td width="100" height="35">Year</td>
			    <td width="100"><?php echo $period?></td>
		        <td width="100">Conti<br />
		        <td width="100">James<br />
		        <td width="100">Joel<br />
		        <td width="100">Juan<br />
		        <td width="100">Pete<br />
		        <td width="100">Savanna<br />
		      </tr>
		      
              <form method="post" name="FormUpdate_<?php echo $row_Recordset1['shop_id']; ?>" action="<?php echo $editFormAction; ?>">
                <?php while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)) { //do { 
			  if(1 == 2) {?>
                <tr valign="bottom" bgcolor="#CCCC33">
                  <td>&nbsp;</td>
			      <td>&nbsp;</td>
			      <td>&nbsp;</td>
			      <td>&nbsp;</td>
			    </tr>
                <input type="hidden" name="MM_insert" value="FormEdit">
                <input type="hidden" name="shop_id" value="<?php echo $row_Recordset1['shop_id']; ?>">
              </form>
		    <?php } else { // end if EDIT RECORD ?>
              <tr class=yb_standardRIGHT>
			    <td><?php echo $row_Recordset1['Year']; ?></td>
			    <td><?php echo $row_Recordset1["$period"]; ?></td>
			    <td><?php echo formatnum($row_Recordset1['Conti'],$currency,$places); ?></td>
			    <td><?php echo formatnum($row_Recordset1['James'],$currency,$places); ?></td>
			    <td><?php echo formatnum($row_Recordset1['Joel'],$currency,$places); ?></td>
			    <td><?php echo formatnum($row_Recordset1['Juan'],$currency,$places); ?></td>
			    <td><?php echo formatnum($row_Recordset1['Pete'],$currency,$places); ?></td>
			    <td><?php echo formatnum($row_Recordset1['Savanna'],$currency,$places); ?></td>
		      </tr>
              <?php
		  } // end if EDIT RECORD 
		  } // end WHILE count of recordset ?>
          </table>	  </td>
	  </tr>
        </table>
		<p class ="yb_standard_small">Formula notes:</p>
		<ul class="yb_standard_small">
			<li>Hours All and Pay All include Regular and Special Hours</li>
			<li>Est. Gross Income per Staff Reg Hour = (value of bikes and wheels produced + sales of used and new parts - cost of new parts) / regular hours. This is a production number per regular staff hour to show changes in production over time independent of special projects and increased compensation. By dividing by regular staff hours (omitting special projects) this is normalized to be independent of number of hours workedworked per period (e.g. hours changes for a staff person). </li>
			<li>Est. Net Income per Staff Reg Hour = (value of bikes and wheels produced + sales of used and new parts - cost of new parts - pay for regular hours) / regular hours. This net production number includes regular pay and the effect of increased compensation (but excludes special project pay unlike the operation metric). By dividing by reg staff hours this is normalized to be independent of number of hours worked per period (e.g. hours changes for a staff person).</li>
		</ul>
		<?php include("include_footer.html"); ?>
<?php
mysql_free_result($Recordset1);
?>
