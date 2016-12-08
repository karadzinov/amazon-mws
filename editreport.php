<?php

require_once 'header.php';
echo '<a href="reportlist.php" class="btn btn-default">Back</a><br /><br /><div class="clearfix"></div>';
$id = $_GET['id'];
$dbquery = mysqli_query($con, "SELECT * FROM reports WHERE rid = '$id'");



while ($row = mysqli_fetch_array($dbquery)) {
	echo "<h3>Report Name: PO-" . $row['TrackNum'] . ".xml</h3>";

	echo '
	<div class="row">
		<div class="col-sm-6">
			<h4>Basic Info</h4>
			<form role="form" class="form-horizontal" method="post" action="process/updatereport.php">
				<input type="hidden" name="rid" value="'.$id.'" />
				<div class="form-group">
					<label for="TrackNum">TrackNum</label>
					<input type="text" class="form-control" name="TrackNum" value="' . $row['TrackNum'] . '">
				</div>
				<div class="form-group">
					<label for="CustomerID">CustomerID</label>
					<input type="text" class="form-control" name="CustomerID" value="' . $row['bi_CustomerID'] . '">
				</div>
				<div class="form-group">
					<label for="Password">Password</label>
					<input type="text" class="form-control" name="Password" value="' . $row['bi_Password'] . '">
				</div>

				<div class="form-group">
					<label for="SellingStore">SellingStore</label>
					<input type="text" class="form-control" name="SellingStore" value="' . $row['SellingStore'] . '">
				</div>

				<div class="form-group">
					<label for="PONum">PONum</label>
					<input type="text" class="form-control" name="PONum" value="' . $row['PONum'] . '">
				</div>

				<div class="form-group">
					<label for="CancelOrderFlag">CancelOrderFlag</label>
					<input type="text" class="form-control" name="CancelOrderFlag" value="' . $row['CancelOrderFlag'] . '">
				</div>

				<div class="form-group">
					<label for="JobNumber">JobNumber</label>
					<input type="text" class="form-control" name="JobNumber" value="' . $row['JobNumber'] . '">
				</div>

				<div class="form-group">
					<label for="UseSellPrice">UseSellPrice</label>
					<input type="text" class="form-control" name="UseSellPrice" value="' . $row['UseSellPrice'] . '">
				</div>

			</div>
			<div class="col-sm-6">
				<h4>Item Info</h4>
				<div class="form-group">
					<label for="ItemID">ItemID</label>
					<input type="text" class="form-control" name="ItemID" value="' . $row['ItemID'] . '">
				</div>
				<div class="form-group">
					<label for="MfgCode">MfgCode</label>
					<input type="text" class="form-control" name="MfgCode" value="' . $row['MfgCode'] . '">
				</div>		
				<div class="form-group">
					<label for="PartNum">PartNum</label>
					<input type="text" class="form-control" name="PartNum" value="' . $row['PartNum'] . '">
				</div>	
				<div class="form-group">
					<label for="Qty">Qty</label>
					<input type="text" class="form-control" name="Qty" value="' . $row['Qty'] . '">
				</div>
				<div class="form-group">
					<label for="QtyOrder">QtyOrder</label>
					<input type="text" class="form-control" name="QtyOrder" value="' . $row['QtyOrder'] . '">
				</div>	
				<div class="form-group">
					<label for="SellPrice">SellPrice</label>
					<input type="text" class="form-control" name="SellPrice" value="' . $row['SellPrice'] . '">
				</div>
			</div>
		</div>
		<div class="row">

			<div class="col-sm-6">
				<h4>Ship To</h4>
				<div class="form-group">
					<label for="spt_CompanyName">CompanyName</label>
					<input type="text" class="form-control" name="spt_CompanyName" value="' . $row['spt_CompanyName'] . '">
				</div>
				<div class="form-group">
					<label for="spt_LastName">LastName</label>
					<input type="text" class="form-control" name="spt_LastName" value="' . $row['spt_LastName'] . '">
				</div>

				<div class="form-group">
					<label for="spt_Street">Street</label>
					<input type="text" class="form-control" name="spt_Street" value="' . $row['spt_Street'] . '">
				</div>
				<div class="form-group">
					<label for="spt_City">City</label>
					<input type="text" class="form-control" name="spt_City" value="' . $row['spt_City'] . '">
				</div>
				<div class="form-group">
					<label for="spt_State">State</label>
					<input type="text" class="form-control" name="spt_State" value="' . $row['spt_State'] . '">
				</div>

				<div class="form-group">
					<label for="spt_ZipCode">ZipCode</label>
					<input type="text" class="form-control" name="spt_ZipCode" value="' . $row['spt_ZipCode'] . '">
				</div>

				<div class="form-group">
					<label for="spt_Phone">Phone</label>
					<input type="text" class="form-control" name="spt_Phone" value="' . $row['spt_Phone'] . '">
				</div>


				<div class="form-group">
					<label for="spt_ResidentialDelivery">ResidentialDelivery</label>
					<input type="text" class="form-control" name="spt_ResidentialDelivery" value="' . $row['spt_ResidentialDelivery'] . '">
				</div>
				<div class="form-group">
					<label for="ShipVia">ShipVia</label>
					<input type="text" class="form-control" name="ShipVia" value="' . $row['ShipVia'] . '">
				</div>
			</div>
			<div class="col-sm-6">
				<h4>Sold To</h4>
				<fieldset disabled>
					<div class="form-group">
						<label for="sdt_CompanyName">CompanyName</label>
						<input type="text" class="form-control" name="sdt_CompanyName" value="' . $row['sdt_CompanyName'] . '">
					</div>

					<div class="form-group">
						<label for="sdt_Street">Street</label>
						<input type="text" class="form-control" name="sdt_Street" value="' . $row['sdt_Street'] . '">
					</div>
					<div class="form-group">
						<label for="sdt_City">City</label>
						<input type="text" class="form-control" name="sdt_City" value="' . $row['sdt_City'] . '">
					</div>
					<div class="form-group">
						<label for="sdt_State">State</label>
						<input type="text" class="form-control" name="sdt_State" value="' . $row['sdt_State'] . '">
					</div>

					<div class="form-group">
						<label for="sdt_ZipCode">ZipCode</label>
						<input type="text" class="form-control" name="sdt_ZipCode" value="' . $row['sdt_ZipCode'] . '">
					</div>

					<div class="form-group">
						<label for="sdt_Phone">Phone</label>
						<input type="text" class="form-control" name="sdt_Phone" value="' . $row['sdt_Phone'] . '">
					</div>
				</fieldset>
			</div>
		</div>
		<button type="submit" class="btn btn-warning">Update report and export to SBC</button>
	</form>
</div>
';

}

require_once 'footer.php';
?>