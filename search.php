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
            --green: #16a34a;
            --red: #dc2626;
        }
        * { box-sizing:border-box; margin:0; padding:0; }
        body { background:var(--bg); color:var(--text); font-family:'DM Sans',sans-serif; }
        .sidebar { position:fixed;top:0;left:0;width:72px;height:100vh;background:var(--sidebar-bg);border-right:none;display:flex;flex-direction:column;align-items:center;padding:24px 0;z-index:100;box-shadow:4px 0 24px rgba(26,35,64,0.12); }
        .sidebar-logo { color:var(--gold2);font-size:24px;margin-bottom:36px; }
        .sidebar-nav { display:flex;flex-direction:column;gap:8px;width:100%; }
        .sidebar-item { display:flex;flex-direction:column;align-items:center;gap:4px;padding:12px 0;cursor:pointer;color:rgba(255,255,255,0.45);font-size:10px;transition:all .2s;text-decoration:none;border-left:3px solid transparent; }
        .sidebar-item i { font-size:20px; }
        .sidebar-item:hover { color:rgba(255,255,255,0.85);background:rgba(255,255,255,.06);border-left-color:var(--gold2); }
        .sidebar-item.active { color:#fff;background:var(--sidebar-active);border-left-color:var(--gold2); }
        .main { margin-left:72px; min-height:100vh; }
        .topbar { display:flex;align-items:center;justify-content:space-between;padding:16px 32px;border-bottom:1px solid var(--border);background:var(--card-bg); }
        .breadcrumb-nav { display:flex;align-items:center;gap:8px;color:var(--muted);font-size:14px; }
        .breadcrumb-nav a { color:var(--muted);text-decoration:none; }
        .breadcrumb-nav a:hover { color:var(--sky); }
        .breadcrumb-nav .active { color:var(--text); }

        /* ── Trip Progress Bar ── */
        .trip-progress { display:flex;align-items:center;background:var(--card-bg);padding:12px 32px;border-bottom:1px solid var(--border); }
        .tp-step { display:flex;align-items:center;gap:12px;opacity:0.5; }
        .tp-step.active { opacity:1; }
        .tp-step.done { opacity:0.8; }
        .tp-dot { width:32px;height:32px;border-radius:50%;background:var(--bg2);border:1.5px solid var(--border);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;color:var(--text); }
        .tp-step.active .tp-dot { background:var(--sky);color:#fff;border-color:var(--sky); }
        .tp-step.done .tp-dot { background:var(--green);color:#fff;border-color:var(--green); }
        .tp-line { flex:1;height:1px;background:var(--border);margin:0 24px;max-width:100px; }

        .search-bar { background:var(--card-bg);border-bottom:1px solid var(--border);padding:16px 32px; }
        .search-bar form { display:flex;gap:12px;align-items:center;flex-wrap:wrap; }
        .sb-field { display:flex;flex-direction:column;gap:2px;min-width:140px; }
        .sb-label { font-size:10px;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;font-weight:600; }
        .sb-select, .sb-input { background:var(--bg);border:1.5px solid var(--border);color:var(--text);border-radius:10px;padding:8px 12px;font-size:14px;font-family:'DM Sans',sans-serif;outline:none;transition:border-color .2s; }
        .sb-select:focus,.sb-input:focus { border-color:var(--sky);box-shadow:0 0 0 3px rgba(37,99,235,0.08); }
        .sb-select option { background:#fff;color:var(--text); }
        .btn-search { background:linear-gradient(135deg,var(--sky),var(--sky2));border:none;color:#fff;border-radius:10px;padding:10px 20px;font-weight:600;cursor:pointer;transition:all .2s;font-family:'DM Sans',sans-serif;box-shadow:0 4px 12px rgba(37,99,235,0.2); }
        .btn-search:hover { transform:translateY(-1px);box-shadow:0 6px 18px rgba(37,99,235,0.3); }
        .content { display:grid;grid-template-columns:260px 1fr;gap:24px;padding:24px 32px; }
        .filter-panel { background:var(--card-bg);border:1px solid var(--border);border-radius:16px;padding:20px;height:fit-content;box-shadow:var(--shadow); }
        .filter-title { font-size:16px;font-weight:600;margin-bottom:16px;color:var(--text); }
        .filter-section { margin-bottom:20px; }
        .filter-section-title { font-size:12px;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px;font-weight:600; }
        .filter-check { display:flex;align-items:center;gap:8px;margin-bottom:8px;cursor:pointer;font-size:14px;color:var(--text); }
        .filter-check input { accent-color:var(--sky);width:16px;height:16px; }
        .btn-apply { width:100%;background:linear-gradient(135deg,var(--sky),var(--sky2));border:none;color:#fff;border-radius:10px;padding:10px;font-weight:600;cursor:pointer;font-family:'DM Sans',sans-serif;box-shadow:0 4px 12px rgba(37,99,235,0.2); }
        .btn-apply:hover { transform:translateY(-1px);box-shadow:0 6px 18px rgba(37,99,235,0.3); }
        .results-header { display:flex;justify-content:space-between;align-items:center;margin-bottom:16px; }
        .results-count { font-size:14px;color:var(--muted); }
        .results-count span { color:var(--text);font-weight:600; }
        .flight-card { background:var(--card-bg);border:1.5px solid var(--border);border-radius:16px;padding:20px 24px;margin-bottom:12px;display:grid;grid-template-columns:1fr auto 1fr auto auto;gap:16px;align-items:center;transition:all .2s;cursor:pointer;box-shadow:var(--shadow); }
        .flight-card:hover { border-color:rgba(37,99,235,0.3);transform:translateY(-2px);box-shadow:0 8px 32px rgba(37,99,235,0.12); }
        .airline-info { display:flex;align-items:center;gap:10px; }
        .airline-logo { width:40px;height:40px;border-radius:10px;background:var(--bg2);display:flex;align-items:center;justify-content:center;font-size:18px;border:1px solid var(--border); }
        .flight-num { font-size:11px;color:var(--sky);font-weight:600; }
        .route-col { text-align:center; }
        .route-time { font-size:22px;font-weight:700;color:var(--text); }
        .route-airport { font-size:12px;color:var(--muted); }
        .route-line { display:flex;align-items:center;gap:8px;margin:8px 0; }
        .route-dot { width:6px;height:6px;border-radius:50%;background:var(--muted); }
        .route-line-bar { flex:1;height:1px;background:linear-gradient(to right,var(--muted),var(--sky),var(--muted));position:relative; }
        .route-plane { position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);font-size:14px;color:var(--sky); }
        .route-duration { font-size:11px;color:var(--muted);text-align:center; }
        .price-col { text-align:right; }
        .price-from { font-size:11px;color:var(--muted); }
        .price-amount { font-size:22px;font-weight:700;color:var(--gold); }
        .price-seat { font-size:11px;color:var(--green); }
        .btn-select { background:linear-gradient(135deg,var(--sky),var(--sky2));border:none;color:#fff;border-radius:10px;padding:12px 20px;font-weight:600;font-size:14px;cursor:pointer;transition:all .2s;white-space:nowrap;font-family:'DM Sans',sans-serif;box-shadow:0 4px 12px rgba(37,99,235,0.2); }
        .btn-select:hover { transform:scale(1.03);box-shadow:0 6px 18px rgba(37,99,235,0.3); }
        .no-results { text-align:center;padding:60px;color:var(--muted); }
        .no-results i { font-size:48px;display:block;margin-bottom:16px; }
    </style>
</head>
<body>
<?php
include_once('db_connect.php');

$is_searched    = isset($_GET['origin_id']) && !empty($_GET['origin_id']);
$trip_type      = $_GET['trip_type'] ?? 'oneway';
$search_step    = intval($_GET['step'] ?? 1);
$outbound_id    = intval($_GET['outbound_id'] ?? 0);

$origin_id      = intval($_GET['origin_id'] ?? 0);
$destination_id = intval($_GET['destination_id'] ?? 0);
$departure_date = $_GET['departure_date'] ?? '';
$return_date    = $_GET['return_date'] ?? '';
$passengers     = intval($_GET['passengers'] ?? 1);
$class_filter   = $_GET['class_filter'] ?? '';
$sort_by        = $_GET['sort_by'] ?? 'price_asc';

$airports_q = mysqli_query($conn, "SELECT * FROM airport ORDER BY city");
$airports_arr = [];
while($r = mysqli_fetch_assoc($airports_q)) $airports_arr[$r['id']] = $r;

// ── Multi-Step Logic ──
if ($trip_type == 'roundtrip' && $search_step == 2) {
    $q_origin = $destination_id;
    $q_dest   = $origin_id;
    $q_date   = $return_date;
} else {
    $q_origin = $origin_id;
    $q_dest   = $destination_id;
    $q_date   = $departure_date;
}

$total = 0;
if ($is_searched) {
    $safe_class = mysqli_real_escape_string($conn, $class_filter);
    $class_cond = $class_filter ? "AND travel_class = '$safe_class'" : "";

    // DAYOFWEEK(): 1=Sun, 7=Sat. Multiply by 1.2 for 20% premium ONLY on Sat & Sun.
    $sql = "SELECT 
                fs.id AS schedule_id, fs.departure_time, fs.arrival_time, fr.flight_number,
                al.name AS airline_name, a1.code AS origin_code, a1.city AS origin_city,
                a2.code AS dest_code, a2.city AS dest_city,
                (SELECT MIN(price) * (CASE WHEN DAYOFWEEK(fs.departure_time) IN (1, 7) THEN 1.2 ELSE 1.0 END) 
                 FROM flight_pricing WHERE flight_schedule_id = fs.id $class_cond) AS min_price,
                ((SELECT COUNT(*) FROM aircraft_seat WHERE aircraft_id = fs.aircraft_id $class_cond) - 
                 (SELECT COUNT(*) FROM ticket WHERE flight_schedule_id = fs.id $class_cond)) AS available_seats
            FROM flight_schedule fs
            JOIN flight_route fr ON fs.flight_route_id = fr.id
            JOIN airline al ON fr.airline_id = al.id
            JOIN airport a1 ON fr.origin_id = a1.id
            JOIN airport a2 ON fr.destination_id = a2.id";

    $wheres = [];
    if ($q_origin) $wheres[] = "fr.origin_id = $q_origin";
    if ($q_dest)   $wheres[] = "fr.destination_id = $q_dest";
    if ($q_date)   $wheres[] = "DATE(fs.departure_time) = '$q_date'";
    
    if ($class_filter) {
        $wheres[] = "EXISTS (SELECT 1 FROM flight_pricing WHERE flight_schedule_id = fs.id $class_cond)";
    }
    if ($wheres) $sql .= " WHERE " . implode(" AND ", $wheres);

    $order = match($sort_by) {
        'price_desc' => 'ORDER BY min_price DESC',
        'duration'   => 'ORDER BY TIMESTAMPDIFF(MINUTE, fs.departure_time, fs.arrival_time) ASC',
        default      => 'ORDER BY min_price ASC',
    };
    $sql .= " $order";

    $flights = mysqli_query($conn, $sql);
    $total = mysqli_num_rows($flights);
}
?>

<div class="sidebar">
    <div class="sidebar-logo"><i class="bi bi-send-fill" style="transform:rotate(-45deg);display:inline-block"></i></div>
    <nav class="sidebar-nav">
        <a href="index.php" class="sidebar-item"><i class="bi bi-house-fill"></i><span>Home</span></a>
        <a href="search.php" class="sidebar-item active"><i class="bi bi-airplane-fill"></i><span>Flights</span></a>
        <a href="my_booking.php" class="sidebar-item"><i class="bi bi-journal-bookmark-fill"></i><span>Trips</span></a>
    </nav>
</div>

<div class="main">
    <div class="topbar">
        <div class="breadcrumb-nav">
            <a href="index.php"><i class="bi bi-house"></i></a>
            <i class="bi bi-chevron-right" style="font-size:11px"></i>
            <a href="search.php">Flights</a>
            <i class="bi bi-chevron-right" style="font-size:11px"></i>
            <span class="active">
                <?php echo $airports_arr[$q_origin]['code'] ?? '?'; ?> →
                <?php echo $airports_arr[$q_dest]['code'] ?? '?'; ?>
            </span>
        </div>
        <div style="color:var(--muted);font-size:13px">
            <?php echo $q_date ? date('D, d M Y', strtotime($q_date)) : ''; ?> &nbsp;·&nbsp; <?php echo $passengers; ?> Passenger<?php echo $passengers>1?'s':''; ?>
        </div>
    </div>

    <?php if ($trip_type == 'roundtrip'): ?>
    <div class="trip-progress">
        <div class="tp-step <?php echo $search_step == 1 ? 'active' : 'done'; ?>">
            <div class="tp-dot"><?php echo $search_step == 1 ? '1' : '<i class="bi bi-check"></i>'; ?></div>
            <div><strong style="color:var(--text)">Outbound</strong><br><small><?php echo $airports_arr[$origin_id]['code']; ?> → <?php echo $airports_arr[$destination_id]['code']; ?></small></div>
        </div>
        <div class="tp-line"></div>
        <div class="tp-step <?php echo $search_step == 2 ? 'active' : ''; ?>">
            <div class="tp-dot">2</div>
            <div><strong style="color:var(--text)">Return</strong><br><small><?php echo $airports_arr[$destination_id]['code']; ?> → <?php echo $airports_arr[$origin_id]['code']; ?></small></div>
        </div>
    </div>
    <?php endif; ?>

    <div class="search-bar">
        <form method="GET">
            <input type="hidden" name="trip_type" value="<?php echo $trip_type; ?>">
            <input type="hidden" name="step" value="<?php echo $search_step; ?>">
            <input type="hidden" name="outbound_id" value="<?php echo $outbound_id; ?>">

            <div class="sb-field">
                <div class="sb-label">From</div>
                <select name="origin_id" class="sb-select" required <?php echo $search_step==2?'disabled':''; ?>>
                    <?php foreach($airports_arr as $ap): ?>
                    <option value="<?php echo $ap['id']; ?>" <?php echo ($ap['id']==$origin_id)?'selected':''; ?>><?php echo $ap['code'].' – '.$ap['city']; ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if($search_step==2): ?><input type="hidden" name="origin_id" value="<?php echo $origin_id; ?>"><?php endif; ?>
            </div>
            <div class="sb-field">
                <div class="sb-label">To</div>
                <select name="destination_id" class="sb-select" required <?php echo $search_step==2?'disabled':''; ?>>
                    <?php foreach($airports_arr as $ap): ?>
                    <option value="<?php echo $ap['id']; ?>" <?php echo ($ap['id']==$destination_id)?'selected':''; ?>><?php echo $ap['code'].' – '.$ap['city']; ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if($search_step==2): ?><input type="hidden" name="destination_id" value="<?php echo $destination_id; ?>"><?php endif; ?>
            </div>
            <div class="sb-field">
                <div class="sb-label"><?php echo $search_step==2?'Return Date':'Departure Date'; ?></div>
                <input type="date" name="<?php echo $search_step==2?'return_date':'departure_date'; ?>" class="sb-input" value="<?php echo $search_step==2?$return_date:$departure_date; ?>" required>
            </div>
            
            <?php if($trip_type == 'roundtrip' && $search_step == 1): ?>
            <div class="sb-field">
                <div class="sb-label">Return Date</div>
                <input type="date" name="return_date" class="sb-input" value="<?php echo $return_date; ?>" required>
            </div>
            <?php elseif($search_step == 2): ?>
            <input type="hidden" name="departure_date" value="<?php echo $departure_date; ?>">
            <?php endif; ?>

            <div class="sb-field">
                <div class="sb-label">Passengers</div>
                <select name="passengers" class="sb-select" <?php echo $search_step==2?'disabled':''; ?>>
                    <?php for($i=1;$i<=4;$i++): ?>
                    <option value="<?php echo $i; ?>" <?php echo ($i==$passengers)?'selected':''; ?>><?php echo $i; ?> Passenger<?php echo $i>1?'s':''; ?></option>
                    <?php endfor; ?>
                </select>
                <?php if($search_step==2): ?><input type="hidden" name="passengers" value="<?php echo $passengers; ?>"><?php endif; ?>
            </div>
            <button type="submit" class="btn-search"><i class="bi bi-search"></i> Search</button>
        </form>
    </div>

    <div class="content">
        <aside>
            <div class="filter-panel">
                <div class="filter-title">Filters</div>
                <form method="GET" id="filterForm">
                    <input type="hidden" name="trip_type" value="<?php echo $trip_type; ?>">
                    <input type="hidden" name="step" value="<?php echo $search_step; ?>">
                    <input type="hidden" name="outbound_id" value="<?php echo $outbound_id; ?>">
                    <input type="hidden" name="origin_id" value="<?php echo $origin_id; ?>">
                    <input type="hidden" name="destination_id" value="<?php echo $destination_id; ?>">
                    <input type="hidden" name="departure_date" value="<?php echo $departure_date; ?>">
                    <input type="hidden" name="return_date" value="<?php echo $return_date; ?>">
                    <input type="hidden" name="passengers" value="<?php echo $passengers; ?>">

                    <div class="filter-section">
                        <div class="filter-section-title">Class</div>
                        <?php foreach(['Economy','Business','First'] as $cl): ?>
                        <label class="filter-check">
                            <input type="radio" name="class_filter" value="<?php echo $cl; ?>" <?php echo ($class_filter==$cl)?'checked':''; ?>> <?php echo $cl; ?>
                        </label>
                        <?php endforeach; ?>
                        <label class="filter-check">
                            <input type="radio" name="class_filter" value="" <?php echo (!$class_filter)?'checked':''; ?>> All Classes
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

        <div>
            <?php if (!$is_searched): ?>
                <div class="no-results"><i class="bi bi-search"></i> Where would you like to fly?<br>Please select your origin, destination, and dates above.</div>
            <?php else: ?>
                <div class="results-header">
                    <div class="results-count">Found <span><?php echo $total; ?></span> flight<?php echo $total!=1?'s':''; ?></div>
                </div>
                <?php if ($total == 0): ?>
                <div class="no-results"><i class="bi bi-airplane"></i> No flights found for this route.<br>Try different dates or destinations.</div>
                <?php endif; ?>

                <?php while ($f = mysqli_fetch_assoc($flights)):
                    $dep = new DateTime($f['departure_time']);
                    $arr = new DateTime($f['arrival_time']);
                    $dur = $dep->diff($arr);
                    $dur_str = ($dur->h ? $dur->h.'h ' : '') . $dur->i.'m';
                    $available = intval($f['available_seats']);

                    // PHP format('N'): 6 = Sat, 7 = Sun. Friday (5) is no longer a weekend.
                    $is_weekend = in_array($dep->format('N'), [6, 7]);

                    // ── Link Generation Logic ──
                    if ($trip_type == 'roundtrip' && $search_step == 1) {
                        $next_url = "search.php?trip_type=roundtrip&step=2&origin_id=$origin_id&destination_id=$destination_id&departure_date=$departure_date&return_date=$return_date&passengers=$passengers&outbound_id=" . $f['schedule_id'];
                    } else if ($trip_type == 'roundtrip' && $search_step == 2) {
                        $next_url = "seat_selection.php?trip_type=roundtrip&step=1&outbound_id=$outbound_id&return_id=" . $f['schedule_id'] . "&passengers=$passengers";
                    } else {
                        $next_url = "seat_selection.php?schedule_id=" . $f['schedule_id'] . "&passengers=$passengers";
                    }
                ?>
                
                <div class="flight-card" onclick="window.location='<?php echo $next_url; ?>'">
                    <div class="airline-info">
                        <div class="airline-logo">✈️</div>
                        <div>
                            <div style="font-weight:600;font-size:14px"><?php echo $f['airline_name']; ?></div>
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
                            <div class="route-dot"></div><div class="route-line-bar"><div class="route-plane"><i class="bi bi-airplane-fill"></i></div></div><div class="route-dot"></div>
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
                            <?php if($is_weekend): ?>
                                <div style="font-size:10px; color:var(--gold); background:var(--gold-light); padding:2px 6px; border-radius:4px; margin-top:2px;">Weekend Fare</div>
                            <?php else: ?>
                                <div class="price-seat" style="color:<?php echo $available<5?'var(--red)':'var(--green)'; ?>">
                                    <?php echo $available; ?> seat<?php echo $available!=1?'s':''; ?> left
                                </div>
                            <?php endif; ?>
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