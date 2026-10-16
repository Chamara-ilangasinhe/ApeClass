<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Download Count එක 1කින් වැඩි කිරීම
    $stmt = $conn->prepare("UPDATE resources SET downloads = downloads + 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // File path එක ලබා ගැනීම
    $stmt_file = $conn->prepare("SELECT file_path FROM resources WHERE id = ?");
    $stmt_file->bind_param("i", $id);
    $stmt_file->execute();
    $result = $stmt_file->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $file_path = $row['file_path'];
        if (file_exists($file_path)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
            readfile($file_path);
            exit;
        }
    }
}
echo "File not found!";
?>