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
            --dark: #0d1117; --dark2: #161b27; --card-bg: #1c2333;
            --gold: #c9a84c; --gold2: #e8c96a; --text: #e8eaf0;
            --muted: #8892a4; --border: rgba(255,255,255,0.08);
            --accent-bg: #1c2333;
        }

        * { box-sizing:border-box; margin:0; padding:0; }
        body { background: var(--dark); color: var(--text); font-family: 'DM Sans', sans-serif; }

        /* ── SIDEBAR ── */
        .sidebar { position:fixed;top:0;left:0;width:72px;height:100vh;background:var(--dark2);border-right:1px solid var(--border);display:flex;flex-direction:column;align-items:center;padding:24px 0;z-index:100; }
        .sidebar-logo { color:var(--gold);font-size:24px;margin-bottom:36px; }
        .sidebar-nav { display:flex;flex-direction:column;gap:8px;width:100%; }
        .sidebar-item { display:flex;flex-direction:column;align-items:center;gap:4px;padding:12px 0;cursor:pointer;color:var(--muted);font-size:10px;transition:all .2s;text-decoration:none;border-left:3px solid transparent; }
        .sidebar-item i { font-size:20px; }
        .sidebar-item:hover,.sidebar-item.active { color:var(--text);background:rgba(255,255,255,.04);border-left-color:var(--gold); }

        /* ── MAIN CONTENT ── */
        .main { margin-left: 72px; padding-bottom: 50px; }

        .topbar {
            display: flex; justify-content: space-between; align-items: center;
            padding: 20px 40px;
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
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 24px; padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .trip-tabs { display: flex; gap: 10px; margin-bottom: 25px; }
        .trip-tab {
            padding: 10px 24px; border-radius: 12px; border: none;
            background: var(--dark2); color: var(--muted);
            font-weight: 500; transition: 0.3s; cursor: pointer;
        }
        .trip-tab.active { background: var(--gold); color: #000; }

        /* Modern Grid Layout */
        .search-grid {
            display: grid;
            grid-template-columns: 1.5fr auto 1.5fr 1fr 1fr auto;
            gap: 20px; align-items: center;
        }
        .input-box {
            background: var(--dark2);
            border: 1px solid var(--border);
            border-radius: 16px; padding: 12px 18px;
            position: relative; transition: border-color 0.2s;
        }
        .input-box:focus-within { border-color: var(--gold); }
        .label { font-size: 11px; color: var(--muted); text-transform: uppercase; margin-bottom: 4px; }
        .val-select {
            width: 100%; background: transparent; border: none;
            color: var(--text); font-size: 18px; font-weight: 700; outline: none;
        }
        .val-select option { background: var(--dark2); color: var(--text); }
        
        .swap-btn {
            color: var(--muted); font-size: 20px; cursor: pointer;
            transition: all 0.2s; display: flex; align-items: center; justify-content: center;
            width: 40px; height: 40px; border-radius: 50%; background: var(--dark2); border: 1px solid var(--border);
        }
        .swap-btn:hover { color: var(--gold); border-color: var(--gold); transform: rotate(180deg); }

        .btn-search-main {
            width: 60px; height: 60px; border-radius: 18px;
            background: var(--gold); border: none; color: #000;
            font-size: 24px; display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: all 0.2s;
        }
        .btn-search-main:hover { background: var(--gold2); transform: scale(1.05); }
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
        <div class="promo-badge" style="color: var(--gold); font-weight: 600;">
            <span style="background: var(--gold); color: #000; padding: 2px 8px; border-radius: 5px; font-size: 12px; margin-right: 10px;">New</span>
            Get 10% off your first booking
        </div>
        <div class="topbar-right d-flex align-items-center gap-3">
            <div class="avatar" style="width: 40px; height: 40px; border-radius: 50%; background: var(--dark2); border: 1px solid var(--border); display:flex; align-items:center; justify-content:center; font-weight: bold; color: var(--gold);">N</div>
        </div>
    </div>

    <div class="hero">
        <div class="hero-content">
            <h1 class="hero-title">Fly to your<br>dream <span>destination</span></h1>
            <p style="color: var(--muted); margin-top: 20px;">Find the best flight deals to anywhere in the world.</p>
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
                        <div class="label">From</div>
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
                        <div class="label">To</div>
                        <select name="destination_id" id="destination_id" class="val-select">
                            <?php foreach($airports as $ap): ?>
                            <option value="<?php echo $ap['id']; ?>" <?php echo $ap['code']=='NRT'?'selected':''; ?>>
                                <?php echo $ap['code']; ?> (<?php echo $ap['city']; ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="input-box">
                        <div class="label">Departure</div>
                        <input type="date" id="dep-date" name="departure_date" class="val-select" style="font-size: 14px;" value="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
                    </div>

                    <div class="input-box" id="return-box" style="opacity: 0.5; pointer-events: none;">
                        <div class="label">Return</div>
                        <input type="date" id="ret-date" name="return_date" class="val-select" style="font-size: 14px;" disabled>
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