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
$query_Recordset1 = "SELECT transaction_id, amount, c.first_name AS name, description, date(date) as date, dayname(date) as day, style, size,photo_link 
FROM ybdb.transaction_log t LEFT JOIN contacts c ON t.sold_by = c.contact_id 
WHERE transaction_type = 'Metrics - Completed Mechanic Operation Bike' 
ORDER BY amount DESC, name, date DESC;";
$Recordset1 = mysql_query($query_Recordset1, $YBDB) or die(mysql_error());
//$row_Recordset1 = mysql_fetch_assoc($Recordset1);   //Wait to fetch until do loop
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?>

<?php include("include_header.html"); ?>

        <table>
        <tr valign="top">
          <td><span class="yb_heading3red">Shop Transaction Totals</span> - Total includes sales and cash donations</td>
	  </tr>
        <tr>
          <td>
            <table   border="1" cellpadding="1" cellspacing="0">
              
              <tr valign="top" bgcolor="#99CC33" class="yb_standardCENTER">
                <td width="100" height="35">TransactionID</td>
                <td width="100" height="35">Amount</td>
			    <td width="100">CompletedBy</td>
			    <td width="200">Description</td>
			    <td width="100">Date</td>
			    <td width="100">Day</td>
			    <td width="100">Style</td>
			    <td width="100">Size</td>
			    <td width="100">PhotoLink</td>
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
		        </tr>
                <input type="hidden" name="MM_insert" value="FormEdit">
                <input type="hidden" name="shop_id" value="<?php echo $row_Recordset1['shop_id']; ?>">
              </form>
		    <?php } else { // end if EDIT RECORD ?>
              <tr>
                <td><?php echo $row_Recordset1['transaction_id']; ?></td>
                <td><?php echo $row_Recordset1['amount']; ?></td>
			    <td><?php echo $row_Recordset1['name']; ?></td>
			    <td><?php echo $row_Recordset1['description']; ?></td>
                <td><?php echo $row_Recordset1['date']; ?></td>
			    <td><?php echo $row_Recordset1['day']; ?></td>
			    <td><?php echo $row_Recordset1['style']; ?>&nbsp;</td>
                <td><?php echo $row_Recordset1['size']; ?>&nbsp;</td>
			    <td><?php echo $row_Recordset1['photo_link']; ?>&nbsp;</td>
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
