<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - LMS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Search Results</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publication Year</th>
                    <th>ISBN</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db_connect.php';

                
                if (isset($_GET['query']) && !empty($_GET['query'])) {
                    $search_query = $conn->real_escape_string($_GET['query']);
                    
                    // query to search for books by title or author
                    $sql = "SELECT * FROM books WHERE title LIKE '%$search_query%' OR author LIKE '%$search_query%'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
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
                        echo "<tr><td colspan='6'>No books found matching your search criteria.</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Please enter a search term.</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
        <a href="index.html" class="back-link">Back to Dashboard</a>
    </div>
</body>
</html>
