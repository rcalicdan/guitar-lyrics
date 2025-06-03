@extends('layouts.homepage')

@section('title', 'About Us - Guitar Lyrics & Chords')

@section('content')
<div class="container-fluid p-0">
    <!-- Hero Section with Gradient -->
    <section class="hero-gradient text-white py-5 position-relative overflow-hidden">
        <div class="hero-overlay"></div>
        <div class="container position-relative">
            <div class="row align-items-center min-vh-50">
                <div class="col-lg-7">
                    <div class="hero-content">
                        <h1 class="display-3 fw-bold mb-4 text-shadow">About Guitar Lyrics & Chords</h1>
                        <p class="lead mb-4 fs-5 opacity-90">Empowering musicians worldwide with comprehensive chord charts, accurate lyrics, and innovative learning tools for over a decade.</p>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="badge-item">
                                <i class="fas fa-users me-2"></i>
                                <span>Community Driven</span>
                            </div>
                            <div class="badge-item">
                                <i class="fas fa-music me-2"></i>
                                <span>Great Songs</span>
                            </div>
                            <div class="badge-item">
                                <i class="fas fa-star me-2"></i>
                                <span>Industry Leading</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 text-center">
                    <div class="hero-icon-container">
                        <i class="fas fa-guitar hero-icon"></i>
                        <div class="floating-notes">
                            <i class="fas fa-music note-1"></i>
                            <i class="fas fa-music note-2"></i>
                            <i class="fas fa-music note-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Company Overview -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center mb-5">
                    <h2 class="section-title">Leading the Future of Music Education</h2>
                    <p class="section-subtitle">We are a technology-driven music platform dedicated to democratizing music education through innovative digital solutions.</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="professional-card h-100">
                        <div class="card-icon-wrapper">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4>Market Leadership</h4>
                        <p class="text-muted">Recognized as the premier destination for guitar learning resources, serving musicians across 50+ countries.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="professional-card h-100">
                        <div class="card-icon-wrapper">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h4>Innovation Focus</h4>
                        <p class="text-muted">Continuously developing cutting-edge features powered by music theory and user experience research.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="professional-card h-100">
                        <div class="card-icon-wrapper">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4>Quality Assurance</h4>
                        <p class="text-muted">Every chord chart and lyric undergoes rigorous verification by our team of professional musicians.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-5 mission-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="mission-content">
                        <h2 class="section-title text-white mb-4">Our Mission & Vision</h2>
                        <div class="mission-item mb-4">
                            <h4 class="text-white mb-3">
                                <i class="fas fa-bullseye text-warning me-3"></i>Mission
                            </h4>
                            <p class="text-light">To provide the world's most comprehensive and accurate collection of guitar chords and lyrics, making music learning accessible to everyone regardless of skill level or location.</p>
                        </div>
                        <div class="mission-item">
                            <h4 class="text-white mb-3">
                                <i class="fas fa-eye text-warning me-3"></i>Vision
                            </h4>
                            <p class="text-light">To become the global standard for digital music education, empowering the next generation of musicians through technology and community.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-number">10K+</div>
                            <div class="stat-label">Songs Available</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">50K+</div>
                            <div class="stat-label">Active Users</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">95%</div>
                            <div class="stat-label">Accuracy Rate</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">24/7</div>
                            <div class="stat-label">Support</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center mb-5">
                    <h2 class="section-title">Our Core Values</h2>
                    <p class="section-subtitle">The principles that guide our every decision and innovation</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <h5>Excellence</h5>
                        <p>Commitment to delivering the highest quality musical content and user experience.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h5>Accessibility</h5>
                        <p>Making music education available to everyone, regardless of background or ability.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <h5>Innovation</h5>
                        <p>Continuously pushing boundaries to enhance the music learning experience.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="value-card">
                        <div class="value-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h5>Community</h5>
                        <p>Building a supportive global community of passionate musicians and learners.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Leadership Team -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center mb-5">
                    <h2 class="section-title">Leadership Team</h2>
                    <p class="section-subtitle">Meet the experts driving our mission forward</p>
                </div>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="team-card">
                        <div class="team-avatar">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="team-info">
                            <h5>Executive Leadership</h5>
                            <p class="text-primary fw-semibold">Chief Executive Officer</p>
                            <p class="text-muted small">Leading strategic vision and company growth with 15+ years in music technology.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="team-card">
                        <div class="team-avatar">
                            <i class="fas fa-code"></i>
                        </div>
                        <div class="team-info">
                            <h5>Technical Leadership</h5>
                            <p class="text-primary fw-semibold">Chief Technology Officer</p>
                            <p class="text-muted small">Driving technical innovation and platform architecture with expertise in scalable systems.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="team-card">
                        <div class="team-avatar">
                            <i class="fas fa-music"></i>
                        </div>
                        <div class="team-info">
                            <h5>Music Direction</h5>
                            <p class="text-primary fw-semibold">Head of Content</p>
                            <p class="text-muted small">Ensuring musical accuracy and quality with professional performance background.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact CTA -->
    <section class="py-5 cta-gradient text-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="mb-4">Partner With Us</h2>
                    <p class="lead mb-4">Interested in collaboration, partnership opportunities, or have questions about our platform?</p>
                    <div class="row g-4 mt-4">
                        <div class="col-md-4">
                            <div class="contact-method">
                                <i class="fas fa-envelope fa-2x mb-3"></i>
                                <h6>Business Inquiries</h6>
                                <a href="mailto:business@guitarlyricsandchords.com" class="text-white text-decoration-none">business@guitarlyricsandchords.com</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="contact-method">
                                <i class="fas fa-phone fa-2x mb-3"></i>
                                <h6>Support Line</h6>
                                <a href="tel:+1234567890" class="text-white text-decoration-none">+1 (234) 567-8900</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="contact-method">
                                <i class="fas fa-map-marker-alt fa-2x mb-3"></i>
                                <h6>Headquarters</h6>
                                <span>San Francisco, CA</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    :root {
        --primary-color: #2D3436;
        --accent-color: #6C5CE7;
        --gradient-start: #6C5CE7;
        --gradient-end: #a17fe0;
    }

    /* Hero Section */
    .hero-gradient {
        background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
        position: relative;
    }

    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.1);
    }

    .min-vh-50 {
        min-height: 50vh;
    }

    .text-shadow {
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .badge-item {
        background: rgba(255, 255, 255, 0.2);
        padding: 8px 16px;
        border-radius: 25px;
        backdrop-filter: blur(10px);
        font-size: 0.9rem;
        font-weight: 500;
    }

    .hero-icon-container {
        position: relative;
    }

    .hero-icon {
        font-size: 8rem;
        opacity: 0.9;
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
    }

    .floating-notes {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }

    .floating-notes i {
        position: absolute;
        animation: float 6s ease-in-out infinite;
    }

    .note-1 { top: 20%; left: 10%; animation-delay: 0s; }
    .note-2 { top: 60%; right: 20%; animation-delay: 2s; }
    .note-3 { bottom: 30%; left: 70%; animation-delay: 4s; }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }

    /* Professional Cards */
    .professional-card {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 1px solid rgba(108, 92, 231, 0.1);
    }

    .professional-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(108, 92, 231, 0.15);
    }

    .card-icon-wrapper {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
    }

    .card-icon-wrapper i {
        color: white;
        font-size: 1.5rem;
    }

    /* Section Styling */
    .section-title {
        color: var(--primary-color);
        font-weight: 700;
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .section-subtitle {
        color: #6c757d;
        font-size: 1.1rem;
        line-height: 1.6;
    }

    /* Mission Section */
    .mission-section {
        background: linear-gradient(135deg, var(--primary-color) 0%, #636e72 100%);
    }

    .mission-item {
        background: rgba(255, 255, 255, 0.1);
        padding: 1.5rem;
        border-radius: 8px;
        backdrop-filter: blur(10px);
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.15);
        padding: 2rem 1.5rem;
        border-radius: 12px;
        text-align: center;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: white;
        line-height: 1;
    }

    .stat-label {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.9rem;
        margin-top: 0.5rem;
    }

    /* Value Cards */
    .value-card {
        background: white;
        padding: 2rem 1.5rem;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
    }

    .value-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(108, 92, 231, 0.15);
    }

    .value-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }

    .value-icon i {
        color: white;
        font-size: 1.8rem;
    }

    /* Team Cards */
    .team-card {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .team-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(108, 92, 231, 0.15);
    }

    .team-avatar {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }

    .team-avatar i {
        color: white;
        font-size: 2rem;
    }

    /* CTA Section */
    .cta-gradient {
        background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
    }

    .contact-method {
        padding: 1rem;
    }

    .contact-method i {
        opacity: 0.9;
    }

    .contact-method h6 {
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero-icon {
            font-size: 4rem;
        }
        
        .section-title {
            font-size: 2rem;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .stat-number {
            font-size: 2rem;
        }
    }

    /* Custom Colors */
    .text-primary {
        color: var(--accent-color) !important;
    }

    .bg-primary {
        background-color: var(--accent-color) !important;
    }
</style>
@endpush