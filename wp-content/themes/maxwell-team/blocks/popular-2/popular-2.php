
<!-- Hero Sekcija -->
 <?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
?>
<!-- Popular Tours Section - Version 2 -->
    <section class="py-8 sm:py-12 lg:py-18 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <span class="text-primary font-semibold">ALTERNATIVE LAYOUT</span>
                <h2 class="h2-responsive mt-2 mb-4">Featured Experiences</h2>
                <p class="text-gray-600 max-w-2xl mx-auto text-lg">A different presentation of our most popular tours with emphasis on visual appeal.</p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Tour 1 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg">
                    <div class="md:flex">
                        <div class="md:w-2/5 bg-gradient-to-b from-blue-400 to-blue-600 p-8 flex flex-col justify-between text-white">
                            <div>
                                <h3 class="text-2xl font-bold mb-2">Lake Bled & Bohinj</h3>
                                <p class="text-white/80 mb-4">Full day scenic tour</p>
                                <div class="flex items-center mb-6">
                                    <div class="flex text-amber-400 mr-2">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <span class="text-white/80">(48 reviews)</span>
                                </div>
                            </div>
                            <div class="text-3xl font-bold">From €120</div>
                        </div>
                        <div class="md:w-3/5 p-8">
                            <ul class="space-y-3 mb-6">
                                <li class="flex items-center text-gray-600">
                                    <i class="fas fa-check text-primary mr-2"></i>
                                    <span>Bled Castle visit</span>
                                </li>
                                <li class="flex items-center text-gray-600">
                                    <i class="fas fa-check text-primary mr-2"></i>
                                    <span>Pletna boat ride (optional)</span>
                                </li>
                                <li class="flex items-center text-gray-600">
                                    <i class="fas fa-check text-primary mr-2"></i>
                                    <span>Bohinj Lake viewpoints</span>
                                </li>
                                <li class="flex items-center text-gray-600">
                                    <i class="fas fa-check text-primary mr-2"></i>
                                    <span>Traditional lunch stop</span>
                                </li>
                            </ul>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600"><i class="fas fa-clock mr-1"></i> 8 hours</span>
                                <a href="#" class="bg-primary text-white px-4 py-2 rounded-xl font-medium hover:bg-blue-700 transition">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tour 2 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg">
                    <div class="md:flex">
                        <div class="md:w-2/5 bg-gradient-to-b from-amber-400 to-amber-600 p-8 flex flex-col justify-between text-white">
                            <div>
                                <h3 class="h3-responsive mb-2">Vipava Valley Wine Tour</h3>
                                <p class="text-white/80 mb-4">Wine tasting experience</p>
                                <div class="flex items-center mb-6">
                                    <div class="flex text-amber-400 mr-2">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <span class="text-white/80">(36 reviews)</span>
                                </div>
                            </div>
                            <div class="text-3xl font-bold">From €90</div>
                        </div>
                        <div class="md:w-3/5 p-8">
                            <ul class="space-y-3 mb-6">
                                <li class="flex items-center text-gray-600">
                                    <i class="fas fa-check text-primary mr-2"></i>
                                    <span>3 premium winery visits</span>
                                </li>
                                <li class="flex items-center text-gray-600">
                                    <i class="fas fa-check text-primary mr-2"></i>
                                    <span>Wine tasting sessions</span>
                                </li>
                                <li class="flex items-center text-gray-600">
                                    <i class="fas fa-check text-primary mr-2"></i>
                                    <span>Local cheese pairing</span>
                                </li>
                                <li class="flex items-center text-gray-600">
                                    <i class="fas fa-check text-primary mr-2"></i>
                                    <span>Vineyard tour</span>
                                </li>
                            </ul>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600"><i class="fas fa-clock mr-1"></i> 6 hours</span>
                                <a href="#" class="bg-primary text-white px-4 py-2 rounded-xl font-medium hover:bg-blue-700 transition">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tour 3 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg">
                    <div class="md:flex">
                        <div class="md:w-2/5 bg-gradient-to-b from-green-400 to-green-600 p-8 flex flex-col justify-between text-white">
                            <div>
                                <h3 class="h3-responsive mb-2">Postojna Cave & Predjama Castle</h3>
                                <p class="text-white/80 mb-4">Historical adventure</p>
                                <div class="flex items-center mb-6">
                                    <div class="flex text-amber-400 mr-2">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <span class="text-white/80">(52 reviews)</span>
                                </div>
                            </div>
                            <div class="text-3xl font-bold">From €80</div>
                        </div>
                        <div class="md:w-3/5 p-8">
                            <ul class="space-y-3 mb-6">
                                <li class="flex items-center text-gray-600">
                                    <i class="fas fa-check text-primary mr-2"></i>
                                    <span>Postojna Cave train ride</span>
                                </li>
                                <li class="flex items-center text-gray-600">
                                    <i class="fas fa-check text-primary mr-2"></i>
                                    <span>Predjama Castle tour</span>
                                </li>
                                <li class="flex items-center text-gray-600">
                                    <i class="fas fa-check text-primary mr-2"></i>
                                    <span>Underground river viewing</span>
                                </li>
                                <li class="flex items-center text-gray-600">
                                    <i class="fas fa-check text-primary mr-2"></i>
                                    <span>Audio guides included</span>
                                </li>
                            </ul>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600"><i class="fas fa-clock mr-1"></i> 5 hours</span>
                                <a href="#" class="bg-primary text-white px-4 py-2 rounded-xl font-medium hover:bg-blue-700 transition">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tour 4 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg">
                    <div class="md:flex">
                        <div class="md:w-2/5 bg-gradient-to-b from-purple-400 to-purple-600 p-8 flex flex-col justify-between text-white">
                            <div>
                                <h3 class="h3-responsive mb-2">Zagreb City Transfer</h3>
                                <p class="text-white/80 mb-4">International trip</p>
                                <div class="flex items-center mb-6">
                                    <div class="flex text-amber-400 mr-2">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <span class="text-white/80">(29 reviews)</span>
                                </div>
                            </div>
                            <div class="text-3xl font-bold">From €150</div>
                        </div>
                        <div class="md:w-3/5 p-8">
                            <ul class="space-y-3 mb-6">
                                <li class="flex items-center text-gray-600">
                                    <i class="fas fa-check text-primary mr-2"></i>
                                    <span>Direct to city center</span>
                                </li>
                                <li class="flex items-center text-gray-600">
                                    <i class="fas fa-check text-primary mr-2"></i>
                                    <span>Optional city tour</span>
                                </li>
                                <li class="flex items-center text-gray-600">
                                    <i class="fas fa-check text-primary mr-2"></i>
                                    <span>Border crossing assistance</span>
                                </li>
                                <li class="flex items-center text-gray-600">
                                    <i class="fas fa-check text-primary mr-2"></i>
                                    <span>Multilingual driver</span>
                                </li>
                            </ul>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600"><i class="fas fa-clock mr-1"></i> 2.5 hours</span>
                                <a href="#" class="bg-primary text-white px-4 py-2 rounded-xl font-medium hover:bg-blue-700 transition">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>