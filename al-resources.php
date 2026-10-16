<?php
include 'db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// URL Parameters ලබාගැනීම
$selected_stream = isset($_GET['stream']) ?$_GET['stream'] : null;
$selected_subject = isset($_GET['subject']) ?$_GET['subject'] : null;
$selected_type = isset($_GET['type']) ?$_GET['type'] : null; // notes හෝ papers
$selected_subtype = isset($_GET['subtype']) ?$_GET['subtype'] : null; // past_papers හෝ model_papers

// Database එකෙන් Papers / Notes ලබාගන්නා Query එක
$result = null;

if ($selected_stream &&$selected_subject) {
    if ($selected_type == 'notes') {
        $stmt =$conn->prepare("SELECT * FROM resources WHERE category = ? AND subject = ? AND resource_type = 'notes' ORDER BY id DESC");
        $category_code = "AL_" . strtoupper($selected_stream);
        $stmt->bind_param("ss", $category_code, $selected_subject);$stmt->execute();
        $result =$stmt->get_result();
    } elseif ($selected_type == 'papers' &&$selected_subtype) {
        $stmt =$conn->prepare("SELECT * FROM resources WHERE category = ? AND subject = ? AND resource_type = ? ORDER BY id DESC");
        $category_code = "AL_" . strtoupper($selected_stream);$stmt->bind_param("sss", $category_code,$selected_subject, $selected_subtype);$stmt->execute();
        $result =$stmt->get_result();
    }
}
?>

