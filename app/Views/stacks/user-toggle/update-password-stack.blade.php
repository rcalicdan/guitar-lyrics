@push('custom-styles')
    <style>
        /* Card styling */
        .card-primary {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 8px;
            margin-top: 2rem;
        }

        .card-header {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            color: white;
            border-radius: 8px 8px 0 0 !important;
            padding: 1.25rem;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
        }

        /* Form controls styling */
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 6px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        .input-group {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        /* Button styling */
        .toggle-password {
            border: 2px solid #e9ecef;
            background-color: #f8f9fa;
            color: #6c757d;
            padding: 0.75rem;
            transition: all 0.3s ease;
        }

        .toggle-password:hover {
            background-color: #e9ecef;
            color: #2c3e50;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3498db, #2980b9);
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2980b9, #3498db);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background-color: #f8f9fa;
            border: 2px solid #e9ecef;
            color: #6c757d;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #e9ecef;
            color: #2c3e50;
        }

        /* Helper text styling */
        .text-muted {
            font-size: 0.875rem;
            color: #6c757d !important;
            margin-top: 0.5rem;
        }

        /* Card body and footer spacing */
        .card-body {
            padding: 2rem;
        }

        .card-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
            padding: 1.25rem 2rem;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }

            .card-footer {
                padding: 1rem 1.5rem;
            }
        }

        /* Animation for focus states */
        .form-control:focus+.toggle-password {
            border-color: #3498db;
        }

        /* Password strength indicator */
        .mb-3 {
            position: relative;
        }

        .form-control:valid {
            border-color: #2ecc71;
        }

        .form-control:invalid {
            border-color: #e74c3c;
        }
    </style>
@endpush

@push('custom-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select all toggle buttons
            const toggleButtons = document.querySelectorAll('.toggle-password');

            // Add event listeners to each toggle button
            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Get the target input field
                    const targetId = this.getAttribute('data-target');
                    const passwordField = document.getElementById(targetId);

                    // Toggle between password and text
                    if (passwordField.type === 'password') {
                        passwordField.type = 'text';
                        this.innerHTML =
                        '<i class="bi bi-eye-slash"></i>'; // Change icon to "eye-slash"
                    } else {
                        passwordField.type = 'password';
                        this.innerHTML = '<i class="bi bi-eye"></i>'; // Change icon back to "eye"
                    }
                });
            });
        });
    </script>
@endpush
