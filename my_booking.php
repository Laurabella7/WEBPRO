<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Trips – SkyWings</title>
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
            --text: #1a2340;
            --muted: #7a8aaa;
            --border: rgba(26,35,64,0.10);
            --sky: #2563eb;
            --sky2: #3b82f6;
            --shadow: 0 4px 32px rgba(37,99,235,0.08);
            --green: #16a34a;
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

        .main { margin-left: 72px; padding: 48px; max-width: 900px; }
        
        .page-title { font-size: 32px; font-weight: 700; margin-bottom: 8px; color: var(--text); font-family: 'Playfair Display', serif; }
        .page-sub { color: var(--muted); font-size: 15px; margin-bottom: 32px; }

        /* ── SEARCH BOX ── */
        .search-box { display: flex; gap: 12px; margin-bottom: 40px; background: var(--card-bg); padding: 10px; border-radius: 20px; box-shadow: var(--shadow); border: 1px solid var(--border); }
        .code-input { 
            flex: 1; background: transparent; border: none; padding: 12px 20px; 
            font-size: 18px; font-weight: 700; letter-spacing: 3px; color: var(--sky); 
            text-transform: uppercase; outline: none; 
        }
        .code-input::placeholder { letter-spacing: 0; text-transform: none; color: var(--muted); font-weight: 400; }
        .btn-find { 
            background: linear-gradient(135deg, var(--sky), var(--sky2)); 
            color: #fff; border: none; border-radius: 14px; padding: 0 32px; 
            font-weight: 700; transition: 0.2s; 
        }
        .btn-find:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(37,99,235,0.2); }

        /* ── TICKET CARD ── */
        .ticket-card { background: var(--card-bg); border-radius: 24px; border: 1px solid var(--border); overflow: hidden; margin-bottom: 24px; box-shadow: var(--shadow); }
        .ticket-header { 
            background: linear-gradient(to right, #f8fafc, #ffffff); 
            padding: 24px 32px; border-bottom: 1px dashed var(--border); 
            display: flex; justify-content: space-between; align-items: center; 
        }
        .ticket-route { font-size: 24px; font-weight: 800; color: var(--text); letter-spacing: -0.5px; }
        .ticket-airline { font-size: 13px; color: var(--muted); font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; }
        .ticket-status { 
            background: #ecfdf5; color: var(--green); padding: 6px 14px; 
            border-radius: 10px; font-size: 12px; font-weight: 700; display: flex; align-items: center; gap: 6px; 
        }

        .ticket-body { padding: 32px; display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
        .ticket-info-group { margin-bottom: 4px; }
        .ticket-label { font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: 1px; font-weight: 700; margin-bottom: 4px; display: block; }
        .ticket-value { font-size: 15px; font-weight: 600; color: var(--text); }

        .booking-code-display { 
            background: var(--sidebar-bg); border-radius: 16px; padding: 24px; 
            text-align: center; margin-top: 32px; 
        }
        .booking-code-display .label { color: rgba(255,255,255,0.5); font-size: 12px; margin-bottom: 8px; display: block; }
        .booking-code-val { font-size: 32px; font-weight: 800; letter-spacing: 6px; color: var(--gold2); }

        .no-result { text-align: center; padding: 80px 40px; color: var(--muted); }
        .no-result i { font-size: 56px; color: var(--bg2); margin-bottom: 20px; display: block; }

        .total-strip { 
            background: var(--gold-light); border: 1px solid rgba(196,125,32,0.1); 
            padding: 16px 32px; display: flex; justify-content: space-between; align-items: center; 
        }
    </style>
</head>
<body>

<?php
include_once('db_connect.php');

$code = strtoupper(trim($_GET['code'] ?? $_POST['code'] ?? ''));
$code = preg_replace('/[^A-Z0-9]/', '', $code);

$reservations = [];
if ($code) {
    $code_safe = mysqli_real_escape_string($conn, $code);
    $query = "SELECT b.booking_code, b.contact_email, b.contact_phone, b.total_amount, b.booked_at,
              t.passenger_name, t.seat_number, t.travel_class,
              fp.price * (CASE WHEN DAYOFWEEK(fs.departure_time) IN (1, 7) THEN 1.2 ELSE 1.0 END) AS seat_price,
              fr.flight_number, al.name AS airline_name, fs.departure_time, fs.arrival_time,
              a1.code AS origin_code, a1.city AS origin_city,
              a2.code AS dest_code, a2.city AS dest_city
              FROM booking b
              JOIN ticket t ON b.id = t.booking_id
              JOIN flight_schedule fs ON t.flight_schedule_id = fs.id
              JOIN flight_route fr ON fs.flight_route_id = fr.id
              JOIN airline al ON fr.airline_id = al.id
              JOIN airport a1 ON fr.origin_id = a1.id
              JOIN airport a2 ON fr.destination_id = a2.id
              LEFT JOIN flight_pricing fp ON fp.flight_schedule_id = fs.id AND fp.travel_class = t.travel_class
              WHERE b.booking_code = '$code_safe'";

    $q = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($q)) $reservations[] = $row;
}
?>

<div class="sidebar">
    <div class="sidebar-logo"><i class="bi bi-send-fill" style="transform:rotate(-45deg);display:inline-block"></i></div>
    <nav class="sidebar-nav">
        <a href="index.php" class="sidebar-item"><i class="bi bi-house-fill"></i><span>Home</span></a>
        <a href="search.php" class="sidebar-item"><i class="bi bi-airplane-fill"></i><span>Flights</span></a>
        <a href="my_booking.php" class="sidebar-item active"><i class="bi bi-journal-bookmark-fill"></i><span>Trips</span></a>
    </nav>
</div>

<div class="main">
    <div class="page-title">My Trips</div>
    <div class="page-sub">Enter your 8-digit booking code to manage your reservation.</div>

    <form method="GET" class="search-box">
        <input type="text" name="code" class="code-input" placeholder="e.g. A1B2C3D4" value="<?php echo htmlspecialchars($code); ?>" maxlength="8">
        <button type="submit" class="btn-find">Retrieve Booking</button>
    </form>

    <?php if ($code && empty($reservations)): ?>
    <div class="no-result">
        <i class="bi bi-ticket-perforated"></i>
        <h5>Reservation Not Found</h5>
        <p>We couldn't find any trips for "<strong><?php echo htmlspecialchars($code); ?></strong>".<br>Please verify your code and try again.</p>
    </div>

    <?php elseif (!empty($reservations)): ?>
    
    <?php 
        $first_ticket = $reservations[0]; 
        $master_total = $first_ticket['total_amount'];
    ?>
    
    <?php foreach ($reservations as $r):
        $dep = new DateTime($r['departure_time']);
        $arr = new DateTime($r['arrival_time']);
        $dur = $dep->diff($arr);
        $dur_str = ($dur->h ? $dur->h.'h ' : '') . $dur->i.'m';
    ?>
    <div class="ticket-card">
        <div class="ticket-header">
            <div>
                <div class="ticket-route"><?php echo $r['origin_code'].' <i class="bi bi-arrow-right" style="font-size:16px; vertical-align:middle; color:var(--sky)"></i> '.$r['dest_code']; ?></div>
                <div class="ticket-airline"><?php echo $r['airline_name'].' &bull; '.$r['flight_number']; ?></div>
            </div>
            <span class="ticket-status"><i class="bi bi-patch-check-fill"></i> Confirmed</span>
        </div>
        <div class="ticket-body">
            <div class="ticket-info-group"><span class="ticket-label">Passenger Name</span><span class="ticket-value"><?php echo htmlspecialchars($r['passenger_name']); ?></span></div>
            <div class="ticket-info-group"><span class="ticket-label">Seat & Class</span><span class="ticket-value"><?php echo $r['seat_number'].' ('.$r['travel_class'].')'; ?></span></div>
            <div class="ticket-info-group"><span class="ticket-label">Departure</span><span class="ticket-value"><?php echo $dep->format('d M Y, H:i'); ?></span></div>
            <div class="ticket-info-group"><span class="ticket-label">Arrival</span><span class="ticket-value"><?php echo $arr->format('d M Y, H:i'); ?></span></div>
            <div class="ticket-info-group"><span class="ticket-label">Travel Duration</span><span class="ticket-value"><?php echo $dur_str; ?></span></div>
            <div class="ticket-info-group"><span class="ticket-label">Fare</span><span class="ticket-value" style="color:var(--gold)">IDR <?php echo number_format($r['seat_price']); ?></span></div>
        </div>
    </div>
    <?php endforeach; ?>

    <div class="ticket-card">
        <div class="total-strip">
            <span style="font-weight:700; color:var(--text)">Total Paid Amount</span>
            <span style="font-size:20px; font-weight:800; color:var(--sky)">IDR <?php echo number_format($master_total); ?></span>
        </div>
        <div class="booking-code-display">
            <span class="label">Official Booking Reference</span>
            <div class="booking-code-val"><?php echo $first_ticket['booking_code']; ?></div>
        </div>
    </div>

    <?php elseif (!$code): ?>
    <div class="no-result">
        <i class="bi bi-search"></i>
        <h5>Ready to Fly?</h5>
        <p>Your booking code was sent to your email after purchase.</p>
    </div>
    <?php endif; ?>
</div>

</body>
</html>