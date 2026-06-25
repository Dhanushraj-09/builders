<?php
/**
 * Contact Page — StructuraPro Builders
 */
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';

$pageTitle = 'Contact Us';
$pageDescription = 'Get in touch with StructuraPro Builders for free construction consultation and quotation. Call, WhatsApp, or fill our contact form.';

$success = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $construction_type = sanitize($_POST['construction_type'] ?? '');
    $budget_range = sanitize($_POST['budget_range'] ?? '');
    $location = sanitize($_POST['location'] ?? '');
    $message = sanitize($_POST['message'] ?? '');

    if (empty($name) || empty($phone)) {
        $error = 'Please fill in your name and phone number.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO contacts (name, email, phone, construction_type, budget_range, location, message) VALUES (:name, :email, :phone, :ct, :br, :loc, :msg)");
        $stmt->execute([
            ':name' => $name, ':email' => $email, ':phone' => $phone,
            ':ct' => $construction_type, ':br' => $budget_range,
            ':loc' => $location, ':msg' => $message
        ]);
        $success = 'Thank you! Your inquiry has been submitted successfully. We will contact you soon.';
    }
}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<!-- Page Header -->
<section class="pt-32 pb-16 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-primary-500/5 to-transparent"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center" data-aos="fade-up">

            <h1 class="section-title text-4xl sm:text-5xl md:text-6xl text-white mt-4 mb-4">
                Contact <span class="gradient-text">Us</span>
            </h1>
            <p class="text-dark-400 max-w-2xl mx-auto text-lg">Have a construction project in mind? Get a free quotation and expert consultation today.</p>
        </div>
    </div>
</section>

<!-- Contact Info Cards -->
<section class="pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="glass-card p-6 text-center group" data-aos="fade-up">
                <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-primary-400/20 to-primary-600/10 border border-primary-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-phone text-primary-400 text-xl"></i>
                </div>
                <h3 class="font-heading font-bold text-white mb-1">Call Us</h3>
                <a href="tel:<?= SITE_PHONE ?>" class="text-dark-400 text-sm hover:text-primary-400 transition-colors"><?= SITE_PHONE ?></a>
            </div>
            <div class="glass-card p-6 text-center group" data-aos="fade-up" data-aos-delay="100">
                <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-green-400/20 to-green-600/10 border border-green-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fa-brands fa-whatsapp text-green-400 text-xl"></i>
                </div>
                <h3 class="font-heading font-bold text-white mb-1">WhatsApp</h3>
                <a href="https://wa.me/<?= SITE_WHATSAPP ?>" target="_blank" class="text-dark-400 text-sm hover:text-green-400 transition-colors">Chat with us</a>
            </div>
            <div class="glass-card p-6 text-center group" data-aos="fade-up" data-aos-delay="200">
                <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-blue-400/20 to-blue-600/10 border border-blue-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-envelope text-blue-400 text-xl"></i>
                </div>
                <h3 class="font-heading font-bold text-white mb-1">Email</h3>
                <a href="mailto:<?= SITE_EMAIL ?>" class="text-dark-400 text-sm hover:text-blue-400 transition-colors"><?= SITE_EMAIL ?></a>
            </div>
            <div class="glass-card p-6 text-center group" data-aos="fade-up" data-aos-delay="300">
                <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-purple-400/20 to-purple-600/10 border border-purple-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-location-dot text-purple-400 text-xl"></i>
                </div>
                <h3 class="font-heading font-bold text-white mb-1">Visit</h3>
                <p class="text-dark-400 text-sm"><?= SITE_ADDRESS ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form + Map -->
<section class="py-12 pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row gap-10 items-stretch w-full">
            <!-- Form -->
            <div class="glass-card p-8 md:p-10 flex-1 w-full" data-aos="fade-right">
                <h2 class="font-heading font-bold text-white text-2xl mb-2">Get Free Quotation</h2>
                <p class="text-dark-400 text-sm mb-8">Fill in your details and we'll get back to you within 24 hours.</p>

                <?php if ($success): ?>
                <div class="bg-green-500/10 border border-green-500/20 text-green-400 p-4 rounded-xl mb-6 flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-lg"></i>
                    <span class="text-sm"><?= $success ?></span>
                </div>
                <?php endif; ?>
                <?php if ($error): ?>
                <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-xl mb-6 flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-lg"></i>
                    <span class="text-sm"><?= $error ?></span>
                </div>
                <?php endif; ?>

                <form id="contact-form" method="POST" class="space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="form-label">Full Name *</label>
                            <input type="text" name="name" class="form-input" placeholder="Your full name" required>
                        </div>
                        <div>
                            <label class="form-label">Phone Number *</label>
                            <input type="tel" name="phone" class="form-input" placeholder="+91 XXXXX XXXXX" required>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-input" placeholder="your@email.com">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="form-label">Construction Type</label>
                            <select name="construction_type" class="form-input">
                                <option value="">Select type</option>
                                <option value="Residential">Residential Construction</option>
                                <option value="Commercial">Commercial Construction</option>
                                <option value="Interior">Interior Works</option>
                                <option value="Renovation">Renovation</option>
                                <option value="Architecture">Architecture & Design</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Budget Range</label>
                            <select name="budget_range" class="form-input">
                                <option value="">Select budget</option>
                                <option value="Under 20 Lakhs">Under ₹20 Lakhs</option>
                                <option value="20-50 Lakhs">₹20 - 50 Lakhs</option>
                                <option value="50 Lakhs - 1 Crore">₹50 Lakhs - 1 Crore</option>
                                <option value="1-5 Crores">₹1 - 5 Crores</option>
                                <option value="Above 5 Crores">Above ₹5 Crores</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Project Location</label>
                        <input type="text" name="location" class="form-input" placeholder="City / Area">
                    </div>
                    <div>
                        <label class="form-label">Message</label>
                        <textarea name="message" rows="4" class="form-input" placeholder="Tell us about your project..."></textarea>
                    </div>
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-primary-500 to-primary-600 text-dark-950 px-8 py-4 rounded-xl font-heading font-bold text-base hover:shadow-2xl hover:shadow-primary-500/30 hover:-translate-y-1 transition-all">
                        <i class="fa-solid fa-paper-plane"></i>
                        Submit Inquiry
                    </button>
                </form>
            </div>

            <!-- Map -->
            <div class="flex-1 w-full" data-aos="fade-left">
                <div class="glass-card p-2 rounded-2xl h-full min-h-[500px]">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3940.2035!2d77.6363!3d9.5127!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zOcKwMzAnNDUuNyJOIDc3wrAzOCcxMC43IkU!5e0!3m2!1sen!2sin!4v1" class="w-full h-full rounded-xl" style="border:0; min-height:480px;" allowfullscreen loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
