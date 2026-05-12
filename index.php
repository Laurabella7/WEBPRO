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
            --bg: #f0f4f8;
            --bg2: #e4eaf2;
            --card-bg: #ffffff;
            --sidebar-bg: #1a2340;
            --sidebar-active: #2a3a60;
            --gold: #c47d20;
            --gold2: #e09830;
            --gold-light: #fdf3e3;
            --text: #1a2340;
            --muted: #7a8aaa;
            --border: rgba(26,35,64,0.10);
            --sky: #2563eb;
            --sky2: #3b82f6;
            --shadow: 0 4px 32px rgba(37,99,235,0.08);
        }

        * { box-sizing:border-box; margin:0; padding:0; }
        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            position:fixed;top:0;left:0;width:72px;height:100vh;
            background: var(--sidebar-bg);
            border-right: none;
            display:flex;flex-direction:column;align-items:center;padding:24px 0;z-index:100;
            box-shadow: 4px 0 24px rgba(26,35,64,0.12);
        }
        .sidebar-logo { color: var(--gold2); font-size:24px; margin-bottom:36px; }
        .sidebar-nav { display:flex;flex-direction:column;gap:8px;width:100%; }
        .sidebar-item {
            display:flex;flex-direction:column;align-items:center;gap:4px;
            padding:12px 0;cursor:pointer;color:rgba(255,255,255,0.45);
            font-size:10px;transition:all .2s;text-decoration:none;border-left:3px solid transparent;
        }
        .sidebar-item i { font-size:20px; }
        .sidebar-item:hover { color:rgba(255,255,255,0.85); background:rgba(255,255,255,.06); border-left-color: var(--gold2); }
        .sidebar-item.active { color:#fff; background: var(--sidebar-active); border-left-color: var(--gold2); }

        /* ── MAIN CONTENT ── */
        .main { margin-left: 72px; padding-bottom: 60px; }

        .topbar {
            display: flex; justify-content: space-between; align-items: center;
            padding: 20px 48px;
            background: transparent;
        }

        /* ── HERO ── */
        .hero {
            position: relative;
            padding: 48px 60px 120px;
            display: flex; align-items: center;
            min-height: 420px;
            overflow: hidden;
            background: linear-gradient(135deg, #1a2340 0%, #2563eb 60%, #4fa3e0 100%);
        }
        /* Decorative sky circles */
        .hero::before {
            content: '';
            position: absolute; top: -80px; right: -80px;
            width: 420px; height: 420px; border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero::after {
            content: '';
            position: absolute; bottom: -60px; left: 30%;
            width: 600px; height: 200px; border-radius: 50%;
            background: rgba(255,255,255,0.06);
            transform: rotate(-6deg);
            pointer-events: none;
        }
        /* Floating cloud blobs */
        .hero-cloud {
            position: absolute; border-radius: 100px;
            background: rgba(255,255,255,0.07);
            pointer-events: none;
        }
        .hero-cloud.c1 { width:260px; height:60px; top:60px; right:200px; }
        .hero-cloud.c2 { width:180px; height:44px; top:110px; right:120px; opacity:0.5; }
        .hero-cloud.c3 { width:100px; height:30px; bottom:100px; left:200px; opacity:0.4; }

        .hero-content { position: relative; z-index:2; }
        .hero-eyebrow {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,0.13); border: 1px solid rgba(255,255,255,0.18);
            border-radius: 20px; padding: 6px 16px;
            color: rgba(255,255,255,0.85); font-size: 13px; font-weight: 500;
            margin-bottom: 20px; backdrop-filter: blur(6px);
        }
        .hero-eyebrow span { background: var(--gold2); color: #fff; border-radius: 10px; padding: 2px 8px; font-size: 11px; font-weight: 700; }
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 62px; line-height: 1.08; font-weight: 700;
            color: #fff; letter-spacing: -1px;
        }
        .hero-title em { color: var(--gold2); font-style: italic; }
        .hero-subtitle { color: rgba(255,255,255,0.65); margin-top: 16px; font-size: 16px; max-width: 420px; }

        /* ── SEARCH CARD ── */
        .search-section { padding: 0 48px; margin-top: -70px; position: relative; z-index: 10; }
        .search-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 28px; padding: 32px 36px;
            box-shadow: 0 20px 60px rgba(37,99,235,0.13), 0 2px 8px rgba(0,0,0,0.05);
        }
        .trip-tabs { display: flex; gap: 8px; margin-bottom: 26px; }
        .trip-tab {
            padding: 9px 22px; border-radius: 10px; border: 1.5px solid var(--border);
            background: transparent; color: var(--muted);
            font-weight: 600; font-size: 13px; transition: 0.2s; cursor: pointer;
            font-family: 'DM Sans', sans-serif;
        }
        .trip-tab.active { background: var(--sky); color: #fff; border-color: var(--sky); }
        .trip-tab:not(.active):hover { border-color: var(--sky2); color: var(--sky); }

        /* Modern Grid Layout */
        .search-grid {
            display: grid;
            grid-template-columns: 1.5fr auto 1.5fr 1fr 0.7fr 1fr auto;
            gap: 14px; align-items: center;
        }
        .input-box {
            background: var(--bg);
            border: 1.5px solid var(--border);
            border-radius: 16px; padding: 12px 18px;
            position: relative; transition: border-color 0.2s, box-shadow 0.2s;
        }
        .input-box:focus-within {
            border-color: var(--sky);
            box-shadow: 0 0 0 3px rgba(37,99,235,0.08);
        }
        .label {
            font-size: 10px; color: var(--muted);
            text-transform: uppercase; letter-spacing: 0.8px;
            margin-bottom: 5px; font-weight: 600;
        }
        .val-select {
            width: 100%; background: transparent; border: none;
            color: var(--text); font-size: 17px; font-weight: 700;
            outline: none; font-family: 'DM Sans', sans-serif;
        }
        .val-select option { background: #fff; color: var(--text); }

        .swap-btn {
            color: var(--muted); font-size: 18px; cursor: pointer;
            transition: all 0.22s; display: flex; align-items: center; justify-content: center;
            width: 40px; height: 40px; border-radius: 50%;
            background: var(--card-bg); border: 1.5px solid var(--border);
            box-shadow: var(--shadow);
        }
        .swap-btn:hover { color: var(--sky); border-color: var(--sky); transform: rotate(180deg); box-shadow: 0 4px 16px rgba(37,99,235,0.12); }

        .btn-search-main {
            height: 56px; padding: 0 28px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--sky) 0%, #4fa3e0 100%);
            border: none; color: #fff;
            font-size: 15px; font-weight: 700;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            cursor: pointer; transition: all 0.2s;
            font-family: 'DM Sans', sans-serif;
            box-shadow: 0 6px 20px rgba(37,99,235,0.25);
            white-space: nowrap;
        }
        .btn-search-main:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(37,99,235,0.35); }
        .btn-search-main i { font-size: 18px; }

        /* ── PROMO BADGE ── */
        .promo-badge {
            display: inline-flex; align-items: center; gap: 8px;
            color: var(--text); font-weight: 600; font-size: 14px;
        }
        .promo-tag {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold2) 100%);
            color: #fff; padding: 3px 10px; border-radius: 6px;
            font-size: 11px; font-weight: 700; letter-spacing: 0.5px;
        }

        /* ── STATS ROW ── */
        .stats-row {
            display: flex; gap: 40px;
            padding: 40px 48px 0;
        }
        .stat-item { text-align: center; }
        .stat-num { font-size: 28px; font-weight: 800; color: var(--sky); letter-spacing: -1px; }
        .stat-label { font-size: 12px; color: var(--muted); margin-top: 2px; }
    </style>
