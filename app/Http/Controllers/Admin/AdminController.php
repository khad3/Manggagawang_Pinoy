<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin\AccountAdminModel as Admin;
use App\Models\Admin\AddTesdaOfficerModel as AddTesdaOfficer;
use App\Models\Applicant\TesdaUploadCertificationModel as TesdaCertification;
use App\Models\Report\ReportModel;
use Illuminate\Support\Str;
use App\Models\Applicant\PostModel as Post;
use App\Models\Admin\UserManagmentModel;
use App\Models\Admin\AnnouncementModel;
use App\Models\Applicant\ApplyJobModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

// Employer Model
use App\Models\Employer\AccountInformationModel as Employer;
// Applicants Model
use App\Models\Applicant\RegisterModel;
use App\Models\Employer\JobDetailModel;
use App\Models\User;

class AdminController extends Controller
{
    // Homepage
    public function homepageDisplay()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login.display');
        }

        $retrieveAdmin = Auth::guard('admin')->user();

        // Total counts
        $employerCount = Employer::count();
        $applicantsCount = RegisterModel::count();

        // Monthly count comparison
        $now = Carbon::now();
        $currentMonth = $now->month;
        $currentYear = $now->year;

        $lastMonth = $now->copy()->subMonth()->month;
        $lastMonthYear = $now->copy()->subMonth()->year;

        $applicantsThisMonth = RegisterModel::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        $applicantsLastMonth = RegisterModel::whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $lastMonthYear)
            ->count();

        // Calculate trend percentage
        $change = 0;
        $isTrendingUp = true;

        if ($applicantsLastMonth > 0) {
            $change = (($applicantsThisMonth - $applicantsLastMonth) / $applicantsLastMonth) * 100;
            $isTrendingUp = $change >= 0;
        } elseif ($applicantsThisMonth > 0) {
            $change = 100;
        }

        // Employer trends
        $employersThisMonth = Employer::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        $employersLastMonth = Employer::whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $lastMonthYear)
            ->count();

        $employerChange = 0;
        $employersTrendingUp = true;

        if ($employersLastMonth > 0) {
            $employerChange = (($employersThisMonth - $employersLastMonth) / $employersLastMonth) * 100;
            $employersTrendingUp = $employerChange >= 0;
        } elseif ($employersThisMonth > 0) {
            $employerChange = 100;
        }

        // Total users
        $totalUsers = $applicantsCount + $employerCount;
        $totalUsersThisMonth = $applicantsThisMonth + $employersThisMonth;
        $totalUsersLastMonth = $applicantsLastMonth + $employersLastMonth;

        // Percentage growth
        $percentageGrowth = 0;
        if ($totalUsersLastMonth > 0) {
            $percentageGrowth = (($totalUsersThisMonth - $totalUsersLastMonth) / $totalUsersLastMonth) * 100;
        }

        $last_login = $retrieveAdmin->last_login;

        // Retrieve TESDA officers and announcements
        $retrieveTesdaOfficers = AddTesdaOfficer::all();
        $retrieveAnnouncementsTotal = AnnouncementModel::count();
        $retrieveAnnouncements = AnnouncementModel::orderBy('created_at', 'desc')->get();
        $weeklyAnnouncements = AnnouncementModel::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $publishedAnnouncementTotal = AnnouncementModel::where('status', 'published')->count();

        $tesdaOfficersCount = AddTesdaOfficer::count();
        $newTesdaOfficers = AddTesdaOfficer::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        // User trend chart
        $applicantStats = RegisterModel::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $employerStats = Employer::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $chartData = [];
        $chartData[] = "['Month', 'Applicants', 'Employers']";

        for ($m = 1; $m <= 12; $m++) {
            $monthName = Carbon::create()->month($m)->format('F');
            $applicants = $applicantStats[$m] ?? 0;
            $employers = $employerStats[$m] ?? 0;
            $chartData[] = "['{$monthName}', {$applicants}, {$employers}]";
        }

        $colors = ['#1E88E5', '#43A047'];

         // --- Retrieve Applicants ---
        $applicantUser = RegisterModel::with('personal_info')
            ->get()
            ->map(function ($a) {
                // Safely decrypt fields if needed
                $a->email = $this->safeDecrypt($a->email);
                $a->status = $this->safeDecrypt($a->status);
                if ($a->personal_info) {
                    $a->personal_info->first_name = $this->safeDecrypt($a->personal_info->first_name);
                    $a->personal_info->last_name = $this->safeDecrypt($a->personal_info->last_name);
                }

                return [
                    'type' => 'applicant',
                    'data' => $a
                ];
            });
          // --- Retrieve Employers ---
        $employerUser = Employer::with('personal_info', 'addressCompany')
            ->get()
            ->map(function ($e) {
                // Safely decrypt fields if needed
                $e->email = $this->safeDecrypt($e->email);
                $e->status = $this->safeDecrypt($e->status);
                if ($e->addressCompany) {
                    $e->addressCompany->company_name = $this->safeDecrypt($e->addressCompany->company_name);
                }
                if ($e->personal_info) {
                    $e->personal_info->first_name = $this->safeDecrypt($e->personal_info->first_name);
                    $e->personal_info->last_name = $this->safeDecrypt($e->personal_info->last_name);
                }

                return [
                    'type' => 'employer',
                    'data' => $e
                ];
            });


        $users = $applicantUser->concat($employerUser);

        // Ban/suspension data
        $retrieveAccountBanApplicant = RegisterModel::where('status', 'banned')->count();
        $retrieveAccountBanEmployer = Employer::where('status', 'banned')->count();

        $banChartData = [
            "['Account Type', 'Banned Count']",
            "['Applicants', {$retrieveAccountBanApplicant}]",
            "['Employers', {$retrieveAccountBanEmployer}]"
        ];
        $banColors = ['#E53935', '#FB8C00'];

        $retrievedSuspendedApplicants = RegisterModel::where('status', 'suspended')->count();
        $retrievedSuspendedEmployers = Employer::where('status', 'suspended')->count();

        $suspendedChartData = [
            "['Account Type', 'Suspended Count']",
            "['Applicants', {$retrievedSuspendedApplicants}]",
            "['Employers', {$retrievedSuspendedEmployers}]"
        ];
        $suspendedColors = ['#E53935', '#FB8C00'];

        // Certification chart
        $retrievedCertificationCount = TesdaCertification::where('status', 'approved')->count();
        $certifications = TesdaCertification::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, status, COUNT(*) as total")
            ->groupBy('month', 'status')
            ->orderBy('month')
            ->get();

        $statuses = ['approved', 'pending', 'rejected', 'request_revision'];
        $months = $certifications->pluck('month')->unique()->values();

        $certificationsChartData = [];
        $certificationsChartData[] = "['Month', 'Approved', 'Pending', 'Rejected', 'Request Revision']";

        foreach ($months as $month) {
            $monthLabel = Carbon::createFromFormat('Y-m', $month)->format('M Y');
            $row = ["'{$monthLabel}'"];
            foreach ($statuses as $status) {
                $count = $certifications
                    ->where('month', $month)
                    ->where('status', $status)
                    ->sum('total');
                $row[] = $count;
            }
            $certificationsChartData[] = "[" . implode(',', $row) . "]";
        }

        $certificationsColors = ['#43A047', '#FB8C00', '#E53935', '#1E88E5'];

        // Activity logs
        $activityLogs = collect();

        $applicantSuspensions = RegisterModel::with('suspension')
            ->where('status', 'suspended')
            ->latest()
            ->get()
            ->map(function ($a) {
                $duration = $a->suspension->duration ?? 'N/A';
                return [
                    'action' => 'suspended',
                    'email' => $a->email,
                    'description' => "{$a->email} suspended for {$duration} days due to multiple reports",
                    'created_at' => $a->updated_at,
                ];
            });

        $employerSuspensions = Employer::with('suspension')
            ->where('status', 'suspended')
            ->latest()
            ->get()
            ->map(function ($e) {
                $duration = $e->suspension->duration ?? 'N/A';
                return [
                    'action' => 'suspended',
                    'email' => $e->email,
                    'description' => "{$e->email} suspended for {$duration} days due to multiple reports",
                    'created_at' => $e->updated_at,
                ];
            });

        $applicantBanned = RegisterModel::where('status', 'banned')
            ->latest()
            ->get()
            ->map(fn($a) => [
                'action' => 'banned',
                'email' => $a->email,
                'description' => "{$a->email} was banned by admin",
                'created_at' => $a->updated_at,
            ]);

        $employerBanned = Employer::where('status', 'banned')
            ->latest()
            ->get()
            ->map(fn($e) => [
                'action' => 'banned',
                'email' => $e->email,
                'description' => "{$e->email} was banned by admin",
                'created_at' => $e->updated_at,
            ]);

        $applicantUnbans = RegisterModel::where('status', 'active')
            ->latest()
            ->get()
            ->map(fn($a) => [
                'action' => 'unbanned',
                'email' => $a->email,
                'description' => "{$a->email} ban was lifted by admin",
                'created_at' => $a->updated_at,
            ]);

        $employerUnbans = Employer::where('status', 'active')
            ->latest()
            ->get()
            ->map(fn($e) => [
                'action' => 'unbanned',
                'email' => $e->email,
                'description' => "{$e->email} ban was lifted by admin",
                'created_at' => $e->updated_at,
            ]);

       // --- Applicant posts (visible to admin) ---
        $applicantPosts = Post::with(['applicant.personal_info']) // include applicant details
            ->latest() // order by newest post
            ->get()
            ->map(fn($p) => [
                'action' => 'post',
                'email' => $p->applicant->email ?? 'Unknown Applicant',
                'author' => trim(($p->applicant->personal_info->first_name ?? '') . ' ' . ($p->applicant->personal_info->last_name ?? '')),
                'description' => "<strong>APPLICANT:</strong>  {$p->applicant->email} has posted a new post to community forum: " . "<strong>" . strip_tags(Str::limit($p->content, 100)). "</strong>",
                'created_at' => $p->created_at,
            ]);

        //Applicant logins
        $applicantLogins = RegisterModel::whereNotNull('last_login')
            ->latest('last_login')
            ->get()
            ->map(function($u) {
                return [
                    'action' => 'login',
                    'email' => $u->email,
                    'description' => "<strong>APPLICANT:</strong> {$u->email} logged in",
                    'created_at' => $u->last_login,
                ];
            });

        //applicantCreatedAccounts
        $applicantCreatedAccounts = RegisterModel::whereNotNull('created_at')
            ->latest('created_at')
            ->get()
            ->map(function($u) {
                return [
                    'action' => 'created_account',
                    'email' => $u->email,
                    'description' => "<strong>APPLICANT:</strong> {$u->email} created an account",
                    'created_at' => $u->created_at,
                ];
            });

        //Employer logins and account creations can be added similarly if needed
        $employerCreatedAccounts = Employer::whereNotNull('created_at')
            ->latest('created_at')
            ->get()
            ->map(function($u) {
                return [
                    'action' => 'created_account',
                    'email' => $u->email,
                    'description' => "<strong>EMPLOYER:</strong> {$u->email} created an account",
                    'created_at' => $u->created_at,
                ];
            });

        $employerLogins = Employer::whereNotNull('last_login')
            ->latest('last_login')
            ->get()
            ->map(function($u) {
                return [
                    'action' => 'login',
                    'email' => $u->email,
                    'description' => "<strong>EMPLOYER:</strong> {$u->email} logged in",
                    'created_at' => $u->last_login,
                ];
            });

        $employerJobPosts = JobDetailModel::with(['employer.personal_info'])
            ->latest()
            ->get()
            ->map(function($p) {
                $employer = $p->employer;

                    return [
                        'action' => 'post',
                        'email' => $employer?->email ?? 'Unknown Employer',
                        'author' => trim(($employer?->personal_info?->first_name ?? '') . ' ' . ($employer?->personal_info?->last_name ?? '')),
                        'description' => "<strong>EMPLOYER:</strong>  " . ($employer?->email ?? 'Unknown Employer') . " has posted a new job:  " ."<strong>". strip_tags(Str::limit($p->job_description, 100)). "</strong>",
                        'created_at' => $p->created_at,
                    ];
            });


            //upload certification
            $applicantCertifications = TesdaCertification::with(['applicant.personal_info', 'tesda_officer'])
            ->where('status', 'pending')
            ->latest()
            ->get()
            ->map(function($c) {
                $applicant = $c->applicant;

                    return [
                        'action' => 'upload_certification',
                        'email' => $applicant?->email ?? 'Unknown Applicant',
                        'author' => trim(($applicant?->personal_info?->first_name ?? '') . ' ' . ($applicant?->personal_info?->last_name ?? '')),
                        'description' =>  ($applicant?->email ?? 'Unknown Applicant') . " has uploaded a new certification " . "<strong>".strip_tags(Str::limit($c->certification_program, 100)). "</strong>",
                        'created_at' => $c->created_at,
                    ];
            });

            $applicantCertificationApproved = TesdaCertification::with(['applicant.personal_info' , 'tesda_officer'])
            ->where('status', 'approved')
            ->latest()
            ->get()
            ->map(function($c) {
                $approver = $c->tesda_officer;
                $applicant = $c->applicant;

                    return [
                        'action' => 'approved_certification',
                        'email' => $applicant?->email ?? 'Unknown Applicant',
                        'author' => trim(($applicant?->personal_info?->first_name ?? '') . ' ' . ($applicant?->personal_info?->last_name ?? '')),
                        'description' => ($applicant?->email ?? 'Unknown Applicant') . " certification of " .($c->certification_program ?? 'Unknown Certification') . " has been approved  by tesda_officer : " . ($approver?->first_name ?? 'Unknown tesda_officer') . " " . strip_tags(Str::limit($c->officer_comment, 100)),
                        'created_at' => $c->created_at,
                    ];
            });

            $applicantCertificationRejected = TesdaCertification::with(['applicant.personal_info' , 'tesda_officer'])
            ->where('status', 'rejected')
            ->latest()
            ->get()
            ->map(function($c) {
                $approver = $c->tesda_officer;
                $applicant = $c->applicant;

                    return [
                        'action' => 'rejected_certification',
                        'email' => $applicant?->email ?? 'Unknown Applicant',
                        'author' => trim(($applicant?->personal_info?->first_name ?? '') . ' ' . ($applicant?->personal_info?->last_name ?? '')),
                        'description' => "Rejected certification by tesda_officer  " . ($approver?->first_name ?? 'Unknown tesda_officer') . " " . strip_tags(Str::limit($c->officer_comment, 100)),
                        'created_at' => $c->created_at,
                    ];
            });

            $applicantCertificationRequestedRevision = TesdaCertification::with(['applicant.personal_info' , 'tesda_officer'])
            ->where('status', 'request_revision')
            ->latest()
            ->get()
            ->map(function($c) {
                $approver = $c->tesda_officer;
                $applicant = $c->applicant;

                    return [
                        'action' => 'request_revision_certification',
                        'email' => $applicant?->email ?? 'Unknown Applicant',
                        'author' => trim(($applicant?->personal_info?->first_name ?? '') . ' ' . ($applicant?->personal_info?->last_name ?? '')),
                         'description' => ($applicant?->email ?? 'Unknown Applicant') . " certification of " .($c->certification_program ?? 'Unknown Certification') . " has been requested revision by tesda_officer  " . ($approver?->first_name ?? 'Unknown tesda_officer') . " : " ."<strong>" . strip_tags(Str::limit($c->officer_comment, 100)). "</strong>",
                        'created_at' => $c->created_at,
                    ];
            });

         // Apply job logs
            $applicantApplyJobPosts = ApplyJobModel::with(['applicant.personal_info', 'job'])
                ->latest()
                ->get()
                ->map(function ($a) {
                    $applicant = $a->applicant;
                    $job = $a->job;

                        return [
                            'action' => 'apply_job',
                            'email' => $applicant?->email ?? 'Unknown Applicant',
                            'author' => trim(($applicant?->personal_info?->first_name ?? '') . ' ' . ($applicant?->personal_info?->last_name ?? '')),
                            'description' => '<strong>APPLICANT:</strong> ' . ($applicant?->email ?? 'Unknown Applicant') . ' applied for the job <strong>' . ($job?->title ?? 'Unknown Job') . '</strong>','created_at' => $a->created_at,
                        ];
            });

            
        // Reject applicant logs
            $applicantRejectJobPosts = ApplyJobModel::with(['applicant.personal_info', 'job'])
                ->where('status', 'rejected')
                ->latest()
                ->get()
                ->map(function ($a) {
                    $applicant = $a->applicant;
                    $job = $a->job;

                        return [
                            'action' => 'reject_job',
                            'email' => $applicant?->email ?? 'Unknown Applicant',
                            'author' => trim(($applicant?->personal_info?->first_name ?? '') . ' ' . ($applicant?->personal_info?->last_name ?? '')),
                            'description' => '<strong>EMPLOYER:</strong> Rejected the application of ' . ($applicant?->email ?? 'Unknown Applicant') . ' for the job <strong>' . ($job?->title ?? 'Unknown Job') . '</strong>', 'created_at' => $a->created_at,
                        ];
            });

            //Announcement logs can be added similarly if needed
            $adminPostedAnnouncements = AnnouncementModel::with('admin')
            ->latest()
            ->get()
            ->map(function ($a) {
                $admin = $a->admin;

                    return [
                        'action' => 'post_announcement',
                        'email' => $admin?->email ?? 'Unknown Admin',
                        'author' => trim(($admin?->first_name ?? '') . ' ' . ($admin?->last_name ?? '')),
                        'description' => '<strong>ANNOUNCEMENT:</strong> ' . strip_tags(Str::limit($a->title, 100)), strip_tags(Str::limit($a->content, 100)),'created_at' => $a->created_at,
                    ];
            });

            $employerPostGotReports = ReportModel::with(['applicant.personal_info', 'job.employer.addressCompany'])
            ->latest()
            ->get()
            ->map(function ($a) {
                $applicant = $a->applicant;
                $job = $a->job;
                $employer = $job?->employer; // Employer who owns the job

                // Map the reason to readable text
                $reasonText = match($a->reason) {
                    'fraudulent' => 'Fraudulent or Scam Job',
                    'misleading' => 'Misleading Information',
                    'discriminatory' => 'Discriminatory Content',
                    'inappropriate' => 'Inappropriate Content',
                    'other' => strip_tags(Str::limit($a->other_reason ?? 'Other', 100)),
                    default => strip_tags(Str::limit($a->reason ?? 'Unknown', 100)),
                };

                // Prepare attachment URL if exists
                $attachmentUrl = $a->attachment ? asset('storage/' . ltrim($a->attachment, '/')) : null;

                return [
                    'action' => 'report_job',
                    'email' => $applicant?->email ?? 'Unknown Applicant',
                    'author' => trim(($applicant?->personal_info?->first_name ?? '') . ' ' . ($applicant?->personal_info?->last_name ?? '')),
                    'description' => '<strong>APPLICANT:</strong> ' . ($applicant?->email ?? 'Unknown Applicant') .
                             ' has reported the job <strong>' . ($job?->title ?? 'Unknown Job') . '</strong>' .
                             ' posted by <strong>' . ($employer?->addressCompany?->company_name ?? 'Unknown Company') . '</strong>' .
                             ' (Email: ' . ($employer?->email ?? 'N/A') . ')' .
                             ' for review. <br><strong>Reason:</strong> ' . $reasonText,
                    'attachment' => $attachmentUrl,
                    'created_at' => $a->created_at,
                ];
            });


                // Map to include reports_received
                $users = $users->map(function ($user) {

                    if ($user['type'] === 'applicant') {
                        // Applicant — direct reported_id
                        $reportedId = $user['data']->id;

                        $reportCount = \App\Models\Report\ReportModel::where('reported_id', $reportedId)
                            ->where('reported_type', 'applicant')
                            ->count();

                        } elseif ($user['type'] === 'employer') {
                        // Employer — use employer_id directly
                        $employerId = $user['data']->id;

                        $reportCount = \App\Models\Report\ReportModel::where(function ($query) use ($employerId) {
                            $query->orWhere('employer_id', $employerId);
                        })->count();
                        } else { $reportCount = 0; }

                        $user['reports_received'] = $reportCount;
                        return $user;
                    });


          // Applicant Got Reports
