<!DOCTYPE html>
<html>
<head>
  <title>Car Search</title>
</head>
<body>
  <h1>Search Car Inventory</h1>
  <form method="GET" action="search_result.php">
    <label for="model_search">Search Car Model:</label>
    <input type="text" name="model" id="model_search" required>
    <input type="submit" value="Search">
  </form>
  <p><a href="cars.php">View All Inventory</a></p>
</body>
</html>