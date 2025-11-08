<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration - Employer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="{{ asset('css/applicant/employer/successful.css') }}" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" />
</head>

<body>
    <div class="success-container p-4">
        <!-- Success Icon -->
        <div class="success-icon">
            <i class="fas fa-check fa-3x text-white"></i>
        </div>
        <!-- Success Message -->
        <h1 class="display-4 fw-bold text-dark mb-3">Registration Successful!</h1>
        <p class="lead text-muted mb-4">
            Your employer account has been created successfully.
        </p>

        <!-- Contact Information -->
        <div class="info-card mt-4">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-envelope text-primary me-2"></i>Confirmation Sent
            </h5>
            <p class="mb-3">A confirmation email has been sent to:</p>
            <div class="alert alert-info">
                <i class="fas fa-mail-bulk me-2"></i>
                <strong>{{ $email }}</strong>
            </div>
            <p class="small text-muted">
                Please check your email for detailed next steps and account activation instructions.
            </p>
        </div>


        <!-- Action Buttons -->
        <div class="mt-5">
            <a href="{{ route('employer.login.display') }}" class="btn btn-primary-custom btn-lg me-3">
                <i class="fas fa-home me-2"></i>Return to login
            </a>
            <a href="{{ route('display.aboutus') }}" class="btn btn-outline-secondary btn-lg">
                <i class="fas fa-phone me-2"></i>Contact Support
            </a>
        </div>

        <!-- Additional Information -->
        <div class="mt-4">
            <p class="small text-muted">
                <i class="fas fa-clock me-1"></i>
                Registration completed on <strong>{{ date('F j, Y \a\t g:i A') }}</strong>
            </p>
            <p class="small text-muted">
                Need help? Contact us at
                <strong>
                    <a href="mailto:manggagawangpinoycompany@gmail.com" class="text-decoration-none">
                        manggagawangpinoycompany@gmail.com
                    </a>
                </strong>
                or call <strong>+63 99 999 9999</strong>
            </p>
        </div>

    </div>


</body>

</html>
