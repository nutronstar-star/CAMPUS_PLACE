<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="CampusPlace - National Placement Management System for India. Free for colleges and students. DPDP compliant.">
    <title>CampusPlace — National Placement Management System</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/campusplace-icon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-800 bg-white">

<header class="sticky top-0 z-40 backdrop-blur bg-white/80 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <a href="/" class="flex items-center gap-2">
            <img src="{{ asset('images/campusplace-icon.svg') }}" alt="" class="h-10 w-10">
            <span class="text-xl font-bold text-slate-900">Campus<span class="text-sky-600">Place</span></span>
        </a>
        <nav class="flex items-center gap-3">
            @auth
                <a href="{{ url('/dashboard') }}" class="px-4 py-2 bg-sky-600 text-white rounded-lg text-sm font-semibold hover:bg-sky-700 transition">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-slate-700 hover:text-sky-600 transition">Log in</a>
                <a href="{{ route('register') }}" class="px-4 py-2 bg-sky-600 text-white rounded-lg text-sm font-semibold hover:bg-sky-700 transition">Get Started</a>
            @endauth
        </nav>
    </div>
</header>

<section class="relative overflow-hidden bg-gradient-to-b from-sky-50 via-white to-white">
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-sky-100 via-transparent to-transparent"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 grid lg:grid-cols-2 gap-12 items-center">
        <div>
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-100 text-sky-700 text-xs font-semibold uppercase tracking-wider">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                National Recruitment Portal
            </span>
            <h1 class="mt-6 text-4xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight">
                Where India's colleges<br>
                meet <span class="bg-gradient-to-r from-sky-600 to-teal-500 bg-clip-text text-transparent">India's recruiters</span>.
            </h1>
            <p class="mt-6 text-lg text-slate-600 max-w-xl leading-relaxed">
                CampusPlace digitizes the entire campus recruitment lifecycle — from college verification to offer acceptance — on one secure, DPDP-compliant platform.
            </p>
            <div class="mt-8 flex flex-col sm:flex-row gap-3">
                <a href="{{ route('register.student') }}" class="px-6 py-3 bg-sky-600 text-white text-center font-semibold rounded-lg shadow-lg shadow-sky-600/20 hover:bg-sky-700 transition">I'm a Student</a>
                <a href="{{ route('register.college') }}" class="px-6 py-3 bg-white text-slate-700 text-center font-semibold rounded-lg border border-slate-300 hover:bg-slate-50 transition">Register a College</a>
                <a href="{{ route('register.company') }}" class="px-6 py-3 bg-white text-slate-700 text-center font-semibold rounded-lg border border-slate-300 hover:bg-slate-50 transition">Hire Talent</a>
            </div>
            <div class="mt-10 flex flex-wrap items-center gap-6 text-sm text-slate-500">
                <div class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-emerald-500"></span> Free for colleges</div>
                <div class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-emerald-500"></span> DPDP compliant</div>
                <div class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-emerald-500"></span> AICTE / UGC verified</div>
            </div>
        </div>
        <div class="relative">
            <div class="relative rounded-2xl bg-white shadow-2xl border border-slate-200 overflow-hidden">
                <img src="{{ asset('images/campusplace-logo.svg') }}" alt="CampusPlace" class="w-full h-auto">
            </div>
            <div class="absolute -bottom-6 -left-6 -z-10 h-48 w-48 rounded-full bg-sky-200 blur-3xl opacity-60"></div>
            <div class="absolute -top-6 -right-6 -z-10 h-56 w-56 rounded-full bg-teal-200 blur-3xl opacity-60"></div>
        </div>
    </div>
</section>

