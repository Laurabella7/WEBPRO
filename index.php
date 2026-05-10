<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkyWings – Fly to Your Dream Destination</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            /* Dark Theme (Default) */
            --bg-body: #0d1117;
            --bg-sidebar: #161b27;
            --bg-card: rgba(28, 35, 51, 0.9);
            --text-main: #e8eaf0;
            --text-muted: #8892a4;
            --border-color: rgba(255, 255, 255, 0.08);
            --gold: #c9a84c;
            --accent-bg: #1c2333;
        }

        body.light-theme {
            /* Light Theme (Reference Style) */
            --bg-body: #f4f7fa;
            --bg-sidebar: #ffffff;
            --bg-card: #ffffff;
            --text-main: #1a1d23;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --gold: #b38e2f;
            --accent-bg: #f8fafc;
        }

        body {
            background: var(--bg-body);
            color: var(--text-main);
            font-family: 'DM Sans', sans-serif;
            transition: background 0.3s, color 0.3s;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            position: fixed; top: 0; left: 0;
            width: 80px; height: 100vh;
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border-color);
            display: flex; flex-direction: column;
            align-items: center; padding: 30px 0;
            z-index: 100;
        }
        .sidebar-logo { color: var(--gold); font-size: 28px; margin-bottom: 40px; }
        .sidebar-nav { display: flex; flex-direction: column; gap: 15px; width: 100%; }
        .sidebar-item {
            display: flex; flex-direction: column;
            align-items: center; gap: 5px;
            padding: 15px 0; color: var(--text-muted);
            text-decoration: none; font-size: 11px;
            transition: 0.2s;
        }
        .sidebar-item i { font-size: 22px; }
        .sidebar-item.active, .sidebar-item:hover { color: var(--gold); background: rgba(179, 142, 47, 0.05); }

        /* ── MAIN CONTENT ── */
        .main { margin-left: 80px; padding-bottom: 50px; }

        .topbar {
            display: flex; justify-content: space-between; align-items: center;
            padding: 20px 40px;
        }
        .theme-toggle {
            cursor: pointer; font-size: 20px; color: var(--text-muted);
            background: var(--accent-bg); border: 1px solid var(--border-color);
            padding: 8px 12px; border-radius: 10px;
        }

        /* ── HERO ── */
        .hero {
            padding: 40px 60px;
            display: flex; align-items: center;
            min-height: 400px;
            background: radial-gradient(circle at 80% 20%, rgba(201,168,76,0.05) 0%, transparent 50%);
        }
        .hero-title { font-family: 'Playfair Display', serif; font-size: 64px; line-height: 1.1; font-weight: 700; }
        .hero-title span { color: var(--gold); font-style: italic; }

        /* ── SEARCH CARD ── */
        .search-section { padding: 0 60px; margin-top: -40px; }
        .search-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 24px; padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.05);
        }
        .trip-tabs { display: flex; gap: 10px; margin-bottom: 25px; }
        .trip-tab {
            padding: 10px 24px; border-radius: 12px; border: none;
            background: var(--accent-bg); color: var(--text-muted);
            font-weight: 500; transition: 0.3s;
        }
        .trip-tab.active { background: var(--text-main); color: var(--bg-body); }

        /* Modern Grid Layout */
        .search-grid {
            display: grid;
            grid-template-columns: 1.5fr auto 1.5fr 1fr 1fr auto;
            gap: 20px; align-items: center;
        }
        .input-box {
            background: var(--accent-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px; padding: 12px 18px;
            position: relative;
        }
        .label { font-size: 11px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 4px; }
        .val-select {
            width: 100%; background: transparent; border: none;
            color: var(--text-main); font-size: 18px; font-weight: 700; outline: none;
        }
        
        /* Price Indicator Style */
        #price-info {
            font-size: 11px; font-weight: 600; padding: 2px 8px;
            border-radius: 20px; margin-top: 5px; display: inline-block;
        }
        .price-low { background: #dcfce7; color: #166534; }
        .price-high { background: #fee2e2; color: #991b1b; }
        .price-normal { background: #f1f5f9; color: #475569; }

        .btn-search-main {
            width: 60px; height: 60px; border-radius: 18px;
            background: var(--gold); border: none; color: white;
            font-size: 24px; display: flex; align-items: center; justify-content: center;
        }
    </style>
</head>
<body class="light-theme"> <?php include_once('db_connect.php'); ?>

<div class="sidebar">
    <div class="sidebar-logo"><i class="bi bi-wind"></i></div>
    <nav class="sidebar-nav">
        <a href="index.php" class="sidebar-item active"><i class="bi bi-house"></i><span>Home</span></a>
        <a href="search.php" class="sidebar-item"><i class="bi bi-airplane"></i><span>Flights</span></a>
        <a href="my_booking.php" class="sidebar-item"><i class="bi bi- luggage"></i><span>Trips</span></a>
    </nav>
</div>

<div class="main">
    <div class="topbar">
        <div class="promo-badge" style="color: var(--gold); font-weight: 600;">
            <span style="background: var(--gold); color: white; padding: 2px 8px; border-radius: 5px; font-size: 12px; margin-right: 10px;">New</span>
            Get 10% off your first booking
        </div>
        <div class="topbar-right d-flex align-items-center gap-3">
            <div class="theme-toggle" onclick="toggleTheme()">
                <i id="theme-icon" class="bi bi-moon"></i>
            </div>
            <div class="avatar" style="width: 40px; height: 40px; border-radius: 50%; background: #ddd; display:flex; align-items:center; justify-content:center; font-weight: bold;">G</div>
        </div>
    </div>

    <div class="hero">
        <div class="hero-content">
            <h1 class="hero-title">Fly to your<br>dream <span>destination</span></h1>
            <p style="color: var(--text-muted); margin-top: 20px;">Find the best flight deals to anywhere in the world.</p>
        </div>
    </div>

    <div class="search-section">
        <div class="search-card">
            <div class="trip-tabs">
                <button class="trip-tab active" onclick="setTrip('oneway')">One Way</button>
                <button class="trip-tab" onclick="setTrip('roundtrip')">Round Trip</button>
            </div>

            <form action="search.php" method="GET">
                <div class="search-grid">
                    <div class="input-box">
                        <div class="label">From</div>
                        <select name="origin_id" class="val-select">
                            <option value="1">CGK (Jakarta)</option>
                            <option value="2">NRT (Tokyo)</option>
                        </select>
                    </div>

                    <i class="bi bi-arrow-left-right" style="color: var(--text-muted); font-size: 20px;"></i>

                    <div class="input-box">
                        <div class="label">To</div>
                        <select name="destination_id" class="val-select">
                            <option value="2" selected>NRT (Tokyo)</option>
                            <option value="1">CGK (Jakarta)</option>
                        </select>
                    </div>

                    <div class="input-box">
                        <div class="label">Departure</div>
                        <input type="date" id="dep-date" name="departure_date" class="val-select" style="font-size: 14px;" onchange="checkPrice(this.value)">
                        <span id="price-indicator" style="display:none;"></span>
                    </div>

                    <div class="input-box" id="return-box" style="opacity: 0.5; pointer-events: none;">
                        <div class="label">Return</div>
                        <input type="date" name="return_date" class="val-select" style="font-size: 14px;">
                    </div>

                    <button type="submit" class="btn-search-main">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleTheme() {
        const body = document.body;
        const icon = document.getElementById('theme-icon');
        body.classList.toggle('light-theme');
        
        if(body.classList.contains('light-theme')) {
            icon.className = 'bi bi-moon';
        } else {
            icon.className = 'bi bi-sun';
        }
    }

    function setTrip(type) {
        const tabs = document.querySelectorAll('.trip-tab');
        const returnBox = document.getElementById('return-box');
        tabs.forEach(t => t.classList.remove('active'));
        event.target.classList.add('active');

        if(type === 'roundtrip') {
            returnBox.style.opacity = "1";
            returnBox.style.pointerEvents = "auto";
        } else {
            returnBox.style.opacity = "0.5";
            returnBox.style.pointerEvents = "none";
        }
    }

    function checkPrice(date) {
        const indicator = document.getElementById('price-indicator');
        indicator.style.display = "inline-block";
        
        // Simulating price check logic
        const day = new Date(date).getDay();
        if(day === 0 || day === 6) { // Weekends
            indicator.innerHTML = "Price: High Peak 📈";
            indicator.className = "price-high";
            indicator.style.color = "red";
        } else if (day === 2 || day === 3) { // Midweek
            indicator.innerHTML = "Price: Best Deal ✨";
            indicator.className = "price-low";
            indicator.style.color = "green";
        } else {
            indicator.innerHTML = "Price: Normal";
            indicator.className = "price-normal";
            indicator.style.color = "gray";
        }
    }
</script>
</body>
</html>