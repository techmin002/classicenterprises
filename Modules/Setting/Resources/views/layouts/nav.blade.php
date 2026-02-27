<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    {{-- LEFT NAV --}}
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('home') }}" class="nav-link">Home</a>
        </li>
    </ul>

    @php
        use Modules\Branch\Entities\Branch;

        $branches = Branch::where('status','on')->get();
        $currentBranch = session('branch_id')
            ? Branch::find(session('branch_id'))
            : null;
    @endphp

    {{-- RIGHT NAV --}}
    <ul class="navbar-nav ml-auto">

        {{-- SUPER ADMIN BRANCH DROPDOWN --}}
        @if(Auth::check() && Auth::user()->role->name === 'Super Admin')
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                <i class="fas fa-home"></i>
                {{ $currentBranch->name ?? 'Select Branch' }}
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                @foreach($branches as $branch)
                    <a class="dropdown-item" href="{{ route('switch.branch',$branch->id) }}">
                        <i class="fas fa-building"></i> {{ $branch->name }}
                    </a>
                @endforeach
            </div>
        </li>
        @endif

        {{-- USER --}}
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                <i class="fas fa-user"></i> {{ Auth::user()->name }}
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                    <i class="fas fa-user"></i> Profile
                </a>

                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>

{{-- FORCE BRANCH SELECTION MODAL --}}
@if(Auth::check() && Auth::user()->role->name === 'Super Admin' && !session()->has('branch_id'))
<div class="modal fade" id="branchModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle"></i>
                    Branch Required
                </h5>
            </div>

            <div class="modal-body text-center">
                <p class="font-weight-bold">
                    Please select a branch to continue
                </p>

                @foreach($branches as $branch)
                    <a href="{{ route('switch.branch',$branch->id) }}"
                       class="btn btn-outline-primary btn-block mb-2">
                        {{ $branch->name }}
                    </a>
                @endforeach
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#branchModal').modal({
            backdrop: 'static',
            keyboard: false
        });
    });
</script>
@endif
