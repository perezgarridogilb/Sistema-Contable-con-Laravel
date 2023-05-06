<link href="{{ asset('assets/css/loader.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('assets/js/loader.js') }}"></script>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/structure.css') }}" rel="stylesheet" type="text/css" class="structure" />

<link rel="stylesheet" href="{{ asset('plugins/font-icons/fontawesome/css/fontawesome.css') }}">
<link rel="stylesheet" href="{{ asset('css/fontawesome.css') }}">

<link href="{{ asset('plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/notification/snackbar/snackbar.min.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ asset('css/custom.css" rel="stylesheet" type="text/css') }}" />

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/widgets/modules-widgets.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}"/>


<style>
    .widget {
        box-shadow: 0 3px 1px -2px rgba(0,0,0,.2), 0 2px 2px 0 rgba(0,0,0,.14), 0 1px 5px 0 rgba(0,0,0,.12)!important;
    }

    a.green {
        background: #0fadc8;
    }

    a.green1 {
        background: #fafafa;
        border: 2px solid #0fadc8;
    }

    #compactSidebar svg {
        fill: white!important;
    }

    aside {
        display:none|important;
    }
    .page-item.active .page-link{
        z-index: 3;
        color: #fff;
        background-color: #3b3f5c;
        border-color:  #3b3f5c;
    }
    @media (max-width: 480px)
    {
        .mtmobile {
            margin-bottom: 20px|important;
        }
        .mbmobile {
            margin-bottom: 10px|important;
        }
        .hideonsm {
            display: none|important;
        }
        .inblock {
            display:block;
        }
    }
    .sidebar-theme #compactSidebar {
        background: #000!important;
    }
    .header-container .sidebar-Collapse{
        color: #3B3F5C!important;
    }
    .navbar .navbar-item .nav-item form.form-inline input.search-form-control {
        font-size: 15px;
        background-color: #3B3F5C!important;
        padding-right: 40px;
        padding-top: 12px;
        border: none;
        color: #fff;
        back-shadow: none;
        border-radius: 30px;
    }
</style>

@livewireStyles