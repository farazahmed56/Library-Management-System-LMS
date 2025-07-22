<?php
include 'db_connect.php';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = (int)$_POST['book_id'];
    $student_name = $conn->real_escape_string($_POST['student_name']);
    $issue_date = date('Y-m-d'); 

    $conn->begin_transaction();

    try {
        // Checking availability
        $check_sql = "SELECT quantity FROM books WHERE id = $book_id AND quantity > 0";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            // Insert into issued_books table
            $issue_sql = "INSERT INTO issued_books (book_id, student_name, issue_date) VALUES ($book_id, '$student_name', '$issue_date')";
            $conn->query($issue_sql);

            // minus book
            $update_sql = "UPDATE books SET quantity = quantity - 1 WHERE id = $book_id";
            $conn->query($update_sql);

            // Commit transaction
            $conn->commit();
            $message = "<div class='message success'>Book issued successfully to " . htmlspecialchars($student_name) . ".</div>";
        } else {
            $message = "<div class='message error'>This book is currently not available.</div>";
        }
    } catch (mysqli_sql_exception $exception) {
        $conn->rollback();
        $message = "<div class='message error'>Error issuing book: " . $exception->getMessage() . "</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Book - LMS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Issue a Book</h2>
    <?php echo $message; ?>
    <form action="issue_book.php" method="post">
        <div class="form-group">
            <label for="book_id">Select Book:</label>
            <select id="book_id" name="book_id" required>
                <option value="">-- Choose a Book --</option>
                <?php
                // Fetch books that are available (quantity > 0)
                $sql = "SELECT id, title, author FROM books WHERE quantity > 0";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['title']) . " by " . htmlspecialchars($row['author']) . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="student_name">Student Name:</label>
            <input type="text" id="student_name" name="student_name" required>
        </div>
        <button type="submit" class="form-btn">Issue Book</button>
    </form>
    <a href="index.html" class="back-link">Back to Dashboard</a>
</div>
</body>
</html>
<?php $conn->close(); ?>
