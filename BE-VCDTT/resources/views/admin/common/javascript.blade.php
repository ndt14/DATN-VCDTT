<!-- Libs JS -->
<script src="{{ asset('admin/assets/libs/apexcharts/dist/apexcharts.min.js') }}" defer></script>
<script src="{{ asset('admin/assets/libs/jsvectormap/dist/js/jsvectormap.min.js') }}" defer></script>
<script src="{{ asset('admin/assets/libs/jsvectormap/dist/maps/world.js') }}" defer></script>
<script src="{{ asset('admin/assets/libs/jsvectormap/dist/maps/world-merc.js') }}" defer></script>
<script src="{{ asset('admin/assets/libs/fslightbox/index.js') }}" defer></script>
<!-- Tabler Core -->
<script src="{{ asset('admin/assets/js/tabler.min.js') }}" defer></script>
<script src="{{ asset('admin/assets/js/demo.min.js') }}" defer></script>
<script src="{{ asset('ckedit_js/main.js') }}" type="text/javascript"></script>
<!-- Jquery -->
<script src="{{ asset('admin/assets/js/vendors/jquery-3.6.3.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/vendors/Bs5Utils.js') }}"></script>
<script src="{{ asset('admin/assets/js/vendors/jquery.form.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/vendors/axios.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/vendors/fancybox.umd.js') }}"></script>
<!-- Plugins -->
<script src="{{ asset('ckedit_js/plugins/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
<!-- JS -->
<script type="text/javascript">
    Bs5Utils.defaults.toasts.position = 'top-center';
    Bs5Utils.defaults.toasts.container = 'toast-container';
    Bs5Utils.defaults.toasts.stacking = false;
    const bs5Utils = new Bs5Utils();
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    let updateUrlParameter = function(key, value, uri) {
        if(!uri){
            uri = window.location.href;
        }
        value = encodeURIComponent(value);
        // remove the hash part before operating on the uri
        let i = uri.indexOf('#');
        let hash = i === -1 ? ''  : uri.substr(i);
        uri = i === -1 ? uri : uri.substr(0, i);

        let re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
        let separator = uri.indexOf('?') !== -1 ? "&" : "?";

        if (!value) {
            // remove key-value pair if value is empty
            uri = uri.replace(new RegExp("([&]?)" + key + "=.*?(&|$)", "i"), '');
            if (uri.slice(-1) === '?') {
                uri = uri.slice(0, -1);
            }
        } else if (uri.match(re)) {
            uri = uri.replace(re, '$1' + key + "=" + value + '$2');
        } else {
            uri = uri + separator + key + "=" + value;
        }
        return uri + hash;
    };
</script>
