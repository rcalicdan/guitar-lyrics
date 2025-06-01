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

    /* Profile image container */
    .profile-image-container {
        position: relative;
        display: inline-block;
        margin-bottom: 1rem;
    }

    #profileImagePreview {
        transition: all 0.3s ease;
        border: 4px solid #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .profile-image-container:hover #profileImagePreview {
        filter: brightness(0.8);
    }

    .profile-image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .profile-image-container:hover .profile-image-overlay {
        opacity: 1;
    }

    .overlay-text {
        color: white;
        font-size: 0.9rem;
        text-align: center;
        padding: 0.5rem;
    }

    /* File input styling */
    .file-input-wrapper {
        position: relative;
        margin-top: 1rem;
    }

    .custom-file-input {
        position: relative;
        z-index: 2;
        width: 100%;
        height: calc(1.5em + 0.75rem + 2px);
        opacity: 0;
        cursor: pointer;
    }

    .custom-file-label {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        z-index: 1;
        padding: 0.75rem 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        border: 2px solid #e9ecef;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .custom-file-label::after {
        content: "Browse";
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        z-index: 3;
        display: block;
        padding: 0.75rem 1rem;
        color: #fff;
        background: linear-gradient(135deg, #3498db, #2980b9);
        border-left: inherit;
        border-radius: 0 6px 6px 0;
    }

    /* Helper text */
    .text-muted {
        font-size: 0.875rem;
        color: #6c757d !important;
        margin-top: 0.5rem;
    }

    /* Button styling */
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
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

    /* Loading spinner */
    .loading-spinner {
        display: none;
        width: 20px;
        height: 20px;
        border: 2px solid #f3f3f3;
        border-top: 2px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-right: 8px;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem;
        }

        .card-footer {
            padding: 1rem 1.5rem;
        }

        .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }

        #profileImagePreview {
            width: 120px;
            height: 120px;
        }
    }
</style>
@endpush

@push('custom-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
  const profileImageInput = document.getElementById('profile_image');
  const profileImagePreview = document.getElementById('profileImagePreview');

  // Add event listener to the file input
  profileImageInput.addEventListener('change', function (event) {
    const file = event.target.files[0];

    if (file) {
      // Validate file type
      if (!file.type.startsWith('image/')) {
        alert('Please upload a valid image file.');
        profileImageInput.value = ''; // Clear the input
        return;
      }

      // Create a URL for the selected image
      const imageUrl = URL.createObjectURL(file);

      // Update the preview image
      profileImagePreview.src = imageUrl;
    } else {
      // Reset to default placeholder if no file is selected
      profileImagePreview.src = '{{ $user->profile_image ?? "https://via.placeholder.com/150" }}';
    }
  });
});
</script>
@endpush