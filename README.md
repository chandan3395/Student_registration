# Student Registration Portal

A beginner-friendly PHP 8.5 student registration project for a Web Technology Laboratory assignment. It uses HTML5, CSS3, vanilla JavaScript, jQuery and PHP. No database, Composer, framework or XAMPP is required.

## Features

- Responsive student registration form with all 12 requested fields.
- Client-side validation using JavaScript and jQuery.
- Server-side validation in `process.php` (never relies on browser validation alone).
- Escaped, formatted confirmation page with a generated registration ID.
- Dynamically generated PDF download using a small built-in PHP PDF writer; no PDF package required.
- Indian mobile number and pincode format checks, future-date rejection, and allow-listed dropdown values.

## Project structure

```text
student-registration/
├── index.php       # Registration form
├── process.php     # Server-side validation and processing
├── success.php     # Confirmation and submitted details
├── download.php    # Generates and downloads the PDF
├── style.css       # Responsive styling
├── script.js       # jQuery client-side validation
├── README.md
└── assets/         # Reserved for optional local assets
```

## Requirements

- PHP 8.0 or later (the included runtime test environment used PHP 8.4.24; PHP 8.5 was not available for direct testing).
- A modern browser.
- Internet access for the jQuery CDN and optional Google Fonts. The form and server-side processing do not depend on Google Fonts. For fully offline use, download jQuery and serve it locally, or replace the CDN script with a local copy.

## Run locally in Windows / VS Code

1. Extract `student-registration.zip`.
2. Open the extracted `student-registration` folder in VS Code (`File > Open Folder`).
3. Open the integrated terminal (`Terminal > New Terminal`).
4. Confirm PHP is on your PATH:

   ```powershell
   php -v
   ```

5. Start the built-in PHP development server from the project folder:

   ```powershell
   php -S localhost:8000
   ```

6. Open <http://localhost:8000> in your browser.
7. Complete the form and click **Submit Registration**. On success, choose **Download PDF**.

Stop the server with `Ctrl+C`.

## Test checklist

- Open `index.php` through the PHP server (not by double-clicking the file).
- Submit a complete valid form and verify the confirmation page shows every submitted value.
- Try submitting empty fields, a malformed email, a phone number that is not a 10-digit Indian mobile number, a future date of birth, an invalid dropdown value (can be tested by editing the request), and an invalid pincode.
- Verify invalid submissions return to the form with server-side error messages and preserve the entered values.
- On the confirmation page, click **Download PDF** and open the downloaded file in a PDF reader. Confirm that the registration ID and all 12 fields appear.

## Deploy to InfinityFree (manual)

1. Create/activate your InfinityFree hosting account and add a hosting domain.
2. Open the account's **Online File Manager** or connect using the FTP details provided in the hosting control panel.
3. Open the website document root, commonly `htdocs`.
4. Upload the contents of this project folder directly into `htdocs` (so `index.php` is at `htdocs/index.php`). Do not upload the ZIP as the website itself.
5. Visit your domain over HTTPS and test a complete registration and the PDF download.
6. If your hosting control panel offers a PHP version selector, choose a supported PHP 8.x version. The code is compatible with PHP 8+.

No database setup or environment variables are needed. The project does not write registration records to a database: submitted data is held in the PHP session so the confirmation and PDF work in the same browser session. Session data is temporary and can expire; this is suitable for a lab demonstration, not a production admissions system. Add a database, privacy notice, CSRF protection, rate limiting and secure operational controls before using real student data in production.

## Notes and limitations

- The phone and pincode checks follow common Indian 10-digit mobile and 6-digit postal formats. Adjust them if the application is intended for another country.
- The generated PDF uses standard Helvetica and a compact single-page layout. Non-Latin characters may be transliterated or replaced because the lightweight PDF writer uses a standard built-in PDF font.
- jQuery is loaded from the official jQuery CDN. If the CDN is unavailable, server-side validation still works, but client-side jQuery validation will not load.
- The application intentionally does not save data permanently or send email.
