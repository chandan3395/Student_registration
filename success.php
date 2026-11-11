<?php
declare(strict_types=1);
session_start();
$data = $_SESSION['registration'] ?? null;
$id = $_SESSION['registration_id'] ?? '';
if (!is_array($data)) { header('Location: index.php', true, 303); exit; }
function h(string $value): string { return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
$labels = ['full_name'=>'Full Name','email'=>'Email Address','phone'=>'Phone Number','dob'=>'Date of Birth','gender'=>'Gender','college'=>'College Name','course'=>'Course / Branch','year'=>'Year of Study','address'=>'Address','city'=>'City','state'=>'State','pincode'=>'Pincode'];
$dob = DateTime::createFromFormat('!Y-m-d', $data['dob']);
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Registration Successful | Campus Connect</title><link rel="stylesheet" href="style.css"></head>
<body>
<header class="site-header"><a class="brand" href="index.php"><span class="brand-mark">CC</span><span>Campus Connect<small>STUDENT SERVICES</small></span></a><span class="header-note">Registration Confirmation</span></header>
<main class="page-wrap success-wrap">
  <section class="success-banner"><div class="success-icon" aria-hidden="true">✓</div><div class="eyebrow">APPLICATION RECEIVED</div><h1>Registration Submitted Successfully!</h1><p>Thank you, <?= h($data['full_name']) ?>. Your student registration has been recorded for this session.</p><div class="registration-id">Registration ID <strong><?= h($id) ?></strong></div></section>
  <section class="details-card"><div class="details-heading"><div><div class="eyebrow">YOUR SUBMISSION</div><h2>Registration Details</h2></div><span class="status-pill">Submitted</span></div>
    <div class="details-grid">
      <?php foreach ($labels as $key=>$label): ?><div class="detail-item <?= $key === 'address' ? 'detail-wide' : '' ?>"><span><?= h($label) ?></span><strong><?= h($key === 'dob' && $dob ? $dob->format('d M Y') : $data[$key]) ?></strong></div><?php endforeach; ?>
    </div>
    <div class="success-actions"><a class="btn btn-primary" href="download.php">Download PDF <span aria-hidden="true">↓</span></a><a class="btn btn-secondary" href="index.php">New Registration</a></div>
  </section>
  <p class="privacy-note">Keep your registration ID for future reference. This demo stores the submission in the current PHP session only.</p>
</main>
<footer class="site-footer">© 2026 Campus Connect <span>Student Registration Portal</span></footer>
</body></html>
