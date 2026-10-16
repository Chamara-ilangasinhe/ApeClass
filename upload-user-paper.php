<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_upload'])) {
    $id = intval($_POST['paper_id']);
    $upload_type = $_POST['upload_type']; // 'paper' හෝ 'marking'

    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (isset($_FILES["user_file"]) && $_FILES["user_file"]["error"] === UPLOAD_ERR_OK) {
        $prefix = ($upload_type === 'marking') ? '_marking_' : '_paper_';
        $file_name = time() . '_user' . $prefix . preg_replace("/[^a-zA-Z0-9.]/", "_", basename($_FILES["user_file"]["name"]));
        $target_file = $target_dir . $file_name;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($fileType === "pdf") {
            if (move_uploaded_file($_FILES["user_file"]["tmp_name"], $target_file)) {
                
                // Paper එකද Marking එකද යන්න අනුව Database Column එක Update කිරීම
                if ($upload_type === 'paper') {
                    $stmt = $conn->prepare("UPDATE resources SET file_path = ? WHERE id = ?");
                } else {
                    $stmt = $conn->prepare("UPDATE resources SET marking_file_path = ? WHERE id = ?");
                }

                $stmt->bind_param("si", $target_file, $id);
                if ($stmt->execute()) {
                    echo "<script>alert('✅ PDF එක සාර්ථකව Upload විය! ස්තූතියි.'); window.history.back();</script>";
                } else {
                    echo "<script>alert('❌ Database එක Update කිරීමට නොහැකි විය.'); window.history.back();</script>";
                }
                $stmt->close();
            } else {
                echo "<script>alert('❌ File එක Save කිරීමට නොහැකි විය.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('❌ කරුණාකර PDF File එකක් පමණක් Upload කරන්න!'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('❌ File එක Upload කිරීමේදී දෝෂයක් සිදු විය.'); window.history.back();</script>";
    }
}
?>