<?php 
require_once('Connections/YBDB.php');
require_once('Connections/database_functions.php'); 
$page_individual_history_log = INDIVIDUAL_HISTORY_LOG; 
	
switch ($_GET['error']) {
case 'no_shop':
   $error_message = 'ERROR: A Shop at this location for today does not exist: Start New Shop';
   break;
case 'new_error_message':	//this is a sample error message.  insert error case here		
   $error_message = '';
   break;
default:
   $error_message = 'Total Hours';
   break;
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
   $period = 'Quarter';
   break;
}

mysql_select_db($database_YBDB, $YBDB);
$query_Recordset1 = "SELECT * FROM view_MechanicOperationMetrics_by$period;";
$Recordset1 = mysql_query($query_Recordset1, $YBDB) or die(mysql_error());
//$row_Recordset1 = mysql_fetch_assoc($Recordset1);   //Wait to fetch until do loop
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?>

<?php include("include_header.html"); ?>

        <table>
        <tr valign="top">
          <td><span class="yb_heading3red">Mechanic Operation Metrics by <?php echo $period;?></span></td>
	  </tr>
	  <tr valign="top">
          <td><?php echo "View by: <a href=\"$page?period=Year\">Year</a>,
          <a href=\"$page?period=Quarter\">Quarter</a>, 
          <a href=\"$page?period=Month\">Month</a>, 
          <a href=\"$page?period=Week\">Week</a>"?> 
	  </tr>
        <tr>
          <td>
            <table   border="1" cellpadding="1" cellspacing="0">
              <tr bgcolor="#E6E6E6" class="yb_standardCENTERboldsmall">
                <td height="25" colspan="2">Time Period</td>
			    <td height="25" colspan="4">Payroll / Expenses</td>
			    <td height="25" colspan="5">Estimated Net Income</td>
			    <td height="25" colspan="3">Bike Production</td>
			    <td height="25" colspan="5">Sales</td>
			  </tr>
              <tr valign="top" bgcolor="#99CC33" class="yb_standardCENTERsmall">
                <td width="60" height="35">Year</td>
			    <td width="80"><?php echo $period;?></td>
			    
			    <td width="80">Hours All</td>
			    <td width="80">Hours Spec</td>
			    <td width="100">Pay All</td>
			    <td width="100">New Parts on Bikes</td>
			    
			    <td width="100">Value Of Bikes Completed</td>
			    <td width="100">Value Of Wheels Completed</td>
			    <td width="100" class=yb_standardBold>Est Net Income</td>
			    <td width="100" class=yb_standardBold>Est Gross Income Per Staff Hour</td>
			    <td width="100" class=yb_standardBold>Est Net Per Staff Hour</td>
			    
			    <td width="100"># Bikes Fixed</td>
			    <td width="100">Avg Hours Per Bike Fixed</td>
			    <td width="100">Avg Bike Price</td>
			    
			    <td width="100">Value of Bikes Sold</td>
			    <td width="100">Net Sales New Parts</td>
			    <td width="100">Sales Used Parts</td>
			    <td width="100" class=yb_standardBold>Total Sales</td>
			    <td width="100"># Bikes Sold</td>
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
			    </tr>
                <input type="hidden" name="MM_insert" value="FormEdit">
                <input type="hidden" name="shop_id" value="<?php echo $row_Recordset1['shop_id']; ?>">
              </form>
		    <?php } else { // end if EDIT RECORD ?>
              <tr class="yb_standardRIGHTsmall">
                <td><?php echo $row_Recordset1['Year']; ?></td>
			    <td>&nbsp;<?php echo $row_Recordset1[$period]; ?></td>
			    
			    <td>&nbsp;<?php echo number_format($row_Recordset1['Hours_All'],0); ?></td>
			    <td>&nbsp;<?php echo number_format($row_Recordset1['Hours_Spec'],0); ?></td>
			    <td>&nbsp;<?php currency_format($row_Recordset1['Pay_All'],0);?></td>
			    <td>&nbsp;<?php currency_format($row_Recordset1['ValueNewPartsOnBikes'],0);?></td>	
			    
			    <td>&nbsp;<?php currency_format($row_Recordset1['ValueBikesFixed'],0);?></td>
			    <td>&nbsp;<?php currency_format($row_Recordset1['ValueWheelsFixed'],0);?></td>
			    <td class=yb_standardBold>&nbsp;<?php currency_format($row_Recordset1['EstimatedNetIncome'],0);?></td>
			    <td class=yb_standardBold>&nbsp;<?php currency_format($row_Recordset1['EstimatedGrossPerHour_NoSpec'],1); ?></td>
			    <td class=yb_standardBold>&nbsp;<?php currency_format($row_Recordset1['EstimatedNetPerHour'],1); ?></td>
			    
			    <td>&nbsp;<?php echo $row_Recordset1['TotalBikesFixed']; ?></td>
			    <td>&nbsp;<?php echo number_format($row_Recordset1['HoursPerBike'],1); ?></td>
			    <td>&nbsp;<?php currency_format($row_Recordset1['AverageBikeValue'],0); ?></td>
			    
			    <td>&nbsp;<?php currency_format($row_Recordset1['SalesBikes'],0);?></td>
			    <td>&nbsp;<?php currency_format($row_Recordset1['NetSalesNewParts'],0);?></td>
			    <td>&nbsp;<?php currency_format($row_Recordset1['SalesUsedParts'],0);?></td>
			    <td class=yb_standardBold>&nbsp;<?php currency_format($row_Recordset1['TotalSales'],0);?></td>
			    <td>&nbsp;<?php echo $row_Recordset1['TotalBikesSold']; ?></td>
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
			<li>Est. Net Income = value of bikes and wheels produced + sales of used and new parts - cost of new parts - pay for all hours (regular and special). This net production number includes pay and the effect of increased compensation and special projects. </li>
			<li>Est. Gross Income per Staff Hour = (value of bikes and wheels produced + sales of used and new parts - cost of new parts) / regular hours. This is a production number per regular staff hour to show changes in production over time independent of special projects and increased compensation. By dividing by regular staff hours (omitting special projects) this is normalized to be independent of number of hours worked (e.g. the effect of expanded staff). </li>
			<li>Est. Net Income per Staff Hour = (value of bikes and wheels produced + sales of used and new parts - cost of new parts - pay for all hours) / all hours. This net production number includes pay and the effect of increased compensation and special projects. By dividing by total staff hours (regular and special) this is normalized to be independent of number of hours worked (e.g. the effect of expanded staff).</li>
		</ul>
		<?php include("include_footer.html"); ?>
<?php
mysql_free_result($Recordset1);
?>
