<?php
include 'db_connect.php';
$id = (int)$_GET['id']; // Cast to int for safety

$sql = $conn->prepare("DELETE FROM scp WHERE id = ?");
$sql->bind_param("i", $id);

if ($sql->execute()) {
    echo "<script>alert('Record deleted successfully'); window.location.href='index.php';</script>";
} else {
    echo "Error deleting record: " . $conn->error;
}
?>
