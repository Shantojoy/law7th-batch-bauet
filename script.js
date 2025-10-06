const form = document.getElementById('studentForm');
const formSteps = document.querySelectorAll('.form-step');
const progressSteps = document.querySelectorAll('.progress-step');
const nextButtons = document.querySelectorAll('.next-step');
const prevButtons = document.querySelectorAll('.prev-step');
const summaryContainer = document.getElementById('summaryContainer');
const summaryList = document.getElementById('summaryList');
const summaryPhoto = document.getElementById('summaryPhoto');
const photoInput = document.getElementById('photo');
const photoPreviewWrapper = document.getElementById('photoPreviewWrapper');
const photoPreview = document.getElementById('photoPreview');

let currentStep = 0;

const banglaRegex = /^[^A-Za-z]*$/;
const banglaFields = ['name', 'student_id', 'address', 'quote'];

function showStep(stepIndex) {
    formSteps.forEach((step, index) => {
        step.classList.toggle('active', index === stepIndex);
    });

    progressSteps.forEach((step, index) => {
        step.classList.toggle('active', index === stepIndex);
        step.classList.toggle('completed', index < stepIndex);
    });

    currentStep = stepIndex;
}

function validateBanglaFields(step) {
    const inputs = formSteps[step].querySelectorAll('input[type="text"], textarea');
    for (const input of inputs) {
        if (banglaFields.includes(input.name)) {
            if (!banglaRegex.test(input.value)) {
                return { valid: false, message: 'বাংলা ঘরে ইংরেজি বর্ণ ব্যবহার করা যাবে না।', field: input };
            }
        }
    }
    return { valid: true };
}

function validateStep(step) {
    const inputs = formSteps[step].querySelectorAll('input, textarea');
    for (const input of inputs) {
        if (input.hasAttribute('required') && !input.value.trim()) {
            return { valid: false, message: 'সমস্ত ঘর পূরণ করুন।', field: input };
        }

        if (input.name === 'phone' && input.value.trim()) {
            if (!/^01\d{9}$/.test(input.value.trim())) {
                return { valid: false, message: 'মোবাইল নম্বর অবশ্যই ০১ দিয়ে শুরু হয়ে ১১ ডিজিট হতে হবে।', field: input };
            }
        }

        if (input.name === 'email' && input.value.trim()) {
            const emailPattern = /^[\w-.]+@[\w-]+\.[A-Za-z]{2,}$/;
            if (!emailPattern.test(input.value.trim())) {
                return { valid: false, message: 'সঠিক ইমেইল প্রদান করুন।', field: input };
            }
        }
    }

    const banglaValidation = validateBanglaFields(step);
    if (!banglaValidation.valid) {
        return banglaValidation;
    }

    if (step === 2) {
        const file = photoInput.files[0];
        if (!file) {
            return { valid: false, message: 'একটি বৈধ ছবি আপলোড করুন।', field: photoInput };
        }
        if (file.size > 2 * 1024 * 1024) {
            return { valid: false, message: 'ছবির আকার ২ এমবি-র কম হতে হবে।', field: photoInput };
        }
        const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
            return { valid: false, message: 'শুধুমাত্র JPEG, PNG অথবা WEBP ফাইল গ্রহণযোগ্য।', field: photoInput };
        }
    }

    return { valid: true };
}

nextButtons.forEach(button => {
    button.addEventListener('click', () => {
        const validation = validateStep(currentStep);
        if (!validation.valid) {
            handleInvalid(validation);
            return;
        }
        showStep(Math.min(currentStep + 1, formSteps.length - 1));
    });
});

prevButtons.forEach(button => {
    button.addEventListener('click', () => {
        showStep(Math.max(currentStep - 1, 0));
    });
});

photoInput.addEventListener('change', (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            photoPreview.src = e.target.result;
            photoPreviewWrapper.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        photoPreviewWrapper.style.display = 'none';
        photoPreview.src = '#';
    }
});

function handleInvalid(validation) {
    if (validation.field) {
        validation.field.focus();
        validation.field.classList.add('is-invalid');
        setTimeout(() => validation.field.classList.remove('is-invalid'), 2000);
    }

    Swal.fire({
        icon: 'error',
        title: 'দুঃখিত!',
        text: validation.message,
        confirmButtonText: 'ঠিক আছে',
        confirmButtonColor: '#2f7a59'
    });
}

form.addEventListener('submit', async (event) => {
    event.preventDefault();

    for (let step = 0; step < formSteps.length; step += 1) {
        const validation = validateStep(step);
        if (!validation.valid) {
            showStep(step);
            handleInvalid(validation);
            return;
        }
    }

    const formData = new FormData(form);

    try {
        const response = await fetch('insert.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (!result.success) {
            throw new Error(result.message || 'Submission failed.');
        }

        await Swal.fire({
            icon: 'success',
            title: '✅ তথ্য সফলভাবে জমা হয়েছে! ধন্যবাদ।',
            showConfirmButton: false,
            timer: 1800
        });

        displaySummary(result.data);
        form.reset();
        photoPreviewWrapper.style.display = 'none';
        showStep(0);
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'ত্রুটি',
            text: error.message || 'অজানা ত্রুটি ঘটেছে।',
            confirmButtonText: 'ঠিক আছে',
            confirmButtonColor: '#2f7a59'
        });
    }
});

function displaySummary(data) {
    summaryList.innerHTML = '';

    const summaryItems = [
        { label: 'নাম', value: data.name },
        { label: 'আইডি', value: data.student_id },
        { label: 'ঠিকানা', value: data.address },
        { label: 'মোবাইল', value: data.phone, className: 'english-text' },
        { label: 'ইমেইল', value: data.email, className: 'english-text' },
        { label: 'প্রিয় কথা', value: data.quote }
    ];

    summaryItems.forEach(item => {
        const li = document.createElement('li');
        li.className = 'mb-2';
        li.innerHTML = `<strong>${item.label}:</strong> <span class="${item.className || 'bangla-text'}">${item.value}</span>`;
        summaryList.appendChild(li);
    });

    summaryPhoto.src = data.photo;
    summaryContainer.style.display = 'block';
}

showStep(currentStep);