<section class="bg-slate-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
        <div>
            <div class="text-3xl lg:text-4xl font-extrabold text-sky-400">5+</div>
            <div class="mt-1 text-sm text-slate-400 uppercase tracking-wider">Verified Colleges</div>
        </div>
        <div>
            <div class="text-3xl lg:text-4xl font-extrabold text-teal-400">10+</div>
            <div class="mt-1 text-sm text-slate-400 uppercase tracking-wider">Students</div>
        </div>
        <div>
            <div class="text-3xl lg:text-4xl font-extrabold text-emerald-400">5</div>
            <div class="mt-1 text-sm text-slate-400 uppercase tracking-wider">States</div>
        </div>
        <div>
            <div class="text-3xl lg:text-4xl font-extrabold text-amber-400">100%</div>
            <div class="mt-1 text-sm text-slate-400 uppercase tracking-wider">Free Platform</div>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto">
            <h2 class="text-3xl lg:text-4xl font-bold text-slate-900">Everything a placement cell needs</h2>
            <p class="mt-4 text-slate-600">Four roles, one platform. Strict data isolation, automated eligibility, and end-to-end hiring — replacing Excel sheets and notice boards.</p>
        </div>
        <div class="mt-14 grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="p-6 rounded-xl border border-slate-200 hover:border-sky-300 hover:shadow-lg transition">
                <div class="h-12 w-12 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center text-2xl">🏛️</div>
                <h3 class="mt-4 font-bold text-slate-900">College Verification</h3>
                <p class="mt-2 text-sm text-slate-600">AICTE / UGC document verification by the Super Admin ensures only genuine colleges join.</p>
            </div>
            <div class="p-6 rounded-xl border border-slate-200 hover:border-sky-300 hover:shadow-lg transition">
                <div class="h-12 w-12 rounded-lg bg-teal-100 text-teal-600 flex items-center justify-center text-2xl">🎯</div>
                <h3 class="mt-4 font-bold text-slate-900">Auto Eligibility Engine</h3>
                <p class="mt-2 text-sm text-slate-600">CGPA, backlogs, department, passing year, and skills are checked before a student can apply.</p>
            </div>
            <div class="p-6 rounded-xl border border-slate-200 hover:border-sky-300 hover:shadow-lg transition">
                <div class="h-12 w-12 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl">🔒</div>
                <h3 class="mt-4 font-bold text-slate-900">Strict Data Isolation</h3>
                <p class="mt-2 text-sm text-slate-600">Every college sees only its own students, jobs, and applications. No cross-college leakage.</p>
            </div>
            <div class="p-6 rounded-xl border border-slate-200 hover:border-sky-300 hover:shadow-lg transition">
                <div class="h-12 w-12 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center text-2xl">📜</div>
                <h3 class="mt-4 font-bold text-slate-900">DPDP Compliant</h3>
                <p class="mt-2 text-sm text-slate-600">Explicit consent capture, data access logs, and lifetime audit trails — aligned with India's DPDP Act.</p>
            </div>
            <div class="p-6 rounded-xl border border-slate-200 hover:border-sky-300 hover:shadow-lg transition">
                <div class="h-12 w-12 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-2xl">📊</div>
                <h3 class="mt-4 font-bold text-slate-900">National Reports</h3>
                <p class="mt-2 text-sm text-slate-600">State-wise and college-wise placement analytics for NAAC / NIRF accreditation reporting.</p>
            </div>
            <div class="p-6 rounded-xl border border-slate-200 hover:border-sky-300 hover:shadow-lg transition">
                <div class="h-12 w-12 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center text-2xl">🚀</div>
                <h3 class="mt-4 font-bold text-slate-900">End-to-End Hiring</h3>
                <p class="mt-2 text-sm text-slate-600">Shortlist → interview → offer letter → student acceptance → placement record — all in one flow.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto">
            <h2 class="text-3xl lg:text-4xl font-bold text-slate-900">Built for four roles</h2>
            <p class="mt-4 text-slate-600">Each role gets its own secure dashboard with the exact permissions it needs.</p>
        </div>
        <div class="mt-14 grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="{{ route('register.student') }}" class="block p-6 rounded-xl bg-white border border-slate-200 hover:border-sky-400 hover:shadow-xl transition group">
                <div class="h-12 w-12 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-2xl">🎓</div>
                <h3 class="mt-4 font-bold text-slate-900 group-hover:text-sky-600">Students</h3>
                <p class="mt-2 text-sm text-slate-600">Register under your college, upload resumes, and apply to approved jobs.</p>
                <span class="mt-4 inline-block text-sm font-semibold text-sky-600">Register →</span>
            </a>
            <a href="{{ route('register.college') }}" class="block p-6 rounded-xl bg-white border border-slate-200 hover:border-sky-400 hover:shadow-xl transition group">
                <div class="h-12 w-12 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center text-2xl">🏫</div>
                <h3 class="mt-4 font-bold text-slate-900 group-hover:text-sky-600">Colleges / TPO</h3>
                <p class="mt-2 text-sm text-slate-600">Approve companies and jobs, manage students, generate placement reports.</p>
                <span class="mt-4 inline-block text-sm font-semibold text-sky-600">Register →</span>
            </a>
            <a href="{{ route('register.company') }}" class="block p-6 rounded-xl bg-white border border-slate-200 hover:border-orange-400 hover:shadow-xl transition group">
                <div class="h-12 w-12 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center text-2xl">🏢</div>
                <h3 class="mt-4 font-bold text-slate-900 group-hover:text-orange-600">Companies</h3>
                <p class="mt-2 text-sm text-slate-600">Post jobs to up to 1,000 colleges, shortlist, interview, and release offers.</p>
                <span class="mt-4 inline-block text-sm font-semibold text-orange-600">Register →</span>
            </a>
            <a href="{{ route('login') }}" class="block p-6 rounded-xl bg-white border border-slate-200 hover:border-indigo-400 hover:shadow-xl transition group">
                <div class="h-12 w-12 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-2xl">🛡️</div>
                <h3 class="mt-4 font-bold text-slate-900 group-hover:text-indigo-600">Super Admin</h3>
                <p class="mt-2 text-sm text-slate-600">National oversight, college verification, blacklisting, and audit logs.</p>
                <span class="mt-4 inline-block text-sm font-semibold text-indigo-600">Login →</span>
            </a>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto">
            <h2 class="text-3xl lg:text-4xl font-bold text-slate-900">How it works</h2>
            <p class="mt-4 text-slate-600">From college registration to offer acceptance — six simple steps.</p>
        </div>
        <ol class="mt-14 grid md:grid-cols-3 gap-8">
            <li class="relative p-6 rounded-xl bg-slate-50 border border-slate-200">
                <span class="absolute -top-4 left-6 h-8 w-8 rounded-full bg-sky-600 text-white flex items-center justify-center font-bold text-sm">1</span>
                <h3 class="mt-2 font-bold text-slate-900">College verifies</h3>
                <p class="mt-2 text-sm text-slate-600">Super Admin reviews AICTE / UGC docs and activates the TPO account.</p>
            </li>
            <li class="relative p-6 rounded-xl bg-slate-50 border border-slate-200">
                <span class="absolute -top-4 left-6 h-8 w-8 rounded-full bg-sky-600 text-white flex items-center justify-center font-bold text-sm">2</span>
                <h3 class="mt-2 font-bold text-slate-900">Company posts job</h3>
                <p class="mt-2 text-sm text-slate-600">Company selects up to 1,000 colleges and defines eligibility criteria.</p>
            </li>
            <li class="relative p-6 rounded-xl bg-slate-50 border border-slate-200">
                <span class="absolute -top-4 left-6 h-8 w-8 rounded-full bg-sky-600 text-white flex items-center justify-center font-bold text-sm">3</span>
                <h3 class="mt-2 font-bold text-slate-900">TPO approves</h3>
                <p class="mt-2 text-sm text-slate-600">College Admin approves the job for their college. Only then it's visible.</p>
            </li>
            <li class="relative p-6 rounded-xl bg-slate-50 border border-slate-200">
                <span class="absolute -top-4 left-6 h-8 w-8 rounded-full bg-sky-600 text-white flex items-center justify-center font-bold text-sm">4</span>
                <h3 class="mt-2 font-bold text-slate-900">Student applies</h3>
                <p class="mt-2 text-sm text-slate-600">Auto eligibility check runs. Ineligible students see the reason.</p>
            </li>
            <li class="relative p-6 rounded-xl bg-slate-50 border border-slate-200">
                <span class="absolute -top-4 left-6 h-8 w-8 rounded-full bg-sky-600 text-white flex items-center justify-center font-bold text-sm">5</span>
                <h3 class="mt-2 font-bold text-slate-900">Interview & offer</h3>
                <p class="mt-2 text-sm text-slate-600">Company shortlists, schedules interviews, and uploads the offer letter.</p>
            </li>
            <li class="relative p-6 rounded-xl bg-slate-50 border border-slate-200">
                <span class="absolute -top-4 left-6 h-8 w-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-sm">6</span>
                <h3 class="mt-2 font-bold text-slate-900">Placement recorded</h3>
                <p class="mt-2 text-sm text-slate-600">Student accepts. Placement record auto-created. Reports update instantly.</p>
            </li>
        </ol>
    </div>
