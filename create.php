<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject = $_POST['subject'];
    $class = $_POST['class'];
    $description = $_POST['description'];
    $containment = $_POST['containment'];
    $discovery = $_POST['discovery'];
    $image = $_POST['image'];

    $sql = $conn->prepare("INSERT INTO scp (subject, class, description, containment, discovery, image) VALUES (?, ?, ?, ?, ?, ?)");
    $sql->bind_param("ssssss", $subject, $class, $description, $containment, $discovery, $image);

    if ($sql->execute()) {
        echo "<script>alert('New record created successfully'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $sql->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add SCP Record</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
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
        .home-button {
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            color: #ffffff;
            background-color: #b30000;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .home-button:hover {
            background-color: #ff4d4d;
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
        }
        .form-control:focus {
            border-color: #b30000;
            outline: none;
            box-shadow: 0 0 5px rgba(179, 0, 0, 0.5);
        }
        textarea.form-control {
            resize: vertical;
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
</head>
<body>
    <div class="container">
        <a href="index.php" class="home-button">Home</a>
        <h2>Add New SCP Record</h2>
        <form method="POST">
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" class="form-control" id="subject" name="subject" required>
            </div>
            <div class="form-group">
                <label for="class">Class</label>
                <input type="text" class="form-control" id="class" name="class" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="6" required></textarea>
            </div>
            <div class="form-group">
                <label for="containment">Containment</label>
                <textarea class="form-control" id="containment" name="containment" rows="6" required></textarea>
            </div>
            <div class="form-group">
                <label for="discovery">Discovery</label>
                <textarea class="form-control" id="discovery" name="discovery" rows="6" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image URL</label>
                <input type="text" class="form-control" id="image" name="image" required>
            </div>
            <button type="submit" class="mt-3">Submit</button>
        </form>
    </div>
</body>
</html>