<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="mVzdMsfxog_pR_dth7bZIuPyNi-oUdHFkknM2ml1_ig" />
    <title>A/L Resources | ApeClass</title>
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
                <li><a href="secondary-resources.php">O/L Section</a></li>
                <li><a href="al-resources.php">A/L Section</a></li>
            </ul>
        </nav>
    </header>

    <!-- Page Title Header -->
    <section class="page-header">
        <h1>G.C.E. A/L අධ්‍යයන අංශය</h1>
        <p>ඔබගේ විෂය ධාරාව සහ විෂය තෝරාගෙන Short Notes, Past Papers & Model Papers ලබාගන්න.</p>
    </section>

    <div class="container-box">

        <!-- STEP 1: විෂය ධාරාව තේරීම -->
        <?php if (!$selected_stream): ?>

            <h2 style="text-align: center; color: #0f172a;">ඔබගේ A/L විෂය ධාරාව තෝරන්න</h2>
            
            <div class="selection-grid">
                <a href="al-resources.php?stream=maths" class="select-card">
                    <div class="icon">📐</div>
                    <h3>භෞතික විද්‍යා ධාරාව</h3>
                    <p>Physical Science / Maths Stream</p>
                    <div class="action-btn">ධාරාව තෝරන්න</div>
                </a>

                <a href="al-resources.php?stream=bio" class="select-card">
                    <div class="icon">🧬</div>
                    <h3>ජීව විද්‍යා ධාරාව</h3>
                    <p>Biological Science Stream</p>
                    <div class="action-btn">ධාරාව තෝරන්න</div>
                </a>

                <a href="al-resources.php?stream=commerce" class="select-card">
                    <div class="icon">📊</div>
                    <h3>වාණිජ ධාරාව</h3>
                    <p>Commerce Stream</p>
                    <div class="action-btn">ධාරාව තෝරන්න</div>
                </a>

                <a href="al-resources.php?stream=tech" class="select-card">
                    <div class="icon">⚙️</div>
                    <h3>තාක්ෂණවේදය ධාරාව</h3>
                    <p>Technology Stream</p>
                    <div class="action-btn">ධාරාව තෝරන්න</div>
                </a>

                <a href="al-resources.php?stream=arts" class="select-card">
                    <div class="icon">🎨</div>
                    <h3>කලා ධාරාව</h3>
                    <p>Arts Stream</p>
                    <div class="action-btn">ධාරාව තෝරන්න</div>
                </a>
            </div>

        <!-- STEP 2: විෂය ධාරාව ඇතුළත විෂයන් තේරීම -->
        <?php elseif ($selected_stream && !$selected_subject): ?>

            <div class="breadcrumb">
                <a href="al-resources.php">A/L ධාරාවන්</a> &gt; 
                <b>
                    <?php 
                        if($selected_stream == 'maths') echo 'භෞතික විද්‍යා ධාරාව';
                        elseif($selected_stream == 'bio') echo 'ජීව විද්‍යා ධාරාව';
                        elseif($selected_stream == 'commerce') echo 'වාණිජ ධාරාව';
                        elseif($selected_stream == 'tech') echo 'තාක්ෂණවේදය ධාරාව';
                        elseif($selected_stream == 'arts') echo 'කලා ධාරාව';
                    ?>
                </b>
            </div>

            <h2 style="text-align: center; color: #0f172a; margin-bottom: 20px;">විෂය තෝරන්න</h2>

            <div class="selection-grid">

                <?php if ($selected_stream == 'maths'): ?>
                    <!-- 1. භෞතික විද්‍යා ධාරාව -->
                    <a href="al-resources.php?stream=maths&subject=Combined_Maths" class="select-card">
                        <div class="icon">📐</div>
                        <h3>සංයුක්ත ගණිතය</h3>
                        <p>Combined Mathematics</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>
                    <a href="al-resources.php?stream=maths&subject=Physics" class="select-card">
                        <div class="icon">🧲</div>
                        <h3>භෞතික විද්‍යාව</h3>
                        <p>Physics</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>
                    <a href="al-resources.php?stream=maths&subject=Chemistry" class="select-card">
                        <div class="icon">🧪</div>
                        <h3>රසායන විද්‍යාව</h3>
                        <p>Chemistry</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>
                    <a href="al-resources.php?stream=maths&subject=ICT" class="select-card">
                        <div class="icon">💻</div>
                        <h3>තොරතුරු හා සන්නිවේදන තාක්ෂණය</h3>
                        <p>ICT</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                <?php elseif ($selected_stream == 'bio'): ?>
                    <!-- 2. ජීව විද්‍යා ධාරාව -->
                    <a href="al-resources.php?stream=bio&subject=Biology" class="select-card">
                        <div class="icon">🧬</div>
                        <h3>ජීව විද්‍යාව</h3>
                        <p>Biology</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>
                    <a href="al-resources.php?stream=bio&subject=Chemistry" class="select-card">
                        <div class="icon">🧪</div>
                        <h3>රසායන විද්‍යාව</h3>
                        <p>Chemistry</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>
                    <a href="al-resources.php?stream=bio&subject=Physics" class="select-card">
                        <div class="icon">🧲</div>
                        <h3>භෞතික විද්‍යාව</h3>
                        <p>Physics</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>
                    <a href="al-resources.php?stream=bio&subject=Agri" class="select-card">
                        <div class="icon">🌾</div>
                        <h3>කෘෂි විද්‍යාව</h3>
                        <p>Agricultural Science</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>
                    <a href="al-resources.php?stream=bio&subject=ICT" class="select-card">
                        <div class="icon">💻</div>
                        <h3>තොරතුරු හා සන්නිවේදන තාක්ෂණය</h3>
                        <p>ICT</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                <?php elseif ($selected_stream == 'commerce'): ?>
                    <!-- 3. වාණිජ ධාරාව -->
                    <a href="al-resources.php?stream=commerce&subject=Accounting" class="select-card">
                        <div class="icon">📑</div>
                        <h3>ගිණුම්කරණය</h3>
                        <p>Accounting</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>
                    <a href="al-resources.php?stream=commerce&subject=BS" class="select-card">
                        <div class="icon">🏢</div>
                        <h3>ව්‍යාපාර අධ්‍යයනය</h3>
                        <p>Business Studies</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>
                    <a href="al-resources.php?stream=commerce&subject=Econ" class="select-card">
                        <div class="icon">📈</div>
                        <h3>ආර්ථික විද්‍යාව</h3>
                        <p>Economics</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>
                    <a href="al-resources.php?stream=commerce&subject=ICT" class="select-card">
                        <div class="icon">💻</div>
                        <h3>තොරතුරු හා සන්නිවේදන තාක්ෂණය</h3>
                        <p>ICT</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>
                    <a href="al-resources.php?stream=commerce&subject=Stats" class="select-card">
                        <div class="icon">📊</div>
                        <h3>ව්‍යාපාර සංඛ්‍යානය</h3>
                        <p>Business Statistics</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                <?php elseif ($selected_stream == 'tech'): ?>
                    <!-- 4. තාක්ෂණවේදය ධාරාව -->
                    <a href="al-resources.php?stream=tech&subject=SFT" class="select-card">
                        <div class="icon">⚙️</div>
                        <h3>තාක්ෂණවේදය සඳහා විද්‍යාව</h3>
                        <p>Science for Technology (SFT)</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>
                    <a href="al-resources.php?stream=tech&subject=ET" class="select-card">
                        <div class="icon">🛠️</div>
                        <h3>ඉංජිනේරු තාක්ෂණවේදය</h3>
                        <p>Engineering Technology (ET)</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>
                    <a href="al-resources.php?stream=tech&subject=BST" class="select-card">
                        <div class="icon">🌱</div>
                        <h3>ජීව පද්ධති තාක්ෂණවේදය</h3>
                        <p>Bio Systems Technology (BST)</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>
                    <a href="al-resources.php?stream=tech&subject=ICT" class="select-card">
                        <div class="icon">💻</div>
                        <h3>තොරතුරු හා සන්නිවේදන තාක්ෂණය</h3>
                        <p>ICT</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>
                    <a href="al-resources.php?stream=tech&subject=Econ" class="select-card">
                        <div class="icon">📈</div>
                        <h3>ආර්ථික විද්‍යාව</h3>
                        <p>Economics</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>
                    <a href="al-resources.php?stream=tech&subject=Geography" class="select-card">
                        <div class="icon">🌍</div>
                        <h3>භූගෝල විද්‍යාව</h3>
                        <p>Geography</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                <?php elseif ($selected_stream == 'arts'): ?>
                    <!-- 5. කලා ධාරාව -->
                    <a href="al-resources.php?stream=arts&subject=Econ" class="select-card">
                        <div class="icon">📈</div>
                        <h3>ආර්ථික විද්‍යාව</h3>
                        <p>Economics</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>
                    <a href="al-resources.php?stream=arts&subject=Political_Science" class="select-card">
                        <div class="icon">🏛️</div>
                        <h3>දේශපාලන විද්‍යාව</h3>
                        <p>Political Science</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>
                    <a href="al-resources.php?stream=arts&subject=Logic" class="select-card">
                        <div class="icon">🧠</div>
                        <h3>තර්කශාස්ත්‍රය</h3>
                        <p>Logic & Scientific Method</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>
                    <a href="al-resources.php?stream=arts&subject=Media" class="select-card">
                        <div class="icon">🎙️</div>
                        <h3>සන්නිවේදනය හා මාධ්‍ය අධ්‍යයනය</h3>
                        <p>Media Studies</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>
                    <a href="al-resources.php?stream=arts&subject=Geography" class="select-card">
                        <div class="icon">🌍</div>
                        <h3>භූගෝල විද්‍යාව</h3>
                        <p>Geography</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>
                    <a href="al-resources.php?stream=arts&subject=Agri" class="select-card">
                        <div class="icon">🌾</div>
                        <h3>කෘෂි විද්‍යාව</h3>
                        <p>Agricultural Science</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>
                    <a href="al-resources.php?stream=arts&subject=Buddhism" class="select-card">
                        <div class="icon">☸️</div>
                        <h3>බෞද්ධ දර්ශනය / සංස්කෘතිය</h3>
                        <p>Buddhist Civilization & Philosophy</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>
                    <a href="al-resources.php?stream=arts&subject=Languages" class="select-card">
                        <div class="icon">🗣️</div>
                        <h3>භාෂා හා සාහිත්‍යය</h3>
                        <p>සිංහල, ඉංග්‍රීසි, දෙමළ, ජපන්, චීන ආදී</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>
                    <a href="al-resources.php?stream=arts&subject=Aesthetics" class="select-card">
                        <div class="icon">🎨</div>
                        <h3>සෞන්දර්යාත්මක විෂයන්</h3>
                        <p>චිත්‍ර, සංගීත, නැටුම්, නාට්‍ය</p>
                        <div class="action-btn">තෝරන්න</div>
                    </a>

                <?php endif; ?>

            </div>

        <!-- STEP 3: Notes ද Papers ද කියා තේරීම -->
        <?php elseif ($selected_stream && $selected_subject && !$selected_type): ?>

            <div class="breadcrumb">
                <a href="al-resources.php">A/L ධාරාවන්</a> &gt; 
                <a href="al-resources.php?stream=<?php echo $selected_stream; ?>">
                    <?php 
                        if($selected_stream == 'maths') echo 'භෞතික විද්‍යා ධාරාව';
                        elseif($selected_stream == 'bio') echo 'ජීව විද්‍යා ධාරාව';
                        elseif($selected_stream == 'commerce') echo 'වාණිජ ධාරාව';
                        elseif($selected_stream == 'tech') echo 'තාක්ෂණවේදය ධාරාව';
                        elseif($selected_stream == 'arts') echo 'කලා ධාරාව';
                    ?>
                </a> &gt;
                <b><?php echo htmlspecialchars($selected_subject); ?></b>
            </div>

            <h2 style="text-align: center; color: #0f172a; margin-bottom: 20px;">
                ඔබට අවශ්‍ය කොටස තෝරන්න
            </h2>

            <div class="selection-grid" style="justify-content: center; max-width: 700px; margin: 30px auto;">
                
                <!-- Short Notes Card -->
                <a href="al-resources.php?stream=<?php echo $selected_stream; ?>&subject=<?php echo$selected_subject; ?>&type=notes" class="select-card">
                    <div class="icon">📝</div>
                    <h3>Short Notes & Study Materials</h3>
                    <p>පාඩම් සටහන්, කෙටි සටහන් සහ අධ්‍යයන ද්‍රව්‍ය</p>
                    <div class="action-btn">Notes බලන්න</div>
                </a>

                <!-- Papers Card -->
                <a href="al-resources.php?stream=<?php echo $selected_stream; ?>&subject=<?php echo$selected_subject; ?>&type=papers" class="select-card">
                    <div class="icon">📄</div>
                    <h3>Past Papers & Model Papers</h3>
                    <p>පසුගිය විභාග ප්‍රශ්න පත්‍ර සහ ආදර්ශ ප්‍රශ්න පත්‍ර</p>
                    <div class="action-btn">Papers කොටසට යන්න</div>
                </a>

            </div>

        <!-- STEP 4: Papers තේරූ විට Past Papers ද Model Papers ද කියා තේරීම -->
        <?php elseif ($selected_stream &&$selected_subject && $selected_type == 'papers' && !$selected_subtype): ?>

            <div class="breadcrumb">
                <a href="al-resources.php">A/L ධාරාවන්</a> &gt; 
                <a href="al-resources.php?stream=<?php echo $selected_stream; ?>">
                    <?php 
                        if($selected_stream == 'maths') echo 'භෞතික විද්‍යා ධාරාව';
                        elseif($selected_stream == 'bio') echo 'ජීව විද්‍යා ධාරාව';
                        elseif($selected_stream == 'commerce') echo 'වාණිජ ධාරාව';
                        elseif($selected_stream == 'tech') echo 'තාක්ෂණවේදය ධාරාව';
                        elseif($selected_stream == 'arts') echo 'කලා ධාරාව';
                    ?>
                </a> &gt;
                <a href="al-resources.php?stream=<?php echo $selected_stream; ?>&subject=<?php echo$selected_subject; ?>">
                    <?php echo htmlspecialchars($selected_subject); ?>
                </a> &gt;
                <b>Papers</b>
            </div>

            <h2 style="text-align: center; color: #0f172a; margin-bottom: 20px;">
                ප්‍රශ්න පත්‍ර වර්ගය තෝරන්න
            </h2>

            <div class="selection-grid" style="justify-content: center; max-width: 700px; margin: 30px auto;">
                
                <!-- Past Papers Box -->
                <a href="al-resources.php?stream=<?php echo $selected_stream; ?>&subject=<?php echo$selected_subject; ?>&type=papers&subtype=past_papers" class="select-card">
                    <div class="icon">📚</div>
                    <h3>Past Papers</h3>
                    <p>පසුගිය වසරවල A/L විභාග ප්‍රශ්න පත්‍ර සහ ලකුණු දීමේ පටිපාටි (Marking Schemes)</p>
                    <div class="action-btn">Past Papers බලන්න</div>
                </a>

                <!-- Model Papers Box -->
                <a href="al-resources.php?stream=<?php echo $selected_stream; ?>&subject=<?php echo$selected_subject; ?>&type=papers&subtype=model_papers" class="select-card">
                    <div class="icon">📑</div>
                    <h3>Model Papers</h3>
                    <p>ආදර්ශ ප්‍රශ්න පත්‍ර සහ ප්‍රසිද්ධ පාසල්/ගුරුවරුන්ගේ ප්‍රශ්න පත්‍ර</p>
                    <div class="action-btn">Model Papers බලන්න</div>
                </a>

            </div>

        <!-- STEP 5: අවසාන PDF / Resources පෙන්වීම -->
        <?php else: ?>

            <div class="breadcrumb">
                <a href="al-resources.php">A/L ධාරාවන්</a> &gt; 
                <a href="al-resources.php?stream=<?php echo $selected_stream; ?>">
                    <?php 
                        if($selected_stream == 'maths') echo 'භෞතික විද්‍යා ධාරාව';
                        elseif($selected_stream == 'bio') echo 'ජීව විද්‍යා ධාරාව';
                        elseif($selected_stream == 'commerce') echo 'වාණිජ ධාරාව';
                        elseif($selected_stream == 'tech') echo 'තාක්ෂණවේදය ධාරාව';
                        elseif($selected_stream == 'arts') echo 'කලා ධාරාව';
                    ?>
                </a> &gt;
                <a href="al-resources.php?stream=<?php echo $selected_stream; ?>&subject=<?php echo$selected_subject; ?>">
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
                <?php echo htmlspecialchars($selected_subject); ?> - 
                <?php 
                    if ($selected_type == 'notes') echo 'Short Notes';
                    elseif ($selected_subtype == 'past_papers') echo 'Past Papers';
                    elseif ($selected_subtype == 'model_papers') echo 'Model Papers';
                ?>
            </h2>

            <div class="resources-grid">
                <?php 
                if ($result &&$result->num_rows > 0) {
                    while($row =$result->fetch_assoc()) {
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