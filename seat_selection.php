<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seat Selection – SkyWings</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --dark:#0d1117; --dark2:#161b27; --card-bg:#1c2333;
            --gold:#c9a84c; --gold2:#e8c96a; --text:#e8eaf0;
            --muted:#8892a4; --border:rgba(255,255,255,0.08);
            --available:#2a3a4a; --available-hover:#3a5a7a;
            --occupied:#2a2020; --selected:#c9a84c;
            --economy:#4f8ef7; --business:#9b59b6; --first:#e74c3c;
        }
        * { box-sizing:border-box;margin:0;padding:0; }
        body { background:var(--dark);color:var(--text);font-family:'DM Sans',sans-serif; }

        .sidebar { position:fixed;top:0;left:0;width:72px;height:100vh;background:var(--dark2);border-right:1px solid var(--border);display:flex;flex-direction:column;align-items:center;padding:24px 0;z-index:100; }
        .sidebar-logo { color:var(--gold);font-size:24px;margin-bottom:36px; }
        .sidebar-nav { display:flex;flex-direction:column;gap:8px;width:100%; }
        .sidebar-item { display:flex;flex-direction:column;align-items:center;gap:4px;padding:12px 0;cursor:pointer;color:var(--muted);font-size:10px;transition:all .2s;text-decoration:none;border-left:3px solid transparent; }
        .sidebar-item i { font-size:20px; }
        .sidebar-item:hover,.sidebar-item.active { color:var(--text);background:rgba(255,255,255,.04);border-left-color:var(--gold); }
        .main { margin-left:72px;display:grid;grid-template-columns:1fr 360px;min-height:100vh; }

        /* LEFT: Seat Map */
        .seat-section { padding:32px;border-right:1px solid var(--border); }
        .page-title { font-size:24px;font-weight:600;margin-bottom:4px; }
        .page-sub { color:var(--muted);font-size:14px;margin-bottom:24px; }

        /* LEGEND */
        .legend { display:flex;gap:20px;margin-bottom:24px;flex-wrap:wrap; }
        .legend-item { display:flex;align-items:center;gap:8px;font-size:13px;color:var(--muted); }
        .legend-box { width:24px;height:24px;border-radius:6px; }
        .legend-available { background:var(--available);border:1px solid rgba(79,142,247,.4); }
        .legend-occupied  { background:var(--occupied);border:1px solid rgba(255,255,255,.05);position:relative; }
        .legend-occupied::after { content:'×';position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);color:var(--muted);font-size:12px; }
        .legend-selected  { background:var(--selected); }
        .legend-business  { background:rgba(155,89,182,.3);border:1px solid rgba(155,89,182,.5); }
        .legend-first     { background:rgba(231,76,60,.3);border:1px solid rgba(231,76,60,.5); }

        /* PLANE SHAPE */
        .plane-wrapper { display:flex;justify-content:center; }
        .plane-body {
            width:340px;
            background:var(--dark2);
            border:1px solid var(--border);
            border-radius:50px 50px 20px 20px;
            padding:20px 24px 30px;
            position:relative;
        }
        .plane-nose {
            text-align:center;margin-bottom:16px;
            font-size:28px;padding-top:8px;
        }
        .cabin-label {
            text-align:center;font-size:11px;
            text-transform:uppercase;letter-spacing:1px;
            padding:4px 12px;border-radius:20px;
            margin:12px auto 10px;width:fit-content;
        }
        .cabin-first    { background:rgba(231,76,60,.15);color:#e74c3c;border:1px solid rgba(231,76,60,.3); }
        .cabin-business { background:rgba(155,89,182,.15);color:#9b59b6;border:1px solid rgba(155,89,182,.3); }
        .cabin-economy  { background:rgba(79,142,247,.15);color:#4f8ef7;border:1px solid rgba(79,142,247,.3); }
        .cabin-divider  { height:1px;background:var(--border);margin:12px 0; }

        /* SEAT ROW */
        .seat-row { display:flex;align-items:center;justify-content:center;gap:6px;margin-bottom:6px; }
        .row-num { width:24px;text-align:center;font-size:11px;color:var(--muted); }
        .col-label { width:28px;text-align:center;font-size:10px;color:var(--muted); }
        .aisle { width:20px; }
        .seat {
            width:28px;height:28px;border-radius:6px;border:none;
            cursor:pointer;display:flex;align-items:center;justify-content:center;
            font-size:10px;font-weight:600;transition:all .15s;
            font-family:'DM Sans',sans-serif;
            position:relative;
        }
        .seat.available {
            background:var(--available);color:#4f8ef7;
            border:1px solid rgba(79,142,247,.3);
        }
        .seat.available:hover { background:var(--available-hover);transform:scale(1.1); }
        .seat.occupied {
            background:var(--occupied);color:var(--muted);
            border:1px solid rgba(255,255,255,.05);cursor:not-allowed;
        }
        .seat.occupied::after { content:'✕';font-size:10px; }
        .seat.selected {
            background:var(--selected) !important;color:#000 !important;
            border-color:var(--gold2) !important;transform:scale(1.1);
            box-shadow:0 0 12px rgba(201,168,76,.4);
        }
        .seat.business-seat.available { background:rgba(155,89,182,.2);color:#9b59b6;border-color:rgba(155,89,182,.4); }
        .seat.business-seat.available:hover { background:rgba(155,89,182,.35); }
        .seat.first-seat.available { background:rgba(231,76,60,.2);color:#e74c3c;border-color:rgba(231,76,60,.4); }
        .seat.first-seat.available:hover { background:rgba(231,76,60,.35); }

        /* RIGHT: Summary */
        .summary-section { padding:32px;background:var(--dark2); }
        .flight-info-card { background:var(--card-bg);border:1px solid var(--border);border-radius:16px;padding:20px;margin-bottom:20px; }
        .fi-route { display:flex;align-items:center;justify-content:space-between;margin-bottom:16px; }
        .fi-code { font-size:28px;font-weight:700; }
        .fi-arrow { color:var(--gold); }
        .fi-detail { font-size:13px;color:var(--muted);margin-bottom:6px; }
        .fi-detail span { color:var(--text); }

        .selected-seats-box { background:var(--card-bg);border:1px solid var(--border);border-radius:16px;padding:20px;margin-bottom:20px; }
        .ss-title { font-size:14px;font-weight:600;margin-bottom:12px;color:var(--muted); }
        .ss-empty { text-align:center;color:var(--muted);font-size:13px;padding:20px; }
        .ss-item { display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid var(--border); }
        .ss-item:last-child { border-bottom:none; }
        .ss-seat-num { font-weight:600;font-size:16px; }
        .ss-class { font-size:12px;color:var(--muted); }
        .ss-price { color:var(--gold);font-weight:600; }
        .ss-remove { background:none;border:none;color:var(--muted);cursor:pointer;padding:4px;border-radius:4px;transition:.2s; }
        .ss-remove:hover { color:#e74c3c; }

        .price-breakdown { background:var(--card-bg);border:1px solid var(--border);border-radius:16px;padding:20px;margin-bottom:20px; }
        .pb-row { display:flex;justify-content:space-between;font-size:14px;margin-bottom:8px; }
        .pb-row.total { font-size:18px;font-weight:700;color:var(--gold);border-top:1px solid var(--border);padding-top:12px;margin-top:4px; }
        .pb-muted { color:var(--muted); }

        .btn-book {
            width:100%;background:var(--gold);border:none;color:#000;
            border-radius:12px;padding:16px;font-size:16px;font-weight:700;
            cursor:pointer;transition:all .2s;font-family:'DM Sans',sans-serif;
        }
        .btn-book:hover { background:var(--gold2);transform:translateY(-2px); }
        .btn-book:disabled { background:var(--muted);cursor:not-allowed;transform:none; }
        .btn-back { display:flex;align-items:center;gap:6px;color:var(--muted);text-decoration:none;font-size:14px;margin-bottom:24px; }
        .btn-back:hover { color:var(--text); }
    </style>
</head>
<body>

<?php
include_once('db_connect.php');

$flight_id = intval($_GET['flight_id'] ?? 0);
$passengers = intval($_GET['passengers'] ?? 1);

if (!$flight_id) { header('Location: index.php'); exit; }

$flight = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT f.*, a1.code AS origin_code, a1.city AS origin_city,
     a2.code AS dest_code, a2.city AS dest_city
     FROM flight f
     JOIN airport a1 ON f.origin_id=a1.id
     JOIN airport a2 ON f.destination_id=a2.id
     WHERE f.id=$flight_id"));

if (!$flight) { header('Location: index.php'); exit; }

$seats_q = mysqli_query($conn, "SELECT * FROM seat WHERE flight_id=$flight_id ORDER BY class DESC, seat_number ASC");
$seats = [];
while ($s = mysqli_fetch_assoc($seats_q)) $seats[] = $s;

// Group by class
$classes = ['First'=>[], 'Business'=>[], 'Economy'=>[]];
foreach ($seats as $s) {
    if (isset($classes[$s['class']])) $classes[$s['class']][] = $s;
}

$dep = new DateTime($flight['departure_time']);
$arr = new DateTime($flight['arrival_time']);
$dur = $dep->diff($arr);
$dur_str = ($dur->h ? $dur->h.'h ' : '') . $dur->i.'m';
?>

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
    <!-- SEAT MAP -->
    <div class="seat-section">
        <a href="javascript:history.back()" class="btn-back"><i class="bi bi-arrow-left"></i> Back to flights</a>
        <div class="page-title">Select Your Seat<?php echo $passengers>1?'s':''; ?></div>
        <div class="page-sub">Flight <?php echo $flight['flight_number']; ?> · <?php echo $flight['origin_code']; ?> → <?php echo $flight['dest_code']; ?> · <?php echo $dep->format('d M Y'); ?> · Select <?php echo $passengers; ?> seat<?php echo $passengers>1?'s':''; ?></div>

        <div class="legend">
            <div class="legend-item"><div class="legend-box legend-available"></div>Available</div>
            <div class="legend-item"><div class="legend-box legend-occupied"></div>Occupied</div>
            <div class="legend-item"><div class="legend-box legend-selected"></div>Selected</div>
            <div class="legend-item"><div class="legend-box legend-business"></div>Business</div>
            <div class="legend-item"><div class="legend-box legend-first"></div>First Class</div>
        </div>

        <div class="plane-wrapper">
            <div class="plane-body">
                <div class="plane-nose">✈️</div>

                <?php
                $col_order = ['A','B','C','D','E','F'];
                $class_styles = [
                    'First'    => ['label'=>'First Class','label_class'=>'cabin-first','seat_class'=>'first-seat','cols'=>['A','B']],
                    'Business' => ['label'=>'Business Class','label_class'=>'cabin-business','seat_class'=>'business-seat','cols'=>['A','B','C']],
                    'Economy'  => ['label'=>'Economy Class','label_class'=>'cabin-economy','seat_class'=>'','cols'=>['A','B','C','D','E','F']],
                ];

                foreach ($class_styles as $class_name => $cfg):
                    if (empty($classes[$class_name])) continue;

                    // Build rows map
                    $rows = [];
                    foreach ($classes[$class_name] as $seat) {
                        preg_match('/(\d+)([A-F])/', $seat['seat_number'], $m);
                        if ($m) { $rows[$m[1]][$m[2]] = $seat; }
                    }
                    ksort($rows);
                    $cols = $cfg['cols'];
                    $mid = intval(count($cols)/2);
                ?>
                <div class="cabin-label <?php echo $cfg['label_class']; ?>"><?php echo $cfg['label']; ?></div>

                <!-- Column headers -->
                <div class="seat-row">
                    <div class="row-num"></div>
                    <?php for($i=0;$i<count($cols);$i++): ?>
                        <?php if($i==$mid && count($cols)>3): ?><div class="aisle"></div><?php endif; ?>
                        <div class="col-label"><?php echo $cols[$i]; ?></div>
                    <?php endfor; ?>
                </div>

                <?php foreach ($rows as $row_num => $row_seats): ?>
                <div class="seat-row">
                    <div class="row-num"><?php echo $row_num; ?></div>
                    <?php for($i=0;$i<count($cols);$i++):
                        if($i==$mid && count($cols)>3): ?><div class="aisle"></div><?php endif;
                        $col = $cols[$i];
                        $seat = $row_seats[$col] ?? null;
                        if ($seat):
                            $status = $seat['is_booked'] ? 'occupied' : 'available';
                            $sclass = $cfg['seat_class'];
                    ?>
                    <button
                        class="seat <?php echo $status; ?> <?php echo $sclass; ?>"
                        <?php echo $seat['is_booked'] ? 'disabled' : ''; ?>
                        data-seat-id="<?php echo $seat['id']; ?>"
                        data-seat-num="<?php echo $seat['seat_number']; ?>"
                        data-seat-class="<?php echo $seat['class']; ?>"
                        data-seat-price="<?php echo $seat['price']; ?>"
                        onclick="toggleSeat(this)"
                        title="Seat <?php echo $seat['seat_number']; ?> – <?php echo $seat['class']; ?> – IDR <?php echo number_format($seat['price']); ?>"
                    ></button>
                    <?php else: ?>
                    <div style="width:28px;height:28px"></div>
                    <?php endif; ?>
                    <?php endfor; ?>
                </div>
                <?php endforeach; ?>
                <div class="cabin-divider"></div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- SUMMARY -->
    <div class="summary-section">
        <div style="height:56px"></div><!-- spacer for topbar visual -->

        <div class="flight-info-card">
            <div class="fi-route">
                <div>
                    <div class="fi-code"><?php echo $flight['origin_code']; ?></div>
                    <div style="font-size:12px;color:var(--muted)"><?php echo $flight['origin_city']; ?></div>
                </div>
                <div class="fi-arrow"><i class="bi bi-airplane-fill" style="font-size:20px"></i></div>
                <div style="text-align:right">
                    <div class="fi-code"><?php echo $flight['dest_code']; ?></div>
                    <div style="font-size:12px;color:var(--muted)"><?php echo $flight['dest_city']; ?></div>
                </div>
            </div>
            <div class="fi-detail"><span><?php echo $flight['airline']; ?></span> · <?php echo $flight['flight_number']; ?></div>
            <div class="fi-detail">Departure: <span><?php echo $dep->format('d M Y, H:i'); ?></span></div>
            <div class="fi-detail">Arrival: <span><?php echo $arr->format('d M Y, H:i'); ?></span></div>
            <div class="fi-detail">Duration: <span><?php echo $dur_str; ?></span></div>
        </div>

        <div class="selected-seats-box">
            <div class="ss-title">Selected Seats (0 / <?php echo $passengers; ?>)</div>
            <div id="selectedSeatsContainer">
                <div class="ss-empty" id="emptyMsg">No seats selected. Click on the seat map.</div>
            </div>
        </div>

        <div class="price-breakdown">
            <div class="pb-row"><span class="pb-muted">Seats</span><span id="pbSeats">IDR 0</span></div>
            <div class="pb-row"><span class="pb-muted">Tax & Fee (10%)</span><span id="pbTax">IDR 0</span></div>
            <div class="pb-row total"><span>Total</span><span id="pbTotal">IDR 0</span></div>
        </div>

        <form method="GET" action="booking.php" id="bookingForm">
            <input type="hidden" name="flight_id" value="<?php echo $flight_id; ?>">
            <input type="hidden" name="passengers" value="<?php echo $passengers; ?>">
            <input type="hidden" name="seat_ids" id="seatIdsInput" value="">
            <button type="submit" class="btn-book" id="btnBook" disabled>
                Continue Booking <i class="bi bi-arrow-right"></i>
            </button>
        </form>
    </div>
</div>

<script>
const MAX_SEATS = <?php echo $passengers; ?>;
let selectedSeats = []; // {id, num, class, price}

function toggleSeat(btn) {
    const id    = btn.dataset.seatId;
    const num   = btn.dataset.seatNum;
    const cls   = btn.dataset.seatClass;
    const price = parseInt(btn.dataset.seatPrice);

    const idx = selectedSeats.findIndex(s => s.id === id);
    if (idx >= 0) {
        // Deselect
        selectedSeats.splice(idx, 1);
        btn.classList.remove('selected');
        btn.classList.add('available');
    } else {
        if (selectedSeats.length >= MAX_SEATS) {
            // Deselect oldest
            const old = selectedSeats.shift();
            document.querySelector(`[data-seat-id="${old.id}"]`)?.classList.replace('selected','available');
        }
        selectedSeats.push({id, num, cls, price});
        btn.classList.add('selected');
    }
    updateSummary();
}

function removeSeat(id) {
    const idx = selectedSeats.findIndex(s => s.id === id);
    if (idx >= 0) {
        document.querySelector(`[data-seat-id="${selectedSeats[idx].id}"]`)?.classList.replace('selected','available');
        selectedSeats.splice(idx, 1);
    }
    updateSummary();
}

function fmt(n) { return 'IDR ' + n.toLocaleString('id-ID'); }

function updateSummary() {
    const box = document.getElementById('selectedSeatsContainer');
    const empty = document.getElementById('emptyMsg');
    const title = document.querySelector('.ss-title');
    title.textContent = `Selected Seats (${selectedSeats.length} / ${MAX_SEATS})`;

    if (selectedSeats.length === 0) {
        box.innerHTML = '<div class="ss-empty" id="emptyMsg">No seats selected. Click on the seat map.</div>';
    } else {
        box.innerHTML = selectedSeats.map(s => `
            <div class="ss-item">
                <div>
                    <div class="ss-seat-num">Seat ${s.num}</div>
                    <div class="ss-class">${s.cls}</div>
                </div>
                <div style="display:flex;align-items:center;gap:12px">
                    <div class="ss-price">${fmt(s.price)}</div>
                    <button class="ss-remove" onclick="removeSeat('${s.id}')"><i class="bi bi-x-circle"></i></button>
                </div>
            </div>
        `).join('');
    }

    const subtotal = selectedSeats.reduce((a,s) => a + s.price, 0);
    const tax = Math.round(subtotal * 0.1);
    const total = subtotal + tax;

    document.getElementById('pbSeats').textContent = fmt(subtotal);
    document.getElementById('pbTax').textContent   = fmt(tax);
    document.getElementById('pbTotal').textContent = fmt(total);

    const btn = document.getElementById('btnBook');
    const ready = selectedSeats.length === MAX_SEATS;
    btn.disabled = !ready;
    document.getElementById('seatIdsInput').value = selectedSeats.map(s => s.id).join(',');
}
</script>
</body>
</html>
