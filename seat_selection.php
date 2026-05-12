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
            --available: #dbeafe;
            --available-hover: #bfdbfe;
            --occupied: #f1f5f9;
            --selected: #c47d20;
        }
        * { box-sizing:border-box;margin:0;padding:0; }
        body { background:var(--bg);color:var(--text);font-family:'DM Sans',sans-serif; }
        .sidebar { position:fixed;top:0;left:0;width:72px;height:100vh;background:var(--sidebar-bg);border-right:none;display:flex;flex-direction:column;align-items:center;padding:24px 0;z-index:100;box-shadow:4px 0 24px rgba(26,35,64,0.12); }
        .sidebar-logo { color:var(--gold2);font-size:24px;margin-bottom:36px; }
        .sidebar-nav { display:flex;flex-direction:column;gap:8px;width:100%; }
        .sidebar-item { display:flex;flex-direction:column;align-items:center;gap:4px;padding:12px 0;cursor:pointer;color:rgba(255,255,255,0.45);font-size:10px;transition:all .2s;text-decoration:none;border-left:3px solid transparent; }
        .sidebar-item i { font-size:20px; }
        .sidebar-item:hover { color:rgba(255,255,255,0.85);background:rgba(255,255,255,.06);border-left-color:var(--gold2); }
        .sidebar-item.active { color:#fff;background:var(--sidebar-active);border-left-color:var(--gold2); }
        .main { margin-left:72px;display:grid;grid-template-columns:1fr 360px;min-height:100vh; }
        .seat-section { padding:32px;border-right:1px solid var(--border); }

        .trip-progress { display:flex;align-items:center;margin-bottom:24px;padding-bottom:24px;border-bottom:1px solid var(--border); }
        .tp-step { display:flex;align-items:center;gap:12px;opacity:0.5; }
        .tp-step.active { opacity:1; }
        .tp-step.done { opacity:0.8; }
        .tp-dot { width:32px;height:32px;border-radius:50%;background:var(--bg2);border:1.5px solid var(--border);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;color:var(--text); }
        .tp-step.active .tp-dot { background:var(--sky);color:#fff;border-color:var(--sky); }
        .tp-step.done .tp-dot { background:var(--green);color:#fff;border-color:var(--green); }
        .tp-line { flex:1;height:1px;background:var(--border);margin:0 24px;max-width:100px; }

        .page-title { font-size:24px;font-weight:600;margin-bottom:4px;color:var(--text); }
        .page-sub { color:var(--muted);font-size:14px;margin-bottom:24px; }
        .legend { display:flex;gap:20px;margin-bottom:24px;flex-wrap:wrap; }
        .legend-item { display:flex;align-items:center;gap:8px;font-size:13px;color:var(--muted); }
        .legend-box { width:24px;height:24px;border-radius:6px; }
        .legend-available { background:var(--available);border:1px solid rgba(37,99,235,0.3); }
        .legend-occupied  { background:var(--occupied);border:1px solid var(--border);position:relative; }
        .legend-occupied::after { content:'×';position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);color:var(--muted);font-size:12px; }
        .legend-selected  { background:var(--selected); }
        .plane-wrapper { display:flex;justify-content:center; }
        .plane-body { width:340px;background:var(--card-bg);border:1px solid var(--border);border-radius:50px 50px 20px 20px;padding:20px 24px 30px;position:relative;box-shadow:var(--shadow); }
        .cabin-label { text-align:center;font-size:11px;text-transform:uppercase;letter-spacing:1px;padding:4px 12px;border-radius:20px;margin:12px auto 10px;width:fit-content; }
        .cabin-first { background:rgba(220,38,38,.1);color:#dc2626;border:1px solid rgba(220,38,38,.3); }
        .cabin-business { background:rgba(124,58,237,.1);color:#7c3aed;border:1px solid rgba(124,58,237,.3); }
        .cabin-economy { background:rgba(37,99,235,.1);color:#2563eb;border:1px solid rgba(37,99,235,.3); }
        .cabin-divider { height:1px;background:var(--border);margin:12px 0; }
        .seat-row { display:flex;align-items:center;justify-content:center;gap:6px;margin-bottom:6px; }
        .row-num { width:24px;text-align:center;font-size:11px;color:var(--muted); }
        .aisle { width:20px; }
        .seat { width:28px;height:28px;border-radius:6px;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:600;transition:all .15s;font-family:'DM Sans',sans-serif; }
        .seat.available { background:var(--available);color:var(--sky);border:1px solid rgba(37,99,235,.3); }
        .seat.available:hover { background:var(--available-hover);transform:scale(1.1); }
        .seat.occupied { background:var(--occupied);color:var(--muted);border:1px solid var(--border);cursor:not-allowed; }
        .seat.selected { background:var(--selected) !important;color:#fff !important;transform:scale(1.1);box-shadow:0 0 12px rgba(196,125,32,.4); }
        .seat.business-seat.available { background:rgba(124,58,237,.1);color:#7c3aed;border-color:rgba(124,58,237,.3); }
        .seat.first-seat.available { background:rgba(220,38,38,.1);color:#dc2626;border-color:rgba(220,38,38,.3); }
        .summary-section { padding:32px;background:var(--bg2); }
        .flight-info-card { background:var(--card-bg);border:1px solid var(--border);border-radius:16px;padding:20px;margin-bottom:20px;box-shadow:var(--shadow); }
        .fi-route { display:flex;align-items:center;justify-content:space-between;margin-bottom:16px; }
        .fi-code { font-size:28px;font-weight:700;color:var(--text); }
        .fi-arrow { color:var(--sky); }
        .fi-detail { font-size:13px;color:var(--muted);margin-bottom:6px; }
        .fi-detail span { color:var(--text); }
        .selected-seats-box { background:var(--card-bg);border:1px solid var(--border);border-radius:16px;padding:20px;margin-bottom:20px;box-shadow:var(--shadow); }
        .ss-title { font-size:14px;font-weight:600;margin-bottom:12px;color:var(--muted); }
        .ss-empty { text-align:center;color:var(--muted);font-size:13px;padding:20px; }
        .ss-item { display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid var(--border); }
        .ss-item:last-child { border-bottom:none; }
        .ss-seat-num { font-weight:600;font-size:16px;color:var(--text); }
        .ss-price { color:var(--gold);font-weight:600; }
        .ss-remove { background:none;border:none;color:var(--muted);cursor:pointer;padding:4px;transition:.2s; }
        .ss-remove:hover { color:#dc2626; }
        .price-breakdown { background:var(--card-bg);border:1px solid var(--border);border-radius:16px;padding:20px;margin-bottom:20px;box-shadow:var(--shadow); }
        .pb-row { display:flex;justify-content:space-between;font-size:14px;margin-bottom:8px;color:var(--text); }
        .pb-row.total { font-size:18px;font-weight:700;color:var(--sky);border-top:1px solid var(--border);padding-top:12px;margin-top:4px; }
        .pb-muted { color:var(--muted); }
        .btn-book { width:100%;background:linear-gradient(135deg,var(--sky),var(--sky2));border:none;color:#fff;border-radius:12px;padding:16px;font-size:16px;font-weight:700;cursor:pointer;transition:all .2s;box-shadow:0 6px 20px rgba(37,99,235,0.25); }
        .btn-book:hover:not(:disabled) { transform:translateY(-2px);box-shadow:0 10px 28px rgba(37,99,235,0.35); }
        .btn-book:disabled { background:var(--muted);cursor:not-allowed;opacity:0.5; }
        .btn-back { display:flex;align-items:center;gap:6px;color:var(--muted);text-decoration:none;font-size:14px;margin-bottom:24px; }
    </style>
</head>
<body>
<?php
include_once('db_connect.php');

$trip_type      = $_GET['trip_type'] ?? 'oneway';
$seat_step      = intval($_GET['step'] ?? 1);
$outbound_id    = intval($_GET['outbound_id'] ?? 0);
$return_id      = intval($_GET['return_id'] ?? 0);
$outbound_seats = $_GET['outbound_seats'] ?? '';
$passengers     = intval($_GET['passengers'] ?? 1);

if ($trip_type == 'roundtrip') {
    $current_schedule_id = ($seat_step == 1) ? $outbound_id : $return_id;
} else {
    $current_schedule_id = intval($_GET['schedule_id'] ?? 0);
}

if (!$current_schedule_id) { header('Location: index.php'); exit; }

$q_schedule = "SELECT fs.*, fr.flight_number, al.name AS airline_name,
               a1.code AS origin_code, a1.city AS origin_city,
               a2.code AS dest_code, a2.city AS dest_city
               FROM flight_schedule fs
               JOIN flight_route fr ON fs.flight_route_id = fr.id
               JOIN airline al ON fr.airline_id = al.id
               JOIN airport a1 ON fr.origin_id = a1.id
               JOIN airport a2 ON fr.destination_id = a2.id  
               WHERE fs.id = $current_schedule_id";
$schedule = mysqli_fetch_assoc(mysqli_query($conn, $q_schedule));

if (!$schedule) { header('Location: index.php'); exit; }

$prices_q = mysqli_query($conn, "SELECT travel_class, price FROM flight_pricing WHERE flight_schedule_id = $current_schedule_id");
$pricing = [];
while ($p = mysqli_fetch_assoc($prices_q)) $pricing[$p['travel_class']] = $p['price'];

$tickets_q = mysqli_query($conn, "SELECT seat_number FROM ticket WHERE flight_schedule_id = $current_schedule_id");
$occupied_seats = [];
while ($t = mysqli_fetch_assoc($tickets_q)) $occupied_seats[] = $t['seat_number'];

$aircraft_id = $schedule['aircraft_id'];
$seats_q = mysqli_query($conn, "SELECT * FROM aircraft_seat WHERE aircraft_id = $aircraft_id ORDER BY travel_class DESC, seat_number ASC");

$dep = new DateTime($schedule['departure_time']);
$arr = new DateTime($schedule['arrival_time']);
$dur = $dep->diff($arr);

// 6 = Saturday, 7 = Sunday
$is_weekend = in_array($dep->format('N'), [6, 7]);
$multiplier = $is_weekend ? 1.2 : 1.0;

$classes = ['First'=>[], 'Business'=>[], 'Economy'=>[]];
while ($s = mysqli_fetch_assoc($seats_q)) {
    $s['price'] = ($pricing[$s['travel_class']] ?? 0) * $multiplier;
    $s['is_occupied'] = in_array($s['seat_number'], $occupied_seats);
    $classes[$s['travel_class']][] = $s;
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
    <div class="seat-section">
        <a href="javascript:history.back()" class="btn-back"><i class="bi bi-arrow-left"></i> Back</a>
        
        <?php if ($trip_type == 'roundtrip'): ?>
        <div class="trip-progress">
            <div class="tp-step <?php echo $seat_step == 1 ? 'active' : 'done'; ?>">
                <div class="tp-dot"><?php echo $seat_step == 1 ? '1' : '<i class="bi bi-check"></i>'; ?></div>
                <div><strong style="color:var(--text)">Outbound Seats</strong></div>
            </div>
            <div class="tp-line"></div>
            <div class="tp-step <?php echo $seat_step == 2 ? 'active' : ''; ?>">
                <div class="tp-dot">2</div>
                <div><strong style="color:var(--text)">Return Seats</strong></div>
            </div>
        </div>
        <?php endif; ?>

        <div class="page-title"><?php echo ($trip_type == 'roundtrip' && $seat_step == 2) ? 'Select Return Seats' : 'Select Outbound Seats'; ?></div>
        <div class="page-sub">Flight <?php echo $schedule['flight_number']; ?> · <?php echo $schedule['origin_code']; ?> → <?php echo $schedule['dest_code']; ?> · Select <?php echo $passengers; ?> seat<?php echo $passengers>1?'s':''; ?></div>

        <div class="legend">
            <div class="legend-item"><div class="legend-box legend-available"></div>Available</div>
            <div class="legend-item"><div class="legend-box legend-occupied"></div>Occupied</div>
            <div class="legend-item"><div class="legend-box legend-selected"></div>Selected</div>
        </div>

        <div class="plane-wrapper">
            <div class="plane-body">
                <div style="text-align:center; font-size:24px; margin-bottom:20px;">✈️</div>

                <?php
                $class_configs = [
                    'First'    => ['label'=>'First Class','label_class'=>'cabin-first','seat_class'=>'first-seat','cols'=>['A','B']],
                    'Business' => ['label'=>'Business Class','label_class'=>'cabin-business','seat_class'=>'business-seat','cols'=>['A','B','C','D']],
                    'Economy'  => ['label'=>'Economy Class','label_class'=>'cabin-economy','seat_class'=>'','cols'=>['A','B','C','D','E','F']],
                ];

                foreach ($class_configs as $class_name => $cfg):
                    if (empty($classes[$class_name])) continue;
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
                <?php foreach ($rows as $row_num => $row_seats): ?>
                <div class="seat-row">
                    <div class="row-num"><?php echo $row_num; ?></div>
                    <?php for($i=0;$i<count($cols);$i++):
                        if($i==$mid): ?><div class="aisle"></div><?php endif;
                        $col = $cols[$i];
                        $seat = $row_seats[$col] ?? null;
                        if ($seat):
                            $status = $seat['is_occupied'] ? 'occupied' : 'available';
                    ?>
                    <button class="seat <?php echo $status; ?> <?php echo $cfg['seat_class']; ?>"
                        <?php echo $seat['is_occupied'] ? 'disabled' : ''; ?>
                        data-seat-num="<?php echo $seat['seat_number']; ?>"
                        data-seat-class="<?php echo $class_name; ?>"
                        data-seat-price="<?php echo $seat['price']; ?>"
                        onclick="toggleSeat(this)"></button>
                    <?php else: ?><div style="width:28px;height:28px"></div><?php endif; ?>
                    <?php endfor; ?>
                </div>
                <?php endforeach; ?>
                <div class="cabin-divider"></div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="summary-section">
        <div class="flight-info-card">
            <div class="fi-route">
                <div class="fi-code"><?php echo $schedule['origin_code']; ?></div>
                <div class="fi-arrow"><i class="bi bi-airplane-fill"></i></div>
                <div class="fi-code"><?php echo $schedule['dest_code']; ?></div>
            </div>
            <div class="fi-detail"><span><?php echo $schedule['airline_name']; ?></span> · <?php echo $schedule['flight_number']; ?></div>
            <div class="fi-detail">Departure: <span><?php echo $dep->format('d M Y, H:i'); ?></span></div>
        </div>
        <div class="selected-seats-box">
            <div class="ss-title">Selected Seats (0 / <?php echo $passengers; ?>)</div>
            <div id="selectedSeatsContainer"><div class="ss-empty">No seats selected.</div></div>
        </div>
        <div class="price-breakdown">
            <div class="pb-row"><span class="pb-muted">Seats</span><span id="pbSeats">IDR 0</span></div>
            <div class="pb-row"><span class="pb-muted">Tax & Fee (10%)</span><span id="pbTax">IDR 0</span></div>
            <div class="pb-row total"><span>Total</span><span id="pbTotal">IDR 0</span></div>
        </div>

        <?php if ($trip_type == 'roundtrip' && $seat_step == 1): ?>
            <form method="GET" action="seat_selection.php">
                <input type="hidden" name="trip_type" value="roundtrip">
                <input type="hidden" name="step" value="2">
                <input type="hidden" name="outbound_id" value="<?php echo $outbound_id; ?>">
                <input type="hidden" name="return_id" value="<?php echo $return_id; ?>">
                <input type="hidden" name="passengers" value="<?php echo $passengers; ?>">
                <input type="hidden" name="outbound_seats" id="seatNumbersInput" value="">
                <button type="submit" class="btn-book" id="btnBook" disabled>Select Return Seats <i class="bi bi-arrow-right"></i></button>
            </form>
        <?php else: ?>
            <form method="GET" action="booking.php">
                <input type="hidden" name="trip_type" value="<?php echo $trip_type; ?>">
                <input type="hidden" name="passengers" value="<?php echo $passengers; ?>">
                <?php if ($trip_type == 'roundtrip'): ?>
                    <input type="hidden" name="outbound_id" value="<?php echo $outbound_id; ?>">
                    <input type="hidden" name="return_id" value="<?php echo $return_id; ?>">
                    <input type="hidden" name="outbound_seats" value="<?php echo $outbound_seats; ?>">
                    <input type="hidden" name="return_seats" id="seatNumbersInput" value="">
                <?php else: ?>
                    <input type="hidden" name="schedule_id" value="<?php echo $current_schedule_id; ?>">
                    <input type="hidden" name="seat_numbers" id="seatNumbersInput" value="">
                <?php endif; ?>
                <button type="submit" class="btn-book" id="btnBook" disabled>Continue to Booking <i class="bi bi-arrow-right"></i></button>
            </form>
        <?php endif; ?>

    </div>
</div>

<script>
const MAX_SEATS = <?php echo $passengers; ?>;
let selectedSeats = []; 
function toggleSeat(btn) {
    const num   = btn.dataset.seatNum;
    const cls   = btn.dataset.seatClass;
    const price = parseInt(btn.dataset.seatPrice);
    const idx = selectedSeats.findIndex(s => s.num === num);
    if (idx >= 0) {
        selectedSeats.splice(idx, 1);
        btn.classList.remove('selected');
    } else {
        if (selectedSeats.length >= MAX_SEATS) {
            const old = selectedSeats.shift();
            document.querySelector(`[data-seat-num="${old.num}"]`)?.classList.remove('selected');
        }
        selectedSeats.push({num, cls, price});
        btn.classList.add('selected');
    }
    updateSummary();
}
function removeSeat(num) {
    const idx = selectedSeats.findIndex(s => s.num === num);
    if (idx >= 0) {
        document.querySelector(`[data-seat-num="${num}"]`)?.classList.remove('selected');
        selectedSeats.splice(idx, 1);
    }
    updateSummary();
}
function fmt(n) { return 'IDR ' + n.toLocaleString('id-ID'); }
function updateSummary() {
    const container = document.getElementById('selectedSeatsContainer');
    document.querySelector('.ss-title').textContent = `Selected Seats (${selectedSeats.length} / ${MAX_SEATS})`;
    if (selectedSeats.length === 0) {
        container.innerHTML = '<div class="ss-empty">No seats selected.</div>';
    } else {
        container.innerHTML = selectedSeats.map(s => `
            <div class="ss-item">
                <div><div class="ss-seat-num">Seat ${s.num}</div><div style="font-size:12px; color:var(--muted)">${s.cls}</div></div>
                <div style="display:flex;align-items:center;gap:12px"><div class="ss-price">${fmt(s.price)}</div><button class="ss-remove" onclick="removeSeat('${s.num}')"><i class="bi bi-x-circle"></i></button></div>
            </div>
        `).join('');
    }
    const subtotal = selectedSeats.reduce((sum, s) => sum + s.price, 0);
    const tax = Math.round(subtotal * 0.1);
    const total = subtotal + tax;
    document.getElementById('pbSeats').textContent = fmt(subtotal);
    document.getElementById('pbTax').textContent   = fmt(tax);
    document.getElementById('pbTotal').textContent = fmt(total);
    document.getElementById('btnBook').disabled = selectedSeats.length !== MAX_SEATS;
    document.getElementById('seatNumbersInput').value = selectedSeats.map(s => s.num).join(',');
}
</script>
</body>
</html>