<?php
?>
<!DOCTYPE html>
<html lang="bn" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bangladesh Army University of Engineering &amp; Technology (BAUET) – Department of Law and Justice | Batch 7th Student Info Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="bauet-header">
        <div class="container">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <img src="https://upload.wikimedia.org/wikipedia/en/2/28/Bangladesh_Army_University_of_Engineering_%26_Technology_logo.png" alt="BAUET Logo" class="logo">
                    <div>
                        <h1 class="title-text bangla-text mb-1">বাংলাদেশ আর্মি ইউনিভার্সিটি অব ইঞ্জিনিয়ারিং অ্যান্ড টেকনোলজি (BAUET)</h1>
                        <p class="mb-0 bangla-text">আইন ও বিচার বিভাগ – ৭ম ব্যাচ</p>
                    </div>
                </div>
                <div class="text-md-end">
                    <p class="mb-0 fw-semibold text-uppercase" style="letter-spacing: 1px; color: var(--accent-gold);">Student Information Portal</p>
                    <small class="text-muted">Qadirabad Cantonment, Natore</small>
                </div>
            </div>
        </div>
    </header>

    <main class="pb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="step-card">
                        <div class="progress-indicator">
                            <div class="progress-step active" data-step="0">১</div>
                            <div class="progress-step" data-step="1">২</div>
                            <div class="progress-step" data-step="2">৩</div>
                        </div>
                        <div class="progress-labels bangla-text">
                            <span>ব্যক্তিগত তথ্য</span>
                            <span>যোগাযোগ</span>
                            <span>উক্তি ও ছবি</span>
                        </div>

                        <form id="studentForm" class="mt-4" enctype="multipart/form-data">
                            <div class="form-step active" data-step="0">
                                <div class="mb-3">
                                    <label for="name" class="form-label bangla-text">নাম *</label>
                                    <input type="text" class="form-control bangla-text" id="name" name="name" placeholder="আপনার নাম লিখুন" required>
                                </div>
                                <div class="mb-3">
                                    <label for="student_id" class="form-label bangla-text">আইডি *</label>
                                    <input type="text" class="form-control bangla-text" id="student_id" name="student_id" placeholder="আইডি নম্বর লিখুন" required>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label bangla-text">ঠিকানা *</label>
                                    <textarea class="form-control bangla-text" id="address" name="address" rows="3" placeholder="পূর্ণ ঠিকানা লিখুন" required></textarea>
                                </div>
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-soft btn-outline-success next-step bangla-text">পরবর্তী ধাপ</button>
                                </div>
                            </div>

                            <div class="form-step" data-step="1">
                                <div class="mb-3">
                                    <label for="phone" class="form-label bangla-text">মোবাইল নম্বর *</label>
                                    <input type="text" class="form-control english-text" id="phone" name="phone" placeholder="01XXXXXXXXX" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label bangla-text">ইমেইল *</label>
                                    <input type="email" class="form-control english-text" id="email" name="email" placeholder="name@example.com" required>
                                </div>
                                <div class="d-flex justify-content-between gap-2">
                                    <button type="button" class="btn btn-soft btn-outline-secondary prev-step bangla-text">পূর্ববর্তী</button>
                                    <button type="button" class="btn btn-soft btn-outline-success next-step bangla-text">পরবর্তী ধাপ</button>
                                </div>
                            </div>

                            <div class="form-step" data-step="2">
                                <div class="mb-3">
                                    <label for="quote" class="form-label bangla-text">প্রিয় কথা *</label>
                                    <textarea class="form-control bangla-text" id="quote" name="quote" rows="3" placeholder="আপনার প্রিয় উক্তিটি লিখুন" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="photo" class="form-label bangla-text">প্রোফাইল ছবি আপলোড *</label>
                                    <input type="file" class="form-control" id="photo" name="photo" accept="image/*" required>
                                    <div class="mt-2" id="photoPreviewWrapper" style="display:none;">
                                        <span class="bangla-text d-block mb-1">ছবির প্রিভিউ:</span>
                                        <img id="photoPreview" src="#" alt="Photo Preview" class="img-fluid rounded-4 border" style="max-height: 180px;">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between gap-2">
                                    <button type="button" class="btn btn-soft btn-outline-secondary prev-step bangla-text">পূর্ববর্তী</button>
                                    <button type="submit" class="btn btn-soft btn-success bangla-text">জমা দিন</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center mt-5" id="summaryContainer" style="display:none;">
                <div class="col-lg-8">
                    <div class="summary-card">
                        <h2 class="bangla-text mb-4">জমাকৃত তথ্য</h2>
                        <div class="row g-4 align-items-center">
                            <div class="col-md-4 text-center">
                                <img id="summaryPhoto" src="" alt="Submitted Photo" class="img-fluid">
                            </div>
                            <div class="col-md-8">
                                <ul class="list-unstyled bangla-text" id="summaryList"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer-credit bangla-text">
        Developed by Batch 7 Students – Department of Law and Justice, BAUET
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
</body>
</html>
