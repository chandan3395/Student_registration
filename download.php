<?php
declare(strict_types=1);
session_start();
$data = $_SESSION['registration'] ?? null;
$id = $_SESSION['registration_id'] ?? '';
if (!is_array($data)) { http_response_code(404); echo 'No submitted registration was found. Please submit the form first.'; exit; }

function pdfEscape(string $text): string {
    $text = str_replace(["\\", "(", ")", "\r", "\n"], ["\\\\", "\\(", "\\)", " ", " "], $text);
    if (function_exists('iconv')) {
        $converted = iconv('UTF-8', 'Windows-1252//TRANSLIT//IGNORE', $text);
        if ($converted !== false) $text = $converted;
    }
    return preg_replace('/[^\\x20-\\x7E\\x80-\\xFF]/', '?', $text) ?? $text;
}
$labels = ['full_name'=>'Full Name','email'=>'Email Address','phone'=>'Phone Number','dob'=>'Date of Birth','gender'=>'Gender','college'=>'College Name','course'=>'Course / Branch','year'=>'Year of Study','address'=>'Address','city'=>'City','state'=>'State','pincode'=>'Pincode'];
$dob = DateTime::createFromFormat('!Y-m-d', $data['dob']);
$rows = [
    'Registration ID: ' . $id,
    'Submitted: ' . date('d M Y, h:i A'),
    ''
];
foreach ($labels as $key => $label) {
    $value = $key === 'dob' && $dob ? $dob->format('d M Y') : $data[$key];
    $rows[] = $label . ': ' . $value;
}
$wrapped = [];
foreach ($rows as $row) {
    if ($row === '') { $wrapped[] = ''; continue; }
    $parts = explode("\n", wordwrap($row, 82, "\n", true));
    foreach ($parts as $part) $wrapped[] = $part;
}
$commands = "BT\n/F1 19 Tf\n50 790 Td\n(" . pdfEscape('STUDENT REGISTRATION') . ") Tj\n/F1 10 Tf\n0 -22 Td\n(" . pdfEscape('Campus Connect | Application Confirmation') . ") Tj\n/F1 11 Tf\n";
foreach ($wrapped as $line) {
    $commands .= "0 -25 Td\n(" . pdfEscape($line) . ") Tj\n";
}
$commands .= "ET";
$stream = $commands;
$objects = [];
$objects[] = '<< /Type /Catalog /Pages 2 0 R >>';
$objects[] = '<< /Type /Pages /Kids [3 0 R] /Count 1 >>';
$objects[] = '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >>';
$objects[] = '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica /Encoding /WinAnsiEncoding >>';
$objects[] = '<< /Length ' . strlen($stream) . " >>\nstream\n" . $stream . "\nendstream";
$pdf = "%PDF-1.4\n";
$offsets = [0];
foreach ($objects as $i => $obj) {
    $offsets[] = strlen($pdf);
    $pdf .= ($i + 1) . " 0 obj\n" . $obj . "\nendobj\n";
}
$xref = strlen($pdf);
$pdf .= "xref\n0 " . (count($objects) + 1) . "\n0000000000 65535 f \n";
for ($i = 1; $i <= count($objects); $i++) $pdf .= sprintf("%010d 00000 n \n", $offsets[$i]);
$pdf .= "trailer\n<< /Size " . (count($objects) + 1) . " /Root 1 0 R >>\nstartxref\n" . $xref . "\n%%EOF";
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="student-registration-' . preg_replace('/[^A-Za-z0-9-]/', '', $id) . '.pdf"');
header('Content-Length: ' . strlen($pdf));
echo $pdf;
exit;
