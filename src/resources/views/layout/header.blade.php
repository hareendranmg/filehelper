<nav class="main-header navbar-expand-md navbar navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav">
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ URL::to('/file_helper_dashboard') }}" class="nav-link">Files Dashboard</a>
        </li>
    </ul>
    <div class="row navbar-nav ml-auto">

        <ul class="navbar-nav">
            <li class="nav-item d-none d-sm-inline-block">
                <a class="nav-link">Dark Mode</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <div class="theme-switch-wrapper nav-link">
                <label class="theme-switch" for="checkbox">
                    <input type="checkbox" id="checkbox">
                    <span class="slider round"></span>
                </label>
            </div>
        </ul>
    </div>

</nav>