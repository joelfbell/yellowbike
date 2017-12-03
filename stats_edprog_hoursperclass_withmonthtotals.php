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

mysql_select_db($database_YBDB, $YBDB);
$query_Recordset1 = "SELECT * FROM ybdb.view_EmployeeHours_EdProg_byMonthAndShop;";
$Recordset1 = mysql_query($query_Recordset1, $YBDB) or die(mysql_error());
//$row_Recordset1 = mysql_fetch_assoc($Recordset1);   //Wait to fetch until do loop
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?>

<?php include("include_header.html"); ?>

        <table>
        <tr valign="top">
          <td><span class="yb_heading3red">Hours and Pay for Ed Program Activities by Class or Month</span></td>
	  </tr>
        <tr>
          <td>
            <table   border="1" cellpadding="1" cellspacing="0">
              <tr valign="top" bgcolor="#99CC33" class="yb_standardCENTER">
                <td width="100" height="35">Year</td>
			    <td width="100">Month</td>
			    <td width="100">ShopID</td>
			    <td width="100">Day</td>
			    <td width="100">Date</td>
			    <td width="250">ShopType</td>
			    <td width="100">Location</td>
			    <td width="100">NumOfStaff</td>
			    <td width="100">TotalHours</td>
			    <td width="100">TotalPay</td>
			    <td width="200">ShopUserRole</td>
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
			    </tr>
                <input type="hidden" name="MM_insert" value="FormEdit">
                <input type="hidden" name="shop_id" value="<?php echo $row_Recordset1['shop_id']; ?>">
              </form>
		    <?php } else { // end if EDIT RECORD ?>
              <tr>
                <td><?php echo $row_Recordset1['Year']; ?></td>
                <td><?php echo $row_Recordset1['Month']; ?></td>
                <td><?php echo $row_Recordset1['shop_id']; ?></td>
                <td><?php echo $row_Recordset1['DayName']; ?></td>
                <td><?php echo $row_Recordset1['ShopDate']; ?></td>
                <td><?php echo $row_Recordset1['ShopType']; ?></td>
                <td><?php echo $row_Recordset1['ShopLocation']; ?></td>
                <td><?php echo $row_Recordset1['NumOfStaff']; ?></td>
                <td><?php echo $row_Recordset1['TotalHours']; ?></td>
                <td><?php echo $row_Recordset1['TotalPay']; ?></td>
                <td><?php echo $row_Recordset1['ShopUserRole']; ?></td>
		      </tr>
              <?php
		  } // end if EDIT RECORD 
		  } // end WHILE count of recordset ?>
          </table>	  </td>
	  </tr>
        </table>
		
		<?php include("include_footer.html"); ?>
<?php
mysql_free_result($Recordset1);
?>