</head>
<body> 
<?php 
include_once('db_connect.php'); 
// Fetch dynamic airports for the select boxes
$airports_q = mysqli_query($conn, "SELECT * FROM airport ORDER BY city");
$airports = [];
while($a = mysqli_fetch_assoc($airports_q)) $airports[] = $a;
?>

<div class="sidebar">
    <div class="sidebar-logo"><i class="bi bi-send-fill" style="transform:rotate(-45deg);display:inline-block"></i></div>
    <nav class="sidebar-nav">
        <a href="index.php" class="sidebar-item active"><i class="bi bi-house-fill"></i><span>Home</span></a>
        <a href="search.php" class="sidebar-item"><i class="bi bi-airplane-fill"></i><span>Flights</span></a>
        <a href="my_booking.php" class="sidebar-item"><i class="bi bi-journal-bookmark-fill"></i><span>Trips</span></a>
    </nav>
</div>

<div class="main">
    <div class="topbar">
        <div class="promo-badge">
            <span class="promo-tag">NEW</span>
            Get 10% off your first booking
        </div>
        <div class="topbar-right d-flex align-items-center gap-3">
            <div style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,var(--sky),#4fa3e0);display:flex;align-items:center;justify-content:center;font-weight:800;color:#fff;font-size:15px;box-shadow:0 4px 12px rgba(37,99,235,0.25);">N</div>
        </div>
    </div>

    <div class="hero">
        <div class="hero-cloud c1"></div>
        <div class="hero-cloud c2"></div>
        <div class="hero-cloud c3"></div>
        <div class="hero-content">
            <div class="hero-eyebrow"><span>✦ NEW</span> 10% off your first flight</div>
            <h1 class="hero-title">Fly to your<br>dream <em>destination</em></h1>
            <p class="hero-subtitle">Discover the best flight deals to hundreds of destinations worldwide.</p>
        </div>
    </div>

    <div class="search-section">
        <div class="search-card">
            <div class="trip-tabs">
                <button class="trip-tab active" onclick="setTrip('oneway')">One Way</button>
                <button class="trip-tab" onclick="setTrip('roundtrip')">Round Trip</button>
            </div>

            <form action="search.php" method="GET" id="searchForm">
                <input type="hidden" name="trip_type" id="trip_type_input" value="oneway">
                
                <div class="search-grid">
                    <div class="input-box">
                        <div class="label"><i class="bi bi-geo-alt-fill" style="color:var(--sky);margin-right:3px"></i>From</div>
                        <select name="origin_id" id="origin_id" class="val-select">
                            <?php foreach($airports as $ap): ?>
                            <option value="<?php echo $ap['id']; ?>" <?php echo $ap['code']=='CGK'?'selected':''; ?>>
                                <?php echo $ap['code']; ?> (<?php echo $ap['city']; ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="swap-btn" onclick="swapAirports()" title="Swap Origin and Destination">
                        <i class="bi bi-arrow-left-right"></i>
                    </div>

                    <div class="input-box">
                        <div class="label"><i class="bi bi-geo-fill" style="color:var(--gold);margin-right:3px"></i>To</div>
                        <select name="destination_id" id="destination_id" class="val-select">
                            <?php foreach($airports as $ap): ?>
                            <option value="<?php echo $ap['id']; ?>" <?php echo $ap['code']=='NRT'?'selected':''; ?>>
                                <?php echo $ap['code']; ?> (<?php echo $ap['city']; ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="input-box">
                        <div class="label"><i class="bi bi-calendar3" style="margin-right:3px"></i>Departure</div>
                        <input type="date" id="dep-date" name="departure_date" class="val-select" style="font-size: 14px;" value="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
                    </div>

                    <div class="input-box" id="return-box" style="opacity: 0.5; pointer-events: none;">
                        <div class="label"><i class="bi bi-calendar3-event" style="margin-right:3px"></i>Return</div>
                        <input type="date" id="ret-date" name="return_date" class="val-select" style="font-size: 14px;" disabled>
                    </div>

                    <div class="input-box">
                        <div class="label"><i class="bi bi-people-fill" style="color:var(--sky);margin-right:3px"></i>Passengers</div>
                        <select name="passengers" id="passengers" class="val-select" style="font-size:15px;">
                            <option value="1">1 Adult</option>
                            <option value="2">2 Adults</option>
                            <option value="3">3 Adults</option>
                            <option value="4">4 Adults</option>
                            <option value="5">5 Adults</option>
                            <option value="6">6 Adults</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-search-main">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="stats-row">
        <div class="stat-item">
            <div class="stat-num">500+</div>
            <div class="stat-label">Destinations</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">2M+</div>
            <div class="stat-label">Happy Travelers</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">150+</div>
            <div class="stat-label">Airlines</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">4.9★</div>
            <div class="stat-label">Average Rating</div>
        </div>
    </div>
</div>

<script>
    // ── Trip Type Toggle Logic ──
    function setTrip(type) {
        const tabs = document.querySelectorAll('.trip-tab');
        const returnBox = document.getElementById('return-box');
        const returnInput = document.getElementById('ret-date');
        const typeInput = document.getElementById('trip_type_input');
        
        tabs.forEach(t => t.classList.remove('active'));
        event.target.classList.add('active');
        typeInput.value = type;

        if(type === 'roundtrip') {
            returnBox.style.opacity = "1";
            returnBox.style.pointerEvents = "auto";
            returnInput.disabled = false;
            returnInput.required = true;
            
            // Auto-set return date to departure date + 2 days if empty
            if(!returnInput.value) {
                let depDate = new Date(document.getElementById('dep-date').value);
                depDate.setDate(depDate.getDate() + 2);
                returnInput.value = depDate.toISOString().split('T')[0];
            }
        } else {
            returnBox.style.opacity = "0.5";
            returnBox.style.pointerEvents = "none";
            returnInput.disabled = true;
            returnInput.required = false;
        }
    }

    // ── Swap Origin and Destination ──
    function swapAirports() {
        const originSelect = document.getElementById('origin_id');
        const destSelect = document.getElementById('destination_id');
        
        const tempValue = originSelect.value;
        originSelect.value = destSelect.value;
        destSelect.value = tempValue;
    }
</script>
</body>
</html>