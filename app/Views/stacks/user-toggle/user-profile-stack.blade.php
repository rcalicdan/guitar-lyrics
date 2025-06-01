@push('custom-styles')
<style>
    /* Card Container */
    .card {
        background: #ffffff;
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    /* Profile Image Styles */
    .profile-image-container {
        position: relative;
        width: 200px;
        height: 200px;
        margin: 0 auto;
        transition: all 0.3s ease;
    }

    .profile-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 4px 20px rgba(52, 152, 219, 0.2);
        transition: all 0.3s ease;
    }

    .edit-overlay {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: linear-gradient(135deg, #3498db, #2980b9);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .edit-overlay:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    /* Profile Information Styles */
    .profile-info {
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        padding-bottom: 2rem;
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .info-item:hover {
        background: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transform: translateX(5px);
    }

    .info-item i {
        font-size: 1.2rem;
        margin-right: 1rem;
        margin-top: 0.25rem;
        color: #3498db;
    }

    .info-content label {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
        font-weight: 600;
    }

    .info-content p {
        font-size: 1rem;
        margin-bottom: 0;
        color: #2c3e50;
    }

    /* Section Titles */
    .section-title {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 1.5rem;
        position: relative;
        padding-bottom: 0.75rem;
    }

    .section-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 3px;
        background: linear-gradient(135deg, #3498db, #2980b9);
        border-radius: 3px;
    }

    /* Bio Section */
    .bio-section {
        margin-top: 2rem;
    }

    .bio-content {
        line-height: 1.8;
        color: #2c3e50;
        background: #f8f9fa;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .bio-content:hover {
        background: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    /* Button Styles */
    .btn {
        border-radius: 50px;
        font-weight: 500;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #3498db, #2980b9);
        border: none;
        box-shadow: 0 4px 8px rgba(52, 152, 219, 0.2);
    }

    .btn-outline-primary {
        border: 2px solid #3498db;
        color: #3498db;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }

    /* Name and Role Styles */
    h3 {
        color: #2c3e50;
        font-weight: 600;
    }

    .text-muted {
        color: #6c757d !important;
        font-size: 0.95rem;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .card-body {
            padding: 2rem !important;
        }

        .profile-image-container {
            width: 150px;
            height: 150px;
        }

        .btn {
            width: 100%;
            margin-bottom: 1rem;
        }

        .d-flex.justify-content-center {
            flex-direction: column;
        }

        .gap-3 {
            gap: 0 !important;
        }
    }

    /* Animation Keyframes */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        animation: fadeIn 0.5s ease-out;
    }
</style>
@endpush