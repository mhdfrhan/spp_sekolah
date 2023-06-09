<!DOCTYPE html>
<html>

@include('partials.head')


<body>

    @include('partials.sidenav')
    <!-- Main content -->
    <div class="main-content" id="panel">
        @include('partials.topnav')
        <!-- Header -->
        @yield('header')
        <!-- Page content -->
        <div class="container-fluid mt--6">
            @yield('content')

            @include('partials.footer')
        </div>
    </div>
    <div class="modal" id="logout" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Log Out <i class="fa fa-lock"></i></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <p><i class="fa fa-question-circle"></i> Are you sure you want to log-off? <br /></p>
                    <div class="actionsBtns">
                        <form action="{{ url('admin/logout') }}" method="POST">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-outline-primary">Log Out</button>
                            <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
            @include('partials.scripts')
</body>

</html>
