<? php
$full_name = $_POST['full_name'];
$registration_no = $_POST['registration_no'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$gender = $_POST['gender'];
$date = $_POST['date'];
$description = $_POST['description']

if (!empty($full_name) ||!empty($registration_no)|| !empty($phone) || !empty($gender || !empty($date)){ 

$host = "localhost";
$dbname = "mkuhospital";
 
 #creation of connectio
$conn = new mysqli($host, $dbname);

if (mysqli_connect_error()) {
	die('connect error('.mysqli_connect_error().')'.mysqli_connect_error());
}else{
	 $SELECT = "SELECT email From appointment where email = ? Limit 1";
	$INSERT = "INSERT Into appointment(full_name, registration_no, email, phone, gender, date, description) values(?,?,?,?,?,?,?) "

	#prepare statement
	$stmt = $conn->prepare($SELECT);
	$stmt->bind_param("s",$email);
	$stmt->execute();
	$stmt->bind_result($email);
	$stmt->store_result();
	$rnum = $stmt->num_rows;

	if ($rnum==0) {
		$stmt->close();

		$stmt = $conn->prepare($INSERT);
		$stmt->bind_param("ssssii",$full_name, $registration_no, $email, $phone, $gender, $date, $description);
		$stmt->execute();

		echo "Appointment requested successfully!";

	} else{
		echo "email already registered! ";
	}
	$stmt->close();
	$conn->close();

}

}
else{ 
	echo "Fill all the field!";
	die();
}
?>