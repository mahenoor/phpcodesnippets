<?php
require "calculation.php";
class CrudOperations 
{
	private $db_hostname = 'localhost';        
	private $db_username = 'root';              
	private $db_password = 'compass';                  
	private $db_name = 'studentInformation'; 
	private $conn;
	public function __construct()
	{
		$this->conn = mysqli_connect($this->db_hostname, $this->db_username, $this->db_password, $this->db_name);
		if (!$this->conn) {
		    die("Unable to connect database" .mysqli_error($this->conn));
		}
	}
	public function deleteRecord($id)
	{
		try {
				$delete_query = "DELETE from Student where id = {$id}";
				$result = $this->conn->query($delete_query);
		} catch(Exception $e) {
	    	echo "Error: " . $delete_query . "<br>" . mysqli_error($this->conn);
	    }
	}
	public function deleteRecordOfStudentLeave($student_id)
	{
		try {
				$delete_query = "DELETE from studentLeave where student_id = {$student_id}";
				$result = $this->conn->query($delete_query);
		} catch(Exception $e) {
	    	echo "Error: " . $delete_query . "<br>" . mysqli_error($this->conn);
	    }
	}
	public function createStudentRecord($inputData)
	{
		$studentName = $inputData['studentName'];
		$Department = $inputData['Department'];
		$Gender = $inputData['Gender'];
	    $Roll_no = $inputData['Roll_no'];
	    $Physics = $inputData['Physics'];
	    $Chemistry = $inputData['Chemistry'];
	    $Maths = $inputData['Maths'];
		$errorMessage = "";
	    $calculation = new Calculation();
		$Total = $calculation->Total($inputData['Physics'], $inputData['Chemistry'], $inputData['Maths']);
		$Percentage = $calculation->Percentage($inputData['Physics'], $inputData['Chemistry'], 
						$inputData['Maths']);
		try {
				$insert_query = "INSERT INTO Student(studentName, Department, Gender, Roll_no, Physics, Chemistry, Maths, Total, Percentage ) VALUES('$studentName', '$Department', '$Gender', '$Roll_no', '$Physics', 
			            '$Chemistry', '$Maths', '$Total', '$Percentage')";
				if (mysqli_query($this->conn, $insert_query)) {
	                return true;
	            } if (!mysqli_query($this->conn, $insert_query)) {
		    		throw new Exception();
		    	}
	    } catch(Exception $e) {
	    	echo "Error: " . $insert_query . "<br>" . mysqli_error($this->conn);
	    }
    }
	public function editStudentRecord($inputData, $id) 
	{
		$id = $_POST['id'];
		$studentName = $inputData['studentName']; 
		$Department = $inputData['Department'];
		$Gender = $inputData['Gender'];
		$Roll_no = $inputData['Roll_no'];
		$Physics = $inputData['Physics'];
		$Chemistry = $inputData['Chemistry'];
		$Maths = $inputData['Maths'];
		$errorMessage = ""; 
	    $calculation = new Calculation();
		$Total = $calculation->Total($inputData['Physics'], $inputData['Chemistry'], $inputData['Maths']);
		$Percentage = $calculation->Percentage($inputData['Physics'], $inputData['Chemistry'], 
						$inputData['Maths']);
		try {
				$update_query = "UPDATE Student SET studentName = '$studentName', Department = '$Department', 
	            Gender = '$Gender', Roll_no = '$Roll_no', Physics = '$Physics', Chemistry = '$Chemistry', Maths = 
	            '$Maths', Total = '$Total',  Percentage = '$Percentage' WHERE id = $id"; 
	            if (mysqli_query($this->conn, $update_query)) {
	                return true;
	        	}
	        	if (!mysqli_query($this->conn, $update_query)) {
		    		throw new Exception();
		    	}
	    } catch(Exception $e) {
	    	echo "Error: " . $update_query . "<br>" . mysqli_error($this->conn);
	    }
	}
	public function editStudentLeaveRecord($inputData, $id)
	{
		$id = $_POST['id'];
		$startDate = $inputData['startDate'];
		$endDate = $inputData['endDate'];
		$studentLeave = $inputData['studentLeave'];
		try {
				$update_query = "UPDATE studentLeave SET startDate = '$startDate', endDate = 
				'$endDate', studentLeave = '$studentLeave' WHERE id = $id"; 
				if (mysqli_query($this->conn, $update_query)) {
	                return true;
	        	}
	        	if (!mysqli_query($this->conn, $update_query)) {
		    		throw new Exception();
		    	}
	    } catch(Exception $e) {
	    	echo "Error: " . $update_query . "<br>" . mysqli_error($this->conn);
	    }
	}
	public function readRecord($id)
	{
		try {
				$read_query = "SELECT * from Student s where s.id={$id}";
				$result = $this->conn->query($read_query); 
				$studentData = $result->fetch_assoc();
	        	return $studentData;
        } catch(Exception $e) {
	    	echo "Error: " . $read_query.  "<br>" . mysqli_error($this->conn);
	    }
	}
	public function readStudentLeaveRecord($id)
	{
		try {
				$read_query = "SELECT * from studentLeave sl where sl.id = {$id}";
				$result = $this->conn->query($read_query); 
				$studentData = $result->fetch_assoc();
	        	return $studentData;
			} catch(Exception $e) {
	    	echo "Error: " . $read_query.  "<br>" . mysqli_error($this->conn);
	    }
	}
	public function readRecordOfIndividualStudent($id)
	{
		try {
				$read_query = "SELECT * from Student s left outer JOIN studentLeave sl on s.id = sl.student_id where s.id = {$id}";
				$resultOfReadRecordOfIndividualStudent = $this->conn->query($read_query); 
				return $resultOfReadRecordOfIndividualStudent;
		} catch(Exception $e) {
	    	echo "Error: " . $read_query.  "<br>" . mysqli_error($this->conn);
	    }
	}
	public function viewRecords()
	{
		try {
				$view_query = "SELECT * from Student";
				$result = $this->conn->query($view_query);
				$studentRecords = array();
				while ($studentRecord = $result->fetch_assoc()) {
					$studentRecords[] = $studentRecord;
			}
			return $studentRecords;
		} catch(Exception $e) {
	    	echo "Error: " . $view_query.  "<br>" . mysqli_error($this->conn);
	    }
	}
	public function studentLeave($inputData)
	{
		$startDate = $inputData['startDate'];
		$endDate = $inputData['endDate'];
		$studentLeave = $inputData['studentLeave'];
		$student_id = $inputData['id'];
		$errorMessage = "";
		try {
				$insert_query = "INSERT INTO studentLeave(student_id, startDate, endDate, studentLeave) 
				VALUES($student_id, '$startDate', '$endDate', $studentLeave)";
				if (mysqli_query($this->conn, $insert_query)) {
	                return true;
	            } if (!mysqli_query($this->conn, $insert_query)) {
		    		throw new Exception();
		    	}
	    } catch(Exception $e) {
	    	echo "Error: " . $insert_query. "<br>" . mysqli_error($this->conn);
	    }
	}
	public function viewRecordsOfLeaveTable()
	{
		try {
				$view_query = "SELECT * FROM studentLeave";
				$result = $this->conn->query($view_query);
				$studentLeaveRecords = array();
				while ($studentLeaveRecord = $result->fetch_assoc()) {
					$studentLeaveRecords[] = $studentLeaveRecord;
				}
				return $studentLeaveRecords;
		}  catch(Exception $e) {
	    	echo "Error: " . $view_query. "<br>" . mysqli_error($this->conn);
	    }
	}
}    
?>