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
$query_Recordset1 = "SELECT * FROM ybdb.view_SaleBikesbyPricebyYear3;";
$Recordset1 = mysql_query($query_Recordset1, $YBDB) or die(mysql_error());
//$row_Recordset1 = mysql_fetch_assoc($Recordset1);   //Wait to fetch until do loop
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?>

<?php include("include_header.html"); ?>

        <table>
        <tr valign="top">
          <td><span class="yb_heading3red">Sale Bike Prices and Donations by Year</span> <br> Before 2014 is sales and 2014 afterwards is mechanic production since sale transactions often contain two bikes</td>
	  </tr>
        <tr>
          <td>
            <table   border="1" cellpadding="1" cellspacing="0">
              
              <tr valign="top" bgcolor="#99CC33" class="yb_standardCENTER">
                <td width="100" height="35">Year</td>
                <td width="50">Scrapped</td>
                <td width="50">Donated</td>
                <td width="50">$50</td>
			    <td width="50">$100</td>
			    <td width="50">$150</td>
			    <td width="50">$200</td>
			    <td width="50">$250</td>
			    <td width="50">$300</td>
			    <td width="50">$400</td>
			    <td width="50">$500</td>
			    <td width="50">$600</td>
			    <td width="50">$700</td>
			    <td width="50">$1000</td>
			    <td width="50">$1500</td>
			    <td width="50">$2000</td>
			    <td width="50">Total Sold</td>
			    <td width="50">Total</td>			    
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
                <td><?php echo number_format($row_Recordset1['Scrapped'],0); ?></td>
                <td><?php echo number_format($row_Recordset1['Donated'],0); ?></td>
                <td><?php echo number_format($row_Recordset1['$50'],0); ?></td>
                <td><?php echo number_format($row_Recordset1['$100'],0); ?></td>
                <td><?php echo number_format($row_Recordset1['$150'],0); ?></td>
                <td><?php echo number_format($row_Recordset1['$200'],0); ?></td>
                <td><?php echo number_format($row_Recordset1['$250'],0); ?></td>
                <td><?php echo number_format($row_Recordset1['$300'],0); ?></td>
                <td><?php echo number_format($row_Recordset1['$400'],0); ?></td>
                <td><?php echo number_format($row_Recordset1['$500'],0); ?></td>
                <td><?php echo number_format($row_Recordset1['$600'],0); ?></td>
                <td><?php echo number_format($row_Recordset1['$700'],0); ?></td>
                <td><?php echo number_format($row_Recordset1['$1000'],0); ?></td>
                <td><?php echo number_format($row_Recordset1['$1500'],0); ?></td>
                <td><?php echo number_format($row_Recordset1['$2000'],0); ?></td>
                <td><?php echo number_format($row_Recordset1['TotalSold'],0); ?></td>
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
