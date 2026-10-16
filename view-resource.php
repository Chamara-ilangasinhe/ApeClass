<?php
include 'db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$resource = null;

if ($id > 0) {
    $stmt = $conn->prepare("SELECT * FROM resources WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $resource = $result->fetch_assoc();
    }
}

if (!$resource) {
    echo "<h2 style='text-align:center; margin-top:50px;'>Resource එක හමු නොවීය!</h2>";
    exit;
}

// Domain URL එක (Auto Generated)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$base_url = $protocol . "://" . $_SERVER['HTTP_HOST'] . "/";
$full_pdf_url = $base_url . ltrim($resource['file_path'], '/');

// දැනට බලන පිටුවේ Link එක (WhatsApp Share සඳහා)
$current_page_url = $base_url . "view-resource.php?id=" . $id;

// Shortcodes සිංහලට Mapping කිරීම
$category_names = [
    'SCHOLARSHIP' => '5 ශ්‍රේණිය ශිෂ්‍යත්වය',
    'GRADE_6'     => '6 ශ්‍රේණිය',
    'GRADE_7'     => '7 ශ්‍රේණිය',
    'GRADE_8'     => '8 ශ්‍රේණිය',
    'GRADE_9'     => '9 ශ්‍රේණිය',
    'GRADE_10'    => '10 ශ්‍රේණිය',
    'GRADE_11'    => '11 ශ්‍රේණිය (O/L)',
    'AL_MATHS'    => 'A/L - Maths',
    'AL_BIO'      => 'A/L - Bio',
    'AL_COMMERCE' => 'A/L - Commerce',
    'AL_TECH'     => 'A/L - Tech',
    'AL_ARTS'     => 'A/L - Arts'
];

$subject_names = [
    'BS'             => 'ව්‍යාපාර අධ්‍යයනය (BS)',
    'Accounting'     => 'ගිණුම්කරණය',
    'Econ'           => 'ආර්ථික විද්‍යාව',
    'Combined_Maths' => 'සංයුක්ත ගණිතය',
    'Physics'        => 'භෞතික විද්‍යාව',
    'Chemistry'      => 'රසායන විද්‍යාව',
    'Biology'        => 'ජීව විද්‍යාව',
    'ICT'            => 'තොරතුරු තාක්ෂණය (ICT)',
    'Maths'          => 'ගණිතය',
    'Science'        => 'විද්‍යාව',
    'English'        => 'ඉංග්‍රීසි',
    'Mother_Tongue'  => 'මව්බස',
    'Scholarship'    => 'ශිෂ්‍යත්ව සාමාන්‍ය දැනීම'
];

$resource_types = [
    'past_papers'  => 'පසුගිය විභාග ප්‍රශ්න පත්‍ර',
    'model_papers' => 'ආදර්ශ ප්‍රශ්න පත්‍ර',
    'notes'        => 'කෙටි සටහන්'
];

$raw_cat  = isset($resource['category']) ? trim($resource['category']) : '';
$raw_sub  = isset($resource['subject']) ? trim($resource['subject']) : '';
$raw_type = isset($resource['resource_type']) ? trim($resource['resource_type']) : '';

$display_cat  = isset($category_names[$raw_cat]) ? $category_names[$raw_cat] : ($raw_cat !== '' ? $raw_cat : '-');
$display_sub  = isset($subject_names[$raw_sub])  ? $subject_names[$raw_sub]  : ($raw_sub !== '' ? $raw_sub : '-');
$display_type = isset($resource_types[$raw_type]) ? $resource_types[$raw_type] : ($raw_type !== '' ? $raw_type : '-');

