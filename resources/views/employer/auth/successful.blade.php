<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Complete - SkillForce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/applicant/employer/successful.css') }}" rel="stylesheet">
</head>
<body>
    <div class="success-container p-4">
        <!-- Success Icon -->
        <div class="success-icon">
            <i class="fas fa-check fa-3x text-white"></i>
        </div>
        
        <!-- Success Message -->
        <h1 class="display-4 fw-bold text-dark mb-3">Registration Complete!</h1>
        <p class="lead text-muted mb-4">
            Your employer account has been successfully created. We'll review your information and connect you with qualified TESDA-certified workers.
        </p>
        
        <!-- Confirmation Details -->
        <div class="info-card text-start">
            <h4 class="fw-bold mb-3 text-center">
                <i class="fas fa-info-circle text-warning me-2"></i>What Happens Next?
            </h4>
            
            <div class="step-item">
                <div class="step-number">1</div>
                <div>
                    <strong>Account Verification (24 hours)</strong>
                    <br><small class="text-muted">We'll verify your company information and approve your account</small>
                </div>
            </div>
            
            <div class="step-item">
                <div class="step-number">2</div>
                <div>
                    <strong>Job Posting Activation</strong>
                    <br><small class="text-muted">Your job requirements will be matched with qualified workers</small>
                </div>
            </div>
            
            <div class="step-item">
                <div class="step-number">3</div>
                <div>
                    <strong>Worker Recommendations</strong>
                    <br><small class="text-muted">We'll send you profiles of TESDA-certified candidates</small>
                </div>
            </div>
            
            <div class="step-item">
                <div class="step-number">4</div>
                <div>
                    <strong>Interview & Hiring</strong>
                    <br><small class="text-muted">Connect with candidates and start the hiring process</small>
                </div>
            </div>
        </div>
        
        <!-- Contact Information -->
        <div class="info-card mt-4">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-envelope text-primary me-2"></i>Confirmation Sent
            </h5>
            <p class="mb-3">A confirmation email has been sent to:</p>
            <div class="alert alert-info">
                <i class="fas fa-mail-bulk me-2"></i>
                <strong>employer@company.com</strong>
            </div>
            <p class="small text-muted">
                Please check your email for detailed next steps and account activation instructions.
            </p>
        </div>
        
        <!-- TESDA Information -->
        <div class="info-card mt-4">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-certificate text-warning me-2"></i>TESDA Partnership Benefits
            </h5>
            <div class="row text-start">
                <div class="col-md-6">
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success me-2"></i>Verified certifications</li>
                        <li><i class="fas fa-check text-success me-2"></i>Skills assessment scores</li>
                        <li><i class="fas fa-check text-success me-2"></i>Background verification</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success me-2"></i>Continuous training records</li>
                        <li><i class="fas fa-check text-success me-2"></i>Safety compliance status</li>
                        <li><i class="fas fa-check text-success me-2"></i>Work history verification</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="mt-5">
        <a href="{{ route('employer.register.display') }}" class="btn btn-primary-custom btn-lg me-3">
                <i class="fas fa-home me-2"></i>Return to Homepage
            </a>
            <a href="#" class="btn btn-outline-secondary btn-lg">
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
                Need help? Contact us at <strong>support@skillforce.ph</strong> or call <strong>+63 2 8XXX-XXXX</strong>
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>