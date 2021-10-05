@push('commonstyle')
<link rel="stylesheet" type="text/css" href="{{ asset('keltron/filehelper/css/fontawesome-free/css/all.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('keltron/filehelper/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('keltron/filehelper/css/responsive.bootstrap4.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('keltron/filehelper/css/adminlte.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('keltron/filehelper/css/sweetalert2.min.css') }}" />
<link rel="stylesheet" type="text/css" href="https://cdn.materialdesignicons.com/2.5.94/css/materialdesignicons.min.css" />
@endpush

@push('pagestyle')
<style>
.max-height-300 pre {
    max-height: 300px;
}

.theme-switch {
    display: inline-block;
    height: 24px;
    position: relative;
    width: 50px;
}

.theme-switch input {
    display: none;
}

.slider {
    background-color: #ccc;
    bottom: 0;
    cursor: pointer;
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
    transition: 400ms;
}

.slider::before {
    background-color: #fff;
    bottom: 4px;
    content: "";
    height: 16px;
    left: 4px;
    position: absolute;
    transition: 400ms;
    width: 16px;
}

input:checked+.slider {
    background-color: #5C646C;
}

input:checked+.slider::before {
    transform: translateX(26px);
}

.slider.round {
    border-radius: 34px;
}

.slider.round::before {
    border-radius: 50%;
}
</style>
@endpush
