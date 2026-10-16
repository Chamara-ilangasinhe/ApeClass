<?php
include 'db.php';

$query = isset($_GET['q']) ? trim($_GET['q']) : '';

if (!empty($query)) {
    $search = "%" . $query . "%";
    $stmt = $conn->prepare("SELECT * FROM resources WHERE title LIKE ? OR description LIKE ? ORDER BY id DESC LIMIT 10");
    $stmt->bind_param("ss", $search, $search);
} else {
    // Search එක හිස් විට අලුත්ම Resources 10ක් පෙන්වීමට
    $stmt = $conn->prepare("SELECT * FROM resources ORDER BY id DESC LIMIT 10");
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="resource-card">';
        echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
        echo '<p>' . htmlspecialchars($row['description']) . '</p>';
        echo '<a href="view-resource.php?id=' . $row['id'] . '" class="btn-open">View / Download Paper</a>';
        echo '</div>';
    }
} else {
    echo '<p style="text-align:center; padding:20px; color:#64748b;">ඔබ සොයන Resource එක හමු නොවීය.</p>';
}
?>