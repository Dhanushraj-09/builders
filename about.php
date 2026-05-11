<?php
/**
 * About Page — StructuraPro Builders
 */
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';

$pageTitle = 'About Us';
$pageDescription = 'Learn about StructuraPro Builders — our history, mission, team, and achievements in premium construction across Tamil Nadu.';

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<!-- Page Header -->
<section class="pt-32 pb-16 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-primary-500/5 to-transparent"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center" data-aos="fade-up">
            <span class="section-badge"><i class="fa-solid fa-building-columns"></i> About Us</span>
            <h1 class="section-title text-4xl sm:text-5xl md:text-6xl text-white mt-4 mb-4">
                Know Our <span class="gradient-text">Story</span>
            </h1>
            <p class="text-dark-400 max-w-2xl mx-auto text-lg">A legacy of premium construction, trusted craftsmanship, and building dreams across Tamil Nadu since 2013.</p>
        </div>
    </div>
</section>

<!-- Company Story -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div data-aos="fade-right">
                <div class="glass-card p-2 rounded-2xl glow-primary">
                    <div class="aspect-[4/3] rounded-xl bg-dark-800 flex items-center justify-center overflow-hidden">
                        <div class="text-center p-8">
                            <i class="fa-solid fa-helmet-safety text-6xl text-primary-500/30 mb-4"></i>
                            <p class="text-dark-500 text-sm">Company Photo</p>
                        </div>
                    </div>
                </div>
            </div>
            <div data-aos="fade-left">
                <span class="section-badge mb-4"><i class="fa-solid fa-book-open"></i> Our Journey</span>
                <h2 class="section-title text-3xl sm:text-4xl text-white mt-4 mb-6">
                    Building <span class="gradient-text">Excellence</span> Since 2013
                </h2>
                <p class="text-dark-300 leading-relaxed mb-4">
                    StructuraPro Builders was founded with a vision to transform the construction industry in Tamil Nadu. Starting from a small team in Srivilliputhur, we have grown into a trusted name in residential and commercial construction.
                </p>
                <p class="text-dark-400 leading-relaxed mb-6">
                    With over 150 completed projects and a team of 35+ skilled professionals, we deliver premium construction solutions combining modern technology, quality materials, and expert craftsmanship. Our commitment to transparency, on-time delivery, and client satisfaction has earned us the trust of hundreds of families and businesses.
                </p>
                <div class="grid grid-cols-2 gap-4">
                    <div class="glass-card p-4 text-center">
                        <div class="stat-number text-2xl" data-counter="150" data-suffix="+">0</div>
                        <p class="text-dark-400 text-xs mt-1">Projects Completed</p>
                    </div>
                    <div class="glass-card p-4 text-center">
                        <div class="stat-number text-2xl" data-counter="12" data-suffix="+">0</div>
                        <p class="text-dark-400 text-xs mt-1">Years Experience</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Vision & Mission -->
<section class="py-20 bg-dark-900/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="glass-card p-10" data-aos="fade-up">
                <div class="service-icon mb-6"><i class="fa-solid fa-eye"></i></div>
                <h3 class="font-heading font-bold text-white text-2xl mb-4">Our Vision</h3>
                <p class="text-dark-300 leading-relaxed">To be the most trusted and innovative construction company in Tamil Nadu, known for delivering world-class residential and commercial buildings with cutting-edge technology and sustainable practices.</p>
            </div>
            <div class="glass-card p-10" data-aos="fade-up" data-aos-delay="100">
                <div class="service-icon mb-6"><i class="fa-solid fa-bullseye"></i></div>
                <h3 class="font-heading font-bold text-white text-2xl mb-4">Our Mission</h3>
                <p class="text-dark-300 leading-relaxed">To construct premium buildings that exceed client expectations through quality materials, expert workmanship, transparent processes, and on-time delivery. We aim to make every project a landmark of trust and excellence.</p>
            </div>
        </div>
    </div>
</section>