</section>

<section class="py-20 bg-gradient-to-r from-slate-900 via-sky-900 to-teal-900 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl lg:text-4xl font-bold">Free for all colleges and students.</h2>
        <p class="mt-4 text-lg text-sky-100">Join India's national placement network. No subscription, no per-student fee — ever.</p>
        <div class="mt-8 flex flex-col sm:flex-row justify-center gap-3">
            <a href="{{ route('register') }}" class="px-8 py-3 bg-white text-slate-900 font-semibold rounded-lg hover:bg-slate-100 transition">Get Started</a>
            <a href="{{ route('login') }}" class="px-8 py-3 bg-white/10 text-white font-semibold rounded-lg border border-white/30 hover:bg-white/20 transition">Already have an account?</a>
        </div>
    </div>
</section>

<footer class="bg-white border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid md:grid-cols-3 gap-8 items-center">
        <div class="flex items-center gap-2">
            <img src="{{ asset('images/campusplace-icon.svg') }}" alt="" class="h-8 w-8">
            <span class="font-bold text-slate-900">Campus<span class="text-sky-600">Place</span></span>
        </div>
        <p class="text-sm text-slate-500 text-center md:text-left">National Placement Management System · DPDP Compliant · BCA 5th Semester Project</p>
        <p class="text-sm text-slate-500 text-center md:text-right">© 2026 CampusPlace</p>
    </div>
</footer>

</body>
</html>