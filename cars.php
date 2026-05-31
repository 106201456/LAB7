<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Car Dealership Inventory</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h1>Used Car Inventory</h1>

<?php
    // Step 1: Connect to the database
    require_once "settings.php";    // Loads $host, $user, $pwd, $sql_db
    
    // @mysqli_connect suppresses error messages for security/clean output [cite: 613]
    $conn = @mysqli_connect ($host,$user,$pwd,$sql_db); 
    
    if ($conn) { // Check if connection was successful [cite: 1275]
        
        // Step 2: Create my SQL query
        $query = "SELECT * FROM cars";
        
        // Step 3: Execute my SQL query
        $result = mysqli_query ($conn, $query);

        // Step 4: Did it work? (Check if the query ran and returned data) [cite: 1279]
        if ($result && mysqli_num_rows($result) > 0) 
        {
            // Display results in an HTML table
            echo "<br>
            <table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Price ($)</th>
                    <th>Year</th>
                </tr>";
            
            // Loop through the results (Task 7 Snippet)
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['car_id'] . "</td>";
                echo "<td>" . $row['make'] . "</td>";
                echo "<td>" . $row['model'] . "</td>";
                echo "<td>" . number_format($row['price'], 0) . "</td>"; // Added formatting
                echo "<td>" . $row['yom'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            
            // Free the memory associated with the result pointer
            mysqli_free_result($result); 
        } 
        else {
            // Display message if no records exist (or query failed)
            echo "<p>There are no cars to display.</p>";
        }

		// Step 5: Close connection [cite: 1283]
		mysqli_close ($conn);
	} else {
		// Connection failed error message [cite: 1288]
		echo "<p>Unable to connect to the database.</p>";
	}
?>	
</body>
</html>


