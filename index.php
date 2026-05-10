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
            --dark:    #0d1117;
            --dark2:   #161b27;
            --card-bg: #1c2333;
            --gold:    #c9a84c;
            --gold2:   #e8c96a;
            --text:    #e8eaf0;
            --muted:   #8892a4;
            --accent:  #4f8ef7;
            --border:  rgba(255,255,255,0.08);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: var(--dark);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            position: fixed; top: 0; left: 0;
            width: 72px; height: 100vh;
            background: var(--dark2);
            border-right: 1px solid var(--border);
            display: flex; flex-direction: column;
            align-items: center; padding: 24px 0;
            z-index: 100;
        }
        .sidebar-logo {
            color: var(--gold);
            font-size: 24px; margin-bottom: 36px;
        }
        .sidebar-nav { display: flex; flex-direction: column; gap: 8px; width: 100%; }
        .sidebar-item {
            display: flex; flex-direction: column;
            align-items: center; gap: 4px;
            padding: 12px 0; cursor: pointer;
            color: var(--muted); font-size: 10px;
            transition: all 0.2s; text-decoration: none;
            border-left: 3px solid transparent;
        }
        .sidebar-item i { font-size: 20px; }
        .sidebar-item:hover, .sidebar-item.active {
            color: var(--text); background: rgba(255,255,255,0.04);
            border-left-color: var(--gold);
        }

        /* ── MAIN ── */
        .main { margin-left: 72px; }

        /* ── TOPBAR ── */
        .topbar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 32px;
            border-bottom: 1px solid var(--border);
        }
        .promo-badge {
            display: flex; align-items: center; gap: 8px;
            background: rgba(201,168,76,0.12);
            border: 1px solid rgba(201,168,76,0.3);
            border-radius: 20px; padding: 6px 14px;
            font-size: 13px; color: var(--gold);
        }
        .promo-badge .new-tag {
            background: var(--gold); color: #000;
            border-radius: 10px; padding: 2px 8px;
            font-size: 11px; font-weight: 600;
        }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .currency-select {
            background: var(--card-bg); border: 1px solid var(--border);
            color: var(--text); border-radius: 8px;
            padding: 6px 12px; font-size: 13px; cursor: pointer;
        }
        .avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: linear-gradient(135deg, var(--gold), #a07830);
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 600; cursor: pointer;
        }

        /* ── HERO ── */
        .hero {
            position: relative; overflow: hidden;
            padding: 60px 32px 40px;
            min-height: 420px;
        }
        .hero-bg {
            position: absolute; inset: 0;
            background: 
                linear-gradient(to right, var(--dark) 35%, transparent 70%),
                linear-gradient(to top, var(--dark) 0%, transparent 60%);
            z-index: 1;
        }
        .hero-img {
            position: absolute; right: 0; top: 0;
            width: 65%; height: 100%;
            object-fit: cover; opacity: 0.35;
        }
        .hero-bg-gradient {
            position: absolute; inset: 0;
            background: radial-gradient(ellipse at 70% 50%, rgba(79,142,247,0.08) 0%, transparent 70%);
            z-index: 0;
        }
        .hero-content { position: relative; z-index: 2; max-width: 520px; }
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 56px; line-height: 1.1;
            margin-bottom: 16px;
        }
        .hero-title em { font-style: italic; color: var(--gold); }
        .hero-subtitle { color: var(--muted); font-size: 15px; line-height: 1.6; margin-bottom: 28px; }
        .btn-explore {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--text); color: var(--dark);
            border: none; border-radius: 12px;
            padding: 12px 24px; font-weight: 600; font-size: 14px;
            text-decoration: none; cursor: pointer;
            transition: all 0.2s;
        }
        .btn-explore:hover { background: var(--gold); color: #000; }

        /* ── SEARCH CARD ── */
        .search-section { padding: 0 32px 40px; }
        .search-card {
            background: rgba(28,35,51,0.9);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 24px;
            backdrop-filter: blur(20px);
        }
        .trip-tabs { display: flex; gap: 4px; margin-bottom: 20px; }
        .trip-tab {
            padding: 8px 20px; border-radius: 8px;
            border: none; background: transparent;
            color: var(--muted); font-size: 14px;
            cursor: pointer; transition: all 0.2s;
            font-family: 'DM Sans', sans-serif;
        }
        .trip-tab.active {
            background: var(--text); color: var(--dark); font-weight: 600;
        }
        .search-fields {
            display: grid;
            grid-template-columns: 1fr auto 1fr 1fr 1fr auto;
            gap: 12px; align-items: center;
        }
        .field-group { display: flex; flex-direction: column; gap: 4px; }
        .field-label { font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px; }
        .field-value {
            font-size: 22px; font-weight: 600; color: var(--text);
        }
        .field-sub { font-size: 12px; color: var(--muted); }
        .field-select {
            background: transparent; border: none;
            color: var(--text); font-size: 22px;
            font-weight: 600; font-family: 'DM Sans', sans-serif;
            cursor: pointer; outline: none; width: 100%;
        }
        .field-select option { background: var(--dark2); }
        .field-input {
            background: transparent; border: none;
            color: var(--text); font-size: 16px;
            font-weight: 500; font-family: 'DM Sans', sans-serif;
            outline: none; width: 100%;
            color-scheme: dark;
        }
        .swap-btn {
            width: 36px; height: 36px; border-radius: 50%;
            border: 1px solid var(--border);
            background: var(--dark2);
            color: var(--muted); display: flex;
            align-items: center; justify-content: center;
            cursor: pointer; transition: all 0.2s; flex-shrink: 0;
        }
        .swap-btn:hover { background: var(--gold); color: #000; border-color: var(--gold); }
        .field-divider {
            width: 1px; height: 40px;
            background: var(--border); flex-shrink: 0;
        }
        .btn-search {
            width: 48px; height: 48px; border-radius: 50%;
            background: var(--gold);
            border: none; color: #000;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; cursor: pointer; transition: all 0.2s;
            flex-shrink: 0;
        }
        .btn-search:hover { background: var(--gold2); transform: scale(1.05); }

        /* ── DESTINATIONS ── */
        .destinations { padding: 0 32px 60px; }
        .section-header {
            display: flex; justify-content: space-between;
            align-items: flex-end; margin-bottom: 20px;
        }
        .section-title { font-size: 24px; font-weight: 600; }
        .section-sub { color: var(--muted); font-size: 13px; margin-top: 4px; }
        .view-all {
            display: flex; align-items: center; gap: 6px;
            color: var(--gold); text-decoration: none; font-size: 14px;
        }
        .dest-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; }
        .dest-card {
            position: relative; border-radius: 16px;
            overflow: hidden; cursor: pointer;
            height: 180px; transition: transform 0.3s;
        }
        .dest-card:hover { transform: translateY(-4px); }
        .dest-card-img {
            width: 100%; height: 100%; object-fit: cover;
            background: linear-gradient(135deg, #1a2a4a, #2a4a6a);
            display: flex; align-items: center; justify-content: center;
            font-size: 48px;
        }
        .dest-card-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 60%);
        }
        .dest-card-info {
            position: absolute; bottom: 0; left: 0; right: 0;
            padding: 16px;
        }
        .dest-city { font-weight: 600; font-size: 16px; }
        .dest-country { font-size: 12px; color: rgba(255,255,255,0.6); }
        .dest-price {
            display: flex; align-items: center; gap: 4px;
            font-size: 13px; color: var(--gold); margin-top: 4px;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .search-fields { grid-template-columns: 1fr 1fr; }
            .dest-grid { grid-template-columns: repeat(2,1fr); }
            .hero-title { font-size: 36px; }
        }
    </style>
