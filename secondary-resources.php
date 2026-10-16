<?php
include 'db.php';

// URL Parameters ලබාගැනීම
$selected_grade = isset($_GET['grade']) ? $_GET['grade'] : null;
$selected_category = isset($_GET['category']) ? $_GET['category'] : null;
$selected_subject = isset($_GET['subject']) ? $_GET['subject'] : null;
$selected_type = isset($_GET['type']) ? $_GET['type'] : null; // notes හෝ papers
$selected_subtype = isset($_GET['subtype']) ? $_GET['subtype'] : null; // past_papers හෝ model_papers

// Database එකෙන් Papers / Notes ලබාගන්නා Query එක
$result = null;

if ($selected_grade && $selected_subject) {
    if ($selected_type == 'notes') {
        // Notes සඳහා Query එක
        $stmt = $conn->prepare("SELECT * FROM resources WHERE category = ? AND subject = ? AND resource_type = 'notes' ORDER BY id DESC");
        $category_code = "GRADE_" . $selected_grade;
        $stmt->bind_param("ss", $category_code, $selected_subject);
        $stmt->execute();
        $result = $stmt->get_result();
    } elseif ($selected_type == 'papers' && $selected_subtype) {
        // Past Papers / Model Papers සඳහා Query එක
        $stmt = $conn->prepare("SELECT * FROM resources WHERE category = ? AND subject = ? AND resource_type = ? ORDER BY id DESC");
        $category_code = "GRADE_" . $selected_grade;
        $stmt->bind_param("sss", $category_code, $selected_subject, $selected_subtype);
        $stmt->execute();
        $result = $stmt->get_result();
    }
}
?>

<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="mVzdMsfxog_pR_dth7bZIuPyNi-oUdHFkknM2ml1_ig" />
    <title>6-11 ශ්‍රේණි Resources | ApeClass</title>
    <link rel="stylesheet" href="style.css">
    <!-- `?v=1.1` කොටස එකතු කරන්න -->
<link rel="stylesheet" href="style.css?v=1.1">
    <style>
        .container-box {
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 20px;
        }

        /* Grade & Subject Cards Grid Design */
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
    </style>
