<?php

global $conn; 

function connectDB() {
    global $conn;

    $host = "localhost";
    $dbname = "CSI3140";
    $user = "postgres";
    $port = "5432";

    $conn = pg_connect("host=$host dbname=$dbname user=$user port=$port");

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

function checkStaffIdValidity($staffid) {
    global $conn;

    // Query to check if staffid exists
    $query = "SELECT COUNT(*) FROM staff WHERE staffid = $1";
    $result = pg_query_params($conn, $query, array($staffid));

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

// Connect to the database
connectDB();

// Example usage of functions

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

?>
