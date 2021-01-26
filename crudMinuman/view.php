<?php session_start(); ?>

<?php
if(!isset($_SESSION['valid'])) {
	header('Location: login.php');
}
?>

<?php
//including the database connection file
include_once("koneksi.php");

//fetching data in descending order (lastest entry first)
$result = mysqli_query($mysqli, "SELECT * FROM products ORDER BY id DESC");
?>

<html>
<head>
	<title>Beranda</title>
</head>

<body>
	<?php if($_SESSION['role'] == 1) { ?> <a href="index.php">Home</a> | <a href="add.html">Tambah Data</a> | <?php } ?> <a href="logout.php">Logout</a>
	<br/><br/>
	
	<table width='80%' border=0>
		<tr bgcolor='#CCCCCC'>
			<td>Nama</td>
			<td>Jumlah</td>
			<td>Harga (Rp)</td>
			<?php if($_SESSION['role'] == 1) { ?><td>Update</td> <?php } ?>
		</tr>
		<?php
		while($res = mysqli_fetch_array($result)) {		
			echo "<tr>";
			echo "<td>".$res['name']."</td>";
			echo "<td>".$res['qty']."</td>";
			echo "<td>".$res['price']."</td>";	
			if($_SESSION['role'] == 1) { echo "<td><a href=\"edit.php?id=$res[id]\">Edit</a> | <a href=\"delete.php?id=$res[id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Hapus</a></td>"; }	
		}
		?>
	</table>	
</body>
</html>

