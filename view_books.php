<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books - LMS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Complete Book Library</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publication Year</th>
                    <th>ISBN</th>
                    <th>Quantity Available</th>
                </tr>
            </thead>
            <tbody>
                <?php
        
                include 'db_connect.php';

                // fetching all books
                $sql = "SELECT id, title, author, publication_year, isbn, quantity FROM books";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    
                    // Output of each rom
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . htmlspecialchars($row["title"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["author"]) . "</td>";
                        echo "<td>" . $row["publication_year"] . "</td>";
                        echo "<td>" . htmlspecialchars($row["isbn"]) . "</td>";
                        echo "<td>" . $row["quantity"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No books found in the library.</td></tr>";
                }
                
                $conn->close();
                ?>
            </tbody>
        </table>
        
        <a href="index.html" class="back-link">Back to Dashboard</a>
    </div>
</body>
</html>
