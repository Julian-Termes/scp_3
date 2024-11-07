<?php
include 'db_connect.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Get the ID from the URL and check if it exists
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    die("Invalid ID.");
}

$result = $conn->query("SELECT * FROM scp WHERE id=$id");
if ($result->num_rows == 0) {
    die("Record not found.");
}

$row = $result->fetch_assoc();

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject = $_POST['subject'];
    $class = $_POST['class'];
    $description = $_POST['description'];
    $containment = $_POST['containment'];
    $discovery = $_POST['discovery'];
    $image = $_POST['image'];

    // Use a prepared statement to prevent SQL injection
    $sql = $conn->prepare("UPDATE scp SET subject=?, class=?, description=?, containment=?, discovery=?, image=? WHERE id=?");
    $sql->bind_param("ssssssi", $subject, $class, $description, $containment, $discovery, $image, $id);

    if ($sql->execute()) {
        echo "<script>alert('Record updated successfully'); window.location.href='index.php';</script>";
    } else {
        echo "Error updating record: " . $sql->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit SCP Record</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        body {
            font-family: "Courier New", Courier, monospace;
            background-color: #2e2e2e;
            color: #ffffff;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #333;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #b30000;
        }
        .form-group label {
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
            font-size: 18px;
        }
        .form-control {
            background-color: #444;
            color: #fff;
            border: 1px solid #555;
            padding: 20px;
            font-size: 18px;
            margin-bottom: 20px;
            width: 100%;
        }
        .form-control:focus {
            border-color: #b30000;
            outline: none;
            box-shadow: 0 0 5px rgba(179, 0, 0, 0.5);
        }
        textarea.form-control {
            resize: vertical;
            overflow: hidden;
            min-height: 150px;
        }
        button {
            width: 100%;
            font-size: 20px;
            background-color: #b30000;
            border: none;
            padding: 15px;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #ff4d4d;
        }
    </style>
    <script>
        // Auto-resize textarea based on content
        document.addEventListener("DOMContentLoaded", function() {
            const textareas = document.querySelectorAll("textarea");
            textareas.forEach(textarea => {
                textarea.style.height = textarea.scrollHeight + "px";
                textarea.addEventListener("input", function() {
                    textarea.style.height = "auto";
                    textarea.style.height = textarea.scrollHeight + "px";
                });
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h2>Edit SCP Record</h2>
        <form method="POST">
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" class="form-control" id="subject" name="subject" value="<?php echo htmlspecialchars($row['subject']); ?>" required>
            </div>
            <div class="form-group">
                <label for="class">Class</label>
                <input type="text" class="form-control" id="class" name="class" value="<?php echo htmlspecialchars($row['class']); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="6" required><?php echo htmlspecialchars($row['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="containment">Containment</label>
                <textarea class="form-control" id="containment" name="containment" rows="6" required><?php echo htmlspecialchars($row['containment']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="discovery">Discovery</label>
                <textarea class="form-control" id="discovery" name="discovery" rows="6" required><?php echo htmlspecialchars($row['discovery']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image URL</label>
                <input type="text" class="form-control" id="image" name="image" value="<?php echo htmlspecialchars($row['image']); ?>" required>
            </div>
            <button type="submit" class="mt-3">Update Record</button>
        </form>
    </div>
</body>
</html>

<?php $conn->close(); ?>



