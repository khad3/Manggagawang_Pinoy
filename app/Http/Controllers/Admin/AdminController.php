<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Applicant\TesdaUploadCertificationModel;
use App\Models\Employer\PersonalInformationModel;
use Illuminate\Http\Request;

use App\Models\Admin\AccountAdminModel as Admin;
use App\Models\Admin\AddTesdaOfficerModel as AddTesdaOfficer;
use App\Models\Applicant\TesdaUploadCertificationModel as TesdaCertification;
use App\Models\Employer\JobDetailModel as JobDetails;
use App\Models\Report\ReportModel;
use Illuminate\Support\Str;
use App\Models\Applicant\PostModel as Post;
use App\Models\Admin\UserManagmentModel;
use App\Models\Admin\AnnouncementModel;
use App\Models\Applicant\ApplicantFriendModel;
use App\Models\Applicant\ApplicantPortfolioModel;
use App\Models\Applicant\ApplicantPostLikeModel;
use App\Models\Applicant\ApplicantUrlModel;
use App\Models\Applicant\ApplyJobModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

// Employer Model
use App\Models\Employer\AccountInformationModel as Employer;
// Applicants Model
use App\Models\Applicant\RegisterModel;
use App\Models\Applicant\SendRatingToJobPostModel;
use App\Models\Employer\AccountInformationModel;
use App\Models\Employer\AdditionalInformationModel;
use App\Models\Employer\EmergencyContactModel;
use App\Models\Employer\HiringTimelineModel;
use App\Models\Employer\InterviewScreeningModel;
use App\Models\Employer\JobDetailModel;
use App\Models\Employer\SendNotificationToApplicantModel;
use App\Models\Employer\SendRatingModel;
use App\Models\Employer\SetInterviewModel;
use App\Models\User;
use Faker\Provider\ar_EG\Company;
use Illuminate\Contracts\Queue\Job;
use Illuminate\Queue\Worker;
use Illuminate\Support\Facades\App;
use League\Uri\UriTemplate\Template;

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
                'created_at' =>  $p->updated_at ?? $p->created_at,
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
                    'created_at' =>  $u->updated_at ?? $u->created_at,
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
                    'created_at' =>  $u->updated_at ?? $u->created_at,
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
                        'created_at' =>  $p->updated_at ?? $p->created_at,
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
                        'created_at' =>  $c->updated_at ?? $c->created_at,
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
                        'created_at' =>  $c->updated_at ?? $c->created_at,
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
                        'created_at' =>  $c->updated_at ?? $c->created_at,
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
                        'created_at' =>  $c->updated_at ?? $c->created_at,
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
                            'description' => '<strong>APPLICANT:</strong> ' . ($applicant?->email ?? 'Unknown Applicant') . ' applied for the job <strong>' . ($job?->title ?? 'Unknown Job') . '</strong>','created_at' => $a-> $a->updated_at ?? $a->created_at,
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
                            'description' => '<strong>EMPLOYER:</strong> Rejected the application of ' . ($applicant?->email ?? 'Unknown Applicant') . ' for the job <strong>' . ($job?->title ?? 'Unknown Job') . '</strong>', 'created_at' =>  $a->updated_at ?? $a->created_at,
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
                        'description' => '<strong>ANNOUNCEMENT:</strong> ' . strip_tags(Str::limit($a->title, 100)), strip_tags(Str::limit($a->content, 100)),'created_at' =>  $a->updated_at ?? $a->created_at,
                    ];
            });

           $employerPostGotReports = ReportModel::with(['applicant.personal_info', 'job.employer.addressCompany'])
            ->where('reported_type', 'employer')
            ->latest()
            ->get()
            ->map(function ($a) {
                $applicant = $a->applicant;
                $job = $a->job;
                $employer = $job?->employer; // Employer who owns the job

                // Decrypt applicant's personal information
                $firstName = $this->safeDecrypt($applicant?->personal_info?->first_name);
                $lastName  = $this->safeDecrypt($applicant?->personal_info?->last_name);
                $applicantName = trim($firstName . ' ' . $lastName);

                // Convert reason to readable text
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
                    'author' => $applicantName ?: 'Unknown Applicant',
                    'description' => '<strong>APPLICANT:</strong> ' . ($applicantName ?: 'Unknown Applicant') .' (' . ($applicant?->email ?? 'N/A') . ')' .
                    ' has reported the job post <strong>' . ($job?->title ?? 'Unknown Job') . '</strong>' .
                    ' published by <strong>' . ($employer?->addressCompany?->company_name ?? 'Unknown Company') . '</strong>' .
                    ' (Email: ' . ($employer?->email ?? 'N/A') . ') for further review.' .
                    '<br><strong>Reason:</strong> ' . $reasonText .
                    '<br><strong>Additional Details:</strong> ' . ($a->additional_info ?? 'No additional details provided.'),
                    'attachment' => $attachmentUrl,
                    'created_at' =>  $a->updated_at ?? $a->created_att,
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
            $applicantGotReports = \App\Models\Report\ReportModel::with(['appplicantReported.personal_info', 'employer.personal_info','jobReporter.employer.company'])
             ->where('reported_type', 'applicant')
             ->latest()
             ->get()
             ->map(function ($a) {
                $applicant = $a->appplicantReported;
                $employer = $a->employerReporter;

                //  Convert reason to readable text
                $reasonText = match($a->reason) {
                    'fraudulent' => 'Fraudulent or Scam Job',
                    'misleading' => 'Misleading Information',
                    'discriminatory' => 'Discriminatory Content',
                    'inappropriate' => 'Inappropriate Content',
                    'other' => strip_tags(Str::limit($a->other_reason ?? 'Other', 100)),
                    default => strip_tags(Str::limit($a->reason ?? 'Unknown', 100)),
                };

                //  Attachment URL
                $attachmentUrl = $a->attachment ? asset('storage/' . ltrim($a->attachment, '/')) : null;

                // Clean applicant names
                $firstName = $this->safeDecrypt($applicant?->personal_info?->first_name);
                $lastName  = $this->safeDecrypt($applicant?->personal_info?->last_name);
                $applicantName = trim($firstName . ' ' . $lastName);

                // Employer company name
                $companyName = $employer?->addressCompany?->company_name ?? 'Unknown Employer';

                // Description
                $description = '<strong>EMPLOYER:</strong> ' . $companyName . ' has reported the applicant <strong>' .($applicantName ?: 'Unknown Applicant') .
                    '</strong> (' . ($applicant?->email ?? 'N/A') . ') for further review.' .
                    '<br><strong>Reason:</strong> ' . $reasonText .
                    '<br><strong>Additional Details:</strong> ' . ($a->additional_info ?? 'No additional details provided.');

                    return [
                        'action' => 'report_applicant',
                        'email' => $applicant?->email ?? 'Unknown Applicant',
                        'author' => $applicantName ?: 'Unknown Applicant',
                        'description' => $description,
                        'attachment' => $attachmentUrl,
                        'created_at' =>  $a->updated_at ?? $a->created_at,
                    ];
            });
            function safeDecrypt($value) {
                if (empty($value)) return null;

                // If serialized, unserialize first
                if (@unserialize($value) !== false || $value === 'b:0;') {
                     $value = unserialize($value);
                }

                try {
                    return Crypt::decryptString($value);
                } catch (\Exception $e) {
                    return $value; // return original if not encrypted
                }
            }

            $employerJobPosts = \App\Models\Applicant\ApplyJobModel::with(['applicant.personal_info', 'job.employer.addressCompany'])
            ->where('status', 'approved')
            ->latest()
            ->get()
            ->map(function ($a) {
                $info = $a->applicant->personal_info ?? null;
                $job = $a->job ?? null;

                $firstName = $info ? $this->safeDecrypt($info->first_name) : 'Unknown';
                $lastName = $info ? $this->safeDecrypt($info->last_name) : 'Applicant';

                return [
                    'action' => 'approved_job',
                    'email' => $info ? safeDecrypt($info->email) : 'No email',
                    'author' => $firstName . ' ' . $lastName,
                    'description' => 'EMPLOYER: <strong>' . ($job->employer->addressCompany->company_name ?? 'Unknown Company') . '</strong>' .
                    ' — The job "<strong>' . ($job->title ?? 'N/A') . '</strong>" applied by <strong>' . $firstName . ' ' . $lastName . '</strong>' .
                    ' has been approved.',

                    'created_at' =>  $a->updated_at ?? $a->created_at,
                ];
            });

            // Employer job posts
            $employerJobPost = \App\Models\Employer\JobDetailModel::with(['employer.addressCompany'])
            ->where('status_post', 'published')
            ->latest()
            ->get()
            ->map(function ($a) {
                $info = $a->employer->addressCompany ?? null;

                return [
                    'action' => 'published_job',
                    'email' => $info ? safeDecrypt($info->email) : 'No email',
                    'author' => $info ? safeDecrypt($info->company_name) : 'Unknown Company',
                    'description' => '<strong>EMPLOYER:</strong> <strong>' . 
                        ($info ? safeDecrypt($info->company_name) : 'Unknown Company') . 
                        '</strong> — The job "<strong>' . 
                        ($a->title ?? 'N/A') . 
                        '</strong>" has been approved and published.',
                    'created_at' =>  $a->updated_at ?? $a->created_at,
                ];
            });

            //Employer draft job posts
            $employerDraftJobPost = \App\Models\Employer\JobDetailModel::with(['employer.addressCompany'])
            ->where('status_post', 'draft')
            ->latest()
            ->get()
            ->map(function ($a) {
                $info = $a->employer->addressCompany ?? null;

                return [
                    'action' => 'draft_job',
                    'email' => $info ? safeDecrypt($info->email) : 'No email',
                    'author' => $info ? safeDecrypt($info->company_name) : 'Unknown Company',
                    'description' => '<strong>EMPLOYER:</strong> <strong>' . 
                        ($info ? safeDecrypt($info->company_name) : 'Unknown Company') . 
                        '</strong> — The job "<strong>' . 
                        ($a->title ?? 'N/A') . 
                        '</strong>" has been saved as a draft.',
                    'created_at' =>  $a->updated_at ?? $a->created_at,
                ];
            });

            //Interview
         $employerInterview = \App\Models\Applicant\ApplyJobModel::with(['applicant.personal_info','job.employer.addressCompany'])
        ->where('status', 'interview')
        ->latest()
        ->get()
        ->map(function ($a) {
            $info = $a->applicant->personal_info ?? null;
            $job = $a->job ?? null;

            $firstName = $info ? $this->safeDecrypt($info->first_name) : 'Unknown';
            $lastName = $info ? $this->safeDecrypt($info->last_name) : 'Applicant';
            $email = $info ? $this->safeDecrypt($info->email) : 'No email';
            $companyName = $job->employer->addressCompany->company_name ?? 'Unknown Company';
            $jobTitle = $job->title ?? 'N/A';

            return [
                'action' => 'interview_job',
                'email' => $email,
                'author' => $firstName . ' ' . $lastName,
                'description' => 'EMPLOYER: <strong>' . $companyName . '</strong>' .
                         ' — The job "<strong>' . $jobTitle . '</strong>" applied by <strong>' . 
                         $firstName . ' ' . $lastName . '</strong> has been scheduled for an <strong>INTERVIEW</strong>.',
                'created_at' => $a->updated_at ?? $a->created_at,
            ];
        });
        
       // Send rating to employer
$applicantSendRating = \App\Models\Applicant\SendRatingToJobPostModel::with([
        'jobPost.employer.addressCompany',
        'applicant.personal_info'
    ])
    ->latest()
    ->get()
    ->map(function ($a) {
        $info = $a->applicant->personal_info ?? null;
        $job = $a->jobPost ?? null;

        $firstName = $info ? $this->safeDecrypt($info->first_name) : 'Unknown';
        $lastName = $info ? $this->safeDecrypt($info->last_name) : 'Applicant';
        $email = $info ? $this->safeDecrypt($info->email) : 'No email';
        $companyName = $job->employer->addressCompany->company_name ?? 'Unknown Company';
        $jobTitle = $job->title ?? 'N/A';
        $rating = $a->rating ?? 'N/A';
        $feedback = $a->review_comments ?? 'No feedback provided';

        return [
            'action' => 'send_rating_to_job_post',
            'email' => $email,
            'author' => $firstName . ' ' . $lastName,
            'description' => 'EMPLOYER: <strong>' . e($companyName) . '</strong> — ' .
                'The job "<strong>' . e($jobTitle) . '</strong>" has been <strong>RATED</strong> by ' .
                '<strong>' . e($firstName . ' ' . $lastName) . '</strong> ' .
                'with a <strong>' . e($rating) . '/5</strong> rating.<br>' .
                '<em>Feedback:</em> "' . e($feedback) . '"',
            'created_at' => $a->updated_at ?? $a->created_at,
        ];
    });


    // Employer sends rating to applicant (no jobPost relation)
    $employerSendRating = \App\Models\Employer\SendRatingModel::with(['employer.addressCompany', 'employer.personal_info', 'applicant.personal_info'])
    ->latest()
    ->get()
    ->map(function ($a) {
        // Applicant info (decrypted)
        $applicantInfo = $a->applicant->personal_info ?? null;
        $applicantFirst = $applicantInfo ? $this->safeDecrypt($applicantInfo->first_name) : 'Unknown';
        $applicantLast = $applicantInfo ? $this->safeDecrypt($applicantInfo->last_name) : 'Applicant';
        $applicantEmail = $applicantInfo ? $this->safeDecrypt($applicantInfo->email) : 'No email';

        // Employer info (not decrypted)
        $employerInfo = $a->employer->personal_info ?? null;
        $employerFirst = $employerInfo->first_name ?? 'Unknown';
        $employerLast = $employerInfo->last_name ?? 'Employer';

        // Company info
        $company = $a->employer->addressCompany ?? null;
        $companyName = $company->company_name ?? 'Unknown Company';

        // Rating details
        $rating = $a->rating ?? 'N/A';
        $feedback = $a->review_comments ?? null;

        // Description message
        $description = 'APPLICANT: <strong>' . e($applicantFirst . ' ' . $applicantLast) . '</strong> — ' .
            'Your <strong>work portfolio and TESDA certifications</strong> have been reviewed and rated by ' .
            '<strong>' . e($employerFirst . ' ' . $employerLast) . '</strong> from <strong>' . e($companyName) . '</strong>. ' .
            'You received a <strong>' . e($rating) . '/5</strong> rating.';

        if (!empty($feedback)) {
            $description .= '<br><em>Employer feedback:</em> "' . e($feedback) . '"';
        }

        // Final return data
        return [
            'action' => 'send_rating_to_applicant',
            'email' => $applicantEmail,
            'author' => $employerFirst . ' ' . $employerLast,
            'description' => $description,
            'created_at' => $a->updated_at ?? $a->created_at,
        ];
    });


        $activityLogs = collect()
            ->merge($employerSendRating)
            ->merge($applicantSendRating)
            ->merge($employerInterview)
            ->merge($employerDraftJobPost)
            ->merge($employerJobPost)
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


        // Total approved certifications
        $totalIssueCertifications = \App\Models\Applicant\TesdaUploadCertificationModel::where('status', 'approved')->count();

        // Current month
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Approved certifications this month
        $currentMonthCount = \App\Models\Applicant\TesdaUploadCertificationModel::where('status', 'approved')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->count();

        // Previous month
        $previousMonth = Carbon::now()->subMonth();
        $previousMonthCount = \App\Models\Applicant\TesdaUploadCertificationModel::where('status', 'approved')
            ->whereYear('created_at', $previousMonth->year)
            ->whereMonth('created_at', $previousMonth->month)
            ->count();

        // Calculate percentage change
        if ($previousMonthCount == 0 && $currentMonthCount > 0) {
            $percentageChange = 100; 
        } elseif ($previousMonthCount == 0 && $currentMonthCount == 0) {
            $percentageChange = 0;
        } elseif ($currentMonthCount == 0) {
            $percentageChange = 0; // avoid -100%
        } else {
            $percentageChange = (($currentMonthCount - $previousMonthCount) / $previousMonthCount) * 100;
        }
        // Format percentage
        $percentageChange = round($percentageChange, 2);


        //Chart
       $allMonths = collect(range(1, 12))->map(function ($m) {
    return Carbon::create(null, $m, 1)->format('Y-m');
});

    // Get approved applicants grouped by month
    $approvedApplicants = ApplyJobModel::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total")
        ->where('status', 'approved')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

    // Build chart data with all months
    $approvedChartData = [];
    $approvedChartData[] = "['Month', 'Approved Applicants']";

    foreach ($allMonths as $month) {
        $monthLabel = Carbon::createFromFormat('Y-m', $month)->format('M');
        $count = $approvedApplicants->get($month, 0); // show 0 if no data
        $approvedChartData[] = "['{$monthLabel}', {$count}]";
    }

    // Chart color
    $Approvedcolors = ['#43A047'];

    $topJobs = ApplyJobModel::selectRaw('job_id, COUNT(*) as total')
        ->where('status', 'approved')
        ->groupBy('job_id')
        ->orderByDesc('total')
        ->limit(10)
        ->with('job')
        ->get();

    $topJobsChartData = [];
    $topJobsChartData[] = "['Job Title', 'Hired Applicants']";

    foreach ($topJobs as $record) {
        $jobTitle = addslashes($record->job->department ?? 'Unknown Department').' - '. addslashes($record->job->title ?? 'Unknown Job title') ;
        $topJobsChartData[] = "['{$jobTitle}', {$record->total}]";
    }

    $topJobsColors = ['#FF9800'];


    // Applicant Per Location
    $approvedByLocation = ApplyJobModel::where('status', 'approved')
        ->with('applicant.personal_info') // to access city
        ->get()
        ->groupBy(function ($record) {
            try {
                $cityValue = $record->applicant->personal_info->city ?? 'Unknown';

                // Check if the value looks encrypted (encrypted values are usually long base64 strings)
                if (preg_match('/^[A-Za-z0-9+\/=]{80,}$/', $cityValue)) {
                    return Crypt::decryptString($cityValue);
                }

                //  Otherwise, return as-is (already plain text)
                return $cityValue ?: 'Unknown City';
            } catch (\Exception $e) {
             return 'Unknown City';
            }
        })->map(function ($group) { return $group->count();});

    // Build chart data
    $locationChartData = [];
    $locationChartData[] = "['City', 'Approved Applicants']";

    foreach ($approvedByLocation as $city => $count) {
        $safeCity = addslashes($city);
        $locationChartData[] = "['{$safeCity}', {$count}]";
    }
    // Chart color
    $locationColors = ['#43A047']; // green tone



    // Get all jobs with employer info
    $jobsByLocation = JobDetails::where('status_post', 'published')->with('employer.AddressCompany')
        ->get()
        ->groupBy(function ($job) {
            try {
                $cityValue = $job->employer->addressCompany->company_municipality ?? 'Unknown';

                if ($cityValue) {
                    // Check if it looks encrypted (base64-like string)
                    if (preg_match('/^[A-Za-z0-9+\/=]{80,}$/', $cityValue)) {
                        // Decrypt if encrypted
                        return Crypt::decryptString($cityValue);
                    } else {
                        //  Already decrypted / plain text
                        return $cityValue;
                    }
                } else {
                    return 'Unknown City';
                }
            } catch (\Exception $e) {
                return 'Unknown City';
            }
        })->map(function ($group) {
            return $group->count(); // count jobs per city
    });

    //  Build chart data
    $jobsLocationChartData = [];
    $jobsLocationChartData[] = "['City', 'Jobs Posted']";

    foreach ($jobsByLocation as $city => $count) {
        $safeCity = addslashes($city);
        $jobsLocationChartData[] = "['{$safeCity}', {$count}]";
    }
    // Chart color
    $jobsLocationColors = ['#1E88E5']; // blue tone


    // Fetch ALL applications (not just approved)
    $applications = ApplyJobModel::with('job.employer.addressCompany')->get();

    $employmentRatesByCity = $applications->groupBy(function ($record) {
        try {
            $cityValue = $record->job->employer->addressCompany->company_municipality ?? 'Unknown';

            // Decrypt if it's encrypted
            if ($cityValue && preg_match('/^[A-Za-z0-9+\/=]{80,}$/', $cityValue)) {
                return Crypt::decryptString($cityValue);
            }

            return $cityValue ?: 'Unknown City';
        } catch (\Exception $e) {
            return 'Unknown City';
        }
    })->map(function ($group) {
    // Compute counts
    $approvedCount = $group->where('status', 'approved')->count();
    $totalCount = $group->count();
    // Compute rate safely
    $rate = $totalCount > 0 ? round(($approvedCount / $totalCount) * 100, 2) : 0;
    return $rate;
    });

    //  Build chart data
    $employmentRateChartData = [];
    $employmentRateChartData[] = "['City', 'Employment Rate (%)']";

    foreach ($employmentRatesByCity as $city => $rate) {
        $safeCity = addslashes($city);
        $employmentRateChartData[] = "['{$safeCity}', {$rate}]";
    }
    $employmentRateColors = ['#FFC107'];

        

        return view('admin.homepage.homepage', compact(
            'employmentRateChartData',
            'employmentRateColors',
            'jobsLocationChartData',
            'jobsLocationColors',
            'locationChartData',
            'locationColors',
            'locationChartData',
            'jobTitle',
            'topJobsChartData',
            'topJobsColors',
            'approvedChartData',
            'Approvedcolors',
            'employerCount',
            'totalIssueCertifications',

            'currentMonthCount',
            'percentageChange',
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



 
public function deleteApplicantOrEmployer(Request $request, $id)
{
    $type = $request->input('type'); // must be 'applicant' or 'employer'

    if (!$type || !in_array($type, ['applicant', 'employer'])) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid user type.'
        ], 400);
    }

    DB::beginTransaction();

    try {
        if ($type === 'applicant') {
            $user = RegisterModel::find($id);
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Applicant not found.'
                ], 404);
            }

            // Delete related applicant data
            ApplicantFriendModel::where('request_id', $id)->orWhere('receiver_id', $id)->delete();
            \App\Models\Applicant\ApplicantPostModel::where('applicant_id', $id)->delete();
            ApplicantPortfolioModel::where('applicant_id', $id)->delete();
            \App\Models\Applicant\ApplicantPostCommentModel::where('applicant_id', $id)->delete();
            ApplicantPostLikeModel::where('applicant_id', $id)->delete();
            ApplicantUrlModel::where('applicant_id', $id)->delete();
            ApplyJobModel::where('applicant_id', $id)->delete();
            \App\Models\Applicant\CommentModel::where('applicant_id', $id)->delete();
            \App\Models\Applicant\ExperienceModel::where('applicant_id', $id)->delete();
            \App\Models\Applicant\GroupCommentModel::where('applicant_id', $id)->delete();
            \App\Models\Applicant\GroupLikeModel::where('applicant_id', $id)->delete();
            \App\Models\Applicant\GroupModel::where('applicant_id', $id)->delete();
            \App\Models\Applicant\LikeModel::where('applicant_id', $id)->delete();
            \App\Models\Applicant\ParticipantModel::where('applicant_id', $id)->delete();
            \App\Models\Applicant\PersonalModel::where('applicant_id', $id)->delete();
            \App\Models\Applicant\PostModel::where('applicant_id', $id)->delete();
            \App\Models\Applicant\PostSpecificGroupModel::where('applicant_id', $id)->delete();
            \App\Models\Applicant\ReplyModel::where('applicant_id', $id)->delete();
            \App\Models\Applicant\SavedJobModel::where('applicant_id', $id)->delete();
            SendRatingToJobPostModel::where('applicant_id', $id)->delete();
            \App\Models\Applicant\TemplateModel::where('applicant_id', $id)->delete();
            TesdaUploadCertificationModel::where('applicant_id', $id)->delete();

        } elseif ($type === 'employer') {
            $user = AccountInformationModel::find($id);
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Employer not found.'
                ], 404);
            }

            // Delete related employer data
            AdditionalInformationModel::where('employer_id', $id)->delete();
            \App\Models\Employer\CommunicationPreferenceModel::where('employer_id', $id)->delete();
            \App\Models\Employer\CompanyAdressModel::where('employer_id', $id)->delete();
            EmergencyContactModel::where('employer_id', $id)->delete();
            HiringTimelineModel::where('employer_id', $id)->delete();
            InterviewScreeningModel::where('employer_id', $id)->delete();
            \App\Models\Employer\JobDetailModel::where('employer_id', $id)->delete();
            PersonalInformationModel::where('employer_id', $id)->delete();
            SendNotificationToApplicantModel::where('employer_id', $id)->delete();
            SendRatingModel::where('employer_id', $id)->delete();
            \App\Models\Employer\SpecialRequirementModel::where('employer_id', $id)->delete();
            \App\Models\Employer\WorkerRequirementModel::where('employer_id', $id)->delete();
            \App\Models\Employer\TesdaPriorityModel::where('employer_id', $id)->delete();
            SetInterviewModel::where('employer_id', $id)->delete();
        }

        // Delete main user record
        $user->delete();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => ucfirst($type) . ' deleted successfully.'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Error deleting user: '.$e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Failed to delete user. Error: ' . $e->getMessage()
        ], 500);
    }
}

// AdminController.php
public function markReportsAsRead($reportedId, $reportedType)
{
    try {
        \App\Models\Report\ReportModel::where('reported_id', $reportedId)
            ->where('reported_type', $reportedType)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true, 'message' => 'Reports marked as read.']);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to mark reports as read: ' . $e->getMessage(),
        ], 500);
    }
}




}
