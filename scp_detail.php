<?php
include 'db_connect.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$sql = $conn->prepare("SELECT * FROM scp WHERE id = ?");
$sql->bind_param("i", $id);
$sql->execute();
$result = $sql->get_result();
$scp = $result->fetch_assoc();

if (!$scp) {
    echo "<p>SCP not found.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($scp['subject']); ?> - SCP Foundation</title>
    <link rel="stylesheet" href="styles/styles.css" />
</head>
<body>
    <div class="container">
        <nav class="navbar">
            <ul class="nav-list">
                <li class="nav-item"><a href="index.php">Home</a></li>
                <!-- Add links dynamically as needed -->
            </ul>
        </nav>
        <div class="header">
            <div class="image-container">
                <img src="<?php echo htmlspecialchars($scp['image']); ?>" alt="SCP Image" />
                <div class="top-secret-stamp">TOP SECRET</div>
                <div class="confidential-stamp">CLASSIFIED DOCUMENT</div>
                <h1>Item #: <?php echo htmlspecialchars($scp['subject']); ?></h1>
                <h2>Object Class: <?php echo htmlspecialchars($scp['class']); ?></h2>
            </div>
        </div>
        <div class="section">
            <div class="section-title">Special Containment Procedures</div>
            <p><?php echo htmlspecialchars($scp['containment']); ?></p>
        </div>
        <div class="section">
            <div class="section-title">Description</div>
            <p><?php echo htmlspecialchars($scp['description']); ?></p>
        </div>
        <div class="section">
            <div class="section-title">Discovery</div>
            <p><?php echo htmlspecialchars($scp['discovery']); ?></p>
        </div>
        <div class="section">
            <div class="contact-info">Report to mission commander immediately.</div>
            <div class="footer-note">
                This document is the property of the SCP Foundation and is classified. Unauthorized access is prohibited.
            </div>
        </div>
    </div>
    <script src="scripts/scripts.js"></script>
</body>
</html>

<?php $conn->close(); ?>

