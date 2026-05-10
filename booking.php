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
            --dark:#0d1117;--dark2:#161b27;--card-bg:#1c2333;
            --gold:#c9a84c;--gold2:#e8c96a;--text:#e8eaf0;
            --muted:#8892a4;--border:rgba(255,255,255,0.08);--green:#2ecc71;
        }
        *{box-sizing:border-box;margin:0;padding:0;}
        body{background:var(--dark);color:var(--text);font-family:'DM Sans',sans-serif;}

        .sidebar{position:fixed;top:0;left:0;width:72px;height:100vh;background:var(--dark2);border-right:1px solid var(--border);display:flex;flex-direction:column;align-items:center;padding:24px 0;z-index:100;}
        .sidebar-logo{color:var(--gold);font-size:24px;margin-bottom:36px;}
        .sidebar-nav{display:flex;flex-direction:column;gap:8px;width:100%;}
        .sidebar-item{display:flex;flex-direction:column;align-items:center;gap:4px;padding:12px 0;cursor:pointer;color:var(--muted);font-size:10px;transition:all .2s;text-decoration:none;border-left:3px solid transparent;}
        .sidebar-item i{font-size:20px;}
        .sidebar-item:hover,.sidebar-item.active{color:var(--text);background:rgba(255,255,255,.04);border-left-color:var(--gold);}

        .main{margin-left:72px;padding:40px;max-width:960px;}
        .page-title{font-size:28px;font-weight:600;margin-bottom:4px;}
        .page-sub{color:var(--muted);font-size:14px;margin-bottom:32px;}

        .booking-grid{display:grid;grid-template-columns:1fr 340px;gap:24px;}

        /* FORM */
        .form-card{background:var(--card-bg);border:1px solid var(--border);border-radius:16px;padding:28px;}
        .form-section-title{font-size:16px;font-weight:600;margin-bottom:16px;padding-bottom:12px;border-bottom:1px solid var(--border);}
        .form-label-custom{display:block;font-size:12px;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;}
        .form-control-custom{
            width:100%;background:var(--dark2);border:1px solid var(--border);
            color:var(--text);border-radius:10px;padding:12px 14px;
            font-size:14px;font-family:'DM Sans',sans-serif;outline:none;
            transition:border-color .2s;
        }
        .form-control-custom:focus{border-color:var(--gold);}
        .form-control-custom::placeholder{color:var(--muted);}
        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;}
        .form-group{margin-bottom:14px;}
        .passenger-header{display:flex;align-items:center;gap:8px;margin:20px 0 14px;color:var(--gold);font-size:14px;font-weight:600;}

        /* SUMMARY */
        .summary-card{background:var(--card-bg);border:1px solid var(--border);border-radius:16px;padding:24px;height:fit-content;}
        .sum-title{font-size:16px;font-weight:600;margin-bottom:16px;}
        .sum-route{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;padding-bottom:16px;border-bottom:1px solid var(--border);}
        .sum-code{font-size:24px;font-weight:700;}
        .sum-seat{display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid var(--border);font-size:14px;}
        .sum-seat-num{font-weight:600;}
        .sum-seat-class{font-size:12px;color:var(--muted);}
        .sum-seat-price{color:var(--gold);}
        .sum-total{display:flex;justify-content:space-between;align-items:center;padding-top:16px;margin-top:4px;font-size:18px;font-weight:700;color:var(--gold);}
        .sum-tax{display:flex;justify-content:space-between;font-size:13px;color:var(--muted);margin-top:8px;}

        .btn-confirm{width:100%;background:var(--gold);border:none;color:#000;border-radius:12px;padding:16px;font-size:16px;font-weight:700;cursor:pointer;transition:all .2s;font-family:'DM Sans',sans-serif;margin-top:16px;}
        .btn-confirm:hover{background:var(--gold2);transform:translateY(-2px);}

        /* STEPS */
        .steps{display:flex;align-items:center;gap:0;margin-bottom:32px;}
        .step{display:flex;align-items:center;gap:8px;font-size:13px;}
        .step-num{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:12px;}
        .step.done .step-num{background:var(--green);color:#000;}
        .step.active .step-num{background:var(--gold);color:#000;}
        .step.inactive .step-num{background:var(--card-bg);color:var(--muted);border:1px solid var(--border);}
        .step.active span{color:var(--text);font-weight:600;}
        .step.inactive span{color:var(--muted);}
        .step-line{flex:1;height:1px;background:var(--border);margin:0 12px;min-width:30px;}

        /* SUCCESS */
        .success-card{background:var(--card-bg);border:1px solid rgba(46,204,113,.3);border-radius:20px;padding:40px;text-align:center;max-width:600px;margin:0 auto;}
        .success-icon{font-size:64px;margin-bottom:20px;display:block;}
        .booking-code{background:var(--dark2);border:1px solid var(--border);border-radius:12px;padding:16px 24px;font-size:28px;font-weight:700;letter-spacing:4px;color:var(--gold);margin:20px 0;}
        .ticket-detail{display:flex;justify-content:space-between;font-size:14px;padding:10px 0;border-bottom:1px solid var(--border);}
        .ticket-detail .label{color:var(--muted);}
        .btn-back-home{display:inline-flex;align-items:center;gap:8px;background:var(--gold);color:#000;border:none;border-radius:12px;padding:12px 24px;font-weight:600;text-decoration:none;margin-top:24px;font-family:'DM Sans',sans-serif;}
    </style>
</head>
<body>

<?php
include_once('db_connect.php');

$flight_id  = intval($_GET['flight_id'] ?? $_POST['flight_id'] ?? 0);
$passengers = intval($_GET['passengers'] ?? $_POST['passengers'] ?? 1);
$seat_ids_raw = $_GET['seat_ids'] ?? $_POST['seat_ids'] ?? '';

// Sanitize seat IDs – only digits and commas
$seat_ids_raw = preg_replace('/[^0-9,]/', '', $seat_ids_raw);
$seat_ids = array_filter(array_map('intval', explode(',', $seat_ids_raw)));

if (!$flight_id || empty($seat_ids)) { header('Location: index.php'); exit; }

$step = intval($_POST['step'] ?? 1);
$success = false;
$booking_code = '';
$error_msg = '';

/* ── STEP 3: Final Insert ───────────────────────────────── */
if ($step == 3 && $_SERVER['REQUEST_METHOD'] === 'POST') {

    $names   = $_POST['pax_name'] ?? [];
    $emails  = $_POST['pax_email'] ?? [];
    $phones  = $_POST['pax_phone'] ?? [];
    $seat_ids_post = array_filter(array_map('intval', explode(',', $_POST['seat_ids'])));

    mysqli_begin_transaction($conn);
    $all_ok = true;

    foreach ($seat_ids_post as $idx => $sid) {
        // ── AVAILABILITY CHECK (prevent double-booking) ──
        $check = mysqli_fetch_assoc(mysqli_query($conn,
            "SELECT is_booked FROM seat WHERE id=$sid FOR UPDATE"));

        if (!$check || $check['is_booked']) {
            $all_ok = false;
            $error_msg = "Seat is no longer available. Please go back and choose another seat.";
            break;
        }

        $name  = mysqli_real_escape_string($conn, $names[$idx]  ?? $names[0]);
        $email = mysqli_real_escape_string($conn, $emails[$idx] ?? $emails[0]);
        $phone = mysqli_real_escape_string($conn, $phones[$idx] ?? $phones[0]);
        $code  = strtoupper(substr(md5(uniqid(rand(),true)), 0, 8));

        // Insert reservation
        $ins = mysqli_query($conn,
            "INSERT INTO reservation (seat_id, passenger_name, passenger_email, passenger_phone, booking_code)
             VALUES ($sid, '$name', '$email', '$phone', '$code')");

        if (!$ins) { $all_ok = false; break; }

        // Mark seat as booked
        mysqli_query($conn, "UPDATE seat SET is_booked=1 WHERE id=$sid");

        if ($idx === 0) $booking_code = $code;
    }

    if ($all_ok) {
        mysqli_commit($conn);
        $success = true;
    } else {
        mysqli_rollback($conn);
        if (!$error_msg) $error_msg = "Booking failed. Please try again.";
    }
}

/* ── LOAD DATA ────────────────────────────────────────────── */
$flight = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT f.*, a1.code AS origin_code, a1.city AS origin_city,
     a2.code AS dest_code, a2.city AS dest_city
     FROM flight f
     JOIN airport a1 ON f.origin_id=a1.id
     JOIN airport a2 ON f.destination_id=a2.id
     WHERE f.id=$flight_id"));

$seats_data = [];
foreach ($seat_ids as $sid) {
    $s = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM seat WHERE id=$sid"));
    if ($s) $seats_data[] = $s;
}

$subtotal = array_sum(array_column($seats_data, 'price'));
$tax      = round($subtotal * 0.1);
$total    = $subtotal + $tax;

$dep = new DateTime($flight['departure_time']);
$arr = new DateTime($flight['arrival_time']);

function fmt($n) { return 'IDR '.number_format($n); }
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

<?php if ($success): /* ─── SUCCESS ─── */ ?>

    <div class="success-card">
        <span class="success-icon">🎉</span>
        <h2 style="font-size:28px;margin-bottom:8px">Booking Confirmed!</h2>
        <p style="color:var(--muted);margin-bottom:8px">Your flight has been booked successfully.</p>
        <div class="booking-code"><?php echo $booking_code; ?></div>
        <p style="font-size:12px;color:var(--muted);margin-bottom:24px">Save this booking code to view your reservation</p>

        <div style="text-align:left">
            <div class="ticket-detail"><span class="label">Flight</span><span><?php echo $flight['flight_number'].' · '.$flight['airline']; ?></span></div>
            <div class="ticket-detail"><span class="label">Route</span><span><?php echo $flight['origin_code'].' → '.$flight['dest_code']; ?></span></div>
            <div class="ticket-detail"><span class="label">Departure</span><span><?php echo $dep->format('d M Y, H:i'); ?></span></div>
            <div class="ticket-detail"><span class="label">Seats</span><span><?php echo implode(', ', array_column($seats_data, 'seat_number')); ?></span></div>
            <div class="ticket-detail" style="border:none"><span class="label">Total Paid</span><span style="color:var(--gold);font-weight:700"><?php echo fmt($total); ?></span></div>
        </div>

        <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
            <a href="index.php" class="btn-back-home"><i class="bi bi-house"></i> Back to Home</a>
            <a href="my_booking.php?code=<?php echo $booking_code; ?>" class="btn-back-home" style="background:var(--card-bg);color:var(--text);border:1px solid var(--border)">
                <i class="bi bi-journal-bookmark"></i> View My Trips
            </a>
        </div>
    </div>

<?php else: /* ─── FORM ─── */ ?>

<?php if ($error_msg): ?>
<div style="background:rgba(231,76,60,.15);border:1px solid rgba(231,76,60,.3);border-radius:12px;padding:14px 18px;margin-bottom:20px;color:#e74c3c;">
    <i class="bi bi-exclamation-triangle"></i> <?php echo $error_msg; ?>
</div>
<?php endif; ?>

    <!-- STEPS -->
    <div class="steps">
        <div class="step done"><div class="step-num"><i class="bi bi-check"></i></div><span>Search</span></div>
        <div class="step-line"></div>
        <div class="step done"><div class="step-num"><i class="bi bi-check"></i></div><span>Seat Selection</span></div>
        <div class="step-line"></div>
        <div class="step active"><div class="step-num">3</div><span>Passenger Details</span></div>
        <div class="step-line"></div>
        <div class="step inactive"><div class="step-num">4</div><span>Confirm</span></div>
    </div>

    <div class="page-title">Passenger Details</div>
    <div class="page-sub">Fill in the details for <?php echo count($seats_data); ?> passenger<?php echo count($seats_data)>1?'s':''; ?></div>

    <div class="booking-grid">
        <!-- FORM -->
        <div>
            <form method="POST">
                <input type="hidden" name="step" value="3">
                <input type="hidden" name="flight_id" value="<?php echo $flight_id; ?>">
                <input type="hidden" name="passengers" value="<?php echo $passengers; ?>">
                <input type="hidden" name="seat_ids" value="<?php echo implode(',', array_column($seats_data,'id')); ?>">

                <?php foreach ($seats_data as $i => $seat): ?>
                <div class="form-card" style="margin-bottom:16px">
                    <div class="form-section-title">
                        <i class="bi bi-person-circle" style="color:var(--gold)"></i>
                        Passenger <?php echo $i+1; ?> – Seat <?php echo $seat['seat_number']; ?>
                        <span style="font-size:12px;color:var(--muted);font-weight:400">(<?php echo $seat['class']; ?>)</span>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label-custom">Full Name</label>
                            <input type="text" name="pax_name[]" class="form-control-custom" placeholder="John Doe" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label-custom">Phone Number</label>
                            <input type="tel" name="pax_phone[]" class="form-control-custom" placeholder="+62 812 3456 7890" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label-custom">Email Address</label>
                        <input type="email" name="pax_email[]" class="form-control-custom" placeholder="john@example.com" required>
                    </div>
                </div>
                <?php endforeach; ?>

                <button type="submit" class="btn-confirm">
                    Confirm Booking &nbsp;<i class="bi bi-shield-check"></i>
                </button>
            </form>
        </div>

        <!-- SUMMARY -->
        <aside>
            <div class="summary-card">
                <div class="sum-title">Booking Summary</div>

                <div class="sum-route">
                    <div>
                        <div class="sum-code"><?php echo $flight['origin_code']; ?></div>
                        <div style="font-size:12px;color:var(--muted)"><?php echo $flight['origin_city']; ?></div>
                    </div>
                    <div style="color:var(--gold)"><i class="bi bi-airplane-fill"></i></div>
                    <div style="text-align:right">
                        <div class="sum-code"><?php echo $flight['dest_code']; ?></div>
                        <div style="font-size:12px;color:var(--muted)"><?php echo $flight['dest_city']; ?></div>
                    </div>
                </div>

                <div style="font-size:13px;color:var(--muted);margin-bottom:16px">
                    <?php echo $flight['airline'].' · '.$flight['flight_number']; ?><br>
                    <?php echo $dep->format('d M Y, H:i'); ?>
                </div>

                <?php foreach ($seats_data as $seat): ?>
                <div class="sum-seat">
                    <div>
                        <div class="sum-seat-num">Seat <?php echo $seat['seat_number']; ?></div>
                        <div class="sum-seat-class"><?php echo $seat['class']; ?></div>
                    </div>
                    <div class="sum-seat-price"><?php echo fmt($seat['price']); ?></div>
                </div>
                <?php endforeach; ?>

                <div class="sum-tax"><span>Tax & Fee (10%)</span><span><?php echo fmt($tax); ?></span></div>
                <div class="sum-total"><span>Total</span><span><?php echo fmt($total); ?></span></div>
            </div>
        </aside>
    </div>

<?php endif; ?>
</div>

</body>
</html>
