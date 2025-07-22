<?php
include 'db_connect.php';

$message = ''; 

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['title']) && !empty($_POST['author']) && !empty($_POST['publication_year']) && !empty($_POST['isbn']) && !empty($_POST['quantity'])) {
        
        $title = $conn->real_escape_string($_POST['title']);
        $author = $conn->real_escape_string($_POST['author']);
        $publication_year = (int)$_POST['publication_year'];
        $isbn = $conn->real_escape_string($_POST['isbn']);
        $quantity = (int)$_POST['quantity'];

        
        $sql = "INSERT INTO books (title, author, publication_year, isbn, quantity) VALUES ('$title', '$author', $publication_year, '$isbn', $quantity)";

        if ($conn->query($sql) === TRUE) {
            $message = "<div class='message success'>New book added successfully!</div>";
        } else {
            $message = "<div class='message error'>Error: " . $sql . "<br>" . $conn->error . "</div>";
        }
    } else {
        $message = "<div class='message error'>Please fill in all fields.</div>";
    }
}

$conn->close();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Book - LMS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Add a New Book</h2>

        <?php echo $message;?>

        <form action="add_book.php" method="post">
            <div class="form-group">
                <label for="title">Book Title:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" id="author" name="author" required>
            </div>
            
            <div class="form-group">
                <label for="publication_year">Publication Year:</label>
                <input type="number" id="publication_year" name="publication_year" required>
            </div>
            <div class="form-group">
                <label for="isbn">ISBN:</label>
                <input type="text" id="isbn" name="isbn" required>
            
            </div>


             <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" required min="1">
            
            </div>

            <button type="submit" class="form-btn">Add Book</button>
        </form>
        <a href="index.html" class="back-link">Back to Dashboard</a>


    </div>




</body>
</html>
