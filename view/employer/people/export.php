<?php        	

/*******EDIT LINES 3-8*******/
$DB_Server = "localhost"; //MySQL Server    
$DB_Username = "root"; //MySQL Username     
$DB_Password = "";             //MySQL Password     
$DB_DBName = "caph";         //MySQL Database Name  
// $DB_TBLName = "person_information"; //MySQL Table Name   
$filename = "excelfilename";         //File Name
/*******YOU DO NOT NEED TO EDIT ANYTHING BELOW THIS LINE*******/    
//create MySQL connection   
$con = new mysqli($DB_Server, $DB_Username, $DB_Password, $DB_DBName);

if ($con->connect_error) {  //error check
    die("Connection failed: " . $con->connect_error);
}
else
{

}

$user_id = $_GET['user_id'];

// $user_id = 32;

$DB_TBLName = "person_information"; 
$filename = randChars();  //your_file_name
$file_ending = "xlsx";   //file_extention

header("Content-Type: application/xlsx");    
header("Content-Disposition: attachment; filename=$filename.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");

$sep = "\t";

$annualID = 1;
$sickID = 2;
$Maternity = 3;
$Family = 4;
$Unpaid = 5;
$Study = 6;

$numberOfAnnualDaysTaken = 0;
$numberOfSickDaysTaken = 0;
$numberOfFamilyDaysTaken = 0;
$numberOfMaternity = 0;
$numberOfStudyDaysTaken = 0;
$numberOfUnpaidDaysTaken = 0;

$allLeaveAppliedFor = 0;
$approved = 0;
$decline = 0;
$cancel = 0;

$all = "SELECT * FROM `leaveapplications` WHERE `EmployeeId` = $user_id";
$allLeaveAppliedFor =  mysqli_num_rows($con->query($all));

$ap = "SELECT * FROM `leaveapplications` WHERE `EmployeeId` = $user_id AND `Approved` = 1";
$approved = mysqli_num_rows($con->query($ap));

$decline = mysqli_num_rows($con->query("SELECT * FROM `leaveapplications` WHERE `EmployeeId` = $user_id AND `Approved` = 2"));

$cancel = mysqli_num_rows($con->query("SELECT * FROM `leaveapplications` WHERE `EmployeeId` = $user_id AND `Approved` = 3"));

// echo($decline);
// echo($cancel);

// $leave_information = "SELECT * FROM `leave_information`";
// $li = $con->query($leave_information);
// while ($row = mysqli_fetch_assoc($li)) {
// 	// $annualID = $row["leave_id"];
// 	// $sickID = $row["leave_id"];
// }

$sql="SELECT * FROM `caphusers` WHERE `user_id` = $user_id"; 
$result = $con->query($sql);
$annualLeave = "SELECT * FROM `leaveapplications` WHERE `EmployeeId` = $user_id AND `LeaveId` = $annualID AND `Approved` = 1";
$an = $con->query($annualLeave);
$data = array();
$acount = 0;
while ($row = mysqli_fetch_assoc($an)) {
	$acount++;
	array_push($data, $row);
}

// print_r($data);

for ($i=0; $i < $acount; $i++) { 
	$numberOfAnnualDaysTaken += diffInDays($data[$i]["StartDate"], $data[$i]["EndDate"]);
}

// echo($numberOfAnnualDaysTaken);
$sickLeave = "SELECT * FROM `leaveapplications` WHERE `EmployeeId` = $user_id AND `LeaveId` = $sickID AND `Approved` = 1";
$si = $con->query($sickLeave);
$data = array();
$scount = 0;
while ($row = mysqli_fetch_assoc($si)) {
	$scount++;
	array_push($data, $row);
}

for ($i=0; $i < $scount; $i++) { 
	$numberOfSickDaysTaken += diffInDays($data[$i]["StartDate"], $data[$i]["EndDate"]);
}

// echo($numberOfSickDaysTaken);

$familyLeave = "SELECT * FROM `leaveapplications` WHERE `EmployeeId` = $user_id AND `LeaveId` = $Family AND `Approved` = 1";
$fi = $con->query($familyLeave);
$data = array();
$fcount = 0;
while ($row = mysqli_fetch_assoc($fi)) {
	$fcount++;
	array_push($data, $row);
}

for ($i=0; $i < $fcount; $i++) { 
	$numberOfFamilyDaysTaken += diffInDays($data[$i]["StartDate"], $data[$i]["EndDate"]);
}
// echo($numberOfFamilyDaysTaken);

