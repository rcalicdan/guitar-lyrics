@extends('layouts.homepage')

@section('title', 'Terms of Service - Guitar Lyrics & Chords')

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
        border-bottom: 3px solid #28a745;
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
        color: #28a745;
        font-size: 1.5rem;
        margin: 2.5rem 0 1rem 0;
        padding-left: 1rem;
        border-left: 4px solid #28a745;
        position: relative;
    }

    .section-title::before {
        content: '';
        position: absolute;
        left: -4px;
        top: 0;
        height: 100%;
        width: 4px;
        background: linear-gradient(135deg, #28a745, #20c997);
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
        color: #28a745;
        font-weight: 600;
    }

    .contact-info {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 15px;
        padding: 2rem;
        margin-top: 3rem;
        border-left: 5px solid #28a745;
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
        color: #28a745;
        text-decoration: none;
        font-weight: 500;
    }

    .breadcrumb-nav .breadcrumb-item.active {
        color: #6c757d;
    }

    .warning-box {
        background: linear-gradient(135deg, #fff3cd, #ffeaa7);
        border: 1px solid #ffc107;
        border-radius: 10px;
        padding: 1.5rem;
        margin: 2rem 0;
        border-left: 5px solid #ffc107;
    }

    .warning-box .fas {
        color: #856404;
        margin-right: 0.5rem;
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
                    <li class="breadcrumb-item active" aria-current="page">Terms of Service</li>
                </ol>
            </nav>
        </div>

        <div class="legal-card">
            <!-- Header -->
            <div class="legal-header">
                <h1 class="legal-title">
                    <i class="fas fa-file-contract me-3"></i>Terms of Service
                </h1>
                <p class="legal-subtitle">Last updated: {{ date('F d, Y') }}</p>
            </div>

            <!-- Content -->
            <div class="legal-body">
                <p class="legal-text">
                    Welcome to Guitar Lyrics & Chords. These Terms of Service govern your use of our website and
                    services. By using our website, you agree to comply with and be bound by these terms.
                </p>

                <div class="warning-box">
                    <p class="mb-0">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Important:</strong> Please read these terms carefully before using our service. By
                        accessing or using our website, you acknowledge that you have read, understood, and agree to be
                        bound by these terms.
                    </p>
                </div>

                <h2 class="section-title">1. Acceptance of Terms</h2>
                <p class="legal-text">
                    By accessing and using Guitar Lyrics & Chords, you accept and agree to be bound by the terms and
                    provision of this agreement. If you do not agree to abide by these terms, you are not authorized to
                    use or access this website.
                </p>

                <h2 class="section-title">2. Use License</h2>
                <p class="legal-text">
                    Permission is granted to temporarily access the materials on Guitar Lyrics & Chords for personal,
                    non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and
                    you may not:
                </p>
                <ul class="legal-list">
                    <li>Modify or copy the materials</li>
                    <li>Use the materials for any commercial purpose or for any public display</li>
                    <li>Remove any copyright or other proprietary notations from the materials</li>
                    <li>Transfer the materials to another person or mirror the materials on any other server</li>
                </ul>

                <h2 class="section-title">3. User Accounts</h2>
                <p class="legal-text">
                    When you create an account with us, you must provide information that is accurate, complete, and
                    current at all times. You are responsible for safeguarding the password and for all activities under
                    your account.
                </p>

                <h2 class="section-title">4. Content and Copyright</h2>
                <p class="legal-text">
                    Our service allows you to access guitar chords, lyrics, and related musical content. We respect
                    intellectual property rights and expect our users to do the same:
                </p>
                <ul class="legal-list">
                    <li>All content is provided for educational and personal use only</li>
                    <li>Commercial use of copyrighted material is strictly prohibited</li>
                    <li>Users must respect copyright laws and fair use principles</li>
                    <li>We respond promptly to valid copyright infringement notices</li>
                </ul>

                <h2 class="section-title">5. Prohibited Uses</h2>
                <p class="legal-text">You may not use our service:</p>
                <ul class="legal-list">
                    <li>For any unlawful purpose or to solicit others to unlawful acts</li>
                    <li>To violate any international, federal, provincial, or state regulations, rules, laws, or local
                        ordinances</li>
                    <li>To infringe upon or violate our intellectual property rights or the intellectual property rights
                        of others</li>
                    <li>To harass, abuse, insult, harm, defame, slander, disparage, intimidate, or discriminate</li>
                    <li>To submit false or misleading information</li>
                    <li>To upload or transmit viruses or any other type of malicious code</li>
                </ul>

                <h2 class="section-title">6. Disclaimers</h2>
                <p class="legal-text">
                    The information on this website is provided on an "as is" basis. To the fullest extent permitted by
                    law, this Company excludes all representations, warranties, conditions and terms.
                </p>

                <h2 class="section-title">7. Limitations</h2>
                <p class="legal-text">
                    In no event shall Guitar Lyrics & Chords or its suppliers be liable for any damages arising out of
                    the use or inability to use the materials on our website, even if we have been notified orally or in
                    writing of the possibility of such damage.
                </p>

                <h2 class="section-title">8. Privacy Policy</h2>
                <p class="legal-text">
                    Your privacy is important to us. Please review our Privacy Policy, which also governs your use of
                    the website, to understand our practices.
                </p>

                <h2 class="section-title">9. Modifications</h2>
                <p class="legal-text">
                    We may revise these terms of service at any time without notice. By using this website, you are
                    agreeing to be bound by the then current version of these terms of service.
                </p>

                <h2 class="section-title">10. Termination</h2>
                <p class="legal-text">
                    We may terminate or suspend your account and bar access to the service immediately, without prior
                    notice or liability, under our sole discretion, for any reason whatsoever.
                </p>

                <h2 class="section-title">11. Governing Law</h2>
                <p class="legal-text">
                    These terms and conditions are governed by and construed in accordance with the laws and you
                    irrevocably submit to the exclusive jurisdiction of the courts.
                </p>

                <!-- Contact Information -->
                <div class="contact-info">
                    <h3 class="contact-title">
                        <i class="fas fa-envelope me-2"></i>Contact Us
                    </h3>
                    <p class="legal-text mb-0">
                        If you have any questions about these Terms of Service, please contact us at:
                        <br><strong>Email:</strong> legal@guitarlyricsandchords.com
                        <br><strong>Address:</strong> [Your Company Address]
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection