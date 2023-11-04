<!-- CSS files -->
<link href="{{ asset('admin/assets/css/tabler.css') }}" rel="stylesheet" />
<!-- <link href="{{ asset('admin/assets/css/tabler-flags.min.css') }}" rel="stylesheet" /> -->
<link href="{{ asset('admin/assets/css/tabler-payments.min.css') }}" rel="stylesheet" />
<link href="{{ asset('admin/assets/css/tabler-vendors.min.css') }}" rel="stylesheet" />
<!-- <link href="{{ asset('admin/assets/css/demo.min.css') }}" rel="stylesheet" /> -->
<link rel="stylesheet" href="{{ asset('admin/assets/css/fancybox.css')}}"/>
<link rel="stylesheet" href="{{ asset('admin/assets/libs/jquery-confirm/jquery-confirm.min.css')}}"/>
<style>
    .fancybox_content{
        z-index: 99 !important;
    }
    .active-sidebar{
        border-top-right-radius: var(--tblr-border-radius-xl) !important;
        border-bottom-right-radius: var(--tblr-border-radius-xl) !important;
        background-color: rgba(var(--tblr-info-lt-rgb));
        color: var(--tblr-indigo) !important;
    }
    .active-sidebar>a{
        color: var(--tblr-indigo) !important;
    }
    .accordion-button:not(.collapsed) {
        color: var(--tblr-indigo) !important;
    }
    
    li:has(.accordion-button:not(.collapsed)){
        color: var(--tblr-indigo) !important;
        border-top-right-radius: var(--tblr-border-radius-xl) !important;
        border-bottom-right-radius: var(--tblr-border-radius-xl) !important;
    }
</style>