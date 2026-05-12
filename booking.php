<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking – SkyWings</title>
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

        .main { margin-left: 72px; padding: 40px; max-width: 1100px; }
        
        /* ── STEPS ── */
        .steps { display:flex; align-items:center; margin-bottom:40px; background: var(--card-bg); padding: 20px; border-radius: 16px; border: 1px solid var(--border); box-shadow: var(--shadow); }
        .step { display:flex; align-items:center; gap:12px; }
        .step-num { width:32px; height:32px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:14px; background: var(--bg2); border: 1.5px solid var(--border); color: var(--muted); }
        .step.done .step-num { background: var(--green); color: #fff; border-color: var(--green); }
        .step.active .step-num { background: var(--sky); color: #fff; border-color: var(--sky); }
        .step span { font-size: 14px; font-weight: 600; color: var(--muted); }
        .step.active span { color: var(--text); }
        .step-line { flex:1; height:1px; background: var(--border); margin: 0 20px; }

        .page-title { font-size: 28px; font-weight: 700; margin-bottom: 4px; color: var(--text); }
        .page-sub { color: var(--muted); font-size: 14px; margin-bottom: 32px; }

        .booking-grid { display: grid; grid-template-columns: 1fr 380px; gap: 32px; }

        /* ── FORMS ── */
        .form-card { background: var(--card-bg); border: 1px solid var(--border); border-radius: 20px; padding: 32px; margin-bottom: 24px; box-shadow: var(--shadow); }
        .form-section-title { font-size: 18px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; color: var(--text); }
        .form-label-custom { display: block; font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.8px; font-weight: 700; margin-bottom: 8px; }
        .form-control-custom { width: 100%; background: var(--bg); border: 1.5px solid var(--border); border-radius: 12px; padding: 12px 16px; font-size: 15px; color: var(--text); transition: all 0.2s; outline: none; }
        .form-control-custom:focus { border-color: var(--sky); box-shadow: 0 0 0 4px rgba(37,99,235,0.1); }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .form-group { margin-bottom: 20px; }

        /* ── SUMMARY ── */
        .summary-card { background: var(--card-bg); border: 1px solid var(--border); border-radius: 20px; padding: 24px; box-shadow: var(--shadow); margin-bottom: 20px; }
        .sum-title { font-size: 14px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px; }
        .sum-route { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .sum-code { font-size: 24px; font-weight: 800; color: var(--text); }
        .sum-seat { display: flex; justify-content: space-between; padding: 12px 0; border-top: 1px dashed var(--border); }
        .sum-seat-num { font-weight: 700; font-size: 15px; }
        .sum-seat-class { font-size: 12px; color: var(--muted); }
        .sum-seat-price { font-weight: 700; color: var(--gold); }
        
        .total-box { background: var(--sidebar-bg); border-radius: 16px; padding: 24px; color: #fff; }
        .sum-tax { display: flex; justify-content: space-between; font-size: 14px; color: rgba(255,255,255,0.6); margin-bottom: 10px; }
        .sum-total { display: flex; justify-content: space-between; font-size: 20px; font-weight: 800; color: var(--gold2); border-top: 1px solid rgba(255,255,255,0.1); pt: 15px; margin-top: 10px; padding-top: 15px; }

        .btn-confirm { width: 100%; background: linear-gradient(135deg, var(--sky) 0%, var(--sky2) 100%); border: none; color: #fff; border-radius: 16px; padding: 18px; font-size: 16px; font-weight: 700; cursor: pointer; transition: all 0.3s; box-shadow: 0 8px 24px rgba(37,99,235,0.25); }
        .btn-confirm:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(37,99,235,0.35); }

        /* ── SUCCESS ── */
        .success-card { background: var(--card-bg); border: 1px solid var(--border); border-radius: 32px; padding: 60px 40px; text-align: center; max-width: 600px; margin: 40px auto; box-shadow: var(--shadow); }
        .success-icon { width: 80px; height: 80px; background: #ecfdf5; color: var(--green); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 40px; margin: 0 auto 24px; }
        .booking-code { background: var(--gold-light); border: 2px dashed var(--gold2); border-radius: 16px; padding: 20px; font-size: 32px; font-weight: 800; letter-spacing: 4px; color: var(--gold); margin: 24px 0; }
        .btn-back-home { display: inline-flex; align-items: center; gap: 8px; background: var(--sidebar-bg); color: #fff; padding: 14px 28px; border-radius: 12px; text-decoration: none; font-weight: 600; transition: 0.2s; }
        .btn-back-home:hover { background: var(--sidebar-active); color: #fff; }
    </style>
</head>
<body>

<?php
include_once('db_connect.php');

$trip_type  = $_GET['trip_type'] ?? $_POST['trip_type'] ?? 'oneway';
$passengers = intval($_GET['passengers'] ?? $_POST['passengers'] ?? 1);
$step       = intval($_POST['step'] ?? 1);
$success    = false;
$booking_code = '';
$error_msg  = '';

$legs = [];
if ($trip_type == 'roundtrip') {
    $legs[] = [
        'schedule_id' => intval($_GET['outbound_id'] ?? $_POST['outbound_id'] ?? 0),
        'seat_nums'   => array_filter(explode(',', preg_replace('/[^0-9A-Z,]/', '', strtoupper($_GET['outbound_seats'] ?? $_POST['outbound_seats'] ?? '')))),
        'label'       => 'Outbound'
    ];
    $legs[] = [
        'schedule_id' => intval($_GET['return_id'] ?? $_POST['return_id'] ?? 0),
        'seat_nums'   => array_filter(explode(',', preg_replace('/[^0-9A-Z,]/', '', strtoupper($_GET['return_seats'] ?? $_POST['return_seats'] ?? '')))),
        'label'       => 'Return'
    ];
} else {
    $legs[] = [
        'schedule_id' => intval($_GET['schedule_id'] ?? $_POST['schedule_id'] ?? 0),
        'seat_nums'   => array_filter(explode(',', preg_replace('/[^0-9A-Z,]/', '', strtoupper($_GET['seat_numbers'] ?? $_POST['seat_numbers'] ?? '')))),
        'label'       => 'Flight'
    ];
}

if (empty($legs[0]['schedule_id']) || empty($legs[0]['seat_nums'])) { header('Location: index.php'); exit; }

$grand_subtotal = 0;

foreach ($legs as &$leg) {
    $s_id = $leg['schedule_id'];
    
    $q_flight = mysqli_query($conn, 
        "SELECT fs.*, fr.flight_number, al.name AS airline_name, a1.code AS origin_code, a1.city AS origin_city, 
         a2.code AS dest_code, a2.city AS dest_city, ac.model_name AS aircraft_name 
         FROM flight_schedule fs 
         JOIN flight_route fr ON fs.flight_route_id = fr.id 
         JOIN airline al ON fr.airline_id = al.id 
         JOIN airport a1 ON fr.origin_id = a1.id 
         JOIN airport a2 ON fr.destination_id = a2.id 
         JOIN aircraft ac ON fs.aircraft_id = ac.id 
         WHERE fs.id = $s_id");
    $leg['flight'] = mysqli_fetch_assoc($q_flight);

    $q_price = mysqli_query($conn, "SELECT travel_class, price FROM flight_pricing WHERE flight_schedule_id = $s_id");
    $prices = [];
    while($p = mysqli_fetch_assoc($q_price)) $prices[$p['travel_class']] = $p['price'];

    $dep_time = new DateTime($leg['flight']['departure_time']);
    $is_weekend = in_array($dep_time->format('N'), [6, 7]);
    $multiplier = $is_weekend ? 1.2 : 1.0;

    $seat_list = "'" . implode("','", $leg['seat_nums']) . "'";
    $aircraft_id = $leg['flight']['aircraft_id'];
    $q_seats = mysqli_query($conn, "SELECT seat_number, travel_class FROM aircraft_seat WHERE aircraft_id = $aircraft_id AND seat_number IN ($seat_list)");
    
    $leg['seats_data'] = [];
    while($s = mysqli_fetch_assoc($q_seats)){
        $s['price'] = ($prices[$s['travel_class']] ?? 0) * $multiplier;
        $leg['seats_data'][] = $s;
        $grand_subtotal += $s['price'];
    }
}
unset($leg);

$grand_tax   = round($grand_subtotal * 0.1);
$grand_total = $grand_subtotal + $grand_tax;

if ($step == 3 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $names   = $_POST['pax_name'] ?? [];
    $emails  = $_POST['pax_email'] ?? [];
    $phones  = $_POST['pax_phone'] ?? [];

    mysqli_begin_transaction($conn);
    $all_ok = true;

    $code = strtoupper(substr(md5(uniqid(rand(),true)), 0, 8));
    $email_main = mysqli_real_escape_string($conn, $emails[0]);
    $phone_main = mysqli_real_escape_string($conn, $phones[0]);
    
    $ins_b = mysqli_query($conn, "INSERT INTO booking (booking_code, contact_email, contact_phone, total_amount) VALUES ('$code', '$email_main', '$phone_main', $grand_total)");
    
    if (!$ins_b) {
        $all_ok = false;
    } else {
        $booking_id = mysqli_insert_id($conn);
        foreach ($legs as $leg) {
            foreach ($leg['seats_data'] as $idx => $seat) {
                $snum = $seat['seat_number'];
                $sclass = $seat['travel_class'];
                $sid = $leg['schedule_id'];
                
                $check = mysqli_query($conn, "SELECT id FROM ticket WHERE flight_schedule_id=$sid AND seat_number='$snum' FOR UPDATE");
                if(mysqli_num_rows($check) > 0) {
                    $all_ok = false;
                    $error_msg = "Seat $snum on the " . $leg['label'] . " flight has just been taken by someone else!";
                    break 2;
                }

                $name = mysqli_real_escape_string($conn, $names[$idx] ?? $names[0]);
                $ins_t = mysqli_query($conn, "INSERT INTO ticket (booking_id, flight_schedule_id, passenger_name, travel_class, seat_number) VALUES ($booking_id, $sid, '$name', '$sclass', '$snum')");
                if(!$ins_t) $all_ok = false;
            }
        }
    }

    if ($all_ok) { mysqli_commit($conn); $success = true; $booking_code = $code; } 
    else { mysqli_rollback($conn); if (!$error_msg) $error_msg = "Booking failed."; }
}

function fmt($n) { return 'IDR '.number_format($n); }
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

<?php if ($success): ?>
    <div class="success-card">
        <div class="success-icon"><i class="bi bi-check-lg"></i></div>
        <h2 class="page-title" style="margin-bottom:12px">Booking Confirmed!</h2>
        <p class="page-sub">Your tickets have been issued. Pack your bags!</p>
        
        <div class="booking-code"><?php echo $booking_code; ?></div>
        
        <div style="text-align:left; background:var(--bg); padding:20px; border-radius:16px; margin-bottom:32px;">
            <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                <span style="color:var(--muted)">Trip Type</span>
                <span style="font-weight:700"><?php echo ucfirst($trip_type); ?></span>
            </div>
            <div style="display:flex; justify-content:space-between;">
                <span style="color:var(--muted)">Total Paid</span>
                <span style="font-weight:800; color:var(--sky)"><?php echo fmt($grand_total); ?></span>
            </div>
        </div>

        <div style="display:flex; gap:16px; justify-content:center;">
            <a href="index.php" class="btn-back-home">Go to Home</a>
            <a href="my_booking.php?code=<?php echo $booking_code; ?>" class="btn-back-home" style="background:var(--bg2); color:var(--text);">View Ticket</a>
        </div>
    </div>

<?php else: ?>

    <?php if ($error_msg): ?>
    <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius:12px">
        <i class="bi bi-exclamation-circle-fill me-2"></i> <?php echo $error_msg; ?>
    </div>
    <?php endif; ?>

    <div class="steps">
        <div class="step done"><div class="step-num"><i class="bi bi-check"></i></div><span>Search</span></div>
        <div class="step-line"></div>
        <div class="step done"><div class="step-num"><i class="bi bi-check"></i></div><span>Seats</span></div>
        <div class="step-line"></div>
        <div class="step active"><div class="step-num">3</div><span>Details</span></div>
        <div class="step-line"></div>
        <div class="step"><div class="step-num">4</div><span>Finish</span></div>
    </div>

    <div class="page-title">Passenger Details</div>
    <div class="page-sub">Almost there! Please provide the travelers' information.</div>

    <div class="booking-grid">
        <div>
            <form method="POST">
                <input type="hidden" name="step" value="3">
                <input type="hidden" name="trip_type" value="<?php echo $trip_type; ?>">
                <input type="hidden" name="passengers" value="<?php echo $passengers; ?>">
                
                <?php if ($trip_type == 'roundtrip'): ?>
                    <input type="hidden" name="outbound_id" value="<?php echo $legs[0]['schedule_id']; ?>">
                    <input type="hidden" name="return_id" value="<?php echo $legs[1]['schedule_id']; ?>">
                    <input type="hidden" name="outbound_seats" value="<?php echo implode(',', array_column($legs[0]['seats_data'],'seat_number')); ?>">
                    <input type="hidden" name="return_seats" value="<?php echo implode(',', array_column($legs[1]['seats_data'],'seat_number')); ?>">
                <?php else: ?>
                    <input type="hidden" name="schedule_id" value="<?php echo $legs[0]['schedule_id']; ?>">
                    <input type="hidden" name="seat_numbers" value="<?php echo implode(',', array_column($legs[0]['seats_data'],'seat_number')); ?>">
                <?php endif; ?>

                <?php for ($i = 0; $i < $passengers; $i++): ?>
                <div class="form-card">
                    <div class="form-section-title">
                        <i class="bi bi-person-fill" style="color:var(--sky)"></i>
                        Passenger <?php echo $i+1; ?>
                        <span style="font-size:12px; font-weight:500; color:var(--muted); margin-left:auto;">
                            Seats: <?php foreach($legs as $l) echo $l['seats_data'][$i]['seat_number'] . ' '; ?>
                        </span>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label-custom">Full Name</label>
                            <input type="text" name="pax_name[]" class="form-control-custom" placeholder="As per ID/Passport" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label-custom">Phone Number</label>
                            <input type="tel" name="pax_phone[]" class="form-control-custom" placeholder="+62 812..." required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label-custom">Email Address</label>
                        <input type="email" name="pax_email[]" class="form-control-custom" placeholder="email@example.com" required>
                    </div>
                </div>
                <?php endfor; ?>

                <button type="submit" class="btn-confirm">Complete Booking & Issue Tickets</button>
            </form>
        </div>

        <aside>
            <?php foreach ($legs as $leg): $dep = new DateTime($leg['flight']['departure_time']); ?>
            <div class="summary-card">
                <div class="sum-title"><?php echo $leg['label']; ?> Flight</div>
                <div class="sum-route">
                    <div class="sum-code"><?php echo $leg['flight']['origin_code']; ?></div>
                    <i class="bi bi-airplane-fill" style="color:var(--sky); opacity:0.3"></i>
                    <div class="sum-code"><?php echo $leg['flight']['dest_code']; ?></div>
                </div>
                <div style="font-size:13px; margin-bottom:20px;">
                    <div style="font-weight:700"><?php echo $leg['flight']['airline_name']; ?></div>
                    <div style="color:var(--muted)"><?php echo $dep->format('d M Y, H:i'); ?></div>
                </div>

                <?php foreach ($leg['seats_data'] as $seat): ?>
                <div class="sum-seat">
                    <div>
                        <div class="sum-seat-num">Seat <?php echo $seat['seat_number']; ?></div>
                        <div class="sum-seat-class"><?php echo $seat['travel_class']; ?></div>
                    </div>
                    <div class="sum-seat-price"><?php echo fmt($seat['price']); ?></div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endforeach; ?>

            <div class="total-box">
                <div class="sum-tax"><span>Taxes & Fees (10%)</span><span><?php echo fmt($grand_tax); ?></span></div>
                <div class="sum-total"><span>Total Amount</span><span><?php echo fmt($grand_total); ?></span></div>
            </div>
        </aside>
    </div>
<?php endif; ?>
</div>
</body>
</html>