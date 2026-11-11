<?php
declare(strict_types=1);
session_start();

function strLength(string $value): int {
    return preg_match_all('/./us', $value, $matches) ?: 0;
}
function fail(array $errors, array $data): never {
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $data;
    header('Location: index.php', true, 303);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php', true, 303);
    exit;
}
$fields = ['full_name','email','phone','dob','gender','college','course','year','address','city','state','pincode'];
$data = [];
foreach ($fields as $field) $data[$field] = trim((string)($_POST[$field] ?? ''));
$errors = [];
$requiredLabels = ['full_name'=>'Full Name','email'=>'Email Address','phone'=>'Phone Number','dob'=>'Date of Birth','gender'=>'Gender','college'=>'College Name','course'=>'Course / Branch','year'=>'Year of Study','address'=>'Address','city'=>'City','state'=>'State','pincode'=>'Pincode'];
foreach ($requiredLabels as $key=>$label) if ($data[$key] === '') $errors[] = $label . ' is required.';
if ($data['full_name'] !== '' && (strLength($data['full_name']) > 80 || !preg_match("/^[\\p{L}\\p{M} .'-]+$/u", $data['full_name']))) $errors[] = 'Full Name may contain letters, spaces, apostrophes, periods and hyphens only (maximum 80 characters).';
if ($data['email'] !== '' && (!filter_var($data['email'], FILTER_VALIDATE_EMAIL) || strlen($data['email']) > 120)) $errors[] = 'Enter a valid email address (maximum 120 characters).';
if ($data['phone'] !== '' && !preg_match('/^[6-9][0-9]{9}$/', $data['phone'])) $errors[] = 'Enter a valid 10-digit Indian mobile number starting with 6, 7, 8 or 9.';
if ($data['dob'] !== '') {
    $date = DateTime::createFromFormat('!Y-m-d', $data['dob']);
    $dateErrors = DateTime::getLastErrors();
    if (!$date || ($dateErrors !== false && ($dateErrors['warning_count'] > 0 || $dateErrors['error_count'] > 0)) || $date->format('Y-m-d') !== $data['dob'] || $date >= new DateTime('today')) $errors[] = 'Enter a valid date of birth in the past.';
}
$allowedGender = ['Female','Male','Non-binary','Prefer not to say','Other'];
$allowedYears = ['1st Year','2nd Year','3rd Year','4th Year','5th Year'];
$allowedStates = ['Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh','Goa','Gujarat','Haryana','Himachal Pradesh','Jharkhand','Karnataka','Kerala','Madhya Pradesh','Maharashtra','Manipur','Meghalaya','Mizoram','Nagaland','Odisha','Punjab','Rajasthan','Sikkim','Tamil Nadu','Telangana','Tripura','Uttar Pradesh','Uttarakhand','West Bengal','Andaman and Nicobar Islands','Chandigarh','Dadra and Nagar Haveli and Daman and Diu','Delhi','Jammu and Kashmir','Ladakh','Lakshadweep','Puducherry'];
if ($data['gender'] !== '' && !in_array($data['gender'], $allowedGender, true)) $errors[] = 'Select a valid gender option.';
if ($data['year'] !== '' && !in_array($data['year'], $allowedYears, true)) $errors[] = 'Select a valid year of study.';
if ($data['state'] !== '' && !in_array($data['state'], $allowedStates, true)) $errors[] = 'Select a valid state or union territory.';
foreach (['college'=>120,'course'=>100,'address'=>250,'city'=>60] as $key=>$max) if ($data[$key] !== '' && strLength($data[$key]) > $max) $errors[] = ucfirst($key) . " must be {$max} characters or fewer.";
if ($data['pincode'] !== '' && !preg_match('/^[1-9][0-9]{5}$/', $data['pincode'])) $errors[] = 'Enter a valid 6-digit Indian pincode.';
if ($errors) fail($errors, $data);
$_SESSION['registration'] = $data;
$_SESSION['registration_id'] = 'CC-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));
header('Location: success.php', true, 303);
exit;
