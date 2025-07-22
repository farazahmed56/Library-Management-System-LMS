<?php
include 'db_connect.php';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $issued_id = (int)$_POST['issued_id'];
    $return_date = date('Y-m-d');

    $conn->begin_transaction();

    try {
        // Get book_id from issued_books table
        $result = $conn->query("SELECT book_id FROM issued_books WHERE id = $issued_id AND return_date IS NULL");
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $book_id = $row['book_id'];

            // Update return date in issued_books table
            $update_issue = "UPDATE issued_books SET return_date = '$return_date' WHERE id = $issued_id";
            $conn->query($update_issue);

            // Increment book quantity in books table
            $update_book = "UPDATE books SET quantity = quantity + 1 WHERE id = $book_id";
            $conn->query($update_book);

            $conn->commit();
            $message = "<div class='message success'>Book returned successfully.</div>";
        } else {
             $message = "<div class='message error'>Invalid issue record or book already returned.</div>";
        }
    } catch (mysqli_sql_exception $exception) {
        $conn->rollback();
        $message = "<div class='message error'>Error returning book: " . $exception->getMessage() . "</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Book - LMS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Return a Book</h2>
    <?php echo $message; ?>
    <form action="return_book.php" method="post">
        <div class="form-group">
            <label for="issued_id">Select Issued Book to Return:</label>
            <select id="issued_id" name="issued_id" required>
                <option value="">-- Choose a Book --</option>
                <?php



                // Fetch books that are currently issued 
                $sql = "SELECT ib.id, b.title, ib.student_name 
                        FROM issued_books ib 
                        JOIN books b ON ib.book_id = b.id 
                        WHERE ib.return_date IS NULL";


                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['title']) . " (Issued to: " . htmlspecialchars($row['student_name']) . ")</option>";
                    }
                }
                ?>



            </select>
        </div>
        <button type="submit" class="form-btn">Return Book</button>
    </form>
    <a href="index.html" class="back-link">Back to Dashboard</a>

</div>
</body>
</html>
<?php $conn->close(); ?>
