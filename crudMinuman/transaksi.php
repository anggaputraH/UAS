<?php session_start(); ?>
<html>
<head>
	<title>Transaksi</title>
</head>

<body>
<a href="index.php">Home</a> <br />
<?php
include("koneksi.php");

if(isset($_POST['submit'])) {
	$product = $_POST['product'];
	$qty = $_POST['qty'];
	$total = $_POST['total'];
	$id_login =$_SESSION['id'];

	if($product == "" || $qty == "") {
		echo "Harap diisi dengan lengkap";
		echo "<br/>";
		echo "<a href='transaksi.php'>Go back</a>";
	} else {
		$result = mysqli_query($mysqli, "SELECT * FROM products where id = ".$product." ORDER BY id DESC");
		$res = mysqli_fetch_array($result);
		if ($res['qty'] < $qty) {
			echo "Transaksi gagal";
			echo "<br/>";
			echo "jumlah barang yang dibeli melebihi jumlah stok";
			echo "<br/>";
			echo "<a href='transaksi.php'>Transaksi</a>";
		} else {
			$sisa = $res['qty'] - $qty;
			mysqli_query($mysqli, "UPDATE products SET qty='$sisa' WHERE id=$product")
			or die("Could not execute the insert query.");
			mysqli_query($mysqli, "INSERT INTO transaksi(id_product, qty, total, id_login) VALUES('$product', '$qty', '$total', $id_login)")
			or die("Could not execute the insert query.");
			echo "Transaksi sukses";
			echo "<br/>";
			echo "<a href='transaksi.php'>Transaksi</a>";
		}		
			
		
	}
} else {
	$result = mysqli_query($mysqli, "SELECT * FROM products ORDER BY id DESC");
	$transaksi = mysqli_query($mysqli, "SELECT t.qty, t.time, t.total, p.name as name_product, l.name as name FROM transaksi t join products p on t.id_product = p.id join login l on l.id = t.id_login ORDER BY t.id DESC");
?>
	<p><font size="+2">Transaksi</font></p>
	<form name="form1" method="post" action="">
		<table width="75%" border="0">
			<tr> 
				<td width="10%">Produk</td>
				<td>
					<select name="product" required="true" id="product">
						<option value =""> --Pilih Produk-- </option>
						<?php
							while($value = mysqli_fetch_array($result)) {
								echo "<option value ='".$value['id']." '>".$value['name']."#".$value['price']."</option>";
							} ?>
					</select>
				</td>
			</tr>
			<tr> 
				<td>QTY</td>
				<td><input type="number" name="qty" id="qty" onchange="myFunction()"></td>
			</tr>			
			<tr> 
				<td>Total</td>
				<td><input type="text" name="total" id="total" readonly="true"></td>
			</tr>
			<tr> 
				<td>&nbsp;</td>
				<td><input type="submit" name="submit" value="Submit"></td>
			</tr>
		</table>
	</form>
	<table width='80%' border=0>
		<tr bgcolor='#CCCCCC'>
			<td>Name</td>
			<td>Quantity</td>
			<td>Price (Rp)</td>
			<td>Kasir</td>
			
		</tr>
		<?php
		while($res = mysqli_fetch_array($transaksi)) {
			echo "<tr>";
			echo "<td>".$res['name_product']."</td>";
			echo "<td>".$res['qty']."</td>";	
			echo "<td>".$res['total']."</td>";	
			echo "<td>".$res['name']."</td>";	
				
			echo "</tr>"
		?>
		<?php
		}
		?>
	</table>
	
<?php
}
?>
<script>
function myFunction() {
	var x = document.getElementById("product").value;
	var sel = document.getElementById("product");
	var text= sel.options[sel.selectedIndex].text;
	text = text.split('#');
	var y = document.getElementById("qty").value;
	// console.log(text[1] * y);
  document.getElementById("total").value = text[1] * y;
}
</script>
</body>
</html>
