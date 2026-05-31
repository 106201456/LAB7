<?php
require_once("settings.php"); // Includes connection ($conn)

echo "<!DOCTYPE html>
<html>
<head>
  <title>Search Results</title>
</head>
<body>
  <h1>Car Search Results</h1>";

if (isset($_GET['model']) && $conn) {
    // 1. Sanitize Input: Crucial step to prevent SQL injection [cite: 310]
    $model_search = mysqli_real_escape_string($conn, $_GET['model']);

    // 2. Build Query: The LIKE '%$model%' finds any model containing the search term
    $sql = "SELECT * FROM cars WHERE model LIKE '%$model_search%'";
    
    // 3. Execute Query
    $result = mysqli_query($conn, $sql);

    // 4. Check Result
    if ($result && mysqli_num_rows($result) > 0) {
        // Results found
        echo "<p>Found " . mysqli_num_rows($result) . " match(es) for: <strong>" . htmlspecialchars($model_search) . "</strong></p>";
        echo "<table border='1' cellpadding='5'>
                <tr><th>ID</th><th>Make</th><th>Model</th><th>Price</th><th>Year</th></tr>";
        
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['car_id'] . "</td>";
            echo "<td>" . $row['make'] . "</td>";
            echo "<td>" . $row['model'] . "</td>";
            echo "<td>" . number_format($row['price'], 0) . "</td>";
            echo "<td>" . $row['yom'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        mysqli_free_result($result); 
    } else {
        // No results found
        echo "<p>🚫 No matching cars found for model: <strong>" . htmlspecialchars($model_search) . "</strong>.</p>";
    }
} else {
    // No model parameter or connection error
    if (!$conn) {
        echo "<p>Unable to connect to the database.</p>";
    } else {
        echo "<p>Please enter a model to search.</p>";
    }
}

// 5. Close Connection
if ($conn) {
    mysqli_close($conn);
}
echo "<p><a href='search_form.php'>New Search</a></p>
      <p><a href='cars.php'>View All Inventory</a></p>
      </body></html>";
?>
