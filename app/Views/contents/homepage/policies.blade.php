@extends('layouts.homepage')

@section('title', 'Privacy Policy - Guitar Lyrics & Chords')

@push('styles')
<style>
    .legal-content {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
        padding: 80px 0 60px;
    }
    
    .legal-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        padding: 3rem;
        margin-bottom: 2rem;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .legal-header {
        text-align: center;
        margin-bottom: 3rem;
        padding-bottom: 2rem;
        border-bottom: 3px solid #007bff;
    }
    
    .legal-title {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        color: #2c3e50;
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .legal-subtitle {
        font-family: 'Inter', sans-serif;
        color: #6c757d;
        font-size: 1.1rem;
        font-weight: 400;
    }
    
    .section-title {
        font-family: 'Montserrat', sans-serif;
        font-weight: 600;
        color: #007bff;
        font-size: 1.5rem;
        margin: 2.5rem 0 1rem 0;
        padding-left: 1rem;
        border-left: 4px solid #007bff;
        position: relative;
    }
    
    .section-title::before {
        content: '';
        position: absolute;
        left: -4px;
        top: 0;
        height: 100%;
        width: 4px;
        background: linear-gradient(135deg, #007bff, #0056b3);
        border-radius: 2px;
    }
    
    .legal-text {
        font-family: 'Inter', sans-serif;
        line-height: 1.8;
        color: #495057;
        font-size: 1rem;
        margin-bottom: 1.5rem;
        text-align: justify;
    }
    
    .legal-list {
        padding-left: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .legal-list li {
        font-family: 'Inter', sans-serif;
        line-height: 1.7;
        color: #495057;
        margin-bottom: 0.8rem;
        position: relative;
    }
    
    .legal-list li::marker {
        color: #007bff;
        font-weight: 600;
    }
    
    .contact-info {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 15px;
        padding: 2rem;
        margin-top: 3rem;
        border-left: 5px solid #007bff;
    }
    
    .contact-title {
        font-family: 'Montserrat', sans-serif;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 1rem;
    }
    
    .breadcrumb-nav {
        background: rgba(255, 255, 255, 0.9);
        padding: 1rem 0;
        margin-bottom: 2rem;
        border-radius: 10px;
        backdrop-filter: blur(10px);
    }
    
    .breadcrumb-nav .breadcrumb {
        margin-bottom: 0;
        background: transparent;
    }
    
    .breadcrumb-nav .breadcrumb-item a {
        color: #007bff;
        text-decoration: none;
        font-weight: 500;
    }
    
    .breadcrumb-nav .breadcrumb-item.active {
        color: #6c757d;
    }
    
    @media (max-width: 768px) {
        .legal-card {
            padding: 2rem 1.5rem;
            margin: 1rem;
        }
        
        .legal-title {
            font-size: 2rem;
        }
        
        .section-title {
            font-size: 1.3rem;
        }
    }
</style>
@endpush

@section('content')
<div class="legal-content">
    <div class="container">
        <!-- Breadcrumb -->
        <div class="breadcrumb-nav">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/"><i class="fas fa-home me-1"></i>Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Privacy Policy</li>
                </ol>
            </nav>
        </div>

        <div class="legal-card">
            <!-- Header -->
            <div class="legal-header">
                <h1 class="legal-title">
                    <i class="fas fa-shield-alt me-3"></i>Privacy Policy
                </h1>
                <p class="legal-subtitle">Last updated: {{ date('F d, Y') }}</p>
            </div>

            <!-- Content -->
            <div class="legal-body">
                <p class="legal-text">
                    At Guitar Lyrics & Chords, we are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website.
                </p>

                <h2 class="section-title">1. Information We Collect</h2>
                <p class="legal-text">We may collect information about you in a variety of ways:</p>
                <ul class="legal-list">
                    <li><strong>Personal Data:</strong> Name, email address, and other contact information you voluntarily provide</li>
                    <li><strong>Usage Data:</strong> Information about how you use our website, including pages visited and time spent</li>
                    <li><strong>Device Information:</strong> Browser type, operating system, IP address, and device identifiers</li>
                    <li><strong>Cookies:</strong> Small data files stored on your device to enhance user experience</li>
                </ul>

                <h2 class="section-title">2. How We Use Your Information</h2>
                <p class="legal-text">We use the collected information for various purposes:</p>
                <ul class="legal-list">
                    <li>To provide and maintain our service</li>
                    <li>To improve user experience and website functionality</li>
                    <li>To send periodic emails regarding updates or relevant information</li>
                    <li>To analyze usage patterns and optimize our content</li>
                    <li>To prevent fraudulent activities and ensure security</li>
                </ul>

                <h2 class="section-title">3. Information Sharing and Disclosure</h2>
                <p class="legal-text">
                    We do not sell, trade, or otherwise transfer your personal information to third parties without your consent, except in the following circumstances:
                </p>
                <ul class="legal-list">
                    <li>When required by law or to comply with legal processes</li>
                    <li>To protect our rights, property, or safety</li>
                    <li>With trusted service providers who assist in operating our website</li>
                    <li>In connection with a business transfer or acquisition</li>
                </ul>

                <h2 class="section-title">4. Data Security</h2>
                <p class="legal-text">
                    We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. However, no method of transmission over the internet is 100% secure.
                </p>

                <h2 class="section-title">5. Cookies and Tracking Technologies</h2>
                <p class="legal-text">
                    Our website uses cookies to enhance your browsing experience. You can choose to disable cookies through your browser settings, though this may affect certain functionalities of our site.
                </p>

                <h2 class="section-title">6. Your Rights</h2>
                <p class="legal-text">You have the right to:</p>
                <ul class="legal-list">
                    <li>Access and update your personal information</li>
                    <li>Request deletion of your data</li>
                    <li>Opt-out of marketing communications</li>
                    <li>Object to certain data processing activities</li>
                </ul>

                <h2 class="section-title">7. Children's Privacy</h2>
                <p class="legal-text">
                    Our service is not intended for children under 13 years of age. We do not knowingly collect personal information from children under 13.
                </p>

                <h2 class="section-title">8. Changes to This Policy</h2>
                <p class="legal-text">
                    We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new policy on this page with an updated revision date.
                </p>

                <!-- Contact Information -->
                <div class="contact-info">
                    <h3 class="contact-title">
                        <i class="fas fa-envelope me-2"></i>Contact Us
                    </h3>
                    <p class="legal-text mb-0">
                        If you have any questions about this Privacy Policy, please contact us at:
                        <br><strong>Email:</strong> privacy@guitarlyricsandchords.com
                        <br><strong>Address:</strong> [Your Company Address]
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection