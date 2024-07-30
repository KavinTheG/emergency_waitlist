<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");


global $conn; 

function connectDB() {
    global $conn;

    $host = "localhost";
    $dbname = "csi3140";
    //$user = "postgres";
    $port = "5432";

    //$conn = pg_connect("host=$host dbname=$dbname user=$user port=$port");
    conn = pg_connect("host=$host dbname=$dbname port=$port");
    if (!$conn) {
        echo "Error: Unable to connect to database.\n";
        exit;
    }
}

function getListOfPatients() {
    global $conn;

    // Query to get all patients
    $query = "SELECT * FROM patients";
    $result = pg_query($conn, $query);

    if (!$result) {
        echo "Error: Unable to execute query.\n";
        exit;
    }

    $patients = array();
    while ($row = pg_fetch_assoc($result)) {
        $patients[] = $row;
    }

    return $patients;
}


function checkStaffIdValidity($staffid, $password) {
    global $conn;

    // Query to check if staffid exists
    $query = "SELECT COUNT(*) FROM staff WHERE staffid = $1 AND password = $2";
    $result = pg_query_params($conn, $query, array($staffid, $password));

    if (!$result) {
        echo "Error: Unable to execute query.\n";
        exit;
    }

    $count = pg_fetch_result($result, 0, 0);

    return $count > 0;
}

function checkUserIdValidity($name, $userid) {
    global $conn;

    // Query to check if userid exists
    $query = "SELECT COUNT(*) FROM patients WHERE name = $1 AND userid = $2";
    $result = pg_query_params($conn, $query, array($name, $userid));

    if (!$result) {
        echo "Error: Unable to execute query.\n";
        exit;
    }

    $count = pg_fetch_result($result, 0, 0);

    return $count > 0;
}

function returnApproxWaitTime($userid) {
    global $conn;

    // Query to get the approximate wait time for a specific user
    $query = "SELECT approx_wait_time FROM patients WHERE userid = $1";
    $result = pg_query_params($conn, $query, array($userid));

    if (!$result) {
        echo "Error: Unable to execute query.\n";
        exit;
    }

    $row = pg_fetch_assoc($result);

    return isset($row['approx_wait_time']) ? $row['approx_wait_time'] : null;
}

function treatPatient($userid, $name) {
    global $conn;

    $query = "DELETE FROM patients WHERE userid = $1 AND name = $2";
    $result = pg_query_params($conn, $query, array($userid, $name));

    return pg_affected_rows($result) != 0;
}

function subtractWaitTime() {
    global $conn;

    // Query to subtract 5 minutes from approx_wait_time for all patients
    $query = "
    UPDATE patients
    SET approx_wait_time = approx_wait_time - 5
    WHERE approx_wait_time > 5";

    $result = pg_query($conn, $query);

    if (!$result) {
        die("Error: Unable to execute query to subtract wait time.\n");
    }

    echo "Wait times updated successfully.\n";
}


function repopulatePatientsTable() {
    global $conn;

    $query = "
    INSERT INTO patients (userid, name, severity_of_injury, approx_wait_time) VALUES
    ('ABC', 'John Doe', 'Low', 30),
    ('DEF', 'Jane Smith', 'Medium', 45),
    ('GHI', 'Alice Johnson', 'High', 15),
    ('JKL', 'Bob Brown', 'Low', 20),
    ('MNO', 'Carol White', 'High', 10),
    ('PQR', 'David Lee', 'Medium', 40),
    ('STU', 'Emma Brown', 'Low', 25),
    ('VWX', 'George Clark', 'High', 5),
    ('YZA', 'Hannah White', 'Medium', 35),
    ('BCD', 'Ivy Green', 'Low', 50)
    ON CONFLICT (userid) DO NOTHING";

    $result = pg_query($conn, $query);

    if (!$result) {
        die("Error: Unable to execute query to repopulate patients table.\n");
    }

    echo "Patients table repopulated successfully.\n";
}

// Connect to the database
connectDB();

/*

// Get list of patients
$patients = getListOfPatients();
print_r($patients);

// Check staff ID validity
$staffid = 'S01';
$isValid = checkStaffIdValidity($staffid);
echo $isValid ? "Staff ID is valid.\n" : "Staff ID is not valid.\n";

// Get approximate wait time for a specific user
$userid = 'ABC';
$waitTime = returnApproxWaitTime($userid);
echo isset($waitTime) ? "Approximate wait time: $waitTime minutes.\n" : "User not found or wait time not available.\n";


*/

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'getPatients':
        $patients = getListOfPatients();
        echo json_encode(['patients' => $patients]);
        break;
    case 'checkStaffId':
        $staffid = $_POST['staffid'] ?? '';
        $password = $_POST['password'] ?? '';

        $isValid = checkStaffIdValidity($staffid, $password);
        echo json_encode(['valid' => $isValid]);
        break;
    case 'checkUserId':
        $name = $_POST['name'] ?? '';
        $userid = $_POST['userid'] ?? '';
        $isValid = checkUserIdValidity($name, $userid);
        echo json_encode(['valid' => $isValid]);
        break;
    case 'getWaitTime':
        $userid = $_POST['userid'] ?? '';
        $waitTime = returnApproxWaitTime($userid);
        echo json_encode(['waitTime' => $waitTime]);
        break;
    case 'treatPatient':
        $name = $_POST['name'] ?? '';
        $userid = $_POST['userid'] ?? '';
        $isValid = treatPatient($userid, $name);
        if ($isValid) {
            subtractWaitTime();
        }
        echo json_encode(['valid' => $isValid]);
        break;
    case 'repopulate':
        repopulatePatientsTable();
    default:
        echo json_encode(['error' => 'Invalid action']);
        break;
}



?>
