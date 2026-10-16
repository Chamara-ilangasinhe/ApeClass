<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="mVzdMsfxog_pR_dth7bZIuPyNi-oUdHFkknM2ml1_ig" />
    <!-- Google Search & Browser Tab Favicon / Logo -->
    <link rel="icon" type="image/svg+xml" href="logo.svg">
    <link rel="apple-touch-icon" href="logo.svg">
    

    <!-- SEO Meta Tags -->
    <meta name="description" content="5 ශ්‍රේණිය ශිෂ්‍යත්වය, G.C.E. O/L සහ A/L සියලුම විෂයන්හි Past Papers, Model Papers, Short Notes නොමිලේ ලබාගන්න - ApeClass.">
    <meta name="keywords" content="ApeClass, AL Past Papers Sri Lanka, OL Past Papers, Grade 5 Scholarship Papers, Combined Maths Short Notes, Accounting Past Papers">
    <meta name="author" content="ApeClass">
    <meta name="robots" content="index, follow">

    <!-- Social Media Share Preview Title -->
    <meta property="og:title" content="ApeClass">
    <meta property="og:description" content="ශිෂ්‍යත්වය, O/L සහ A/L පහසුවෙන්ම ගොඩදාන්න Past Papers සහ Short Notes එකම තැනකින් ලබාගන්න.">
    <meta property="og:type" content="website">

    <title>ApeClass | Learning Hub</title>
    <link rel="stylesheet" href="style.css">
    <!-- `?v=1.1` කොටස එකතු කරන්න -->
    <link rel="stylesheet" href="style.css?v=1.1">
    
    <!-- Header එකට යටින් Search bar එක තැබීමට අවශ්‍ය CSS -->
    <style>
        .header-search-section {
            background-color: #0f172a; /* Header එකේ Background පාටට ගැලපෙන ලෙස */
            padding: 10px 20px 15px 20px;
            display: flex;
            justify-content: center;
        }

        .header-search-wrapper {
            max-width: 600px;
            width: 100%;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 12px 20px;
            font-size: 15px;
            border: 2px solid #0284c7;
            border-radius: 30px;
            outline: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            box-sizing: border-box;
            background-color: #ffffff;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            box-shadow: 0 4px 15px rgba(2, 132, 199, 0.4);
            border-color: #38bdf8;
        }

        .results-container {
            max-width: 800px;
            margin: 20px auto 0 auto;
            padding: 0 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .resource-card {
            background: #ffffff;
            padding: 16px 22px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: left;
        }

        .resource-info h3 {
            margin: 0 0 5px 0;
            font-size: 17px;
            color: #1e293b;
        }

        .resource-info p {
            margin: 0;
            font-size: 14px;
            color: #64748b;
        }

        .btn-open {
            background-color: #0284c7;
            color: white !important;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 14px;
            white-space: nowrap;
        }

        .btn-open:hover {
            background-color: #0369a1;
        }

        @media (max-width: 600px) {
            .resource-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            .btn-open {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>

    <!-- 1. Header Navigation -->
    <header>
        <div class="logo">Ape<span>Class</span></div>
        <input class="menu-btn" type="checkbox" id="menu-btn" style="display:none;" />
        <label class="menu-icon" for="menu-btn"><span class="nav-icon"></span></label>
        <nav>
            <ul>
                <li><a href="index.php" class="active">මුල් පිටුව</a></li>
                <li><a href="scholarship-resources.php">5 ශ්‍රේණිය (ශිෂ්‍යත්වය)</a></li>
                <li><a href="secondary-resources.php">O/L Section</a></li>
                <li><a href="al-resources.php">A/L Section</a></li>
            </ul>
        </nav>
    </header>

    <!-- Header එකේ Menu එකට කෙලින්ම යටින් Search Bar එක -->
    <div class="header-search-section">
        <div class="header-search-wrapper">
            <input type="text" id="searchInput" class="search-input" placeholder="🔍 ඕනෑම Past Paper එකක්, Short Note එකක් Search කරන්න...">
        </div>
    </div>

    <!-- Live Search Results පෙනෙන ස්ථානය -->
    <div class="results-container" id="searchResults"></div>

    <!-- 2. Hero Section -->
    <section class="hero">
        <h1>ශිෂ්‍යත්වය, O/L සහ A/L පහසුවෙන්ම ගොඩදාන්න <span>ApeClass</span></h1>
        <p>Short Notes, Past Papers සහ Model Papers එකම තැනකින් ලබාගන්න.</p>
        <div class="hero-buttons">
            <a href="#categories" class="btn primary-btn">පාඩම් පටන් ගනිමු</a>
        </div>
    </section>

    <!-- 3. Stream / Category Selection -->
    <section id="categories" class="categories">
        <h2>ඔබේ ශ්‍රේණිය තෝරන්න</h2>
        <div class="card-container">
            
            <!-- Grade 5 Scholarship Card -->
            <div class="card">
                <div class="card-icon">✏️</div>
                <h3>5 ශ්‍රේණිය (ශිෂ්‍යත්වය)</h3>
                <p>5 ශ්‍රේණිය ශිෂ්‍යත්ව විභාගය සඳහා විශේෂ කෙටි සටහන්, ආදර්ශ ප්‍රශ්න පත්‍ර සහ පසුගිය විභාග ප්‍රශ්න පත්‍ර</p>
                <a href="scholarship-resources.php" class="card-btn" style="text-decoration: none; display: block; text-align: center;">5 ශ්‍රේණිය Section එකට යන්න</a>
            </div>

            <!-- G.C.E. O/L Card -->
            <div class="card">
                <div class="card-icon">📚</div>
                <h3>G.C.E. O/L</h3>
                <p>සාමාන්‍ය පෙළ සියලුම විෂයන් සඳහා Short Notes, Model Papers සහ Past Papers</p>
                <a href="secondary-resources.php" class="card-btn" style="text-decoration: none; display: block; text-align: center;">O/L Section එකට යන්න</a>
            </div>

            <!-- G.C.E. A/L Card -->
            <div class="card">
                <div class="card-icon">🎓</div>
                <h3>G.C.E. A/L</h3>
                <p>උසස් පෙළ Maths, Science, Commerce, Arts සහ Tech විෂයන් හි සම්පූර්ණ සම්පත්</p>
                <a href="al-resources.php" class="card-btn" style="text-decoration: none; display: block; text-align: center;">A/L Section එකට යන්න</a>
            </div>

        </div>
    </section>

    <!-- 4. Footer Section -->
    <footer style="text-align: center; padding: 20px; background: #0f172a; color: #94a3b8; margin-top: 40px; font-size: 14px;">
        <p>&copy; <?php echo date('Y'); ?> ApeClass. All rights reserved.</p>
        <p>
            <a href="privacy-policy.php" style="color: #38bdf8; text-decoration: none; margin: 0 10px;">Privacy Policy</a> | 
            <a href="terms.php" style="color: #38bdf8; text-decoration: none; margin: 0 10px;">Terms & Conditions</a>
        </p><br>
        <a href="admin-secret-portal.php" style="color:#38bdf8; text-decoration:none; margin: 0 10px;">Admin Portal</a>
    </footer>

    <!-- Live Search JavaScript Code -->
    <script>
        const searchInput = document.getElementById('searchInput');
        const resultsDiv = document.getElementById('searchResults');

        searchInput.addEventListener('keyup', function() {
            const query = this.value.trim();

            if (query.length > 0) {
                fetch('fetch_resources.php?q=' + encodeURIComponent(query))
                    .then(response => response.text())
                    .then(data => {
                        resultsDiv.innerHTML = data;
                    })
                    .catch(error => console.error('Error fetching data:', error));
            } else {
                resultsDiv.innerHTML = '';
            }
        });
    </script>

</body>
</html>