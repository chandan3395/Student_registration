<?php
declare(strict_types=1);
session_start();
$old = $_SESSION['old'] ?? [];
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['old'], $_SESSION['errors']);
function h(string $value): string { return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Student registration form">
  <title>Student Registration | Campus Connect</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="script.js" defer></script>
</head>
<body>
<header class="site-header">
  <a class="brand" href="index.php"><span class="brand-mark">CC</span><span>Campus Connect<small>STUDENT SERVICES</small></span></a>
  <span class="header-note">Student Registration Portal</span>
</header>
<main class="page-wrap">
  <section class="intro">
    <div class="eyebrow">ACADEMIC YEAR 2026–27</div>
    <h1>Student Registration</h1>
    <p>Complete the form below to submit your student application. Fields marked <span class="required">*</span> are required.</p>
  </section>
  <?php if ($errors): ?>
    <div class="alert alert-error" role="alert">
      <strong>Please correct the following:</strong>
      <ul><?php foreach ($errors as $error): ?><li><?= h($error) ?></li><?php endforeach; ?></ul>
    </div>
  <?php endif; ?>
  <form id="registrationForm" class="form-card" action="process.php" method="post" novalidate>
    <div class="section-heading"><span class="section-number">01</span><div><h2>Personal information</h2><p>Tell us a little about yourself.</p></div></div>
    <div class="form-grid">
      <div class="field field-full"><label for="full_name">Full Name <span class="required">*</span></label><input id="full_name" name="full_name" type="text" maxlength="80" autocomplete="name" required value="<?= h((string)($old['full_name'] ?? '')) ?>" placeholder="Enter your full name"><small class="field-error"></small></div>
      <div class="field"><label for="email">Email Address <span class="required">*</span></label><input id="email" name="email" type="email" maxlength="120" autocomplete="email" required value="<?= h((string)($old['email'] ?? '')) ?>" placeholder="you@example.com"><small class="field-error"></small></div>
      <div class="field"><label for="phone">Phone Number <span class="required">*</span></label><input id="phone" name="phone" type="tel" inputmode="numeric" maxlength="10" autocomplete="tel" required value="<?= h((string)($old['phone'] ?? '')) ?>" placeholder="10-digit mobile number"><small class="field-error"></small></div>
      <div class="field"><label for="dob">Date of Birth <span class="required">*</span></label><input id="dob" name="dob" type="date" required value="<?= h((string)($old['dob'] ?? '')) ?>"><small class="field-error"></small></div>
      <div class="field"><label for="gender">Gender <span class="required">*</span></label><select id="gender" name="gender" required><option value="">Select gender</option><?php foreach (['Female','Male','Non-binary','Prefer not to say','Other'] as $v): ?><option value="<?= h($v) ?>" <?= (($old['gender'] ?? '') === $v) ? 'selected' : '' ?>><?= h($v) ?></option><?php endforeach; ?></select><small class="field-error"></small></div>
    </div>
    <div class="section-heading section-spaced"><span class="section-number">02</span><div><h2>Academic information</h2><p>Share your current college and course details.</p></div></div>
    <div class="form-grid">
      <div class="field field-full"><label for="college">College Name <span class="required">*</span></label><input id="college" name="college" type="text" maxlength="120" required value="<?= h((string)($old['college'] ?? '')) ?>" placeholder="Enter your college name"><small class="field-error"></small></div>
      <div class="field"><label for="course">Course / Branch <span class="required">*</span></label><input id="course" name="course" type="text" maxlength="100" required value="<?= h((string)($old['course'] ?? '')) ?>" placeholder="e.g. B.E. Computer Science"><small class="field-error"></small></div>
      <div class="field"><label for="year">Year of Study <span class="required">*</span></label><select id="year" name="year" required><option value="">Select year</option><?php foreach (['1st Year','2nd Year','3rd Year','4th Year','5th Year'] as $v): ?><option value="<?= h($v) ?>" <?= (($old['year'] ?? '') === $v) ? 'selected' : '' ?>><?= h($v) ?></option><?php endforeach; ?></select><small class="field-error"></small></div>
    </div>
    <div class="section-heading section-spaced"><span class="section-number">03</span><div><h2>Contact information</h2><p>Where can we reach you?</p></div></div>
    <div class="form-grid">
      <div class="field field-full"><label for="address">Address <span class="required">*</span></label><textarea id="address" name="address" rows="3" maxlength="250" required placeholder="House / street / area"><?= h((string)($old['address'] ?? '')) ?></textarea><small class="field-error"></small></div>
      <div class="field"><label for="city">City <span class="required">*</span></label><input id="city" name="city" type="text" maxlength="60" required value="<?= h((string)($old['city'] ?? '')) ?>" placeholder="City"><small class="field-error"></small></div>
      <div class="field"><label for="state">State <span class="required">*</span></label><select id="state" name="state" required><option value="">Select state / UT</option><?php
      $states = ['Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh','Goa','Gujarat','Haryana','Himachal Pradesh','Jharkhand','Karnataka','Kerala','Madhya Pradesh','Maharashtra','Manipur','Meghalaya','Mizoram','Nagaland','Odisha','Punjab','Rajasthan','Sikkim','Tamil Nadu','Telangana','Tripura','Uttar Pradesh','Uttarakhand','West Bengal','Andaman and Nicobar Islands','Chandigarh','Dadra and Nagar Haveli and Daman and Diu','Delhi','Jammu and Kashmir','Ladakh','Lakshadweep','Puducherry'];
      foreach ($states as $v): ?><option value="<?= h($v) ?>" <?= (($old['state'] ?? '') === $v) ? 'selected' : '' ?>><?= h($v) ?></option><?php endforeach; ?></select><small class="field-error"></small></div>
      <div class="field"><label for="pincode">Pincode <span class="required">*</span></label><input id="pincode" name="pincode" type="text" inputmode="numeric" maxlength="6" required value="<?= h((string)($old['pincode'] ?? '')) ?>" placeholder="6-digit pincode"><small class="field-error"></small></div>
    </div>
    <div class="form-footer"><p><span class="required">*</span> All fields are mandatory. Please review your details before submitting.</p><button class="btn btn-primary" type="submit">Submit Registration <span aria-hidden="true">→</span></button></div>
  </form>
  <p class="privacy-note">Your information is used only for this demonstration registration workflow.</p>
</main>
<footer class="site-footer">© 2026 Campus Connect <span>Student Registration Portal</span></footer>
</body>
</html>
