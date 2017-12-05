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
case 'AllTime':
   $period = 'AllTime';
   $periodname = 'All Time';
   $round = 0;
   break;		
case 'Year':
   $period = '1yr';
   $periodname = 'the Last Year';
   $round = 0;
   break;
case '3Month':
   $period = '3mo';
   $periodname = 'the Last 3 Months';
   $round = 1;
   break;
default:
   $period = '3mo';
   break;
}

mysql_select_db($database_YBDB, $YBDB);
$query_Recordset1 = "SELECT * FROM view_ShopUserHours2_CSR_$period ORDER BY NameLastFirst;";
$Recordset1 = mysql_query($query_Recordset1, $YBDB) or die(mysql_error());
//$row_Recordset1 = mysql_fetch_assoc($Recordset1);   //Wait to fetch until do loop
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?>

<?php include("include_header.html"); ?>

        <table>
        <tr valign="top">
          <td><span class="yb_heading3red">CSR Hours by User for <?php echo $periodname;?></span></td>
	  </tr>
	  <tr valign="top">
          <td><?php echo "View by: <a href=\"$page?period=AllTime\">All Time</a>, 
          <a href=\"$page?period=Year\">Year</a>, 
          <a href=\"$page?period=3Month\">3 Months</a>"?> 
	  </tr>
        <tr>
          <td>
            <table   border="1" cellpadding="1" cellspacing="0">
              <tr valign="top" bgcolor="#99CC33" class="yb_standardCENTER">
                <td width="200" height="35">Shop User</td>
			    <td width="150">CSR Hours</td>
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
                <td><a href="<?php echo "{$page_individual_history_log}?contact_id=" . $row_Recordset1['ContactID']; ?>"><?php echo $row_Recordset1['NameLastFirst']; ?></a></td>
			    <td class="yb_standardRightred">&nbsp;<?php echo number_format($row_Recordset1['TotalHoursCSR'],$round); ?></td>
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
