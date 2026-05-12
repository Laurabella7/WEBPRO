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
        :root{--dark:#0d1117;--dark2:#161b27;--card-bg:#1c2333;--gold:#c9a84c;--gold2:#e8c96a;--text:#e8eaf0;--muted:#8892a4;--border:rgba(255,255,255,0.08);--green:#2ecc71;}
        *{box-sizing:border-box;margin:0;padding:0;}
        body{background:var(--dark);color:var(--text);font-family:'DM Sans',sans-serif;}
        .sidebar{position:fixed;top:0;left:0;width:72px;height:100vh;background:var(--dark2);border-right:1px solid var(--border);display:flex;flex-direction:column;align-items:center;padding:24px 0;z-index:100;}
        .sidebar-logo{color:var(--gold);font-size:24px;margin-bottom:36px;}
        .sidebar-nav{display:flex;flex-direction:column;gap:8px;width:100%;}
        .sidebar-item{display:flex;flex-direction:column;align-items:center;gap:4px;padding:12px 0;cursor:pointer;color:var(--muted);font-size:10px;transition:all .2s;text-decoration:none;border-left:3px solid transparent;}
        .sidebar-item i{font-size:20px;}
        .sidebar-item:hover,.sidebar-item.active{color:var(--text);background:rgba(255,255,255,.04);border-left-color:var(--gold);}
        .main{margin-left:72px;padding:40px;max-width:800px;}
        .page-title{font-size:28px;font-weight:600;margin-bottom:4px;}
        .page-sub{color:var(--muted);font-size:14px;margin-bottom:32px;}
        .search-box{display:flex;gap:12px;margin-bottom:32px;}
        .code-input{flex:1;background:var(--card-bg);border:1px solid var(--border);color:var(--text);border-radius:12px;padding:14px 18px;font-size:16px;font-family:'DM Sans',sans-serif;outline:none;transition:border-color .2s;letter-spacing:2px;text-transform:uppercase;}
        .code-input:focus{border-color:var(--gold);}
        .code-input::placeholder{letter-spacing:0;text-transform:none;color:var(--muted);}
        .btn-find{background:var(--gold);border:none;color:#000;border-radius:12px;padding:14px 24px;font-weight:700;font-size:15px;cursor:pointer;font-family:'DM Sans',sans-serif;transition:all .2s;}
        .btn-find:hover{background:var(--gold2);}
        .ticket-card{background:var(--card-bg);border:1px solid var(--border);border-radius:20px;overflow:hidden;margin-bottom:16px;}
        .ticket-header{background:linear-gradient(135deg,rgba(201,168,76,.15),rgba(79,142,247,.1));padding:24px;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;}
        .ticket-route{font-size:28px;font-weight:700;}
        .ticket-airline{font-size:13px;color:var(--muted);margin-top:4px;}
        .ticket-status{background:rgba(46,204,113,.15);border:1px solid rgba(46,204,113,.3);color:var(--green);padding:6px 14px;border-radius:20px;font-size:12px;font-weight:600;}
        .ticket-body{padding:24px;}
        .ticket-row{display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--border);font-size:14px;}
        .ticket-row:last-child{border:none;}
        .ticket-label{color:var(--muted);}
        .ticket-value{font-weight:500;}
        .booking-code-display{background:var(--dark2);border-radius:10px;padding:12px 20px;font-size:20px;font-weight:700;letter-spacing:3px;color:var(--gold);text-align:center;margin-top:16px;}
        .no-result{text-align:center;padding:60px;color:var(--muted);}
        .no-result i{font-size:48px;display:block;margin-bottom:16px;}
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
    
    // IN (1, 7) corresponds to Sunday and Saturday in MySQL's DAYOFWEEK function
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
    <div class="page-sub">Enter your booking code to retrieve your reservation</div>

    <form method="GET" class="search-box">
        <input type="text" name="code" class="code-input" placeholder="Enter booking code (e.g. A1B2C3D4)" value="<?php echo htmlspecialchars($code); ?>" maxlength="8">
        <button type="submit" class="btn-find"><i class="bi bi-search"></i> Find</button>
    </form>

    <?php if ($code && empty($reservations)): ?>
    <div class="no-result">
        <i class="bi bi-ticket-perforated"></i>
        No reservation found for code <strong><?php echo htmlspecialchars($code); ?></strong>.<br>
        Double-check the code and try again.
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
                <div class="ticket-route"><?php echo $r['origin_code'].' → '.$r['dest_code']; ?></div>
                <div class="ticket-airline"><?php echo $r['airline_name'].' · '.$r['flight_number']; ?></div>
            </div>
            <span class="ticket-status"><i class="bi bi-check-circle"></i> Confirmed</span>
        </div>
        <div class="ticket-body">
            <div class="ticket-row"><span class="ticket-label">Passenger</span><span class="ticket-value"><?php echo htmlspecialchars($r['passenger_name']); ?></span></div>
            <div class="ticket-row"><span class="ticket-label">Contact Email</span><span class="ticket-value"><?php echo htmlspecialchars($r['contact_email']); ?></span></div>
            <div class="ticket-row"><span class="ticket-label">Seat</span><span class="ticket-value"><?php echo $r['seat_number'].' ('.$r['travel_class'].')'; ?></span></div>
            <div class="ticket-row"><span class="ticket-label">Departure</span><span class="ticket-value"><?php echo $dep->format('d M Y, H:i'); ?></span></div>
            <div class="ticket-row"><span class="ticket-label">Arrival</span><span class="ticket-value"><?php echo $arr->format('d M Y, H:i'); ?></span></div>
            <div class="ticket-row"><span class="ticket-label">Duration</span><span class="ticket-value"><?php echo $dur_str; ?></span></div>
            <div class="ticket-row"><span class="ticket-label">Seat Price</span><span class="ticket-value">IDR <?php echo number_format($r['seat_price']); ?></span></div>
            <div class="ticket-row"><span class="ticket-label">Booked At</span><span class="ticket-value"><?php echo (new DateTime($r['booked_at']))->format('d M Y, H:i'); ?></span></div>
        </div>
    </div>
    <?php endforeach; ?>

    <div class="ticket-card" style="padding:24px;">
        <div class="ticket-row" style="font-size:18px;font-weight:700;border:none;">
            <span style="color:var(--gold)">Master Booking Total (All Passengers)</span>
            <span style="color:var(--gold)">IDR <?php echo number_format($master_total); ?></span>
        </div>
        <div class="booking-code-display"><?php echo $first_ticket['booking_code']; ?></div>
    </div>

    <?php elseif (!$code): ?>
    <div class="no-result">
        <i class="bi bi-ticket-perforated"></i>
        Enter your booking code above to view your reservation details.
    </div>
    <?php endif; ?>
</div>

</body>
</html>