</head>
<body>

    <!-- Header Navigation -->
    <header>
        <div class="logo">Ape<span>Class</span></div>
        <input class="menu-btn" type="checkbox" id="menu-btn" style="display:none;" />
    <label class="menu-icon" for="menu-btn"><span class="nav-icon"></span></label>
        <nav>
            <ul>
                <li><a href="index.php">මුල් පිටුව</a></li>
                <li><a href="scholarship-resources.php">5 ශ්‍රේණිය (ශිෂ්‍යත්වය)</a></li>
                <li><a href="ol-resources.php">O/L Section</a></li>
                <li><a href="al-resources.php">A/L Section</a></li>
                
            </ul>
        </nav>
    </header>

    <!-- Page Title Header -->
    <section class="page-header">
        <h1>6 - 11 ශ්‍රේණි අධ්‍යයන අංශය</h1>
        <p>ඔබට අවශ්‍ය ශ්‍රේණිය සහ විෂය තෝරාගෙන Short Notes, Past Papers ලබාගන්න.</p>
    </section>

    <div class="container-box">

        <!-- STEP 1: ශ්‍රේණි තේරීම (6 - 11) -->
        <?php if (!$selected_grade): ?>

            <h2 style="text-align: center; color: #0f172a;">ඔබගේ ශ්‍රේණිය තෝරන්න</h2>
            
            <div class="selection-grid">
                <a href="secondary-resources.php?grade=6" class="select-card">
                    <div class="icon">📗</div>
                    <h3>6 ශ්‍රේණිය</h3>
                    <p>6 ශ්‍රේණියට අදාළ සියලුම විෂයයන්හි Notes සහ Papers</p>
                    <div class="action-btn">6 ශ්‍රේණියට යන්න</div>
                </a>

                <a href="secondary-resources.php?grade=7" class="select-card">
                    <div class="icon">📘</div>
                    <h3>7 ශ්‍රේණිය</h3>
                    <p>7 ශ්‍රේණියට අදාළ සියලුම විෂයයන්හි Notes සහ Papers</p>
                    <div class="action-btn">7 ශ්‍රේණියට යන්න</div>
                </a>

                <a href="secondary-resources.php?grade=8" class="select-card">
                    <div class="icon">📙</div>
                    <h3>8 ශ්‍රේණිය</h3>
                    <p>8 ශ්‍රේණියට අදාළ සියලුම විෂයයන්හි Notes සහ Papers</p>
                    <div class="action-btn">8 ශ්‍රේණියට යන්න</div>
                </a>

                <a href="secondary-resources.php?grade=9" class="select-card">
                    <div class="icon">📕</div>
                    <h3>9 ශ්‍රේණිය</h3>
                    <p>9 ශ්‍රේණියට අදාළ සියලුම විෂයයන්හි Notes සහ Papers</p>
                    <div class="action-btn">9 ශ්‍රේණියට යන්න</div>
                </a>

                <a href="secondary-resources.php?grade=10" class="select-card">
                    <div class="icon">📔</div>
                    <h3>10 ශ්‍රේණිය</h3>
                    <p>10 ශ්‍රේණියට අදාළ සියලුම විෂයයන්හි Notes සහ Papers</p>
                    <div class="action-btn">10 ශ්‍රේණියට යන්න</div>
                </a>

                <a href="secondary-resources.php?grade=11" class="select-card">
                    <div class="icon">🎓</div>
                    <h3>11 ශ්‍රේණිය (O/L)</h3>
                    <p>සාමාන්‍ය පෙළ (O/L) සියලුම විෂයයන්හි Notes සහ Papers</p>
                    <div class="action-btn">11 ශ්‍රේණියට යන්න</div>
                </a>
            </div>

        <!-- STEP 2: ප්‍රධාන විෂයන් හෝ කාණ්ඩ තේරීම -->
        <?php elseif ($selected_grade && !$selected_category && !$selected_subject): ?>

            <div class="breadcrumb">
                <a href="secondary-resources.php">6-11 ශ්‍රේණි</a> &gt; <b><?php echo htmlspecialchars($selected_grade); ?> ශ්‍රේණිය</b>
            </div>

            <h2 style="text-align: center; color: #0f172a; margin-bottom: 20px;">
                <?php echo htmlspecialchars($selected_grade); ?> ශ්‍රේණිය - විෂය තෝරන්න
            </h2>

            <div class="selection-grid">

                <?php if (in_array($selected_grade, ['6', '7', '8', '9'])): ?>
                    <!-- 6-9 ශ්‍රේණි සඳහා විෂය මාලාව -->

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&subject=Mother_Tongue" class="select-card">
                        <div class="icon">📖</div>
                        <h3>මව්බස</h3>
                        <p>සිංහල / දෙමළ මාධ්‍ය</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&subject=English" class="select-card">
                        <div class="icon">🔤</div>
                        <h3>ඉංග්‍රීසි (English)</h3>
                        <p>English Language & Literature</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&subject=2nd_Language" class="select-card">
                        <div class="icon">🗣️</div>
                        <h3>දෙවන ජාතික භාෂාව</h3>
                        <p>දෙමළ / සිංහල</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&subject=Maths" class="select-card">
                        <div class="icon">📐</div>
                        <h3>ගණිතය</h3>
                        <p>Mathematics</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&subject=Science" class="select-card">
                        <div class="icon">🔬</div>
                        <h3>විද්‍යාව</h3>
                        <p>Science</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&subject=Civics" class="select-card">
                        <div class="icon">🏛️</div>
                        <h3>පුරවැසි අධ්‍යාපනය</h3>
                        <p>Civic Education / Social Studies</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&subject=Religion" class="select-card">
                        <div class="icon">☸️</div>
                        <h3>ආගම</h3>
                        <p>බුද්ධ ධර්මය / කිතුනු / ඉස්ලාම් / හින්දු</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&subject=ICT" class="select-card">
                        <div class="icon">💻</div>
                        <h3>තොරතුරු තාක්ෂණය (ICT)</h3>
                        <p>Information & Comm. Technology</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&subject=Health" class="select-card">
                        <div class="icon">⚽</div>
                        <h3>සෞඛ්‍ය හා ශාරීරික අධ්‍යාපනය</h3>
                        <p>Health & Physical Education</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&category=aesthetics" class="select-card">
                        <div class="icon">🎨</div>
                        <h3>සෞන්දර්යාත්මක විෂයන්</h3>
                        <p>චිත්‍ර / සංගීත / නැටුම් / නාට්‍ය</p>
                        <div class="action-btn">විෂයන් තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&subject=PTS" class="select-card">
                        <div class="icon">🛠️</div>
                        <h3>ප්‍රායෝගික හා තාක්ෂණික කුසලතා</h3>
                        <p>PTS - Practical & Technical Skills</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&subject=Geography" class="select-card">
                        <div class="icon">🌍</div>
                        <h3>භූගෝල විද්‍යාව</h3>
                        <p>Geography</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                <?php else: ?>
                    <!-- 10 සහ 11 ශ්‍රේණි (O/L) සඳහා විෂයයන් -->

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&subject=Mother_Tongue" class="select-card">
                        <div class="icon">📖</div>
                        <h3>මව්බස</h3>
                        <p>සිංහල / දෙමළ භාෂාව හා සාහිත්‍යය</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&subject=English" class="select-card">
                        <div class="icon">🔤</div>
                        <h3>ඉංග්‍රීසි</h3>
                        <p>English Language</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&subject=Maths" class="select-card">
                        <div class="icon">📐</div>
                        <h3>ගණිතය</h3>
                        <p>Mathematics</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&subject=Science" class="select-card">
                        <div class="icon">🔬</div>
                        <h3>විද්‍යාව</h3>
                        <p>Science</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&subject=History" class="select-card">
                        <div class="icon">📜</div>
                        <h3>ඉතිහාසය</h3>
                        <p>History</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&subject=Religion" class="select-card">
                        <div class="icon">☸️</div>
                        <h3>ආගම</h3>
                        <p>බුද්ධ ධර්මය / කිතුනු / ඉස්ලාම් / හින්දු</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&category=cat1" class="select-card">
                        <div class="icon">📊</div>
                        <h3>1 කාණ්ඩය</h3>
                        <p>ගිණුම්කරණය, භූගෝල, පුරවැසි, දෙවන භාෂාව</p>
                        <div class="action-btn">විෂයන් තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&category=cat2" class="select-card">
                        <div class="icon">🎨</div>
                        <h3>2 කාණ්ඩය</h3>
                        <p>චිත්‍ර, සංගීත, නැටුම්, නාට්‍ය, සාහිත්‍යය</p>
                        <div class="action-btn">විෂයන් තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&category=cat3" class="select-card">
                        <div class="icon">💻</div>
                        <h3>3 කාණ්ඩය</h3>
                        <p>ICT, කෘෂිකර්මය, ගෘහ ආර්ථික විද්‍යාව</p>
                        <div class="action-btn">විෂයන් තෝරන්න</div>
                    </a>

                <?php endif; ?>

            </div>

        <!-- STEP 3: කාණ්ඩයක අභ්‍යන්තර විෂයන් තේරීම -->
        <?php elseif ($selected_grade && $selected_category && !$selected_subject): ?>

            <div class="breadcrumb">
                <a href="secondary-resources.php">6-11 ශ්‍රේණි</a> &gt; 
                <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>"><?php echo htmlspecialchars($selected_grade); ?> ශ්‍රේණිය</a> &gt; 
                <b>
                    <?php 
                        if($selected_category == 'aesthetics') echo 'සෞන්දර්යාත්මක විෂයන්';
                        elseif($selected_category == 'cat1') echo '1 කාණ්ඩය';
                        elseif($selected_category == 'cat2') echo '2 කාණ්ඩය';
                        elseif($selected_category == 'cat3') echo '3 කාණ්ඩය';
                    ?>
                </b>
            </div>

            <h2 style="text-align: center; color: #0f172a; margin-bottom: 20px;">
                <?php echo htmlspecialchars($selected_grade); ?> ශ්‍රේණිය - විෂය තෝරන්න
            </h2>

            <div class="selection-grid">

                <?php if ($selected_category == 'aesthetics'): ?>
                    <!-- 6-9 ශ්‍රේණි සෞන්දර්යාත්මක විෂයන් -->
                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&category=aesthetics&subject=Art" class="select-card">
                        <div class="icon">🎨</div>
                        <h3>චිත්‍ර කලාව</h3>
                        <p>Art</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&category=aesthetics&subject=Music" class="select-card">
                        <div class="icon">🎵</div>
                        <h3>සංගීතය</h3>
                        <p>පෞරස්ත්‍ය / පාශ්චාත්‍ය</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&category=aesthetics&subject=Dancing" class="select-card">
                        <div class="icon">💃</div>
                        <h3>නැටුම්</h3>
                        <p>දේශීය / භාරත</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&category=aesthetics&subject=Drama" class="select-card">
                        <div class="icon">🎭</div>
                        <h3>නාට්‍ය හා රංගකලාව</h3>
                        <p>Drama & Theatre</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                <?php elseif ($selected_category == 'cat1'): ?>
                    <!-- 1 කාණ්ඩයේ විෂයන් -->
                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&category=cat1&subject=2nd_Language" class="select-card">
                        <div class="icon">🗣️</div>
                        <h3>දෙවන ජාතික භාෂාව</h3>
                        <p>දෙමළ / සිංහල</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&category=cat1&subject=Commerce" class="select-card">
                        <div class="icon">📈</div>
                        <h3>ව්‍යාපාර හා ගිණුම්කරණ අධ්‍යයනය</h3>
                        <p>Business & Accounting Studies</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&category=cat1&subject=Geography" class="select-card">
                        <div class="icon">🌍</div>
                        <h3>භූගෝල විද්‍යාව</h3>
                        <p>Geography</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&category=cat1&subject=Civics" class="select-card">
                        <div class="icon">🏛️</div>
                        <h3>පුරවැසි අධ්‍යාපනය</h3>
                        <p>Civic Education</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                <?php elseif ($selected_category == 'cat2'): ?>
                    <!-- 2 කාණ්ඩයේ විෂයන් -->
                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&category=cat2&subject=Art" class="select-card">
                        <div class="icon">🎨</div>
                        <h3>චිත්‍ර කලාව</h3>
                        <p>Art</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&category=cat2&subject=Music" class="select-card">
                        <div class="icon">🎵</div>
                        <h3>සංගීතය</h3>
                        <p>පෞරස්ත්‍ය / පාශ්චාත්‍ය</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&category=cat2&subject=Dancing" class="select-card">
                        <div class="icon">💃</div>
                        <h3>නැටුම්</h3>
                        <p>දේශීය / භාරත</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&category=cat2&subject=Drama" class="select-card">
                        <div class="icon">🎭</div>
                        <h3>නාට්‍ය හා රංගකලාව</h3>
                        <p>Drama & Theatre</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&category=cat2&subject=English_Lit" class="select-card">
                        <div class="icon">📚</div>
                        <h3>ඉංග්‍රීසි සාහිත්‍යය</h3>
                        <p>English Literature</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&category=cat2&subject=Sinhala_Lit" class="select-card">
                        <div class="icon">📜</div>
                        <h3>සිංහල සාහිත්‍යය</h3>
                        <p>Sinhala Literature</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                <?php elseif ($selected_category == 'cat3'): ?>
                    <!-- 3 කාණ්ඩයේ විෂයන් -->
                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&category=cat3&subject=ICT" class="select-card">
                        <div class="icon">💻</div>
                        <h3>තොරතුරු හා සන්නිවේදන තාක්ෂණය</h3>
                        <p>ICT</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&category=cat3&subject=Agriculture" class="select-card">
                        <div class="icon">🌾</div>
                        <h3>කෘෂිකර්මය හා ආහාර තාක්ෂණය</h3>
                        <p>Agriculture & Food Technology</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&category=cat3&subject=Home_Economics" class="select-card">
                        <div class="icon">🏡</div>
                        <h3>ගෘහ ආර්ථික විද්‍යාව</h3>
                        <p>Home Economics</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                <?php endif; ?>

            </div>

        <!-- STEP 4: Notes ද Papers ද කියා තේරීම -->
        <?php elseif ($selected_grade && $selected_subject && !$selected_type): ?>

            <?php 
                $url_prefix = "secondary-resources.php?grade={$selected_grade}";
                if($selected_category) {
                    $url_prefix .= "&category={$selected_category}";
                }
                $url_prefix .= "&subject={$selected_subject}";
            ?>

            <div class="breadcrumb">
                <a href="secondary-resources.php">6-11 ශ්‍රේණි</a> &gt; 
                <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>"><?php echo htmlspecialchars($selected_grade); ?> ශ්‍රේණිය</a> &gt; 
                <?php if($selected_category): ?>
                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&category=<?php echo $selected_category; ?>">
                        <?php 
                            if($selected_category == 'aesthetics') echo 'සෞන්දර්යාත්මක විෂයන්';
                            elseif($selected_category == 'cat1') echo '1 කාණ්ඩය';
                            elseif($selected_category == 'cat2') echo '2 කාණ්ඩය';
                            elseif($selected_category == 'cat3') echo '3 කාණ්ඩය';
                        ?>
                    </a> &gt;
                <?php endif; ?>
                <b><?php echo htmlspecialchars($selected_subject); ?></b>
            </div>

            <h2 style="text-align: center; color: #0f172a; margin-bottom: 20px;">
                ඔබට අවශ්‍ය කොටස තෝරන්න
            </h2>

            <div class="selection-grid" style="justify-content: center; max-width: 700px; margin: 30px auto;">
                
                <!-- Short Notes Card -->
                <a href="<?php echo $url_prefix; ?>&type=notes" class="select-card">
                    <div class="icon">📝</div>
                    <h3>Short Notes & Study Materials</h3>
                    <p>පාඩම් සටහන්, කෙටි සටහන් සහ අධ්‍යයන ද්‍රව්‍ය</p>
                    <div class="action-btn">Notes බලන්න</div>
                </a>

                <!-- Papers Card -->
                <a href="<?php echo $url_prefix; ?>&type=papers" class="select-card">
                    <div class="icon">📄</div>
                    <h3>Past Papers & Model Papers</h3>
                    <p>පසුගිය විභාග ප්‍රශ්න පත්‍ර සහ ආදර්ශ ප්‍රශ්න පත්‍ර</p>
                    <div class="action-btn">Papers කොටසට යන්න</div>
                </a>

            </div>

        <!-- STEP 5: Papers තේරූ විට Past Papers ද Model Papers ද කියා තේරීම -->
        <?php elseif ($selected_grade && $selected_subject && $selected_type == 'papers' && !$selected_subtype): ?>

            <?php 
                $url_prefix = "secondary-resources.php?grade={$selected_grade}";
                if($selected_category) {
                    $url_prefix .= "&category={$selected_category}";
                }
                $url_prefix .= "&subject={$selected_subject}&type=papers";
            ?>

            <div class="breadcrumb">
                <a href="secondary-resources.php">6-11 ශ්‍රේණි</a> &gt; 
                <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>"><?php echo htmlspecialchars($selected_grade); ?> ශ්‍රේණිය</a> &gt; 
                <?php if($selected_category): ?>
                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&category=<?php echo $selected_category; ?>">
                        <?php 
                            if($selected_category == 'aesthetics') echo 'සෞන්දර්යාත්මක විෂයන්';
                            elseif($selected_category == 'cat1') echo '1 කාණ්ඩය';
                            elseif($selected_category == 'cat2') echo '2 කාණ්ඩය';
                            elseif($selected_category == 'cat3') echo '3 කාණ්ඩය';
                        ?>
                    </a> &gt;
                <?php endif; ?>
                <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?><?php echo $selected_category ? '&category='.$selected_category : ''; ?>&subject=<?php echo $selected_subject; ?>">
                    <?php echo htmlspecialchars($selected_subject); ?>
                </a> &gt;
                <b>Papers</b>
            </div>

            <h2 style="text-align: center; color: #0f172a; margin-bottom: 20px;">
                ප්‍රශ්න පත්‍ර වර්ගය තෝරන්න
            </h2>

            <div class="selection-grid" style="justify-content: center; max-width: 700px; margin: 30px auto;">
                
                <!-- Past Papers Box -->
                <a href="<?php echo $url_prefix; ?>&subtype=past_papers" class="select-card">
                    <div class="icon">📚</div>
                    <h3>Past Papers</h3>
                    <p>පසුගිය වසරවල විභාග ප්‍රශ්න පත්‍ර සහ පිළිතුරු පත්‍ර</p>
                    <div class="action-btn">Past Papers බලන්න</div>
                </a>

                <!-- Model Papers Box -->
                <a href="<?php echo $url_prefix; ?>&subtype=model_papers" class="select-card">
                    <div class="icon">📑</div>
                    <h3>Model Papers</h3>
                    <p>ආදර්ශ ප්‍රශ්න පත්‍ර සහ අනුමාන ප්‍රශ්න පත්‍ර</p>
                    <div class="action-btn">Model Papers බලන්න</div>
                </a>

            </div>

        <!-- STEP 6: අවසාන PDF / Resources පෙන්වීම -->
        <?php else: ?>

            <div class="breadcrumb">
                <a href="secondary-resources.php">6-11 ශ්‍රේණි</a> &gt; 
                <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>"><?php echo htmlspecialchars($selected_grade); ?> ශ්‍රේණිය</a> &gt; 
                <?php if($selected_category): ?>
                    <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?>&category=<?php echo $selected_category; ?>">
                        <?php 
                            if($selected_category == 'aesthetics') echo 'සෞන්දර්යාත්මක විෂයන්';
                            elseif($selected_category == 'cat1') echo '1 කාණ්ඩය';
                            elseif($selected_category == 'cat2') echo '2 කාණ්ඩය';
                            elseif($selected_category == 'cat3') echo '3 කාණ්ඩය';
                        ?>
                    </a> &gt;
                <?php endif; ?>
                <a href="secondary-resources.php?grade=<?php echo $selected_grade; ?><?php echo $selected_category ? '&category='.$selected_category : ''; ?>&subject=<?php echo $selected_subject; ?>">
                    <?php echo htmlspecialchars($selected_subject); ?>
                </a> &gt;
                <b>
                    <?php 
                        if ($selected_type == 'notes') echo 'Short Notes';
                        elseif ($selected_subtype == 'past_papers') echo 'Past Papers';
                        elseif ($selected_subtype == 'model_papers') echo 'Model Papers';
                    ?>
                </b>
            </div>

            <h2 style="text-align: center; color: #0f172a; margin-bottom: 25px;">
                <?php echo htmlspecialchars($selected_grade); ?> ශ්‍රේණිය - 
                <?php 
                    if ($selected_type == 'notes') echo 'Short Notes';
                    elseif ($selected_subtype == 'past_papers') echo 'Past Papers';
                    elseif ($selected_subtype == 'model_papers') echo 'Model Papers';
                ?>
            </h2>

            <div class="resources-grid">
                <?php 
                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                ?>
                    <div class="resource-card">
                        <span class="badge pdf-badge"><?php echo strtoupper($row['resource_type']); ?></span>
                        <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                        <div class="card-footer">
                            <span class="file-size">📘 <?php echo htmlspecialchars($row['subject']); ?></span>
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

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 ApeClass. All Rights Reserved.</p>
        <a href="admin-secret-portal.php" class="secret-admin-link">Admin Portal</a>
    </footer>

</body>
</html>