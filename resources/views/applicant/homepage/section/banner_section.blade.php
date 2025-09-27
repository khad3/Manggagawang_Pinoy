<section class="hero-banner">
    <div class="hero-content">
        <h1 class="hero-title">Discover Amazing <br>Career Opportunities</h1>
        <p class="hero-subtitle">Connect with top employers and find your perfect job match</p>

        <div class="hero-stats">
            <div class="stat-card">
                @if ($applicantCounts == 1)
                    <span class="stat-number">{{ $applicantCounts }}+</span>
                    <div class="stat-label">Skilled Workers Registered</div>
                @else
                    <span class="stat-number">{{ $applicantCounts }}+</span>
                    <div class="stat-label">Skilled Workers Registered</div>
                @endif
            </div>
            <div class="stat-card">
                @if ($publishedCounts == 1)
                    <span class="stat-number">{{ $publishedCounts }} </span>
                    <div class="stat-label">Job Openings Available</div>
                @else
                    <span class="stat-number">{{ $publishedCounts }}+</span>
                    <div class="stat-label">Job Openings Available</div>
                @endif
            </div>
            <div class="stat-card">
                @if ($tesdaCertificateCounts == 1)
                    <span class="stat-number">{{ $tesdaCertificateCounts }}</span>
                    <div class="stat-label">TESDA-Certified Employees</div>
                @else
                    <span class="stat-number">{{ $tesdaCertificateCounts }}+</span>
                    <div class="stat-label">TESDA-Certified Employees</div>
                @endif
            </div>

        </div>
    </div>
</section>
