<?php
include 'db_connect.php';
$message = '';
$edit_mode = false;
$book_to_edit = null;



// Delete 
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "DELETE FROM books WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        $message = "<div class='message success'>Book deleted successfully.</div>";
    } else {
        $message = "<div class='message error'>Error deleting record: " . $conn->error . "</div>";
    }
}


// Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $publication_year = (int)$_POST['publication_year'];
    $isbn = $conn->real_escape_string($_POST['isbn']);
    $quantity = (int)$_POST['quantity'];

    $sql = "UPDATE books SET title='$title', author='$author', publication_year=$publication_year, isbn='$isbn', quantity=$quantity WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        $message = "<div class='message success'>Book updated successfully.</div>";
    } else {
        $message = "<div class='message error'>Error updating record: " . $conn->error . "</div>";
    }
}



// Edit
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $edit_mode = true;
    $id = (int)$_GET['id'];
    $result = $conn->query("SELECT * FROM books WHERE id=$id");
    if ($result->num_rows == 1) {
        $book_to_edit = $result->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update/Delete Book - LMS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Manage Books</h2>
    <?php echo $message; ?>

    <?php if ($edit_mode && $book_to_edit): ?>
        <h3>Editing Book: <?php echo htmlspecialchars($book_to_edit['title']); ?></h3>
        <form action="update_delete_book.php" method="post">
            <input type="hidden" name="id" value="<?php echo $book_to_edit['id']; ?>">
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($book_to_edit['title']); ?>" required>
            </div>
            <div class="form-group">
                <label>Author</label>
                <input type="text" name="author" value="<?php echo htmlspecialchars($book_to_edit['author']); ?>" required>
            </div>
            <div class="form-group">
                <label>Publication Year</label>
                <input type="number" name="publication_year" value="<?php echo $book_to_edit['publication_year']; ?>" required>
            </div>
            <div class="form-group">
                <label>ISBN</label>
                <input type="text" name="isbn" value="<?php echo htmlspecialchars($book_to_edit['isbn']); ?>" required>
            </div>
            <div class="form-group">
                <label>Quantity</label>
                <input type="number" name="quantity" value="<?php echo $book_to_edit['quantity']; ?>" required>
            </div>
            <button type="submit" name="update" class="form-btn update">Update Book</button>
        </form>
    <?php endif; ?>

    <h3>List of All Books</h3>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT id, title, author FROM books";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["title"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["author"]) . "</td>";
                    echo "<td>
                            <a href='update_delete_book.php?action=edit&id=" . $row['id'] . "' class='form-btn update'>Update</a>
                            <a href='update_delete_book.php?action=delete&id=" . $row['id'] . "' class='form-btn delete' onclick='return confirm(\"Are you sure you want to delete this book?\");'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No books found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <a href="index.html" class="back-link">Back to Dashboard</a>
</div>
</body>
</html>
<?php $conn->close(); ?>