$maternityLeave = "SELECT * FROM `leaveapplications` WHERE `EmployeeId` = $user_id AND `LeaveId` = $Maternity AND `Approved` = 1";
$ma = $con->query($maternityLeave);
$data = array();
$mcount = 0;
while ($row = mysqli_fetch_assoc($ma)) {
 	$mcount++;
 	array_push($data, $row);
 }

for ($i=0; $i < $mcount; $i++) { 
	$numberOfMaternity += diffInDays($data[$i]["StartDate"], $data[$i]["EndDate"]);
}

// echo($numberOfMaternity);

$studyLeave = "SELECT * FROM `leaveapplications` WHERE `EmployeeId` = $user_id AND `LeaveId` = $Study AND `Approved` = 1";
$st = $con->query($studyLeave);
$data = array();
$scount = 0;
while ($row = mysqli_fetch_assoc($st)) {
	$scount++;
	array_push($data, $row);
}

for ($i=0; $i < $scount; $i++) { 
	$numberOfStudyDaysTaken += diffInDays($data[$i]["StartDate"], $data[$i]["EndDate"]);
}

// echo($numberOfStudyDaysTaken);

$unpaidLeave = "SELECT * FROM `leaveapplications` WHERE `EmployeeId` = $user_id AND `LeaveId` = $Unpaid AND `Approved` = 1";
$un = $con->query($unpaidLeave);
$data = array();
$ucount = 0;

while ($row = mysqli_fetch_assoc($un)) {
	$ucount++;
	array_push($data, $row);
}

for ($i=0; $i < $ucount; $i++) { 
	$numberOfUnpaidDaysTaken += diffInDays($data[$i]["StartDate"], $data[$i]["EndDate"]);
}

// echo($numberOfUnpaidDaysTaken);

echo '<table border="1">';
//make the column headers what you want in whatever order you want
echo '<tr><th>Employee Number</th><th>Employee Full Name</th><th>Line Manager</th><th>Hire Date</th><th>Race</th><th>Gender</th><th>Disability</th><th>Annual Leave</th><th>Sick Leave</th>
<th>Family Responsibility</th><th>Maternity</th><th>Study</th><th>Unpaid</th>
<th>In Lieu of Overtime</th><th>Other</th><th>All leave applied for</th><th>Leaves Approved</th><th>Leaves Decline</th><th>Leaves Cancelled</th>
</tr>';

//loop the query data to the table in same order as the headers
while ($row = mysqli_fetch_assoc($result)){
    echo "<tr><td>".$row['EmployeeNumber']."</td><td>".$row["Name"]." ".$row["Surname"]."<td>N&frasl;A</td><td>".$row["HireDate"]."</td><td>".$row["Race"]."</td><td>".$row["Gender"] ."</td><td>N&frasl;A</td><td>".$numberOfAnnualDaysTaken."&frasl;22</td><td>".$numberOfSickDaysTaken."&frasl;15</td><td>".$numberOfFamilyDaysTaken."&frasl;8</td><td>".$numberOfMaternity."&frasl;18</td><td>".$numberOfStudyDaysTaken."&frasl;5</td><td>".$numberOfUnpaidDaysTaken."&frasl;3</td><td>N&frasl;A</td><td>N&frasl;A</td><td>".$allLeaveAppliedFor."</td><td>".$approved."</td><td>".$decline."</td><td>".$cancel."</tr>";
}
echo '</table>';

print("\n");    


function diffInDays($startDate, $endDate){
	 $begin = strtotime($startDate);
  $end = strtotime($endDate);
  if ($begin > $end)
    {
    echo "startdateisinthefuture!";
    return false;
    }
    else
    {
    $no_days = 0;
    $weekends = 0;
    while ($begin <= $end)
      {
      $no_days++; // no of days in the given interval
      $what_day = date("N", $begin);
      if ($what_day > 5)
        { // 6 and 7 are weekend days
        $weekends++;
        };
      $begin+= 86400; // +1 day
      };
    $working_days = $no_days - $weekends;
    return $working_days;
    }
}

function randChars($len = 10){
  $charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
  $base = strlen($charset);
  $result = 'CapH';

  $now = explode(' ', microtime())[1];
  while ($now >= $base){
    $i = $now % $base;
    $result = $charset[$i] . $result;
    $now /= $base;
  }
  return substr($result, -10);
}