$applicantGotReports = \App\Models\Report\ReportModel::with(['applicant.personal_info', 'employer.personal_info'])
    ->where('reported_type', 'applicant')
    ->latest()
    ->get()
    ->map(function ($a) {
        $applicant = $a->applicant;
        $employer = $a->employer; // Employer who reported

        // Map the reason to readable text
        $reasonText = match($a->reason) {
            'fraudulent' => 'Fraudulent or Scam Job',
            'misleading' => 'Misleading Information',
            'discriminatory' => 'Discriminatory Content',
            'inappropriate' => 'Inappropriate Content',
            'other' => strip_tags(Str::limit($a->other_reason ?? 'Other', 100)),
            default => strip_tags(Str::limit($a->reason ?? 'Unknown', 100)),
        };

        // Prepare attachment URL if exists
        $attachmentUrl = $a->attachment ? asset('storage/' . ltrim($a->attachment, '/')) : null;

        // Get applicant full name
        $applicantName = trim(
            ($applicant?->personal_info?->first_name ?? '') . ' ' . 
            ($applicant?->personal_info?->last_name ?? '')
        );

        // Get employer full name or company name
        $employerName = trim(
            ($employer?->personal_info?->first_name ?? '') . ' ' . 
            ($employer?->personal_info?->last_name ?? '')
        );

        // Build professional description
        $description = '<strong>EMPLOYER:</strong> ' . 
                        ($employerName ?: 'Unknown Employer') . 
                        ' (' . ($employer?->email ?? 'N/A') . ')' .
                        ' has reported the applicant <strong>' . 
                        ($applicantName ?: 'Unknown Applicant') . 
                        '</strong> (' . ($applicant?->email ?? 'N/A') . ') for review.' .
                        '<br><strong>Reason:</strong> ' . $reasonText;

        return [
            'action' => 'report_applicant',
            'email' => $applicant?->email ?? 'Unknown Applicant',
            'author' => $applicantName ?: 'Unknown Applicant',
            'description' => $description,
            'attachment' => $attachmentUrl,
            'created_at' => $a->created_at,
        ];
    });













        

        $activityLogs = collect()
            ->merge($applicantGotReports)
            ->merge($employerPostGotReports)
            ->merge($adminPostedAnnouncements)
            ->merge($applicantRejectJobPosts)
            ->merge($applicantApplyJobPosts)
            ->merge($applicantCertificationRequestedRevision)
            ->merge($applicantCertificationRejected)
            ->merge($applicantCertificationApproved)
            ->merge($applicantCertifications)
            ->merge($employerJobPosts)
            ->merge($employerLogins)
            ->merge($employerCreatedAccounts)
            ->merge($applicantCreatedAccounts)
            ->merge($applicantLogins)
            ->merge($applicantPosts)
            ->merge($applicantSuspensions)
            ->merge($employerSuspensions)
            ->merge($applicantBanned)
            ->merge($employerBanned)
            ->merge($applicantUnbans)
            ->merge($employerUnbans)
            ->sortByDesc('created_at')
            ->values();

        return view('admin.homepage.homepage', compact(
            'employerCount',
            'applicantsCount',
            'applicantsThisMonth',
            'change',
            'isTrendingUp',
            'employersTrendingUp',
            'employerChange',
            'totalUsers',
            'percentageGrowth',
            'retrieveAdmin',
            'last_login',
            'retrieveTesdaOfficers',
            'retrieveAnnouncements',
            'weeklyAnnouncements',
            'retrieveAnnouncementsTotal',
            'publishedAnnouncementTotal',
            'tesdaOfficersCount',
            'newTesdaOfficers',
            'chartData',
            'colors',
            'users',
            'banChartData',
            'banColors',
            'retrieveAccountBanApplicant',
            'retrieveAccountBanEmployer',
            'suspendedChartData',
            'suspendedColors',
            'retrievedSuspendedApplicants',
            'retrievedSuspendedEmployers',
            'certificationsChartData',
            'certificationsColors',
            'retrievedCertificationCount',
            'activityLogs'
        ));
    }

    // --- Safe decrypt helper ---
    private function safeDecrypt($value)
    {
        try {
            return $value ? Crypt::decrypt($value) : null;
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return $value;
        }
    }

    // Login
    public function loginDisplay()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            $admin = Auth::guard('admin')->user();
            $admin->last_login = Carbon::now();
            $admin->save();

            return redirect('/admin/homepage')->with('success', 'Welcome, Admin!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login.display')
            ->with('success', 'You have been logged out successfully.');
    }

    // Add TESDA officer
    public function addTesdaOfficer(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:tesda_officers,email',
            'temporary_password' => 'required|string|min:8',
            'status' => 'required|string|in:active,inactive',
        ]);

        $tesdaOfficer = new AddTesdaOfficer();
        $tesdaOfficer->first_name = $request->first_name;
        $tesdaOfficer->last_name = $request->last_name;
        $tesdaOfficer->email = $request->email;
        $tesdaOfficer->password = Hash::make($request->temporary_password);
        $tesdaOfficer->status = $request->status;
        $tesdaOfficer->save();

        return redirect()->route('admin.homepage.display')->with('success', 'TESDA Officer added successfully!');
    }

    public function updateTesdaOfficer(Request $request, $officer_id)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
            'status' => 'required|string|in:active,inactive',
        ]);

        $tesdaOfficer = AddTesdaOfficer::find($officer_id);
        if (!$tesdaOfficer) {
            return redirect()->back()->with('error', 'TESDA Officer not found.');
        }

        $tesdaOfficer->first_name = $request->first_name;
        $tesdaOfficer->last_name = $request->last_name;
        $tesdaOfficer->email = $request->email;
        $tesdaOfficer->password = Hash::make($request->password);
        $tesdaOfficer->status = $request->status;
        $tesdaOfficer->save();

        return redirect()->route('admin.homepage.display')->with('success', 'TESDA Officer updated successfully!');
    }

    public function deleteTesdaOfficer($officer_id)
    {
        $tesdaOfficer = AddTesdaOfficer::find($officer_id);
        if ($tesdaOfficer) {
            $tesdaOfficer->delete();
            return redirect()->back()->with('success', 'TESDA Officer deleted successfully.');
        }

        return redirect()->back()->with('error', 'TESDA Officer not found.');
    }
}
