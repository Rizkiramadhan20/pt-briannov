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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Kreasi Digital</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style/style.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {}
        }
    }
    </script>
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <?php include 'components/header/header.php'; ?>

    <!-- Main Content -->
    <main class="overflow-hidden">
        <!-- Home -->
        <section class="py-8 sm:py-16 bg-gray-50 min-h-screen flex items-center justify-center">
            <div class="container px-4 text-center flex flex-col gap-4">
                <?php if (!empty($contents)):
                // Get the first item from the fetched data to use for the hero section
                $hero_content = $contents[0];
                ?>

                <p class="text-sm text-gray-600 mb-2">Designing With Us</p>

                <h1
                    class="mx-auto text-3xl sm:text-4xl md:text-5xl lg:text-6xl max-w-3xl font-bold text-gray-900 leading-tight mb-4 px-4">
                    <?php echo htmlspecialchars($hero_content['title']); ?>
                </h1>

                <p class="text-sm sm:text-base lg:text-lg text-gray-700 mb-6 sm:mb-8 max-w-2xl mx-auto px-4">
                    <?php echo htmlspecialchars($hero_content['description']); ?>
                </p>

                <!-- Services/Skills List -->
                <ul class="flex flex-wrap justify-center gap-3 sm:gap-4 md:gap-10 text-gray-600 mb-8 sm:mb-12 px-4">
                    <?php foreach ($hero_content['framework'] as $framework): ?>
                    <li class="text-xs sm:text-sm md:text-base">• <?php echo htmlspecialchars($framework); ?></li>
                    <?php endforeach; ?>
                </ul>

                <!-- Call to Action Button -->
                <a href="<?php echo htmlspecialchars($hero_content['href']); ?>" target="_blank"
                    class="inline-block px-5 sm:px-6 md:px-8 w-fit mx-auto py-2.5 sm:py-3 bg-blue-600 text-white font-semibold text-sm sm:text-base md:text-lg rounded-full shadow-lg hover:bg-blue-700 transition duration-300">
                    <span><?php echo htmlspecialchars($hero_content['labels']); ?></span>
                </a>

                <!-- Social Icons Placeholder -->
                <div
                    class="flex justify-center gap-3 sm:gap-4 md:gap-6 mt-6 sm:mt-8 md:mt-12 text-gray-600 text-lg sm:text-xl md:text-2xl">
                    <a href="#" class="hover:text-blue-600 transition-colors duration-200"><i
                            class='bx bxl-behance'></i></a>
                    <a href="#" class="hover:text-blue-600 transition-colors duration-200"><i
                            class='bx bxl-instagram'></i></a>
                    <a href="#" class="hover:text-blue-600 transition-colors duration-200"><i
                            class='bx bxl-linkedin'></i></a>
                </div>

                <!-- Weekly Growth and Client Trusted Placeholders -->
                <div class="hidden md:block absolute top-1/4 left-4 lg:left-10">
                    <img src="/assets/home/grow.png" alt="" class="w-24 lg:w-auto">
                </div>

                <div class="hidden md:block absolute top-1/4 right-4 lg:right-10">
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
                        <div class="w-20 h-20 sm:w-24 sm:h-24 md:w-32 md:h-32 flex items-center justify-center">
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
        <section class="py-10 bg-white">
            <div class="container px-4">
                <?php if ($about_content):
                ?>

                <div class="flex flex-col md:flex-row justify-evenly overflow-hidden">
                    <!-- Left Side - Image -->
                    <div class="relative">
                        <img src="dashboard/<?php echo htmlspecialchars($about_content['image']); ?>"
                            alt="About Us Image" class="w-full h-full object-cover lg:rounded-l-xl">
                    </div>

                    <!-- Right Side - Content -->
                    <div
                        class="flex p-4 sm:p-6 md:p-8 flex-col md:flex-row items-start md:items-center justify-center bg-gray-100 gap-6 md:gap-4 rounded rounded-md">
                        <div class="flex flex-col gap-4">
                            <h3 class="text-2xl md:text-3xl font-bold text-gray-900">
                                <?php echo htmlspecialchars($about_content['title']); ?>
                            </h3>

                            <p class="text-gray-700 text-sm md:text-base leading-relaxed">
                                <?php echo htmlspecialchars($about_content['text']); ?>
                            </p>
                        </div>

                        <?php if (!empty($about_content['metrics'])): ?>
                        <div class="flex flex-col md:flex-row items-start md:items-center gap-6 md:gap-8">
                            <div class="flex flex-wrap md:flex-nowrap gap-6 md:gap-8">
                                <?php foreach ($about_content['metrics'] as $index => $metric): ?>
                                <div class="flex flex-col items-start">
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
    </main>

    <!-- Footer based on the provided image -->
    <footer class="bg-white py-12 border-t border-gray-200">
        <div class="container max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Kreasi Digital</h3>
                <p class="text-sm text-gray-600 mb-6">
                    Prebör domisaning. Kemkastrering. Fagt kaskade. Bist decissa. Stereodiktisk
                    vasyns att preteng. Mons byning fihör. Pore tolig. Epire kanesk. Monosa
                    medelgam tisk.
                </p>
                <div class="flex gap-4 text-gray-600 text-xl">
                    <a href="#" class="hover:text-blue-600 transition-colors duration-200"><i
                            class='bx bxl-instagram'></i></a>
                    <a href="#" class="hover:text-blue-600 transition-colors duration-200"><i
                            class='bx bxl-whatsapp'></i></a>
                    <a href="#" class="hover:text-blue-600 transition-colors duration-200"><i
                            class='bx bxl-youtube'></i></a>
                    <a href="#" class="hover:text-blue-600 transition-colors duration-200"><i
                            class='bx bxl-linkedin'></i></a>
                    <a href="#" class="hover:text-blue-600 transition-colors duration-200"><i
                            class='bx bxl-twitter'></i></a>
                </div>
            </div>

            <div>
                <h4 class="font-bold text-gray-900 mb-4">Home</h4>
                <ul class="text-sm text-gray-600 space-y-2">
                    <li><a href="#" class="hover:text-blue-600 transition-colors duration-200">Beranda</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition-colors duration-200">Program Keahlian</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition-colors duration-200">Gallery</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition-colors duration-200">Our News</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-gray-900 mb-4">About</h4>
                <ul class="text-sm text-gray-600 space-y-2">
                    <li><a href="#" class="hover:text-blue-600 transition-colors duration-200">Beranda</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition-colors duration-200">Program Keahlian</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition-colors duration-200">Gallery</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition-colors duration-200">Our News</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-gray-900 mb-4">Contact</h4>
                <ul class="text-sm text-gray-600 space-y-3">
                    <li class="flex items-center gap-2">
                        <i class='bx bx-phone text-lg'></i>
                        <span>(406) 555-0120</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class='bx bx-envelope text-lg'></i>
                        <span>kreasi.digital@gmail.com</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class='bx bx-map-pin text-lg'></i>
                        <span>2972 Westheimer Rd. Santa Ana, Illinois 85486</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="container mx-auto px-4 mt-8 text-center text-sm text-gray-600">
            © 2022 Mangcoding. All rights reserved.
        </div>
    </footer>
</body>

</html>