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
        <section class="py-16 bg-gray-50 min-h-screen flex items-center justify-center">
            <div class="container px-4 text-center flex flex-col gap-4">
                <?php if (!empty($contents)):
                // Get the first item from the fetched data to use for the hero section
                $hero_content = $contents[0];
                ?>

                <p class="text-sm text-gray-600 mb-2">Designing With Us</p>

                <h1
                    class="mx-auto text-4xl sm:text-5xl md:text-6xl max-w-3xl font-bold text-gray-900 leading-tight mb-4 px-4">
                    <?php echo htmlspecialchars($hero_content['title']); ?>
                </h1>

                <p class="text-base sm:text-lg text-gray-700 mb-8 max-w-2xl mx-auto px-4">
                    <?php echo htmlspecialchars($hero_content['description']); ?>
                </p>

                <!-- Services/Skills List -->
                <ul class="flex flex-wrap justify-center gap-4 sm:gap-10 text-gray-600 mb-12 px-4">
                    <?php foreach ($hero_content['framework'] as $framework): ?>
                    <li class="text-sm sm:text-base">• <?php echo htmlspecialchars($framework); ?></li>
                    <?php endforeach; ?>
                </ul>

                <!-- Call to Action Button -->
                <a href="<?php echo htmlspecialchars($hero_content['href']); ?>" target="_blank"
                    class="inline-block px-6 sm:px-8 w-fit mx-auto py-3 bg-blue-600 text-white font-semibold text-base sm:text-lg rounded-full shadow-lg hover:bg-blue-700 transition duration-300">
                    <span><?php echo htmlspecialchars($hero_content['labels']); ?></span>
                </a>

                <!-- Social Icons Placeholder -->
                <div class="flex justify-center gap-4 sm:gap-6 mt-8 sm:mt-12 text-gray-600 text-xl sm:text-2xl">
                    <a href="#" class="hover:text-blue-600 transition-colors duration-200"><i
                            class='bx bxl-behance'></i></a>
                    <a href="#" class="hover:text-blue-600 transition-colors duration-200"><i
                            class='bx bxl-instagram'></i></a>
                    <a href="#" class="hover:text-blue-600 transition-colors duration-200"><i
                            class='bx bxl-linkedin'></i></a>
                </div>

                <!-- Weekly Growth and Client Trusted Placeholders -->
                <div class="hidden md:block absolute top-1/4 left-10">
                    <img src="/assets/home/grow.png" alt="" class="w-32 lg:w-auto">
                </div>

                <div class="hidden md:block absolute top-1/4 right-10">
                    <img src="/assets/home/trused.png" alt="" class="w-32 lg:w-auto">
                </div>

                <?php else: ?>
                <div class="text-center py-12 px-4">
                    <h3 class="text-xl sm:text-2xl font-semibold text-gray-600 mb-4">No Content Available</h3>
                    <p class="text-gray-500">Please check back later for updates.</p>
                </div>
                <?php endif; ?>

                <!-- patner -->
                <div class="mt-12 sm:mt-20 px-4">
                    <h3 class="text-lg sm:text-xl font-bold text-gray-400 text-center mb-8">Trusted Partners</h3>
                    <?php if (!empty($partners)): ?>

                    <div class="flex flex-wrap items-center justify-center gap-8 sm:gap-16">
                        <?php foreach ($partners as $partner): ?>
                        <div class="w-24 h-24 sm:w-32 sm:h-32 flex items-center justify-center">
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
        <section>
            <!-- You can add the partner section content here later -->
        </section>
    </main>

    <!-- Footer based on the provided image -->
    <footer class="bg-white py-12 border-t border-gray-200">
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8">
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