<!-- Achievements -->
<section class="py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <span class="section-badge"><i class="fa-solid fa-trophy"></i> Achievements</span>
            <h2 class="section-title text-3xl sm:text-4xl md:text-5xl text-white mt-4">
                Our <span class="gradient-text">Numbers</span> Speak
            </h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <?php
            $stats = [
                ['icon' => 'fa-building', 'count' => 150, 'suffix' => '+', 'label' => 'Projects Completed'],
                ['icon' => 'fa-users', 'count' => 120, 'suffix' => '+', 'label' => 'Happy Clients'],
                ['icon' => 'fa-calendar-check', 'count' => 12, 'suffix' => '+', 'label' => 'Years Experience'],
                ['icon' => 'fa-people-group', 'count' => 35, 'suffix' => '+', 'label' => 'Team Members'],
            ];
            foreach($stats as $i => $stat):
            ?>
            <div class="glass-card stat-card" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                <div class="text-primary-400 text-3xl mb-3"><i class="fa-solid <?= $stat['icon'] ?>"></i></div>
                <div class="stat-number" data-counter="<?= $stat['count'] ?>" data-suffix="<?= $stat['suffix'] ?>">0</div>
                <p class="text-dark-400 text-sm mt-2"><?= $stat['label'] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Team -->
<section class="py-24 bg-dark-900/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <span class="section-badge"><i class="fa-solid fa-users"></i> Leadership</span>
            <h2 class="section-title text-3xl sm:text-4xl md:text-5xl text-white mt-4 mb-4">
                Meet Our <span class="gradient-text">Team</span>
            </h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php
            $team = [
                ['name' => 'Rajesh Krishnan', 'role' => 'Founder & CEO', 'icon' => 'fa-user-tie'],
                ['name' => 'Priya Sundaram', 'role' => 'Chief Architect', 'icon' => 'fa-compass-drafting'],
                ['name' => 'Vijay Murugan', 'role' => 'Project Manager', 'icon' => 'fa-helmet-safety'],
                ['name' => 'Lakshmi Devi', 'role' => 'Interior Head', 'icon' => 'fa-couch'],
            ];
            foreach($team as $i => $member):
            ?>
            <div class="glass-card team-card p-8 text-center" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-primary-400/20 to-primary-600/10 border border-primary-500/20 flex items-center justify-center">
                    <i class="fa-solid <?= $member['icon'] ?> text-primary-400 text-2xl"></i>
                </div>
                <h4 class="font-heading font-bold text-white text-lg"><?= $member['name'] ?></h4>
                <p class="text-primary-400 text-sm mt-1"><?= $member['role'] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <span class="section-badge"><i class="fa-solid fa-check-double"></i> Why Us</span>
            <h2 class="section-title text-3xl sm:text-4xl md:text-5xl text-white mt-4 mb-4">
                Why Choose <span class="gradient-text">StructuraPro</span>
            </h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            $reasons = [
                ['icon' => 'fa-medal', 'title' => 'Premium Quality', 'desc' => 'Only the finest materials and construction methods for lasting durability.'],
                ['icon' => 'fa-clock', 'title' => 'On-Time Delivery', 'desc' => 'Strict project timelines with regular progress tracking and updates.'],
                ['icon' => 'fa-hand-holding-dollar', 'title' => 'Transparent Pricing', 'desc' => 'No hidden costs. Detailed budgets with clear breakdowns upfront.'],
                ['icon' => 'fa-shield-halved', 'title' => 'Safety First', 'desc' => 'Highest safety standards for workers and structures at every stage.'],
                ['icon' => 'fa-headset', 'title' => '24/7 Support', 'desc' => 'Dedicated project managers and round-the-clock communication.'],
                ['icon' => 'fa-certificate', 'title' => 'Warranty Assured', 'desc' => 'Comprehensive warranty coverage for complete peace of mind.'],
            ];
            foreach($reasons as $i => $r):
            ?>
            <div class="glass-card service-card p-8" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                <div class="service-icon mb-4"><i class="fa-solid <?= $r['icon'] ?>"></i></div>
                <h3 class="font-heading font-bold text-white text-lg mb-2"><?= $r['title'] ?></h3>
                <p class="text-dark-400 text-sm leading-relaxed"><?= $r['desc'] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