// Related Papers fetch කිරීම
$related_stmt = $conn->prepare("SELECT id, title FROM resources WHERE (subject = ? OR category = ?) AND id != ? ORDER BY id DESC LIMIT 3");
$related_stmt->bind_param("ssi", $raw_sub, $raw_cat, $id);
$related_stmt->execute();
$related_result = $related_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="mVzdMsfxog_pR_dth7bZIuPyNi-oUdHFkknM2ml1_ig" />
        <!-- Dynamic Meta Tags for SEO -->
    <title><?php echo htmlspecialchars($resource['title']); ?> | ApeClass</title>
    <meta name="description" content="Download <?php echo htmlspecialchars($resource['title']); ?> (<?php echo htmlspecialchars($display_sub); ?>) Sri Lanka A/L & O/L past paper and marking scheme for free on ApeClass.">
    <meta name="keywords" content="<?php echo htmlspecialchars($resource['title']); ?>, <?php echo htmlspecialchars($display_sub); ?> past paper, ApeClass papers, Sri Lanka exam papers">
    
    <!-- Open Graph Tags (Facebook & WhatsApp Preview සඳහා) -->
    <meta property="og:title" content="<?php echo htmlspecialchars($resource['title']); ?> | ApeClass">
    <meta property="og:description" content="Download <?php echo htmlspecialchars($resource['title']); ?> for free.">
    <meta property="og:url" content="<?php echo $current_page_url; ?>">
    <meta property="og:type" content="website">

    <title><?php echo htmlspecialchars($resource['title']); ?> | ApeClass</title>
    <link rel="stylesheet" href="style.css?v=1.2">
    <style>
        .view-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            text-align: center;
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin: 25px 0;
        }

        .btn-action {
            display: inline-block;
            padding: 14px 20px;
            border-radius: 8px;
            font-weight: bold;
            text-decoration: none;
            color: white;
            font-size: 15px;
            transition: background 0.2s;
        }

        .btn-download { background-color: #0284c7; }
        .btn-download:hover { background-color: #0369a1; }

        .btn-view { background-color: #334155; }
        .btn-view:hover { background-color: #1e293b; }

        .preview-box {
            margin: 25px 0;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #cbd5e1;
        }

        /* Missing File Upload Section */
        .missing-upload-box {
            background: #fff7ed;
            border: 2px dashed #f97316;
            padding: 15px;
            border-radius: 8px;
            text-align: left;
            margin-bottom: 5px;
        }

        .missing-upload-box p {
            color: #c2410c;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .btn-user-upload {
            background-color: #f97316;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            font-size: 14px;
        }

        /* WhatsApp Share Button Style */
        .share-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
        }

        .btn-whatsapp {
            display: inline-block;
            background-color: #25D366;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: bold;
            text-decoration: none;
            font-size: 15px;
            margin-top: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        /* Related Papers Style */
        .related-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 15px;
            border-radius: 10px;
            text-align: left;
            margin-top: 25px;
        }

        .related-box h4 {
            margin: 0 0 12px 0;
            color: #1e293b;
            font-size: 16px;
        }

        .related-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .related-list li {
            margin-bottom: 8px;
        }

        .related-list a {
            color: #0284c7;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }

        .related-list a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">Ape<span>Class</span></div>
        <nav>
            <ul>
               <li><a href="index.php" class="active">මුල් පිටුව</a></li>
                <li><a href="scholarship-resources.php">5 ශ්‍රේණිය (ශිෂ්‍යත්වය)</a></li>
                <li><a href="secondary-resources.php">O/L Section</a></li>
                <li><a href="al-resources.php">A/L Section</a></li>
            </ul>
        </nav>
    </header>

    <div class="view-container">
        <h2><?php echo htmlspecialchars($resource['title']); ?></h2>
        <p style="color: #64748b;"><?php echo htmlspecialchars($resource['description']); ?></p>

        <!-- 1. Details Info Box -->
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; margin: 20px 0; display: flex; flex-direction: column; gap: 12px; font-size: 14px; color: #334155; text-align: left;">
            
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 18px;">📚</span>
                <span><b>විෂය:</b> <?php echo htmlspecialchars($display_sub); ?></span>
            </div>

            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 18px;">🎓</span>
                <span><b>අංශය:</b> <?php echo htmlspecialchars($display_cat); ?></span>
            </div>

            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 18px;">📄</span>
                <span><b>වර්ගය:</b> <?php echo htmlspecialchars($display_type); ?></span>
            </div>

            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 18px;">📝</span>
                <span><b>Marking:</b> 
                    <?php if(!empty($resource['marking_file_path']) && file_exists($resource['marking_file_path'])): ?>
                        <span style="color: #16a34a; font-weight: bold;">ඇතුළත් වේ ✅</span>
                    <?php else: ?>
                        <span style="color: #dc2626; font-weight: bold;">නැත ❌</span>
                    <?php endif; ?>
                </span>
            </div>

        </div>

        <!-- 2. PDF Preview Section (Details වලට යටින්) -->
        <?php if (!empty($resource['file_path']) && file_exists($resource['file_path'])): ?>
            <h3 style="margin-top: 25px; color: #1e293b;">PDF Preview</h3>
            <div class="preview-box">
                <iframe src="https://docs.google.com/viewer?url=<?php echo urlencode($full_pdf_url); ?>&embedded=true" width="100%" height="600px" style="border:none;"></iframe>
            </div>
        <?php endif; ?>

        <!-- 3. Download / Upload Buttons Section (PDF Preview එකට යටින්) -->
        <div class="btn-group">
            
            <!-- Question Paper Section (Tracked Download Link) -->
            <?php if (!empty($resource['file_path']) && file_exists($resource['file_path'])): ?>
                <a href="download.php?id=<?php echo $resource['id']; ?>" class="btn-action btn-download">
                    📥 Download Question Paper (ප්‍රශ්න පත්‍රය)
                </a>
            <?php else: ?>
                <div class="missing-upload-box">
                    <p>⚠️️ මෙම Question Paper එක තවම පද්ධතියේ නොමැත. ඔබ සතුව තිබේද?</p>
                    <form action="upload-user-paper.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="paper_id" value="<?php echo $resource['id']; ?>">
                        <input type="hidden" name="upload_type" value="paper">
                        <input type="file" name="user_file" accept=".pdf" required>
                        <button type="submit" name="user_upload" class="btn-user-upload">📤 Question Paper එක Upload කරන්න</button>
                    </form>
                </div>
            <?php endif; ?>

            <!-- Marking Scheme Section (Original Direct Download Link) -->
            <?php if (!empty($resource['marking_file_path']) && file_exists($resource['marking_file_path'])): ?>
                <a href="<?php echo htmlspecialchars($resource['marking_file_path']); ?>" download class="btn-action btn-download" style="background-color: #16a34a;">
                    📝 Download Marking Scheme (ලකුණු දීමේ පටිපාටිය)
                </a>
            <?php else: ?>
                <div class="missing-upload-box" style="background: #f0fdf4; border-color: #22c55e;">
                    <p style="color: #15803d;">⚠️ මෙම Marking Scheme එක නොමැත. ඔබ සතුව තිබේද?</p>
                    <form action="upload-user-paper.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="paper_id" value="<?php echo $resource['id']; ?>">
                        <input type="hidden" name="upload_type" value="marking">
                        <input type="file" name="user_file" accept=".pdf" required>
                        <button type="submit" name="user_upload" class="btn-user-upload" style="background-color: #16a34a;">📤 Marking Scheme එක Upload කරන්න</button>
                    </form>
                </div>
            <?php endif; ?>

            <!-- View Online Button -->
            <?php if (!empty($resource['file_path']) && file_exists($resource['file_path'])): ?>
                <a href="https://docs.google.com/viewer?url=<?php echo urlencode($full_pdf_url); ?>&embedded=true" target="_blank" class="btn-action btn-view">
                    👁️️ Paper එක නව Tab එකකින් බලන්න (View PDF)
                </a>
            <?php endif; ?>

        </div>

        <!-- 4. WhatsApp Share Button Section -->
        <div class="share-box">
            <span style="font-weight: bold; color: #166534; font-size: 14px;">📲 මෙම Paper එක යාළුවන්ටත් Share කරන්න:</span><br>
            <a href="https://api.whatsapp.com/send?text=<?php echo urlencode("මෙන්න " . $resource['title'] . " Past Paper එක Download කරගන්න: " . $current_page_url); ?>" target="_blank" class="btn-whatsapp">
                💬 WhatsApp හරහා Share කරන්න
            </a>
        </div>

        <!-- 5. Related Papers Section -->
        <?php if ($related_result->num_rows > 0): ?>
            <div class="related-box">
                <h4>📌 තවත් Past Papers (Related Papers):</h4>
                <ul class="related-list">
                    <?php while ($rel = $related_result->fetch_assoc()): ?>
                        <li>
                            📄 <a href="view-resource.php?id=<?php echo $rel['id']; ?>"><?php echo htmlspecialchars($rel['title']); ?></a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        <?php endif; ?>

    </div>
    
    <footer style="text-align: center; padding: 20px; background: #0f172a; color: #94a3b8; margin-top: 40px; font-size: 14px;">
    <p>&copy; <?php echo date('Y'); ?> ApeClass. All rights reserved.</p>
    <p>
        <a href="privacy-policy.php" style="color: #38bdf8; text-decoration: none; margin: 0 10px;">Privacy Policy</a> | 
        <a href="terms.php" style="color: #38bdf8; text-decoration: none; margin: 0 10px;">Terms & Conditions</a>
    </p>
</footer>


</body>
</html>