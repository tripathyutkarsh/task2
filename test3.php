<?php
session_start();
$username=$_POST['username'];
$password=$_POST['password'];
$email=$_POST['email'];
$dob=$_POST['dob'];


$conn =mysqli_connect("localhost","utkarsh","utkarsh","utkarsh") or die(mysqli_connect_error());



$rows=mysqli_query($conn,"select username from utkarsh where username='$username'")or die(mysqli_error($conn));

$count=mysqli_num_rows($rows);

if($count>0)
{
	$_SESSION['msg']="Username already present. Please enter a different username";
	header("location:regpage.php");
}

else if(filter_var($email,FILTER_VALIDATE_EMAIL)!=true)
{ 
	$_SESSION['msg']="PLEASE ENTER A VALID EMAIL ID";
	header("location:regpage.php");
}



else
{

	$arr=explode("-",$dob);

	if(preg_match('/^[1-9][0-9]{3}$/',$arr[0]) && (preg_match('/^[0-0][0-9]$/',$arr[1]) or preg_match('/^[0-1][1-2]$/',$arr[1])) && (preg_match('/^[0-2][0-9]$/',$arr[1]) or preg_match('/^[0-3][0-1]$/',$arr[1])))

	{	$from=new DateTime($dob);
		$today=new DateTime('today');

		if($from->diff($today)->y>18)
		{
			mysqli_query($conn,"insert into utkarsh values ('$username','$password','$email','$dob')") or die(mysqli_error($conn));
			$_SESSION['msg']="your details have been entered";
			header("location:regpage.php");
		}

		else
		{
			$_SESSION['msg']="CANNOT REGISTER. AGE IS LESS THAN 18.";
			header("location:regpage.php");		
		}
	}

	else
	{
		$_SESSION['msg']="PLEASE ENTER A VALID DATE OF BIRTH";
		header("location:regpage.php");
	}
}

?>
