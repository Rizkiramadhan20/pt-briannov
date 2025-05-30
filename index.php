<?php
session_start();
require_once 'config/db.php';

// Fetch home content
$result = $db->query("SELECT * FROM home ORDER BY created_at DESC");
$contents = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $row['framework'] = json_decode($row['framework'], true);
        $contents[] = $row;
    }
}

// Fetch partners
$partners_result = $db->query("SELECT * FROM partners ORDER BY created_at DESC");
$partners = [];
if ($partners_result) {
    while ($row = $partners_result->fetch_assoc()) {
        $partners[] = $row;
    }
}

// Fetch about content
$about_result = $db->query("SELECT * FROM about ORDER BY created_at DESC");
$about_content = null;
if ($about_result && $about_result->num_rows > 0) {
    $about_content = $about_result->fetch_assoc();
    $about_content['metrics'] = json_decode($about_content['metrics'], true);
}

// Fetch timeline content
$timeline_result = $db->query("SELECT * FROM timeline ORDER BY created_at ASC");
$timelines = [];
if ($timeline_result) {
    while ($row = $timeline_result->fetch_assoc()) {
        $timelines[] = $row;
    }
}

// Fetch works content
$works_result = $db->query("SELECT * FROM works ORDER BY created_at DESC");
$works = [];
if ($works_result) {
    while ($row = $works_result->fetch_assoc()) {
        $works[] = $row;
    }
}

// Fetch projects content
$projects_result = $db->query("SELECT * FROM projects ORDER BY created_at DESC LIMIT 3");
$projects = [];
if ($projects_result) {
    while ($row = $projects_result->fetch_assoc()) {
        $projects[] = $row;
    }
}

// Fetch inspiration content
$inspiration_result = $db->query("SELECT * FROM inspiration ORDER BY created_at DESC");
$inspirations = [];
if ($inspiration_result) {
    while ($row = $inspiration_result->fetch_assoc()) {
        $inspirations[] = $row;
    }
}

// Fetch testimonials
$testimonials_result = $db->query("SELECT * FROM testimonials ORDER BY created_at DESC");
$testimonials = [];
if ($testimonials_result) {
    while ($row = $testimonials_result->fetch_assoc()) {
        // Assuming 'image' column from the database will be used for the logo
        $row['logo_url'] = 'dashboard/' . $row['image']; // Construct the image path
        $testimonials[] = $row;
    }
}

// Get unique statuses for filter
$statuses = array_unique(array_column($timelines, 'status'));

// Get selected status from URL parameter
$selected_status = isset($_GET['status']) ? $_GET['status'] : 'all';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Kreasi Digital</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="assets/logo.png">
    <link rel="stylesheet" href="style/style.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- GSAP CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {}
        }
    }
    </script>
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</head>

