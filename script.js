$(function () {
  const $form = $('#registrationForm');
  if (!$form.length) return;

  const validators = {
    full_name: value => value.trim() ? (/^[\p{L}\p{M} .'-]+$/u.test(value.trim()) && value.trim().length <= 80 ? '' : 'Use letters, spaces, apostrophes, periods or hyphens (max 80 characters).') : 'Full Name is required.',
    email: value => value.trim() ? (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value.trim()) && value.length <= 120 ? '' : 'Enter a valid email address.') : 'Email Address is required.',
    phone: value => value.trim() ? (/^[6-9]\d{9}$/.test(value.trim()) ? '' : 'Enter a valid 10-digit Indian mobile number.') : 'Phone Number is required.',
    dob: value => {
      if (!value) return 'Date of Birth is required.';
      const date = new Date(value + 'T00:00:00');
      return Number.isNaN(date.getTime()) || date >= new Date(new Date().toDateString()) ? 'Enter a valid date in the past.' : '';
    },
    gender: value => value ? '' : 'Select your gender.',
    college: value => value.trim() ? (value.length <= 120 ? '' : 'Maximum 120 characters.') : 'College Name is required.',
    course: value => value.trim() ? (value.length <= 100 ? '' : 'Maximum 100 characters.') : 'Course / Branch is required.',
    year: value => value ? '' : 'Select your year of study.',
    address: value => value.trim() ? (value.length <= 250 ? '' : 'Maximum 250 characters.') : 'Address is required.',
    city: value => value.trim() ? (value.length <= 60 ? '' : 'Maximum 60 characters.') : 'City is required.',
    state: value => value ? '' : 'Select your state.',
    pincode: value => value.trim() ? (/^[1-9]\d{5}$/.test(value.trim()) ? '' : 'Enter a valid 6-digit Indian pincode.') : 'Pincode is required.'
  };

  function validateField(element) {
    const name = element.name;
    const validator = validators[name];
    if (!validator) return true;
    const message = validator(element.value);
    $(element).toggleClass('invalid', Boolean(message)).attr('aria-invalid', message ? 'true' : 'false');
    $(element).closest('.field').find('.field-error').text(message);
    return !message;
  }

  $form.find('input, select, textarea').on('input change blur', function () {
    validateField(this);
  });

  $form.on('submit', function (event) {
    let valid = true;
    $form.find('input, select, textarea').each(function () {
      if (!validateField(this)) valid = false;
    });
    if (!valid) {
      event.preventDefault();
      const $first = $form.find('.invalid').first();
      if ($first.length) $first.trigger('focus');
    }
  });
});
