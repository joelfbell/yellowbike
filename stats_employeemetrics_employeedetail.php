<?php  
require_once('Connections/YBDB.php');
require_once('Connections/database_functions.php'); 
$page_individual_history_log = INDIVIDUAL_HISTORY_LOG; 

$page = "stats_employeemetrics_employeedetail.php"; 

session_start();

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
                 
switch ($_GET['period']) {
case 'Year':
   $period = $_GET['period'];
   break;	
case 'Quarter':
   $period = $_GET['period'];
   break;
case 'Month':
   $period = $_GET['period'];
   break;
case 'Week':
   $period = $_GET['period'];
   break;
default:
   $period = 'Month';
   break;
}

mysql_select_db($database_YBDB, $YBDB);
$query_Recordset1 = "SELECT * FROM ybdb.view_EmployeeMetrics5_by$period" . "_HoursCalc WHERE ContactID = " . $ContactID . ";";
$Recordset1 = mysql_query($query_Recordset1, $YBDB) or die(mysql_error());
//$row_Recordset1 = mysql_fetch_assoc($Recordset1);   //Wait to fetch until do loop
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?>

<?php include("include_header.html"); ?>

        <table>
        	
        	<tr><td>
        	<a href="stats_employeemetrics.php">Back to Main Employee Metrics Main Page</a><br><br>
        	<?php 
        	//echo "Employee:" . $_SESSION['employee'] . "<br/>";
        	//echo "Timestamp:" . $_SESSION['timestamp'] . "<br/>";
        	//echo "Current Time:" . time() . "<br/>";
        	echo "View by: 
        	<a href=\"$page?period=Year\">Year</a>, 
        	<a href=\"$page?period=Quarter\">Quarter</a>, 
        	<a href=\"$page?period=Month\">Month</a>, 
        	<a href=\"$page?period=Week\">Week</a>";?></td></tr>
        	<tr valign="top"><td><span class="yb_heading3red"><?php echo "Employee Stats for " . $_SESSION['employee'] . " by " . $period;?></span></td></tr>
        <tr>
          <td>
            <table   border="1" cellpadding="1" cellspacing="0">
              <tr bgcolor="#E6E6E6" class="yb_standardCENTERbold">
                <td height="25" colspan="2">Time Period</td>
                <td height="25" colspan="4">Primary Stats</td>
			    <td height="25" colspan="4">Hours</td>
			    <td height="25" colspan="5">Bike Production</td>
			    <td height="25" colspan="2">Wheel Production</td>
			    <td height="25" colspan="2">Bike Sales</td>
			  </tr>
              <tr valign="top" bgcolor="#99CC33" class="yb_standardCENTER">
                <td width="60" height="35">Year</td>
			    <td width="80"><?php echo $period;?></td>
			    
			    <td width="80">Gross Per Reg Hour*</td>
			    <td width="80">Net Per Reg Hour*</td>
			    <td width="80">Hours Per Bike Fixed</td>
			    <td width="80">Sales Per Hour</td>
			    
			    <td width="80">Pay All</td>
			    <td width="80">All Hours</td>
			    <td width="80">Reg Hours</td>
			    <td width="80">Special Hours</td>
			    
			    <td width="80">Avg Value Bikes Fixed</td>
			    <td width="80">Avg Value New Parts on Bikes</td>
			    <td width="80">Avg NetValue Bikes Fixed</td>
			    <td width="80">NetValue Bikes Fixed per Hour</td>
			    <td width="80">Num Bikes Fixed</td>
			    
			    <td width="80">Avg Value Wheels Fixed</td>
			    <td width="80">Num Wheels Fixed</td>
			   
			    <td width="80">Hours Per Bike Sold</td>
			    <td width="80"># Bikes Sold</td>
		      </tr>
              <form method="post" name="FormUpdate_<?php echo $row_Recordset1['shop_id']; ?>" action="<?php echo $editFormAction; ?>">
                <?php while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)) { //do { 
			  if(1 == 2) {?>
                <tr valign="bottom" bgcolor="#CCCC33">
                  <td>&nbsp;</td>
			      <td>&nbsp;</td>
			      <td>&nbsp;</td>
			      <td>&nbsp;</td>
			      <td>&nbsp;</td>
			      <td>&nbsp;</td>
			      <td>&nbsp;</td>
			      <td>&nbsp;</td>
			      <td>&nbsp;</td>
			      <td>&nbsp;</td>
			      <td>&nbsp;</td>
			      <td>&nbsp;</td>
			      <td>&nbsp;</td>
			      <td>&nbsp;</td>
			      <td>&nbsp;</td>
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
			    <td><?php echo $row_Recordset1[$period]; ?></td>
			    
			    <td><?php currency_format($row_Recordset1['GrossProductionPerHour'],1);?></td>
			    <td class=yb_standardBold><?php currency_format($row_Recordset1['NetProductionPerHour'],1);?></td>
			    <td><?php echo number_format($row_Recordset1['HoursPerBikeFixed'],1); ?></td>
			    <td><?php currency_format($row_Recordset1['SalesPerHour'],0);?></td>
			    
			    <td><?php currency_format($row_Recordset1['Pay_All'],0); ?></td>
			    <td><?php echo number_format($row_Recordset1['Hours_All'],1); ?></td>
			    <td><?php echo number_format($row_Recordset1['Hours_NoSpec'],1); ?></td>
			    <td><?php echo number_format($row_Recordset1['Hours_Spec'],1); ?></td>
			    
			    <td><?php currency_format($row_Recordset1['AverageValueBikesFixed'],0);?></td>
			    <td><?php currency_format($row_Recordset1['AverageValueNewPartsOnBikes'],0);?></td>
			    <td><?php currency_format($row_Recordset1['AverageNetValueBikesFixed'],0);?></td>
			    <td><?php currency_format($row_Recordset1['NetValueBikesFixedPerHour'],1);?></td>
			    <td><?php echo number_format($row_Recordset1['NumBikesFixed'],1); ?></td>
			    
			    <td><?php currency_format($row_Recordset1['AverageValueWheelsFixed'],0);?></td>
			    <td><?php echo number_format($row_Recordset1['NumWheelsFixed'],0); ?></td>
			    
			    <td><?php echo number_format($row_Recordset1['HoursPerBikeSold'],0); ?></td>
			    <td><?php echo number_format($row_Recordset1['NumBikesSold'],0); ?></td>
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
