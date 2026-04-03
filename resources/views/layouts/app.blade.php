@include('layouts.admin.head-page')
<!--! [Start] Navigation Manu !-->
@include('layouts.admin.sidebar')
<!--! [End]  Navigation Manu !-->

<!--! [Start] Header !-->
@include('layouts.admin.navbar')
<!--! [End] Header !-->
<!--! [Start] Main Content !-->
@yield('content')
<!--! [End] Main Content !-->
@include('layouts.admin.footer')
