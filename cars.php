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


| **Re-run the Page** | Save `cars.php` and refresh `http://localhost/lab07/cars.php`. If a **specific error message** now appears (e.g., "Call to undefined function mysqli\_connect"), it will point to the exact problem. |

### 3. Check Database Credentials (`settings.php` Issues)

The connection might be failing because the PHP script is using incorrect login information.

| Issue | Action to Check in `settings.php` |
| :--- | :--- |
| **Incorrect Database Name** | Double-check that `$sql_db` exactly matches the database name you created, which is **`exhibition_db`**. (PHP is case-sensitive on some systems!) |
| **Incorrect Filename** | Make sure you are using `require_once "settings.php";` in `cars.php`, and that the filename in your file system is **`settings.php`** (not `Settings.php` or `settings.php.txt`). |
| **Wrong Host/User/Pwd** | [cite_start]Verify your settings are still the XAMPP defaults: `$host = "localhost";`, `$user = "root";`, and `$pwd = "";` (empty string)[cite: 700, 706, 707]. |

### 4. Check Table/Column Names (`cars.php` Query Issues)

If the connection is successful but the query fails, the code after `if ($conn)` will skip all output.

| Issue | Action to Check in `cars.php` |
| :--- | :--- |
| **Incorrect Table Name** | Verify your query uses the correct table name: `$query = "SELECT * FROM cars";`. |
| **Mismatched Column Names** | Ensure the column names used in your `while` loop (Task 7) exactly match the names defined in your SQL table: `car_id`, `make`, `model`, `price`, `yom`. [cite_start]PHP is case-sensitive for array keys[cite: 472]. |

**Example of where to look:**

```php
// If this line fails, the script jumps to the 'else' block
$conn = @mysqli_connect ($host,$user,$pwd,$sql_db); 
    
if ($conn) { // Execution continues here ONLY if the connection works.
    // ...
    // If the table is spelled wrong, the script also skips output.
    $result = mysqli_query ($conn, $query); 
    
    if ($result && mysqli_num_rows($result) > 0) 
    // ...
} else { 
    // If you see this, the problem is in settings.php or XAMPP services.
    echo "<p>Unable to connect to the database.</p>"; 
}