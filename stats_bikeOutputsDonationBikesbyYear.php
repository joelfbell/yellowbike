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
$query_Recordset1 = "SELECT * FROM ybdb.view_Transactions_OutgoingDonationBikes_byYear2_pvTbl;";
$Recordset1 = mysql_query($query_Recordset1, $YBDB) or die(mysql_error());
//$row_Recordset1 = mysql_fetch_assoc($Recordset1);   //Wait to fetch until do loop
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?>

<?php include("include_header.html"); ?>

        <table>
        <tr valign="top">
          <td><span class="yb_heading3red">Bike Donations by Year and Type</span> </td>
	  </tr>
        <tr>
          <td>
            <table   border="1" cellpadding="1" cellspacing="0">
              
              <tr valign="top" bgcolor="#99CC33" class="yb_standardCENTER">
                <td width="100" height="35">Year</td>
                <td width="100">Adult Bikes</td>
                <td width="100">Adult E-A-Bikes</td>
                <td width="100">Kids Bikes</td>
                <td width="100">Kids E-A-Bikes</td>
                <td width="100">Yellow Bikes</td>
			    <td width="100">Total</td>			    
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
		        </tr>
                <input type="hidden" name="MM_insert" value="FormEdit">
                <input type="hidden" name="shop_id" value="<?php echo $row_Recordset1['shop_id']; ?>">
              </form>
		    <?php } else { // end if EDIT RECORD ?>
              <tr>
                <td><?php echo $row_Recordset1['Year']; ?></td>
                <td><?php echo number_format($row_Recordset1['AdultBikes'],0); ?></td>
                <td><?php echo number_format($row_Recordset1['AdultEABikes'],0); ?></td>
                <td><?php echo number_format($row_Recordset1['KidsBikes'],0); ?></td>
                <td><?php echo number_format($row_Recordset1['KidsEABikes'],0); ?></td>
                <td><?php echo number_format($row_Recordset1['YellowBikes'],0); ?></td>
                <td><?php echo number_format($row_Recordset1['Total'],0); ?></td>
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
