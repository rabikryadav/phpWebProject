<?php
include('../assets/component/db_con.php');
if (isset($_GET['update_id'])) {

$updata_data = $_GET['update_id'];

$sqlSearchQuery = "select * from users where id='$updata_data'";

$sql_query = mysqli_query($con,$sqlSearchQuery);

$result = mysqli_fetch_array($sql_query);

// for checked box data show
$checked_data = $result['education']; // here all data will come in string

$checked_edu = explode(',', $checked_data); // this will convert string to array

}

// set new value

if (isset($_REQUEST['submit'])) {

	// store the user data on variable
	$username = $_REQUEST['username'];
	$pwd = $_REQUEST['password'];
	$address = $_REQUEST['address'];
	$gender = $_REQUEST['gender'];
	$country = $_REQUEST['country'];
	$education = $_REQUEST['education'];

	// checkbox data will come in array for so convert it into string for storing in database
	$con_arr_to_str  = implode(',', $education);

	$fileName = $_FILES['photo']['name'];
	$fileTmpName = $_FILES['photo']['tmp_name'];

	// file upload directory name
	$filePathName = '../assets/images/users/'.$fileName;

	// file url for database
	$fileuUrlPath = 'assets/images/users/'.$fileName;

	// for image validation
	$valid_file_extension = array('jpg','jpeg','png','gif');

	$split_str_to_array = explode('.',$fileName); // this will split name and extension

	$fileExtension = strtolower(end($split_str_to_array)); 	// this will give extension name

	if (in_array($fileExtension, $valid_file_extension)) {
	
		// sql query for upload file on dir.
		$sqlFileUploadDir = move_uploaded_file($fileTmpName, $filePathName);

		// for delete old image

		$sqlSearchQuery = "select * from users where id='$updata_data'";

		$sql_query = mysqli_query($con,$sqlSearchQuery);

		$cols_data = mysqli_fetch_array($sql_query);
		
		unlink("../".$cols_data['photo']);

		$sqlUpdateQuery = "update users set username='$username',password='$pwd',address='$address', gender='$gender', education='$con_arr_to_str', country='$country', photo='$fileuUrlPath' where id='$updata_data'";

		$sql_query = mysqli_query($con,$sqlUpdateQuery);

		header('location:user_list.php');
	}else{
		echo "File Is Not Valid";
	}

	$sqlUpdateQuery = "update users set username='$username',password='$pwd',address='$address', gender='$gender', education='$con_arr_to_str', country='$country' where id='$updata_data'";

	$sql_query = mysqli_query($con,$sqlUpdateQuery);

	header('location:user_list.php');
}
?>
<?php include('../links.php'); ?>
<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
<header id="header" class="container bg-secondary text-light pb-2">
	<h1 class="text-center p-1">Complete WebSite in PHP</h1>
	<div class="row">
		<div class="col-xl-10">
		</div>
		<div class="col-xl-2">
			<a href="../login.php" class="btn btn-success">Login</a>
		</div>
	</div>
</header>
<div class="container w-50">
	<form method="post" action="" enctype="multipart/form-data">
		<div class="m-auto p-2 w-50">
			<h3 class="text-center font-weight-bold">Update Form Data</h3>
			<div class="form-group">
			<label for="username">Username:</label>
			<input type="text" name="username" placeholder="Username" value="<?php echo $result['username']; ?>" class="form-control" required>
			</div>
			<div class="form-group">
			<label for="password">Password:</label>
			<input type="password" name="password" placeholder="password" value="<?php echo $result['password']; ?>" class="form-control" required>
			</div>
			<div class="form-group">
			Address:<textarea cols="40%" rows="2" maxlength="130" name="address"><?php echo $result['address']; ?></textarea>
			</div>
			<div class="form-group pt-2">
			Gender: &nbsp;&nbsp;
			<input type="radio" name="gender" value="male"
			<?php 
			if ($result['gender'] == 'male') {
				echo 'checked';
			}
			?>
			>&nbsp;Male &nbsp;
			<input type="radio" name="gender" value="female"
			<?php 
			if ($result['gender'] == 'female') {
				echo 'checked';
			}
			?>
			>&nbsp;Female &nbsp;
			<input type="radio" name="gender" value="other"
			<?php 
			if ($result['gender'] == 'other') {
				echo 'checked';
			}
			?>
			>&nbsp;Not Say &nbsp;
			</div>
			<div class="form-group">
				Education: &nbsp;
				<input type="checkbox" name="education[]" value="html"
				<?php 
				if (in_array('html',$checked_edu)) {
					echo 'checked';
				}
				?>
				>HTML &nbsp;
				<input type="checkbox" name="education[]" value="css"
				<?php 
				if (in_array('css',$checked_edu)) {
					echo 'checked';
				}
				?>
				>CSS &nbsp;
				<input type="checkbox" name="education[]" value="javascript"
				<?php 
				if (in_array('javascript',$checked_edu)) {
					echo 'checked';
				}
				?>
				>JAVASCRIPT &nbsp;
				<input type="checkbox" name="education[]" value="php"
				<?php 
				if (in_array('php',$checked_edu)) {
					echo 'checked';
				}
				?>
				>PHP &nbsp;
			</div>
			<div class="form-group">
				Country:&nbsp;
				<select name="country">
					<option value="">Select Country</option>
					<option value="nepal"
					<?php 
					if ($result['country'] == 'nepal') {
						echo 'selected';
					}
					?>
					>Nepal</option>
					<option value="india"
					<?php 
					if ($result['country'] == 'india') {
						echo 'selected';
					}
					?>
					>India</option>
				</select>
			</div>
			<div class="form-group"><br>Old Image:
				<img src="../<?php echo $result['photo'] ?>" width="150px" height="100px"><br>
				Upload New Image: &nbsp;
				<input type="file" name="photo">
			</div>
			<div class="form-group pt-2">
				<input type="submit" name="submit" value="Submit" class="btn btn-success">
				<input type="reset" name="reset" value="Reset" class="btn btn-warning">
			</div>
		</div>
	</form>
</div>
