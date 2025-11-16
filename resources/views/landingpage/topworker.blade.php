<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Workers</title>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-pap9kM+7PPRL+3xLCZjWJ1qvPgn3hC/Zw9f+5sBczkRjcRzWrV23u0GOKfTQ4gBBY6CkDZnF7UeNj0H3v2lYKw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/applicant/landingpage/topworker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/applicant/landingpage/landingpage.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" />

</head>

<body>
       <!-- Responsive Navbar (HTML) -->
    <nav>
        <div class="navbar-container">
            <div class="nav-logo d-flex align-items-center">
                <a href="{{ route('display.index') }}" class="d-flex align-items-center gap-2"
                    style="text-decoration:none;">
                    <img src="{{ asset('img/logotext.png') }}" alt="MP Logo" id="home" />
                    <img src="{{ asset('img/logo.png') }}" alt="MP Logo" id="home2" />
                </a>
            </div>
            <ul class="nav-links" id="navLinks">
                <li><a href="{{ route('display.topworker') }}">Top Workers</a></li>
                <li><a href="https://www.tesda.gov.ph/">Visit TESDA</a></li>
                <li><a href="{{ route('display.aboutus') }}">About Us</a></li>
                <li class="dropdown">
                    <button class="sign-in-b">Sign in</button>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('applicant.login.display') }}">As Applicant</a></li>
                        <li><a href="{{ route('employer.login.display') }}">As Employer</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <button class="sign-up-b">Sign up </button>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('applicant.register.display') }}">As Applicant</a></li>
                        <li><a href="{{ route('employer.register.display') }}">As Employer</a></li>
                    </ul>
                </li>
            </ul>

            <!-- Mobile Hamburger -->
            <button id="m-hamburger" class="m-hamburger" aria-label="Open menu" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <!-- Replaced old mobile menu with new mobile-navbar -->
            <div class="mobile-overlay" id="mobileOverlay" aria-hidden="true"></div>

            <div class="mobile-navbar" id="mobileNavbar" role="dialog" aria-modal="true" aria-hidden="true">
                <div class="nav-top">
            <div class="nav-logo">
                <img src="img/logotext.png" alt="MP Logo" id="home" />
                <img src="img/logo.png" alt="MP Logo" id="home2" />
            </div>
                    <button id="closeMenu" class="close-btn" aria-label="Close menu"></button>
                </div>

                <ul class="mobile-menu" role="menu" aria-label="Mobile main menu">
                    <li role="none"><a role="menuitem" href="{{ route('display.topworker') }}">Top Workers</a></li>
                    <li role="none"><a role="menuitem" href="https://www.tesda.gov.ph/">Visit TESDA</a></li>
                    <li role="none"><a role="menuitem" href="{{ route('display.aboutus') }}">About Us</a></li>

                    <li class="dropdown" role="none">
                        <button class="dropdown-btn" aria-expanded="false">Sign in</button>
                        <ul class="dropdown-content" role="menu" aria-hidden="true">
                            <li role="none"><a role="menuitem" href="{{ route('applicant.login.display') }}">As Applicant</a>
                            </li>
                            <li role="none"><a role="menuitem" href="{{ route('employer.login.display') }}">As Employer</a>
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown" role="none">
                        <button class="dropdown-btn" aria-expanded="false">Sign up </button>
                        <ul class="dropdown-content" role="menu" aria-hidden="true">
                            <li role="none"><a role="menuitem" href="{{ route('applicant.register.display') }}">As Applicant</a>
                            </li>
                            <li role="none"><a role="menuitem" href="{{ route('employer.register.display') }}">As Employer</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Mobile Navigation Menu -->
    <ul id="mNavLinks" role="menu" aria-hidden="true">
        <li role="none"><a role="menuitem" href="{{ route('display.topworker') }}">Top Workers</a></li>
        <li role="none"><a role="menuitem" href="https://www.tesda.gov.ph/">Visit TESDA</a></li>
        <li role="none"><a role="menuitem" href="{{ route('display.aboutus') }}">About Us</a></li>

        <li class="m-dropdown" role="none">
            <button class="m-drop-btn" aria-expanded="false">Sign in <span></span></button>
            <ul class="m-dropdown-menu" role="menu">
                <li role="none"><a role="menuitem" href="{{ route('applicant.login.display') }}">As Applicant</a></li>
                <li role="none"><a role="menuitem" href="{{ route('employer.login.display') }}">As Employer</a></li>
            </ul>
        </li>

        <li class="m-dropdown" role="none">
            <button class="m-drop-btn" aria-expanded="false">Sign up <span></span></button>
            <ul class="m-dropdown-menu" role="menu">
                <li role="none"><a role="menuitem" href="{{ route('applicant.register.display') }}">As Applicant</a></li>
                <li role="none"><a role="menuitem" href="{{ route('employer.register.display') }}">As Employer</a></li>
            </ul>
        </li>
    </ul>

   
    <div class="top-workers-table">


        @foreach ($topApplicants as $applicant)
            <div class="tw-row">
                <span class="tw-col name">
                    {{ $applicant->personal_info->first_name ?? '' }}
                    {{ $applicant->personal_info->last_name ?? '' }}
                </span>

                <span class="tw-col hire-rate">
                    @php
                        $averageRating = $applicant->average_rating ?? 0;
                    @endphp
                    <div class="stars d-flex align-items-center">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= floor($averageRating))
                                <i class="fas fa-star text-warning"></i>
                            @elseif($i - $averageRating < 1)
                                <i class="fas fa-star-half-alt text-warning"></i>
                            @else
                                <i class="far fa-star text-warning"></i>
                            @endif
                        @endfor
                        <small class="ms-1 text-muted">{{ number_format($averageRating, 1) }}</small>
                    </div>
                </span>

                <span class="tw-col location">
                    {{ $applicant->personal_info->city ?? '' }}
                    {{ $applicant->personal_info->province ?? '' }}
                </span>

                <span class="tw-col industry">{{ $applicant->work_background->position ?? 'N/A' }}</span>

                <button class="tw-dropdown-btn" aria-label="Show details">&#9660;</button>
            </div>

            <div class="tw-dropdown">
                <div class="tw-dropdown-content">
                    <img src="{{ $applicant->work_background->profileimage_path
                        ? asset('storage/' . $applicant->work_background->profileimage_path)
                        : asset('storage/default-profile.png') }}"
                        alt="Profile" class="tw-profile-img" />

                    <div class="tw-profile-info">
                        <strong>{{ $applicant->personal_info->first_name ?? '' }}
                            {{ $applicant->personal_info->last_name ?? '' }}</strong>
                        <p>{{ $applicant->template->description ?? 'No description available' }}</p>

                        <div class="tw-profile-actions">
                            <button class="tw-btn tw-view-profile"
                                onclick="openModal('commentsModal{{ $applicant->id }}')">
                                View review comments
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Unique Modal for Each Applicant -->
            <div class="modal fade" id="commentsModal{{ $applicant->id }}" tabindex="-1"
                aria-labelledby="commentsModalLabel{{ $applicant->id }}" aria-hidden="true" data-bs-backdrop="false">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="commentsModalLabel{{ $applicant->id }}">
                                Employer Review Comments - {{ $applicant->personal_info->first_name ?? '' }}
                                {{ $applicant->personal_info->last_name ?? '' }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            @php
                                // Get all reviews for this applicant from the $topWorkers collection
                                $reviewsForApplicant = $topWorkers->where('applicant.id', $applicant->id);
                            @endphp

                            @if ($reviewsForApplicant->isEmpty())
                                <p class="text-muted">No reviews available for this applicant yet.</p>
                            @else
                                @foreach ($reviewsForApplicant as $review)
                                    <div class="review-item mb-3">
                                        <strong>{{ $review->employer->addressCompany->company_name ?? 'Unknown Company' }}</strong>
                                        <div class="review-stars">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $review->rating)
                                                    <i class="fas fa-star text-warning"></i>
                                                @else
                                                    <i class="far fa-star text-warning"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <p>{{ $review->review_comments ?? 'No comments provided.' }}</p>
                                        <small class="text-muted">Posted on:
                                            {{ $review->created_at->format('M d, Y') }}</small>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- View More Button -->
        <div style="text-align:center;margin-top:18px;">
            <button class="tw-view-more">View more</button>
        </div>
    </div>


    <footer class="footer" style="margin-bottom:-900px;">
        <div class="footer-col about">
            <img src="img/logo.png" class="logo-placeholder">
            <p>
                Manggagawang Pinoy is a web-based job-matching platform designed to help blue-collar Filipino workers
                connect with employers.
            </p>
            <a href="{{ route('display.aboutus') }}">Our Team</a>
        </div>
        <div class="footer-col contact">
            <h4>Contact</h4>
            <p><span class="icon"><svg width="23" height="19" viewBox="0 0 43 39" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M21.5 35.75C21.0819 35.75 20.7236 35.6417 20.425 35.425C20.1264 35.2083 19.9024 34.924 19.7531 34.5719C19.1858 33.0552 18.4691 31.6333 17.6031 30.3062C16.767 28.9792 15.5875 27.4219 14.0646 25.6344C12.5417 23.8469 11.3024 22.1406 10.3469 20.5156C9.42118 18.8906 8.95833 16.9271 8.95833 14.625C8.95833 11.4562 10.1677 8.775 12.5865 6.58125C15.0351 4.36042 18.0062 3.25 21.5 3.25C24.9937 3.25 27.95 4.36042 30.3687 6.58125C32.8174 8.775 34.0417 11.4562 34.0417 14.625C34.0417 17.0896 33.5191 19.1479 32.474 20.8C31.4587 22.425 30.2792 24.0365 28.9354 25.6344C27.3229 27.5844 26.0986 29.2094 25.2625 30.5094C24.4562 31.7823 23.7844 33.1365 23.2469 34.5719C23.0976 34.951 22.8587 35.249 22.5302 35.4656C22.2316 35.6552 21.8882 35.75 21.5 35.75ZM21.5 18.6875C22.7542 18.6875 23.8142 18.2948 24.6802 17.5094C25.5462 16.724 25.9792 15.7625 25.9792 14.625C25.9792 13.4875 25.5462 12.526 24.6802 11.7406C23.8142 10.9552 22.7542 10.5625 21.5 10.5625C20.2458 10.5625 19.1858 10.9552 18.3198 11.7406C17.4538 12.526 17.0208 13.4875 17.0208 14.625C17.0208 15.7625 17.4538 16.724 18.3198 17.5094C19.1858 18.2948 20.2458 18.6875 21.5 18.6875Z"
                            fill="#1D1B20" />
                    </svg></span>MetroGate Silang Estates, Silang, Cavite</p>
            <p><span class="icon"><svg width="16" height="16" viewBox="0 0 36 36" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M33 25.3801V29.8801C33.0017 30.2979 32.9161 30.7114 32.7488 31.0942C32.5814 31.4769 32.336 31.8205 32.0281 32.1029C31.7203 32.3854 31.3569 32.6004 30.9611 32.7342C30.5654 32.868 30.1461 32.9177 29.73 32.8801C25.1143 32.3786 20.6805 30.8014 16.785 28.2751C13.1607 25.9721 10.088 22.8994 7.78501 19.2751C5.24997 15.362 3.67237 10.9066 3.18001 6.27015C3.14252 5.85535 3.19182 5.43729 3.32476 5.04258C3.4577 4.64788 3.67136 4.28518 3.95216 3.97758C4.23295 3.66997 4.57471 3.42421 4.95569 3.25593C5.33667 3.08765 5.74852 3.00054 6.16501 3.00015H10.665C11.393 2.99298 12.0987 3.25076 12.6506 3.72544C13.2026 4.20013 13.5631 4.85932 13.665 5.58015C13.8549 7.02025 14.2072 8.43424 14.715 9.79515C14.9168 10.332 14.9605 10.9155 14.8409 11.4765C14.7212 12.0374 14.4433 12.5523 14.04 12.9601L12.135 14.8651C14.2703 18.6205 17.3797 21.7298 21.135 23.8651L23.04 21.9601C23.4478 21.5569 23.9627 21.2789 24.5237 21.1593C25.0846 21.0397 25.6681 21.0833 26.205 21.2851C27.5659 21.793 28.9799 22.1452 30.42 22.3351C31.1487 22.4379 31.8141 22.805 32.2898 23.3664C32.7655 23.9278 33.0183 24.6445 33 25.3801Z"
                            stroke="#1E1E1E" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>09275044091</p>
            <p><span class="icon"><svg width="23" height="21" viewBox="0 0 33 31" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M5.5 25.8332C4.74375 25.8332 4.09063 25.5856 3.54063 25.0905C3.01354 24.5738 2.75 23.9603 2.75 23.2498V7.74984C2.75 7.03942 3.01354 6.43664 3.54063 5.9415C4.09063 5.42484 4.74375 5.1665 5.5 5.1665H27.5C28.2563 5.1665 28.8979 5.42484 29.425 5.9415C29.975 6.43664 30.25 7.03942 30.25 7.74984V23.2498C30.25 23.9603 29.975 24.5738 29.425 25.0905C28.8979 25.5856 28.2563 25.8332 27.5 25.8332H5.5ZM16.5 16.7915L27.5 10.3332V7.74984L16.5 14.2082L5.5 7.74984V10.3332L16.5 16.7915Z"
                            fill="#1D1B20" />
                    </svg>
                </span>mangaggawangpinoycompany@gmail.com</p>
        </div>
        <div class="footer-col links">
            <h4>Links</h4>
            <ul>
                <li><a href="index">Home</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="#tutorial">Tutorial</a></li>
                <li><a href="https://www.tesda.gov.ph/">TESDA</a>
                </li>
            </ul>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        // Function to open modal
        function openModal(modalId) {
            const modal = new bootstrap.Modal(document.getElementById(modalId), {
                backdrop: false,
                keyboard: true
            });
            modal.show();
        }

        // Dropdown logic for multiple rows
        document.querySelectorAll('.tw-row').forEach(function(row, idx) {
            row.addEventListener('click', function(e) {
                // Prevent toggling when clicking the button or view profile button
                if (e.target.classList.contains('tw-dropdown-btn') ||
                    e.target.classList.contains('tw-view-profile') ||
                    e.target.closest('.tw-view-profile')) {
                    return;
                }

                // Toggle dropdown for this row
                const dropdowns = document.querySelectorAll('.tw-dropdown');
                const btns = document.querySelectorAll('.tw-dropdown-btn');
                dropdowns.forEach((d, i) => {
                    if (i === idx) {
                        d.style.display = d.style.display === 'block' ? 'none' : 'block';
                        btns[i].classList.toggle('open');
                    } else {
                        d.style.display = 'none';
                        btns[i].classList.remove('open');
                    }
                });
            });
        });

        // Also toggle when clicking the dropdown button directly
        document.querySelectorAll('.tw-dropdown-btn').forEach(function(btn, idx) {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const dropdowns = document.querySelectorAll('.tw-dropdown');
                const btns = document.querySelectorAll('.tw-dropdown-btn');
                dropdowns.forEach((d, i) => {
                    if (i === idx) {
                        d.style.display = d.style.display === 'block' ? 'none' : 'block';
                        btns[i].classList.toggle('open');
                    } else {
                        d.style.display = 'none';
                        btns[i].classList.remove('open');
                    }
                });
            });
        });
    </script>

    <script>
    (function() {
        function log(...args) { if (window.console) console.log('[nav]', ...args); }

        document.addEventListener('DOMContentLoaded', () => {
            try {
                // ====== wire new mobile-navbar ======
                const hamburger = document.getElementById('m-hamburger');
                const mobileNavbar = document.getElementById('mobileNavbar');
                const closeMenu = document.getElementById('closeMenu');
                const overlay = document.getElementById('mobileOverlay');

                function openMenu() {
                    mobileNavbar.classList.add('open');
                    overlay.classList.add('show');
                    hamburger.classList.add('active');
                    hamburger.setAttribute('aria-expanded', 'true');
                    mobileNavbar.setAttribute('aria-hidden', 'false');
                    document.body.style.overflow = 'hidden';
                }

                function closeMenuFn() {
                    mobileNavbar.classList.remove('open');
                    overlay.classList.remove('show');
                    hamburger.classList.remove('active');
                    hamburger.setAttribute('aria-expanded', 'false');
                    mobileNavbar.setAttribute('aria-hidden', 'true');
                    document.body.style.overflow = 'auto';
                }

                if (hamburger && mobileNavbar) {
                    hamburger.addEventListener('click', (e) => {
                        e.stopPropagation();
                        if (window.innerWidth <= 768) {
                            if (mobileNavbar.classList.contains('open')) closeMenuFn();
                            else openMenu();
                        }
                    });

                    closeMenu.addEventListener('click', (e) => {
                        e.stopPropagation();
                        closeMenuFn();
                    });

                    overlay.addEventListener('click', closeMenuFn);

                    // dropdown toggles
                    mobileNavbar.querySelectorAll('.dropdown').forEach(drop => {
                        const btn = drop.querySelector('.dropdown-btn');
                        const menu = drop.querySelector('.dropdown-content');
                        btn.addEventListener('click', (ev) => {
                            ev.stopPropagation();
                            const isOpen = drop.classList.toggle('open');
                            btn.setAttribute('aria-expanded', String(isOpen));
                            if (menu) menu.setAttribute('aria-hidden', String(!isOpen));
                        });
                    });

                    // close when selecting a link
                    mobileNavbar.querySelectorAll('a').forEach(a => {
                        a.addEventListener('click', () => closeMenuFn());
                    });

                    // close on ESC
                    document.addEventListener('keydown', (e) => {
                        if (e.key === 'Escape') closeMenuFn();
                    });

                    // click outside closes menu
                    document.addEventListener('click', (e) => {
                        if (!mobileNavbar.contains(e.target) && !hamburger.contains(e.target)) {
                            closeMenuFn();
                        }
                    });

                    log('Mobile navbar initialized');
                }

                // Hide loader after page load
                window.addEventListener("load", function() {
                    setTimeout(function() {
                        const loader = document.getElementById("loader-wrapper");
                        if (loader) loader.style.display = "none";
                    }, 1500);
                });

            } catch (err) {
                log('Error:', err.message);
            }
        });
    })();
</script>
</body>

</html>
