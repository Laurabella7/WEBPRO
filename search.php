<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Results – SkyWings</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --dark:#0d1117; --dark2:#161b27; --card-bg:#1c2333;
            --gold:#c9a84c; --gold2:#e8c96a; --text:#e8eaf0;
            --muted:#8892a4; --accent:#4f8ef7; --border:rgba(255,255,255,0.08);
            --green:#2ecc71; --red:#e74c3c;
        }
        * { box-sizing:border-box; margin:0; padding:0; }
        body { background:var(--dark); color:var(--text); font-family:'DM Sans',sans-serif; }

        /* SIDEBAR */
        .sidebar { position:fixed;top:0;left:0;width:72px;height:100vh;background:var(--dark2);border-right:1px solid var(--border);display:flex;flex-direction:column;align-items:center;padding:24px 0;z-index:100; }
        .sidebar-logo { color:var(--gold);font-size:24px;margin-bottom:36px; }
        .sidebar-nav { display:flex;flex-direction:column;gap:8px;width:100%; }
        .sidebar-item { display:flex;flex-direction:column;align-items:center;gap:4px;padding:12px 0;cursor:pointer;color:var(--muted);font-size:10px;transition:all .2s;text-decoration:none;border-left:3px solid transparent; }
        .sidebar-item i { font-size:20px; }
        .sidebar-item:hover,.sidebar-item.active { color:var(--text);background:rgba(255,255,255,.04);border-left-color:var(--gold); }

        .main { margin-left:72px; min-height:100vh; }

        /* TOPBAR */
        .topbar { display:flex;align-items:center;justify-content:space-between;padding:16px 32px;border-bottom:1px solid var(--border); }
        .breadcrumb-nav { display:flex;align-items:center;gap:8px;color:var(--muted);font-size:14px; }
        .breadcrumb-nav a { color:var(--muted);text-decoration:none; }
        .breadcrumb-nav a:hover { color:var(--gold); }
        .breadcrumb-nav .active { color:var(--text); }

        /* SEARCH BAR */
        .search-bar { background:var(--dark2);border-bottom:1px solid var(--border);padding:16px 32px; }
        .search-bar form { display:flex;gap:12px;align-items:center;flex-wrap:wrap; }
        .sb-field { display:flex;flex-direction:column;gap:2px;min-width:140px; }
        .sb-label { font-size:10px;color:var(--muted);text-transform:uppercase;letter-spacing:.5px; }
        .sb-select, .sb-input {
            background:var(--card-bg);border:1px solid var(--border);
            color:var(--text);border-radius:10px;padding:8px 12px;
            font-size:14px;font-family:'DM Sans',sans-serif;outline:none;
            transition:border-color .2s;
        }
        .sb-select:focus,.sb-input:focus { border-color:var(--gold); }
        .sb-select option { background:var(--dark2); }
        .sb-input { color-scheme:dark; }
        .btn-search { background:var(--gold);border:none;color:#000;border-radius:10px;padding:10px 20px;font-weight:600;cursor:pointer;transition:all .2s;font-family:'DM Sans',sans-serif; }
        .btn-search:hover { background:var(--gold2); }

        /* CONTENT */
        .content { display:grid;grid-template-columns:260px 1fr;gap:24px;padding:24px 32px; }

        /* FILTERS */
        .filter-panel { background:var(--card-bg);border:1px solid var(--border);border-radius:16px;padding:20px;height:fit-content; }
        .filter-title { font-size:16px;font-weight:600;margin-bottom:16px; }
        .filter-section { margin-bottom:20px; }
        .filter-section-title { font-size:12px;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px; }
        .filter-check { display:flex;align-items:center;gap:8px;margin-bottom:8px;cursor:pointer;font-size:14px; }
        .filter-check input { accent-color:var(--gold); width:16px;height:16px; }
        .price-range { width:100%;accent-color:var(--gold); }
        .price-labels { display:flex;justify-content:space-between;font-size:12px;color:var(--muted);margin-top:6px; }
        .btn-apply { width:100%;background:var(--gold);border:none;color:#000;border-radius:10px;padding:10px;font-weight:600;cursor:pointer;font-family:'DM Sans',sans-serif; }
        .btn-apply:hover { background:var(--gold2); }

        /* RESULTS */
        .results-header { display:flex;justify-content:space-between;align-items:center;margin-bottom:16px; }
        .results-count { font-size:14px;color:var(--muted); }
        .results-count span { color:var(--text);font-weight:600; }
        .sort-select { background:var(--card-bg);border:1px solid var(--border);color:var(--text);border-radius:8px;padding:6px 12px;font-size:13px;font-family:'DM Sans',sans-serif; }
        .sort-select option { background:var(--dark2); }

        /* FLIGHT CARD */
        .flight-card {
            background:var(--card-bg);border:1px solid var(--border);border-radius:16px;
            padding:20px 24px;margin-bottom:12px;
            display:grid;grid-template-columns:1fr auto 1fr auto auto;
            gap:16px;align-items:center;
            transition:all .2s;cursor:pointer;
        }
        .flight-card:hover { border-color:rgba(201,168,76,.4);transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,.3); }
        .airline-info { display:flex;align-items:center;gap:10px; }
        .airline-logo { width:40px;height:40px;border-radius:10px;background:rgba(255,255,255,.07);display:flex;align-items:center;justify-content:center;font-size:18px; }
        .airline-name { font-size:13px;color:var(--muted); }
        .flight-num { font-size:11px;color:var(--gold); }
        .route-col { text-align:center; }
        .route-time { font-size:22px;font-weight:700; }
        .route-airport { font-size:12px;color:var(--muted); }
        .route-line { display:flex;align-items:center;gap:8px;margin:8px 0; }
        .route-dot { width:6px;height:6px;border-radius:50%;background:var(--muted); }
        .route-line-bar { flex:1;height:1px;background:linear-gradient(to right,var(--muted),var(--gold),var(--muted)); position:relative; }
        .route-plane { position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);font-size:14px;color:var(--gold); }
        .route-duration { font-size:11px;color:var(--muted);text-align:center; }
        .price-col { text-align:right; }
        .price-from { font-size:11px;color:var(--muted); }
        .price-amount { font-size:22px;font-weight:700;color:var(--gold); }
        .price-seat { font-size:11px;color:var(--green); }
        .btn-select { background:var(--gold);border:none;color:#000;border-radius:10px;padding:12px 20px;font-weight:600;font-size:14px;cursor:pointer;transition:all .2s;white-space:nowrap;font-family:'DM Sans',sans-serif; }
        .btn-select:hover { background:var(--gold2);transform:scale(1.03); }

        .no-results { text-align:center;padding:60px;color:var(--muted); }
        .no-results i { font-size:48px;display:block;margin-bottom:16px; }
    </style>
</head>
<body>

<?php
include_once('db_connect.php');

// Detect if a search was actually submitted
$is_searched = isset($_GET['origin_id']) && !empty($_GET['origin_id']);

$origin_id      = intval($_GET['origin_id'] ?? 0);
$destination_id = intval($_GET['destination_id'] ?? 0);
$departure_date = $_GET['departure_date'] ?? ''; // Removed the +1 day default
$passengers     = intval($_GET['passengers'] ?? 1);
$class_filter   = $_GET['class_filter'] ?? '';
$sort_by        = $_GET['sort_by'] ?? 'price_asc';

// Get airports
$airports_q = mysqli_query($conn, "SELECT * FROM airport ORDER BY city");
$airports_arr = [];
while($r = mysqli_fetch_assoc($airports_q)) $airports_arr[$r['id']] = $r;

// Only run the flight query if the user actually searched
$total = 0;
if ($is_searched) {
    $sql = "SELECT f.*, 
            a1.code AS origin_code, a1.city AS origin_city, a1.name AS origin_name,
            a2.code AS dest_code, a2.city AS dest_city, a2.name AS dest_name,
            MIN(s.price) AS min_price,
            SUM(CASE WHEN s.is_booked=0 THEN 1 ELSE 0 END) AS available_seats
            FROM flight f
            JOIN airport a1 ON f.origin_id = a1.id
            JOIN airport a2 ON f.destination_id = a2.id
            LEFT JOIN seat s ON s.flight_id = f.id";

    $wheres = [];
    if ($origin_id)      $wheres[] = "f.origin_id = $origin_id";
    if ($destination_id) $wheres[] = "f.destination_id = $destination_id";
    if ($departure_date) $wheres[] = "DATE(f.departure_time) >= '$departure_date'"; // Using >= as discussed previously
    if ($class_filter)   $wheres[] = "s.class = '" . mysqli_real_escape_string($conn, $class_filter) . "'";

    if ($wheres) $sql .= " WHERE " . implode(" AND ", $wheres);
    $sql .= " GROUP BY f.id";

    $order = match($sort_by) {
        'price_desc' => 'ORDER BY min_price DESC',
        'duration'   => 'ORDER BY TIMESTAMPDIFF(MINUTE, f.departure_time, f.arrival_time) ASC',
        default      => 'ORDER BY min_price ASC',
    };
    $sql .= " $order";

    $flights = mysqli_query($conn, $sql);
    $total = mysqli_num_rows($flights);
}
?>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="sidebar-logo"><i class="bi bi-send-fill" style="transform:rotate(-45deg);display:inline-block"></i></div>
    <nav class="sidebar-nav">
        <a href="index.php" class="sidebar-item"><i class="bi bi-house-fill"></i><span>Home</span></a>
        <a href="search.php" class="sidebar-item active"><i class="bi bi-airplane-fill"></i><span>Flights</span></a>
        <a href="my_booking.php" class="sidebar-item"><i class="bi bi-journal-bookmark-fill"></i><span>Trips</span></a>
        <a href="#" class="sidebar-item"><i class="bi bi-compass-fill"></i><span>Explore</span></a>
        <a href="#" class="sidebar-item"><i class="bi bi-tag-fill"></i><span>Offers</span></a>
    </nav>
</div>

<div class="main">
    <!-- TOPBAR -->
    <div class="topbar">
        <div class="breadcrumb-nav">
            <a href="index.php"><i class="bi bi-house"></i></a>
            <i class="bi bi-chevron-right" style="font-size:11px"></i>
            <a href="search.php">Flights</a>
            <i class="bi bi-chevron-right" style="font-size:11px"></i>
            <span class="active">
                <?php echo $airports_arr[$origin_id]['code'] ?? '?'; ?> →
                <?php echo $airports_arr[$destination_id]['code'] ?? '?'; ?>
            </span>
        </div>
        <div style="color:var(--muted);font-size:13px">
            <?php echo date('D, d M Y', strtotime($departure_date)); ?> &nbsp;·&nbsp; <?php echo $passengers; ?> Passenger<?php echo $passengers>1?'s':''; ?>
        </div>
    </div>

    <!-- SEARCH BAR -->
    <div class="search-bar">
        <form method="GET">
            <div class="sb-field">
                <div class="sb-label">From</div>
                <select name="origin_id" class="sb-select" required>
                    <option value="" disabled hidden <?php echo !$origin_id ? 'selected' : ''; ?>>Select Origin</option>
                    <?php foreach($airports_arr as $ap): ?>
                    <option value="<?php echo $ap['id']; ?>" <?php echo ($ap['id']==$origin_id)?'selected':''; ?>>
                        <?php echo $ap['code'].' – '.$ap['city']; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="sb-field">
                <div class="sb-label">To</div>
                <select name="destination_id" class="sb-select" required>
                    <option value="" disabled hidden <?php echo !$destination_id ? 'selected' : ''; ?>>Select Destination</option>
                    <?php foreach($airports_arr as $ap): ?>
                    <option value="<?php echo $ap['id']; ?>" <?php echo ($ap['id']==$destination_id)?'selected':''; ?>>
                        <?php echo $ap['code'].' – '.$ap['city']; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="sb-field">
                <div class="sb-label">Date</div>
                <input type="date" name="departure_date" class="sb-input" value="<?php echo $departure_date; ?>" required>
            </div>
            <div class="sb-field">
                <div class="sb-label">Passengers</div>
                <select name="passengers" class="sb-select">
                    <?php for($i=1;$i<=4;$i++): ?>
                    <option value="<?php echo $i; ?>" <?php echo ($i==$passengers)?'selected':''; ?>><?php echo $i; ?> Passenger<?php echo $i>1?'s':''; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <button type="submit" class="btn-search"><i class="bi bi-search"></i> Search</button>
        </form>
    </div>

    <!-- CONTENT -->
    <div class="content">
        <!-- FILTERS -->
        <aside>
            <div class="filter-panel">
                <div class="filter-title">Filters</div>

                <form method="GET" id="filterForm">
                    <input type="hidden" name="origin_id" value="<?php echo $origin_id; ?>">
                    <input type="hidden" name="destination_id" value="<?php echo $destination_id; ?>">
                    <input type="hidden" name="departure_date" value="<?php echo $departure_date; ?>">
                    <input type="hidden" name="passengers" value="<?php echo $passengers; ?>">

                    <div class="filter-section">
                        <div class="filter-section-title">Class</div>
                        <?php foreach(['Economy','Business','First'] as $cl): ?>
                        <label class="filter-check">
                            <input type="radio" name="class_filter" value="<?php echo $cl; ?>"
                                <?php echo ($class_filter==$cl)?'checked':''; ?>>
                            <?php echo $cl; ?>
                        </label>
                        <?php endforeach; ?>
                        <label class="filter-check">
                            <input type="radio" name="class_filter" value="" <?php echo (!$class_filter)?'checked':''; ?>>
                            All Classes
                        </label>
                    </div>

                    <div class="filter-section">
                        <div class="filter-section-title">Sort By</div>
                        <select name="sort_by" class="sb-select" style="width:100%">
                            <option value="price_asc" <?php echo ($sort_by=='price_asc')?'selected':''; ?>>Price: Low to High</option>
                            <option value="price_desc" <?php echo ($sort_by=='price_desc')?'selected':''; ?>>Price: High to Low</option>
                            <option value="duration" <?php echo ($sort_by=='duration')?'selected':''; ?>>Duration</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-apply">Apply Filters</button>
                </form>
            </div>
        </aside>

        <!-- RESULTS -->
        <div>
            <?php if (!$is_searched): ?>
                <div class="no-results">
                    <i class="bi bi-search"></i>
                    Where would you like to fly?<br>Please select your origin, destination, and dates above.
                </div>
            <?php else: ?>
                <div class="results-header">
                    <div class="results-count">Found <span><?php echo $total; ?></span> flight<?php echo $total!=1?'s':''; ?></div>
                </div>

                <?php if ($total == 0): ?>
                <div class="no-results">
                    <i class="bi bi-airplane"></i>
                    No flights found for this route.<br>Try different dates or destinations.
                </div>
                <?php endif; ?>

                <?php while ($f = mysqli_fetch_assoc($flights)):
                    $dep = new DateTime($f['departure_time']);
                    $arr = new DateTime($f['arrival_time']);
                    $dur = $dep->diff($arr);
                    $dur_str = ($dur->h ? $dur->h.'h ' : '') . $dur->i.'m';
                    $available = intval($f['available_seats']);
                ?>
                <div class="flight-card" onclick="window.location='seat_selection.php?flight_id=<?php echo $f['id']; ?>&passengers=<?php echo $passengers; ?>'">
                    <div class="airline-info">
                        <div class="airline-logo">✈️</div>
                        <div>
                            <div style="font-weight:600;font-size:14px"><?php echo $f['airline']; ?></div>
                            <div class="flight-num"><?php echo $f['flight_number']; ?></div>
                        </div>
                    </div>

                    <div class="route-col">
                        <div class="route-time"><?php echo $dep->format('H:i'); ?></div>
                        <div class="route-airport"><?php echo $f['origin_code']; ?></div>
                        <div style="font-size:11px;color:var(--muted)"><?php echo $f['origin_city']; ?></div>
                    </div>

                    <div style="text-align:center">
                        <div class="route-duration"><?php echo $dur_str; ?></div>
                        <div class="route-line">
                            <div class="route-dot"></div>
                            <div class="route-line-bar">
                                <div class="route-plane"><i class="bi bi-airplane-fill"></i></div>
                            </div>
                            <div class="route-dot"></div>
                        </div>
                        <div style="font-size:11px;color:var(--muted)">Direct</div>
                    </div>

                    <div class="route-col">
                        <div class="route-time"><?php echo $arr->format('H:i'); ?></div>
                        <div class="route-airport"><?php echo $f['dest_code']; ?></div>
                        <div style="font-size:11px;color:var(--muted)"><?php echo $f['dest_city']; ?></div>
                    </div>

                    <div style="display:flex;flex-direction:column;align-items:flex-end;gap:8px">
                        <div class="price-col">
                            <div class="price-from">from</div>
                            <div class="price-amount">IDR <?php echo number_format($f['min_price']); ?></div>
                            <div class="price-seat" style="color:<?php echo $available<5?'var(--red)':'var(--green)'; ?>">
                                <?php echo $available; ?> seat<?php echo $available!=1?'s':''; ?> left
                            </div>
                        </div>
                        <button class="btn-select">Select <i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
