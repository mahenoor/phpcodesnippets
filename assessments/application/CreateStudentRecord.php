<?php
require 'config.php';
?>
<html>
<head>
<h1 align="center">Student Information</h1>
<title>Student Information</title>
<style type = "text/css">
.button 
{
    text-align : center;
    color : red;
    background : yellow;
    padding : 2px;
}
.error
{
    color : red;
    font : bold;
}
</style>
</head>
<?php
$studentNameError = "";
$departmentError = "";  
$genderError = "";
$Roll_noError = "";
$subject1Error = "";
$subject2Error = "";
$subject3Error = "";
$gender = "";
$department = "";
if (isset($_POST['submit'])) {
    require 'validation.php';
    if (!empty($studentName)  && !empty($department) && !empty($gender) && !empty($Roll_no) &&  
        !empty($subject1)  && !empty($subject2) && !empty($subject3) && !preg_match("/^['a-zA-Z']*$/", $studentName)
        && !preg_match("/^[a-z0-9]*$/", $Roll_no) && !preg_match("/^[0-9]*$/", $subject1) && 
        !preg_match("/^[0-9]*$/", $subject2) && !preg_match("/^[0-9]*$/", $subject3)) {
        $insert_query = "INSERT INTO Student(studentName, Department, Gender, Roll_no, Subject1, Subject2, Subject3, Total, Percentage ) 	VALUES ('$studentName', '$department', '$gender', '$Roll_no', '$subject1', 
            '$subject2', '$subject3', '$total', '$percentage' )";
        if (mysqli_query($conn, $insert_query)) {
            echo "record inserted into database successfully";
        } else if (!mysqli_query($conn, $insert_query)) {
            echo "Error: " . $insert_query . "<br>" . mysqli_error($conn);
        }
    } else {
?>
        <span class="error"><?php echo "Error:please enter the required fields in proper specified format"; ?></span>
<?php
    }
} 
mysqli_close($conn);
?>
<body bgcolor="pink">
<form method="post" action="" >
<table>
<tr>
<td><label>Enter the Student Name:</label></td>
<td><input type="text" name="studentName"  value="<?php if(!empty($_POST['studentName'])) echo $_POST['studentName'] ?>" />
<?php echo $studentNameError; ?>
</td>
</tr>
<tr>
<td><label>Enter the Department:</label></td>
<td><select name="department">
<option disabled selected value>select</option>
<option <?php if ($department == 'Computer Science') { ?> selected <?php } ?> value="Computer Science ">Computer Science</option>
<option <?php if ($department == 'Electronics') { ?> selected <?php } ?> value="Electronics">Electronics</option>
<option <?php if ($department == 'Mechanical') { ?> selected <?php } ?> value="Mechanical">Mechanical</option>
<option <?php if ($department == 'Civil') { ?> selected <?php } ?> value="Civil">Civil</option>
<option <?php if ($department == 'Electrical') { ?> selected <?php } ?> value="Electrical">Electrical</option>
<option <?php if ($department == 'Aeronatics') { ?> selected <?php } ?> value="Aeronatics">Aeronatics</option>
<option <?php if ($department == 'Chemical') { ?> selected <?php } ?> value="Chemical">Chemical</option>
<option <?php if ($department == 'Metallurgy') { ?> selected <?php } ?> value="Metallurgy">Metallurgy</option>
<option <?php if ($department == 'Medical electronics') { ?> selected <?php } ?> value="Medical electronics">Medical electronics</option>
</select>
<?php echo $departmentError; ?>
</td>
</tr>
<tr>
<td><label>Enter the Gender:</label></td>
<td><input type="radio" <?php if($gender == "male") { echo "checked"; } ?>  name="gender" value="male" />Male<br />
<input type="radio" <?php if($gender == "female") echo "checked" ?> name="gender" value="female" />Female<br />
<?php echo $genderError; ?>
</td>
</tr>
<tr>
<td><label>Enter the Roll_no:</label></td>
<td><input type="text" name="Roll_no" value="<?php if(!empty($_POST['Roll_no'])) echo $_POST['Roll_no'] ?>" />
<?php echo $Roll_noError; ?>
</td>
</tr>
<tr>
<td><label>Enter marks of Subject1:</label></td>
<td><input type="text" name="subject1" value="<?php if(!empty($_POST['subject1'])) echo $_POST['subject1'] ?>" />
<?php echo $subject1Error; ?>
</td>
</tr>
<tr>
<td><label>Enter marks of Subject2:</label></td>
<td><input type="text" name="subject2" value="<?php if(!empty($_POST['subject2'])) echo $_POST['subject2'] ?>"  />
<?php echo $subject2Error; ?>
</td>
</tr>
<tr>
<td><label>Enter marks of Subject3:</label></td>
<td><input type="text" name="subject3" value="<?php if(!empty($_POST['subject3'])) echo $_POST['subject3'] ?>"  />
<?php echo $subject3Error; ?>
</td>
</tr>
</table>
<input type="submit" name="submit" value="submit" class="button" />
<a href="index.php">Go to index page</a></form>
</body>
</html>
