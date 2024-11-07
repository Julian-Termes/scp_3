<?php
include 'db_connect.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Fetch all SCP records from the database
$sql = "SELECT id, subject, image FROM scp";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SCP Gallery</title>
    <link rel="stylesheet" href="styles/styles.css">
    <style>
        body {
            font-family: "Courier New", Courier, monospace;
            background-image: url('images/Modern room.webp');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            padding: 20px;
            color: #fff;
        }
        .navbar {
            background-color: #333;
            padding: 10px;
            color: #fff;
            display: flex;
            justify-content: space-between;
        }
        .nav-list {
            list-style: none;
            display: flex;
            gap: 20px;
        }
        .nav-item {
            display: inline;
        }
        .nav-item a {
            color: #fff;
            text-decoration: none;
            padding: 8px 15px;
            transition: background-color 0.3s;
        }
        .nav-item a:hover {
            background-color: #555;
        }
        .container {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 20px;
        }
        .grid-item {
            background-color: #222;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        .grid-item img {
            width: 100%;
            height: 200px; /* Ensures uniform image size */
            object-fit: cover; /* Ensures images maintain aspect ratio and fit the container */
            border-radius: 5px;
        }
        .grid-item h3 {
            margin-top: 10px;
            color: #fff;
        }
        .action-links {
            margin-top: 10px;
            display: flex;
            justify-content: space-around;
        }
        .action-links a {
            color: #b30000;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }
        .action-links a:hover {
            color: #ff4d4d;
        }
        a {
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <ul class="nav-list">
            <li class="nav-item"><a href="index.php">Home</a></li>
            <li class="nav-item"><a href="create.php">Create New SCP</a></li>
        </ul>
    </div>

    <div class="container">
        <h1 class="header-title">SCP Image Gallery</h1>
        <div class="grid-container">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="grid-item">
                    <a href="scp_detail.php?id=<?php echo $row['id']; ?>">
                        <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="SCP Image">
                        <h3><?php echo htmlspecialchars($row['subject']); ?></h3>
                    </a>
                    <div class="action-links">
                        <a href="update.php?id=<?php echo $row['id']; ?>">Edit</a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this SCP?');">Delete</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>

<?php $conn->close(); ?>