<body>
    <?php include 'components/header/header.php'; ?>

    <!-- Main Content -->
    <main class="overflow-hidden">
        <!-- Home -->
        <section
            class="py-8 sm:py-16 bg-gray-50 min-h-screen flex items-center justify-center mt-0 sm:mt-10 overflow-hidden">
            <div class="container px-4 text-center flex flex-col gap-4">
                <?php if (!empty($contents)):
                // Get the first item from the fetched data to use for the hero section
                $hero_content = $contents[0];
                ?>

                <p class="text-sm text-gray-600 mb-2">Designing With Us</p>

                <h1
                    class="mx-auto text-3xl sm:text-4xl md:text-5xl lg:text-6xl max-w-3xl font-bold text-gray-900 leading-tight mb-4 px-4 home-title">
                    <?php echo htmlspecialchars($hero_content['title']); ?>
                </h1>

                <p
                    class="text-sm sm:text-base lg:text-lg text-gray-700 mb-6 sm:mb-8 max-w-2xl mx-auto px-4 home-description">
                    <?php echo htmlspecialchars($hero_content['description']); ?>
                </p>

                <!-- Services/Skills List -->
                <ul
                    class="flex flex-wrap justify-center gap-3 sm:gap-4 md:gap-10 text-gray-600 mb-8 sm:mb-12 px-4 home-framework">
                    <?php foreach ($hero_content['framework'] as $framework): ?>
                    <li class="text-xs sm:text-sm md:text-base">• <?php echo htmlspecialchars($framework); ?></li>
                    <?php endforeach; ?>
                </ul>

                <!-- Call to Action Button -->
                <a href="<?php echo htmlspecialchars($hero_content['href']); ?>" target="_blank"
                    class="inline-block px-5 sm:px-6 md:px-8 w-fit mx-auto py-2.5 sm:py-3 bg-blue-600 text-white font-semibold text-sm sm:text-base md:text-lg rounded-full shadow-lg hover:bg-blue-700 transition duration-300 home-cta opacity-0 translate-y-12 scale-90">
                    <span><?php echo htmlspecialchars($hero_content['labels']); ?></span>
                </a>

                <!-- Social Icons Placeholder -->
                <div
                    class="flex justify-center gap-3 sm:gap-4 md:gap-6 mt-6 sm:mt-8 md:mt-12 text-gray-600 text-lg sm:text-xl md:text-2xl social-icons">
                    <a href="#" class="hover:text-blue-600 transition-colors duration-200"><i
                            class='bx bxl-behance'></i></a>
                    <a href="#" class="hover:text-blue-600 transition-colors duration-200"><i
                            class='bx bxl-instagram'></i></a>
                    <a href="#" class="hover:text-blue-600 transition-colors duration-200"><i
                            class='bx bxl-linkedin'></i></a>
                </div>

                <!-- Weekly Growth and Client Trusted Placeholders -->
                <div class="hidden md:block absolute top-1/4 left-4 lg:left-10 home-growth">
                    <img src="/assets/home/grow.png" alt="" class="w-24 lg:w-auto">
                </div>

                <div class="hidden md:block absolute top-1/4 right-4 lg:right-10 home-trusted">
                    <img src="/assets/home/trused.png" alt="" class="w-24 lg:w-auto">
                </div>

                <?php else: ?>
                <div class="text-center py-12 px-4">
                    <h3 class="text-xl sm:text-2xl font-semibold text-gray-600 mb-4">No Content Available</h3>
                    <p class="text-gray-500">Please check back later for updates.</p>
                </div>
                <?php endif; ?>

                <!-- partner -->
                <div class="mt-8 sm:mt-12 md:mt-20 px-4">
                    <h3 class="text-base sm:text-lg md:text-xl font-bold text-gray-400 text-center mb-6 sm:mb-8">Trusted
                        Partners</h3>
                    <?php if (!empty($partners)): ?>
                    <div class="flex flex-wrap items-center justify-center gap-6 sm:gap-8 md:gap-16">
                        <?php foreach ($partners as $partner): ?>
                        <div
                            class="w-20 h-20 sm:w-24 sm:h-24 md:w-32 md:h-32 flex items-center justify-center partner-logo">
                            <img src="dashboard/<?php echo htmlspecialchars($partner['image']); ?>" alt="Partner Logo"
                                class="max-w-full max-h-full object-contain">
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-8">
                        <p class="text-gray-500">No partners available at the moment.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- About -->
        <section class="py-10 bg-white" id="about">
            <div class="container px-4">
                <?php if ($about_content):
                ?>

                <div class="flex flex-col md:flex-row justify-evenly overflow-hidden">
                    <!-- Left Side - Image -->
                    <div class="relative about-image">
                        <img src="dashboard/<?php echo htmlspecialchars($about_content['image']); ?>"
                            alt="About Us Image" class="w-full h-full object-cover lg:rounded-l-xl">
                    </div>

                    <!-- Right Side - Content -->
                    <div
                        class="flex p-4 sm:p-6 md:p-8 flex-col md:flex-row items-start md:items-center justify-center bg-gray-100 gap-6 md:gap-4 rounded rounded-md about-content">
                        <div class="flex flex-col gap-4">
                            <h3 class="text-2xl md:text-3xl font-bold text-gray-900">
                                <?php echo htmlspecialchars($about_content['title']); ?>
                            </h3>

                            <p class="text-gray-700 text-sm md:text-base leading-relaxed">
                                <?php echo htmlspecialchars($about_content['text']); ?>
                            </p>
                        </div>

                        <?php if (!empty($about_content['metrics'])): ?>
                        <div class="flex flex-col md:flex-row items-start md:items-center gap-6 md:gap-8 about-metrics">
                            <div class="flex flex-wrap md:flex-nowrap gap-6 md:gap-8">
                                <?php foreach ($about_content['metrics'] as $index => $metric): ?>
                                <div class="flex flex-col items-start about-metric">
                                    <h4 class="text-3xl md:text-4xl font-bold text-blue-600 mb-0">
                                        <?php echo htmlspecialchars($metric['count']); ?>
                                    </h4>
                                    <p class="text-gray-600 text-sm">
                                        <?php echo htmlspecialchars($metric['title']); ?>
                                    </p>
                                </div>

                                <?php if ($index < count($about_content['metrics']) - 1): ?>
                                <div class="hidden md:block w-px bg-gray-300 h-16"></div>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </div>

                            <a href="#"
                                class="inline-flex items-center justify-center px-6 md:px-8 py-4 md:py-6 bg-blue-600 text-white font-semibold rounded-full shadow-lg hover:bg-blue-700 transition duration-300 text-base md:text-lg w-full md:w-auto">Let's
                                work</a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php else: ?>
                <div class="text-center py-12">
                    <h3 class="text-xl sm:text-2xl font-semibold text-gray-600 mb-4">About Content Coming Soon</h3>
                    <p class="text-gray-500">We're working on something amazing. Stay tuned!</p>
                </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Timeline -->
        <section class="py-10 bg-white" id="services">
            <div class="container px-4 flex flex-col gap-10 md:gap-14">
                <?php if (!empty($timelines)): ?>
                <!-- Status Filter -->
                <div class="flex items-end justify-end gap-8 mb-10">
                    <?php foreach ($statuses as $index => $status): ?>
                    <div class="flex items-center gap-2">
                        <input type="radio" name="status-filter" id="status-<?php echo htmlspecialchars($status); ?>"
                            class="form-radio h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300"
                            data-status="<?php echo htmlspecialchars($status); ?>"
                            onclick="filterTimeline('<?php echo htmlspecialchars($status); ?>')"
                            <?php echo $index === 0 ? 'checked' : ''; ?> />
                        <label for="status-<?php echo htmlspecialchars($status); ?>"
                            class="ml-1 text-gray-700 text-base cursor-pointer select-none">
                            <?php echo htmlspecialchars($status); ?>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div id="timeline-container">
                    <?php foreach ($timelines as $timeline): ?>
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 timeline-item mb-12 md:mb-16"
                        data-status="<?php echo htmlspecialchars($timeline['status']); ?>">
                        <!-- Timeline Content -->
                        <div class="md:col-span-7 order-2 md:order-1">
                            <div class="flex flex-col gap-3 md:gap-4">
                                <p class="text-gray-700 text-sm md:text-base italic">
                                    <?php echo htmlspecialchars($timeline['text']); ?>
                                </p>

                                <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-2">
                                    <?php echo htmlspecialchars($timeline['title']); ?>
                                </h3>

                                <p class="text-gray-600 text-sm md:text-base leading-relaxed mb-4">
                                    <?php echo htmlspecialchars($timeline['description']); ?>
                                </p>
                            </div>
                        </div>

                        <!-- Timeline Image -->
                        <div class="md:col-span-5 order-1 md:order-2 mb-4 md:mb-0">
                            <img src="dashboard/<?php echo htmlspecialchars($timeline['image']); ?>"
                                alt="<?php echo htmlspecialchars($timeline['title']); ?>"
                                class="w-full h-44 sm:h-56 md:h-64 lg:h-[300px] object-cover rounded-lg shadow-lg">
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>

                <div class="text-center py-12">
                    <h3 class="text-xl font-semibold text-gray-600 mb-4">Timeline Coming Soon</h3>
                    <p class="text-gray-500">We're working on documenting our journey. Stay tuned!</p>
                </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Works -->
        <section class="py-10 bg-white">
            <div class="container px-4">
                <?php if (!empty($works)): ?>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">
                    <?php foreach ($works as $work): ?>
                    <!-- Image -->
                    <div class="relative aspect-[4/3] w-full max-w-[700px] mx-auto order-2 lg:order-1 work-image">
                        <img src="dashboard/<?php echo htmlspecialchars($work['image']); ?>"
                            alt="<?php echo htmlspecialchars($work['title']); ?>"
                            class="absolute inset-0 w-full h-full object-cover">
                    </div>

                    <!-- Content -->
                    <div
                        class="max-w-lg mx-auto lg:mx-0 flex flex-col justify-center gap-4 order-1 lg:order-2 work-content">
                        <p class="text-gray-500 text-sm sm:text-base mb-2 work-text">
                            <?php echo htmlspecialchars($work['text']); ?>
                        </p>

                        <h3 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-4 work-title">
                            <?php echo htmlspecialchars($work['title']); ?>
                        </h3>

                        <p class="text-gray-500 text-sm sm:text-base mb-6 work-description">
                            <?php echo htmlspecialchars($work['description']); ?>
                        </p>

                        <a href="#"
                            class="inline-block px-6 sm:px-8 py-2.5 sm:py-3 bg-blue-600 text-white font-semibold rounded-full shadow-lg hover:bg-blue-700 transition duration-300 w-fit text-sm sm:text-base work-cta">
                            Let's Work
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="text-center py-12">
                    <h3 class="text-xl font-semibold text-gray-600 mb-4">Works Coming Soon</h3>
                    <p class="text-gray-500">We're working on showcasing our amazing works. Stay tuned!</p>
                </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Projects -->
        <section class="py-8 sm:py-12 md:py-16 bg-white" id="projects">
            <div class="container px-4">
                <div class="flex flex-col gap-3 sm:gap-4 items-center justify-center text-center max-w-2xl mx-auto">
                    <span class="text-gray-500 text-sm sm:text-base">Projects</span>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900">Success Projects</h2>
                    <p class="text-gray-500 text-sm sm:text-base">Lörem ipsum astrobel sar direlig.
                        Kronde est</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 md:gap-8 mt-8 sm:mt-12 md:mt-20">
                    <!-- Card Besar Kiri -->
                    <?php if (isset($projects[0])): ?>
                    <div class="relative rounded-2xl sm:rounded-3xl overflow-hidden min-h-[300px] sm:min-h-[400px] md:min-h-[480px] flex items-end shadow-lg project-card"
                        style="background-image: url('dashboard/<?php echo htmlspecialchars($projects[0]['image']); ?>'); background-size: cover; background-position: center;">
                        <div class="bg-gradient-to-t from-black/80 to-transparent p-4 sm:p-6 md:p-8 w-full">
                            <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">
                                <?php echo htmlspecialchars($projects[0]['title']); ?></h3>
                            <p class="text-white text-sm sm:text-base mb-3 sm:mb-4">
                                <?php echo htmlspecialchars($projects[0]['description']); ?></p>
                            <a href="#"
                                class="inline-block px-4 sm:px-6 py-2 bg-white text-gray-900 font-semibold rounded-full shadow hover:bg-gray-200 transition text-sm sm:text-base">Let's
                                work</a>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Dua Card Kecil Kanan -->
                    <div class="flex flex-col gap-4 sm:gap-6 md:gap-8">
                        <?php foreach (array_slice($projects, 1, 2) as $project): ?>
                        <div class="relative rounded-2xl sm:rounded-3xl overflow-hidden min-h-[200px] sm:min-h-[240px] md:min-h-[280px] flex items-end shadow-lg project-card"
                            style="background-image: url('dashboard/<?php echo htmlspecialchars($project['image']); ?>'); background-size: cover; background-position: center;">
                            <div class="bg-gradient-to-t from-black/80 to-transparent p-4 sm:p-6 w-full">
                                <h3 class="text-lg sm:text-xl font-bold text-white mb-1">
                                    <?php echo htmlspecialchars($project['title']); ?></h3>
                                <p class="text-white mb-2 text-xs sm:text-sm">
                                    <?php echo htmlspecialchars($project['description']); ?></p>
                                <a href="#"
                                    class="inline-block px-3 sm:px-4 py-1.5 bg-white text-gray-900 font-semibold rounded-full shadow hover:bg-gray-200 transition text-xs sm:text-sm">Let's
                                    work</a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Inspirations -->
        <section class="py-12 bg-white relative min-h-full sm:min-h-screen">
            <div class="container px-4">
                <div class="mb-10">
                    <span class="text-sm text-gray-400 inspiration-subtitle">Inspiration</span>
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-900 mb-2 inspiration-title">UI
                        Design Exploration</h1>
                    <p class="text-gray-400 text-base sm:text-lg max-w-2xl inspiration-description">
                        Explore a sea of wit that is impossible to resist. Get inspired by the best UI design
                        collections.
                    </p>
                </div>

                <?php if (!empty($inspirations)): ?>
                <!-- Mobile Scroll Container -->
                <div class="md:hidden overflow-x-auto pb-4 -mx-4 px-4">
                    <div class="flex gap-4" style="min-width: max-content;">
                        <?php foreach ($inspirations as $inspiration): ?>
                        <div
                            class="relative group overflow-hidden rounded-xl shadow-lg w-[240px] aspect-[4/3] flex-shrink-0 inspiration-card">
                            <img src="dashboard/<?php echo htmlspecialchars($inspiration['image']); ?>"
                                alt="Inspiration"
                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110 group-hover:brightness-75" />
                            <div
                                class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition bg-black/40">
                                <span
                                    class="text-white text-lg font-semibold"><?php echo htmlspecialchars($inspiration['title'] ?? 'Inspiration'); ?></span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Desktop Absolute Layout -->
                <div class="hidden md:block">
                    <!-- First Row -->
                    <div class="absolute top-[250px] left-0">
                        <div class="grid grid-cols-5 gap-6">
                            <?php 
                            $firstRow = array_slice($inspirations, 0, 5);
                            foreach ($firstRow as $inspiration): 
                            ?>
                            <div class="relative group overflow-hidden rounded-xl shadow-lg inspiration-card">
                                <img src="dashboard/<?php echo htmlspecialchars($inspiration['image']); ?>"
                                    alt="Inspiration"
                                    class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-110 group-hover:brightness-75" />
                                <div
                                    class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition bg-black/40">
                                    <span
                                        class="text-white text-lg font-semibold"><?php echo htmlspecialchars($inspiration['title'] ?? 'Inspiration'); ?></span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Second Row -->
                    <div class="absolute top-[550px] left-0">
                        <div class="grid grid-cols-5 gap-2">
                            <?php 
                            $secondRow = array_slice($inspirations, 5, 5);
                            foreach ($secondRow as $inspiration): 
                            ?>
                            <div class="relative group overflow-hidden rounded-xl shadow-lg inspiration-card">
                                <img src="dashboard/<?php echo htmlspecialchars($inspiration['image']); ?>"
                                    alt="Inspiration"
                                    class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-110 group-hover:brightness-75" />
                                <div
                                    class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition bg-black/40">
                                    <span
                                        class="text-white text-lg font-semibold"><?php echo htmlspecialchars($inspiration['title'] ?? 'Inspiration'); ?></span>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="text-center py-12">
                    <h3 class="text-xl font-semibold text-gray-600 mb-4">No Inspirations Available</h3>
                    <p class="text-gray-500">Check back later for new inspiration designs.</p>
                </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Testimonials -->
        <section class="py-8 sm:py-12 bg-white">
            <div class="container px-4">
                <div
                    class="flex flex-col gap-2 sm:gap-3 md:gap-4 items-center justify-center text-center max-w-2xl mx-auto">
                    <span class="text-gray-500 text-xs sm:text-sm md:text-base testimonials-subtitle">Testimonial</span>
                    <h2 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 testimonials-title">
                        What our customer
                        say</h2>
                    <p class="text-gray-500 text-xs sm:text-sm md:text-base testimonials-description">Lörem ipsum
                        astrobel sar direlig. Kronde
                        est</p>
                </div>

                <?php if (!empty($testimonials)): ?>
                <div class="relative mt-6 sm:mt-8 md:mt-12 lg:mt-16">
                    <!-- Slider Container -->
                    <div class="testimonial-slider overflow-hidden cursor-grab active:cursor-grabbing">
                        <div class="testimonial-track flex transition-transform duration-500 ease-in-out">
                            <?php foreach ($testimonials as $testimonial): ?>
                            <div class="testimonial-slide min-w-full px-2 sm:px-4 flex items-center justify-center">
                                <div
                                    class="relative bg-white py-6 sm:py-8 md:py-12 px-3 sm:px-6 md:px-8 rounded-xl sm:rounded-2xl w-full mx-auto flex flex-col items-center text-center">
                                    <!-- Kutipan besar kiri atas -->
                                    <div
                                        class="absolute left-4 sm:left-8 md:left-16 lg:left-32 top-2 sm:top-4 md:top-6 text-3xl sm:text-4xl md:text-5xl text-gray-200 select-none">
                                        &#8220;</div>

                                    <!-- Logo dan nama perusahaan -->
                                    <div class="flex flex-col items-center mb-4 sm:mb-6">
                                        <?php if (!empty($testimonial['image'])): ?>
                                        <img src="dashboard/<?php echo htmlspecialchars($testimonial['image']); ?>"
                                            alt="Logo"
                                            class="h-12 sm:h-16 md:h-20 lg:h-24 mb-2 object-contain mx-auto" />
                                        <?php endif; ?>
                                        <?php if (!empty($testimonial['company'])): ?>
                                        <span
                                            class="text-gray-700 font-medium text-sm sm:text-base flex items-center gap-2">
                                            <?php echo htmlspecialchars($testimonial['company']); ?>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                    <!-- Pesan testimonial -->
                                    <p
                                        class="text-gray-800 text-sm sm:text-base md:text-lg lg:text-xl leading-relaxed mb-4 sm:mb-6 md:mb-8">
                                        <?php echo htmlspecialchars($testimonial['message']); ?>
                                    </p>
                                    <!-- Nama pemberi testimonial -->
                                    <div class="flex flex-col items-center mt-2 sm:mt-4">
                                        <span class="text-gray-900 font-bold text-sm sm:text-base md:text-lg mb-1">
                                            <?php echo htmlspecialchars($testimonial['name']); ?>
                                        </span>
                                        <span class="text-gray-700 font-bold text-sm sm:text-base md:text-lg mb-1">
                                            <?php if (!empty($testimonial['name2'])) echo ' & ' . htmlspecialchars($testimonial['name2']); ?>
                                        </span>
                                        <span class="text-gray-900 font-bold text-sm sm:text-base md:text-lg mb-1">
                                            <?php if (!empty($testimonial['name3'])) echo htmlspecialchars($testimonial['name3']); ?>
                                        </span>
                                        <span class="text-gray-500 text-xs sm:text-sm mt-1">
                                            <?php echo htmlspecialchars($testimonial['job']); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="text-center py-12">
                    <h3 class="text-xl font-semibold text-gray-600 mb-4">No Testimonials Available</h3>
                    <p class="text-gray-500">Check back later for customer testimonials.</p>
                </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Contact -->
        <section class="py-10 bg-gradient-to-b from-white to-gray-50" id="contact">
            <div class="container px-4">
                <div class="flex flex-col items-center justify-center">
                    <div class="mb-6">
                        <span
                            class="inline-flex items-center gap-2 px-4 py-1 rounded-full border border-gray-300 bg-white text-gray-700 text-xs font-medium shadow-sm hover:bg-gray-100 transition">
                            <i class='bx bx-envelope text-blue-600'></i>
                            Contact Us
                        </span>
                    </div>
                    <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-4 text-center">Let's Talk</h1>
                    <p class="text-gray-500 text-center max-w-xl mb-12">Join us as we explore tailored solutions,
                        discuss industry insights, and collaborate to find the best strategies for your success.</p>

                    <div class="w-full max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Contact Info -->
                        <div class="bg-white rounded-2xl shadow-lg p-8 lg:p-12 flex flex-col gap-8 contact-info">
                            <div class="flex flex-col gap-6">
                                <h2 class="text-2xl font-bold text-gray-900">Get in Touch</h2>
                                <p class="text-gray-600">We'd love to hear from you. Please fill out this form or shoot
                                    us an email.</p>
                            </div>

                            <div class="flex flex-col gap-6">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                        <i class='bx bx-map text-blue-600 text-xl'></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Alamat</h3>
                                        <p class="text-gray-600">Jl. Daun Karya Raya B1 No. 14 Kalisuren, Tajurhalang
                                            Kab. Bogor
                                            Jawa Barat
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                        <i class='bx bx-phone text-blue-600 text-xl'></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Phone Number</h3>
                                        <p class="text-gray-600">+1 (555) 123-4567</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                        <i class='bx bx-envelope text-blue-600 text-xl'></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Email Address</h3>
                                        <p class="text-gray-600">contact@example.com</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex gap-4 mt-4">
                                <a href="#"
                                    class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center hover:bg-blue-100 transition">
                                    <i class='bx bxl-facebook text-gray-600 hover:text-blue-600'></i>
                                </a>
                                <a href="#"
                                    class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center hover:bg-blue-100 transition">
                                    <i class='bx bxl-twitter text-gray-600 hover:text-blue-600'></i>
                                </a>
                                <a href="#"
                                    class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center hover:bg-blue-100 transition">
                                    <i class='bx bxl-linkedin text-gray-600 hover:text-blue-600'></i>
                                </a>
                                <a href="#"
                                    class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center hover:bg-blue-100 transition">
                                    <i class='bx bxl-instagram text-gray-600 hover:text-blue-600'></i>
                                </a>
                            </div>
                        </div>

                        <!-- Contact Form -->
                        <div class="bg-white rounded-2xl shadow-lg p-8 lg:p-20 contact-form">
                            <?php if (isset($_SESSION['success'])): ?>
                            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                                <?php 
                                echo $_SESSION['success'];
                                unset($_SESSION['success']);
                                ?>
                            </div>
                            <?php endif; ?>

                            <?php if (isset($_SESSION['error'])): ?>
                            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                                <?php 
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                                ?>
                            </div>
                            <?php endif; ?>

                            <form class="flex flex-col gap-6" action="process_contact.php" method="POST">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="name">
                                            <i class='bx bx-user text-blue-600 mr-1'></i>
                                            Full name
                                        </label>
                                        <input
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            type="text" id="name" name="name" placeholder="John Doe" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="email">
                                            <i class='bx bx-envelope text-blue-600 mr-1'></i>
                                            Email
                                        </label>
                                        <input
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            type="email" id="email" name="email" placeholder="john@example.com"
                                            required>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="subject">
                                        <i class='bx bx-message-square-detail text-blue-600 mr-1'></i>
                                        Subject
                                    </label>
                                    <input
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                        type="text" id="subject" name="subject" placeholder="How can we help?" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2" for="message">
                                        <i class='bx bx-message text-blue-600 mr-1'></i>
                                        Message
                                    </label>
                                    <textarea
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition min-h-[150px]"
                                        id="message" name="message" placeholder="Your message here..."
                                        required></textarea>
                                </div>

                                <button type="submit"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition flex items-center justify-center gap-2">
                                    <i class='bx bx-send'></i>
                                    Send Message
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <?php include 'components/footer/footer.php'; ?>

    <!-- Toast Notification -->
    <div id="toast" class="fixed top-4 right-4 z-50 hidden">
        <div class="flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
            role="alert">
            <div id="toast-icon"
                class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                <i class='bx bx-check text-xl'></i>
            </div>
            <div class="ml-3 text-sm font-normal" id="toast-message"></div>
            <button type="button"
                class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                onclick="hideToast()">
                <i class='bx bx-x text-xl'></i>
            </button>
        </div>
    </div>

    <!-- Main Js -->
    <script src="js/main.js"></script>
    <script src="js/toast.js"></script>
    <script src="js/animations.js"></script>
    <?php if (isset($_SESSION['toast'])): ?>
    <script>
    showToast("<?php echo $_SESSION['toast']['message']; ?>", "<?php echo $_SESSION['toast']['type']; ?>");
    </script>
    <?php 
    unset($_SESSION['toast']);
    endif; 
    ?>
</body>

</html>