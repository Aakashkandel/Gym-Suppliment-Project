@extends('layouts.usermenu')

@section('content')
<style>
    :root {
        --primary-color: #2C3E50;
        --primary-light: #34495e;
        --primary-dark: #1a252f;
        --secondary-color: #F39C12;
        --secondary-light: #f4a62a;
        --secondary-dark: #d68910;
    }

    .hero-section {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
        color: white;
    }

    .feature-card {
        background: linear-gradient(145deg, #ffffff, #f8fafc);
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        border-color: var(--secondary-color);
    }

    .team-card {
        background: linear-gradient(145deg, #ffffff, #f8fafc);
        border: 2px solid transparent;
        background-clip: padding-box;
        transition: all 0.3s ease;
    }

    .team-card:hover {
        border-color: var(--secondary-color);
        transform: translateY(-5px);
        box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.15);
    }

    .section-title {
        color: var(--primary-color);
        position: relative;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(135deg, var(--secondary-color), var(--secondary-light));
        border-radius: 2px;
    }

    .stats-card {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: white;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: white;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: linear-gradient(135deg, var(--secondary-color), var(--secondary-light));
        color: white;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background: linear-gradient(135deg, var(--secondary-dark), var(--secondary-color));
        transform: translateY(-2px);
    }
</style>

<div class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <!-- Hero Section -->
    <section class="hero-section pt-20 pb-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h1 class="text-5xl md:text-6xl font-bold mb-6">
                    About <span style="color: var(--secondary-color);">Aakash Gym Supplements</span>
                </h1>
                <p class="text-xl opacity-90 max-w-3xl mx-auto">
                    Your trusted partner in fitness nutrition, providing premium quality supplements to help you achieve your fitness goals and build your best physique.
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row items-center gap-12 mb-16">
                <div class="lg:w-1/2">
                    <div class="relative">
                        <img src="{{ asset('clientimage/aboutus.jpg') }}" 
                             alt="About Aakash Gym Supplements" 
                             class="w-full h-auto rounded-2xl shadow-2xl">
                        <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-gradient-to-br from-orange-400 to-orange-600 rounded-2xl opacity-80"></div>
                    </div>
                </div>
                
                <div class="lg:w-1/2">
                    <div class="space-y-6">
                        <div>
                            <span class="inline-block px-4 py-2 bg-gradient-to-r from-orange-100 to-orange-200 text-orange-800 rounded-full text-sm font-semibold uppercase tracking-wider mb-4">
                                About Us
                            </span>
                            <h2 class="text-4xl font-bold mb-6" style="color: var(--primary-color);">
                                Empowering Your <span style="color: var(--secondary-color);">Fitness Journey</span>
                            </h2>
                        </div>
                        
                        <p class="text-gray-700 text-lg leading-relaxed">
                            Welcome to Aakash Gym Supplement, your go-to platform for high-quality gym supplements and fitness products. Our mission is to help fitness enthusiasts achieve their goals with premium supplements that meet the highest standards of quality and effectiveness.
                        </p>
                        
                        <div class="bg-gradient-to-r from-orange-50 to-orange-100 p-6 rounded-xl border-l-4" style="border-color: var(--secondary-color);">
                            <h3 class="font-bold text-lg mb-2" style="color: var(--primary-color);">Our Commitment</h3>
                            <p class="text-gray-700">
                                We are dedicated to offering supplements that meet the highest standards of quality and effectiveness. Our curated selection ensures that you get the best fitness products available in Nepal.
                            </p>
                        </div>
                        
                        <p class="text-gray-700 text-lg leading-relaxed">
                            Our goal is to make your shopping experience as smooth and efficient as possible. Whether you're looking for specific supplements or just exploring, we are here to help you find what you need with ease, all priced in Nepalese Rupees (Rs) for your convenience.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold section-title mb-16">Why Choose Us</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="feature-card rounded-2xl p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-6 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, var(--secondary-color), var(--secondary-light));">
                        <i class="fas fa-medal text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4" style="color: var(--primary-color);">Premium Quality</h3>
                    <p class="text-gray-600">
                        All our supplements are sourced from trusted manufacturers and meet international quality standards.
                    </p>
                </div>
                
                <div class="feature-card rounded-2xl p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-6 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, var(--secondary-color), var(--secondary-light));">
                        <i class="fas fa-shipping-fast text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4" style="color: var(--primary-color);">Fast Delivery</h3>
                    <p class="text-gray-600">
                        Quick and reliable delivery across Nepal with secure packaging to ensure product integrity.
                    </p>
                </div>
                
                <div class="feature-card rounded-2xl p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-6 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, var(--secondary-color), var(--secondary-light));">
                        <i class="fas fa-headset text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4" style="color: var(--primary-color);">Expert Support</h3>
                    <p class="text-gray-600">
                        Our fitness experts are available to help you choose the right supplements for your goals.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="stats-card rounded-2xl p-8 text-center">
                    <div class="text-4xl font-bold mb-2">500+</div>
                    <div class="text-sm opacity-90">Happy Customers</div>
                </div>
                <div class="stats-card rounded-2xl p-8 text-center">
                    <div class="text-4xl font-bold mb-2">100+</div>
                    <div class="text-sm opacity-90">Products Available</div>
                </div>
                <div class="stats-card rounded-2xl p-8 text-center">
                    <div class="text-4xl font-bold mb-2">24/7</div>
                    <div class="text-sm opacity-90">Customer Support</div>
                </div>
                <div class="stats-card rounded-2xl p-8 text-center">
                    <div class="text-4xl font-bold mb-2">99%</div>
                    <div class="text-sm opacity-90">Satisfaction Rate</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold section-title mb-16">Meet Our Team</h2>
            </div>
            
            <div class="max-w-md mx-auto">
                <div class="team-card rounded-2xl p-8 text-center">
                    <div class="relative mb-6">
                        <img class="w-40 h-40 rounded-full mx-auto object-cover shadow-lg" 
                             src="{{ asset('clientimage/image.png') }}" 
                             alt="Ishika Sigdel" />
                        <div class="absolute -bottom-2 -right-2 w-12 h-12 rounded-full flex items-center justify-center shadow-lg"
                             style="background: linear-gradient(135deg, var(--secondary-color), var(--secondary-light));">
                            <i class="fas fa-crown text-white"></i>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-2xl font-bold" style="color: var(--primary-color);">Aakash Kandel</h3>
                            <p class="text-lg font-semibold" style="color: var(--secondary-color);">Co-Founder & CEO</p>
                        </div>
                        
                        <p class="text-gray-700 leading-relaxed">
                            Co-founder of Aakash Gym Supplement, Aakash is passionate about providing high-quality fitness supplements and helping people achieve their fitness goals. With years of experience in the fitness industry, she ensures every product meets our quality standards.
                        </p>
                        
                        <div class="pt-4">
                            <a href="tel:9763639754" 
                               class="inline-flex items-center px-6 py-3 btn-secondary rounded-full font-semibold">
                                <i class="fas fa-phone mr-2"></i>
                                Contact: 977-9763639754
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16">
        <div class="container mx-auto px-4 text-center">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-4xl font-bold mb-6" style="color: var(--primary-color);">
                    Ready to Start Your <span style="color: var(--secondary-color);">Fitness Journey?</span>
                </h2>
                <p class="text-xl text-gray-600 mb-8">
                    Explore our wide range of premium supplements and take the first step towards achieving your fitness goals.
                </p>
                <div class="space-x-4">
                    <a href="{{route('user.shop')}}" 
                       class="inline-flex items-center px-8 py-4 btn-primary rounded-full text-lg font-semibold">
                        <i class="fas fa-shopping-cart mr-2"></i>
                        Shop Now
                    </a>
                    <a href="{{route('user.index')}}" 
                       class="inline-flex items-center px-8 py-4 btn-secondary rounded-full text-lg font-semibold">
                        <i class="fas fa-home mr-2"></i>
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
