<?php
include 'db.php';

// URL Parameters ලබාගැනීම
$selected_type = isset($_GET['type']) ? $_GET['type'] : null;
$selected_subtype = isset($_GET['subtype']) ? $_GET['subtype'] : null;

// Database එකෙන් Papers ලබාගන්නා Query එක
$result = null;

if ($selected_type == 'papers' && $selected_subtype) {
    $stmt = $conn->prepare("SELECT * FROM resources WHERE category = 'SCHOLARSHIP' AND resource_type = ? ORDER BY id DESC");
    $stmt->bind_param("s", $selected_subtype);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="mVzdMsfxog_pR_dth7bZIuPyNi-oUdHFkknM2ml1_ig" />
    <title>5 ශ්‍රේණිය ශිෂ්‍යත්වය | ApeClass</title>
    <link rel="stylesheet" href="style.css">
    <!-- `?v=1.1` කොටස එකතු කරන්න -->
<link rel="stylesheet" href="style.css?v=1.1">
    <style>
        .container-box {
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .selection-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .select-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 25px 20px;
            text-align: center;
            text-decoration: none;
            color: #1e293b;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
        }

        .select-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(2, 132, 199, 0.15);
            border-color: #38bdf8;
        }

        .select-card .icon {
            font-size: 38px;
            margin-bottom: 10px;
        }

        .select-card h3 {
            font-size: 18px;
            margin-bottom: 8px;
            color: #0f172a;
        }

        .select-card p {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 15px;
        }

        .action-btn {
            background: #0f172a;
            color: white;
            padding: 9px 18px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            width: 100%;
        }

        .breadcrumb {
            background: #f8fafc;
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #64748b;
        }

        .breadcrumb a {
            color: #0284c7;
            text-decoration: none;
            font-weight: bold;
        }

        .resources-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .resource-card {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }

        .badge {
            background: #e0f2fe;
            color: #0369a1;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
        }

        .download-btn {
            display: inline-block;
            background: #0284c7;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 12px;
            margin-top: 10px;
        }
        /* Page Header Section */
.page-header {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
    color: #ffffff !important;
    text-align: center;
    padding: 45px 20px;
    border-bottom: 4px solid #0284c7;
}

.page-header h1 {
    color: #ffffff !important;
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 10px;
}

.page-header p {
    color: #cbd5e1 !important; /* යටින් තියෙන විස්තරය පැහැදිලිව පෙනෙන ලා අළු/සුදු පැහැය */
    font-size: 15px;
}
    </style>
</head>
<body>

    <header>
        <div class="logo">Ape<span>Class</span></div>
        <input class="menu-btn" type="checkbox" id="menu-btn" style="display:none;" />
    <label class="menu-icon" for="menu-btn"><span class="nav-icon"></span></label>
        <nav>
            <ul>
                <li><a href="index.php">මුල් පිටුව</a></li>
                <li><a href="scholarship-resources.php">5 ශ්‍රේණිය (ශිෂ්‍යත්වය)</a></li>
                <li><a href="secondary-resources.php">O/L Section</a></li>
                <li><a href="al-resources.php">A/L Section</a></li>
                
            </ul>
        </nav>
    </header>

    <section class="page-header" style="text-align: center; padding: 30px 0; background: #f1f5f9;">
        <h1>5 ශ්‍රේණිය ශිෂ්‍යත්ව අංශය</h1>
        <p>ශිෂ්‍යත්ව විභාගයට අදාළ පසුගිය ප්‍රශ්න පත්‍ර සහ ආදර්ශ ප්‍රශ්න පත්‍ර ලබාගන්න.</p>
    </section>

    <div class="container-box">

        <!-- STEP 1: Past Papers / Model Papers തෝරන්න -->
        <?php if (!$selected_subtype): ?>

            <h2 style="text-align: center; color: #0f172a; margin-bottom: 20px;">
                ප්‍රශ්න පත්‍ර වර්ගය තෝරන්න
            </h2>

            <div class="selection-grid" style="justify-content: center; max-width: 700px; margin: 30px auto;">
                
                <!-- Past Papers Link -->
                <a href="scholarship-resources.php?type=papers&subtype=past_papers" class="select-card">
                    <div class="icon">📚</div>
                    <h3>Past Papers</h3>
                    <p>පසුගිය වසරවල ශිෂ්‍යත්ව විභාග ප්‍රශ්න පත්‍ර සහ පිළිතුරු පත්‍ර</p>
                    <div class="action-btn">Past Papers බලන්න</div>
                </a>

                <!-- Model Papers Link -->
                <a href="scholarship-resources.php?type=papers&subtype=model_papers" class="select-card">
                    <div class="icon">📑</div>
                    <h3>Model Papers</h3>
                    <p>ශිෂ්‍යත්ව ආදර්ශ ප්‍රශ්න පත්‍ර සහ අනුමාන ප්‍රශ්න පත්‍ර</p>
                    <div class="action-btn">Model Papers බලන්න</div>
                </a>

            </div>

        <!-- STEP 2: PDF Files පෙන්වීම -->
        <?php else: ?>

            <div class="breadcrumb">
                <a href="scholarship-resources.php">ශිෂ්‍යත්ව අංශය</a> &gt; 
                <b>
                    <?php 
                        if ($selected_subtype == 'past_papers') echo 'Past Papers';
                        elseif ($selected_subtype == 'model_papers') echo 'Model Papers';
                    ?>
                </b>
            </div>

            <h2 style="text-align: center; color: #0f172a; margin-bottom: 25px;">
                5 ශ්‍රේණිය ශිෂ්‍යත්වය - 
                <?php 
                    if ($selected_subtype == 'past_papers') echo 'Past Papers';
                    elseif ($selected_subtype == 'model_papers') echo 'Model Papers';
                ?>
            </h2>

            <div class="resources-grid">
                <?php 
                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                ?>
                    <div class="resource-card">
                        <span class="badge">PDF</span>
                        <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                        <div style="margin-top: 15px;">
                            <a href="view-resource.php?id=<?php echo $row['id']; ?>" class="download-btn">Download PDF</a>
                        </div>
                    </div>
                <?php 
                    }
                } else {
                    echo "<div style='grid-column: 1/-1; text-align: center; padding: 40px; color: #64748b; background: white; border-radius: 10px; border: 1px dashed #cbd5e1;'>
                            <h3>තවම කිසිදු PDF එකක් ඇතුළත් කර නොමැත.</h3>
                            <p>Admin Panel එකෙන් මෙතැනට අදාළව Files Upload කළ පසු පෙන්නුම් කරනු ඇත.</p>
                          </div>";
                }
                ?>
            </div>

        <?php endif; ?>

    </div>

</body>
</html>