</head>
<body>

<?php include_once('db_connect.php'); ?>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="sidebar-logo"><i class="bi bi-send-fill" style="transform:rotate(-45deg);display:inline-block"></i></div>
    <nav class="sidebar-nav">
        <a href="index.php" class="sidebar-item active">
            <i class="bi bi-house-fill"></i><span>Home</span>
        </a>
        <a href="search.php" class="sidebar-item">
            <i class="bi bi-airplane-fill"></i><span>Flights</span>
        </a>
        <a href="my_booking.php" class="sidebar-item">
            <i class="bi bi-journal-bookmark-fill"></i><span>Trips</span>
        </a>
        <a href="#" class="sidebar-item">
            <i class="bi bi-compass-fill"></i><span>Explore</span>
        </a>
        <a href="#" class="sidebar-item">
            <i class="bi bi-tag-fill"></i><span>Offers</span>
        </a>
    </nav>
</div>

<!-- MAIN -->
<div class="main">

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="promo-badge">
            <span class="new-tag">New</span>
            Get 10% off your first booking &nbsp;<i class="bi bi-chevron-right"></i>
        </div>
        <div class="topbar-right">
            <i class="bi bi-moon" style="color:var(--muted);font-size:18px;cursor:pointer"></i>
            <select class="currency-select"><option>IDR</option><option>USD</option><option>JPY</option></select>
            <div class="avatar">G</div>
        </div>
    </div>

    <!-- HERO -->
    <div class="hero">
        <div class="hero-bg-gradient"></div>
        <div class="hero-bg"></div>
        <!-- decorative bg using CSS gradient as placeholder for the scenic image -->
        <div style="position:absolute;right:0;top:0;width:65%;height:100%;
            background:radial-gradient(ellipse at 60% 40%, #1a3a6a 0%, #0a1525 60%, #0d1117 100%);
            opacity:0.6;z-index:0;">
            <!-- plane icon decoration -->
            <i class="bi bi-airplane" style="position:absolute;top:60px;left:40%;
                font-size:14px;color:rgba(255,255,255,0.3);transform:rotate(45deg)"></i>
            <div style="position:absolute;top:55px;left:25%;right:10%;height:1px;
                background:linear-gradient(to right,transparent,rgba(255,255,255,0.15),transparent)"></div>
        </div>
        <div class="hero-content">
            <h1 class="hero-title">Fly to your<br>dream <em>destination</em></h1>
            <p class="hero-subtitle">Find the best flight deals to anywhere<br>in the world, fast and easy.</p>
            <a href="search.php" class="btn-explore">Explore Now &nbsp;<i class="bi bi-arrow-up-right"></i></a>
        </div>
    </div>

    <!-- SEARCH -->
    <div class="search-section">
        <div class="search-card">
            <div class="trip-tabs">
                <button class="trip-tab active">One Way</button>
                <button class="trip-tab">Round Trip</button>
                <button class="trip-tab">Multi City</button>
            </div>
            <form action="search.php" method="GET">
                <div class="search-fields">
                    <!-- FROM -->
                    <div class="field-group">
                        <div class="field-label">From</div>
                        <?php
                        $airports = mysqli_query($conn, "SELECT * FROM airport ORDER BY city");
                        $airports_arr = [];
                        while($r = mysqli_fetch_assoc($airports)) $airports_arr[] = $r;
                        ?>
                        <select name="origin_id" class="field-select" required>
                            <?php foreach($airports_arr as $ap): ?>
                            <option value="<?php echo $ap['id']; ?>"
                                <?php echo ($ap['code']=='CGK') ? 'selected' : ''; ?>>
                                <?php echo $ap['code']; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="field-sub">
                            <?php foreach($airports_arr as $ap) if($ap['code']=='CGK') echo $ap['city'].' - '.$ap['name']; ?>
                        </div>
                    </div>

                    <!-- SWAP -->
                    <button type="button" class="swap-btn"><i class="bi bi-arrow-left-right"></i></button>

                    <!-- TO -->
                    <div class="field-group">
                        <div class="field-label">To</div>
                        <select name="destination_id" class="field-select" required>
                            <?php foreach($airports_arr as $ap): ?>
                            <option value="<?php echo $ap['id']; ?>"
                                <?php echo ($ap['code']=='NRT') ? 'selected' : ''; ?>>
                                <?php echo $ap['code']; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="field-sub">
                            <?php foreach($airports_arr as $ap) if($ap['code']=='NRT') echo $ap['city'].' - '.$ap['name']; ?>
                        </div>
                    </div>

                    <div class="field-divider"></div>

                    <!-- DEPARTURE -->
                    <div class="field-group">
                        <div class="field-label">Departure</div>
                        <input type="date" name="departure_date" class="field-input"
                            value="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
                    </div>

                    <!-- PASSENGERS -->
                    <div class="field-group">
                        <div class="field-label">Passengers</div>
                        <select name="passengers" class="field-select" style="font-size:16px">
                            <option value="1">1 Passenger</option>
                            <option value="2">2 Passengers</option>
                            <option value="3">3 Passengers</option>
                            <option value="4">4 Passengers</option>
                        </select>
                        <div class="field-sub">Economy</div>
                    </div>

                    <!-- SEARCH BTN -->
                    <button type="submit" class="btn-search"><i class="bi bi-search"></i></button>
                </div>
            </form>
        </div>
    </div>

    <!-- DESTINATIONS -->
    <div class="destinations">
        <div class="section-header">
            <div>
                <div class="section-title">Explore the world</div>
                <div class="section-sub">Popular destinations around the world</div>
            </div>
            <a href="search.php" class="view-all">View All &nbsp;<i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="dest-grid">
            <?php
            $dests = [
                ['icon'=>'🗼','city'=>'Tokyo','country'=>'Japan','price'=>'IDR 4.2M','origin'=>1,'dest'=>2],
                ['icon'=>'🏖️','city'=>'Bali','country'=>'Indonesia','price'=>'IDR 1.5M','origin'=>1,'dest'=>3],
                ['icon'=>'🏙️','city'=>'Seoul','country'=>'South Korea','price'=>'IDR 3.8M','origin'=>1,'dest'=>4],
                ['icon'=>'🎡','city'=>'London','country'=>'United Kingdom','price'=>'IDR 6.7M','origin'=>1,'dest'=>5],
            ];
            foreach($dests as $d):
            ?>
            <div class="dest-card" onclick="window.location='search.php?origin_id=<?php echo $d['origin'];?>&destination_id=<?php echo $d['dest'];?>'">
                <div class="dest-card-img"><?php echo $d['icon']; ?></div>
                <div class="dest-card-overlay"></div>
                <div class="dest-card-info">
                    <div class="dest-city"><?php echo $d['city']; ?></div>
                    <div class="dest-country"><?php echo $d['country']; ?></div>
                    <div class="dest-price">From <?php echo $d['price']; ?> &nbsp;<i class="bi bi-arrow-right"></i></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

</div><!-- /main -->

<script>
// Swap origin/destination
document.querySelector('.swap-btn')?.addEventListener('click', function() {
    const o = document.querySelector('[name=origin_id]');
    const d = document.querySelector('[name=destination_id]');
    const tmp = o.value; o.value = d.value; d.value = tmp;
});
// Tab switching (visual only)
document.querySelectorAll('.trip-tab').forEach(t => {
    t.addEventListener('click', () => {
        document.querySelectorAll('.trip-tab').forEach(x => x.classList.remove('active'));
        t.classList.add('active');
    });
});
</script>
</body>
</html>
