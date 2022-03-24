@extends('keltron::layout.master')
@section('content')

<style>
.stage {
    max-width: 100%;
    margin: 60px 10%;
    position: relative;
}

.folder-wrap {
    display: flex;
    flex-wrap: wrap;
}

.folder-wrap::before {
    content: '';
    display: block;
    position: absolute;
    top: -40px;
}

.folder-wrap:first-child::before {
    content: 'Home';
    display: block;
    position: absolute;
    top: -40px;
}

.tile {
    border-radius: 10px;
    width: calc(14% - 17px);
    text-align: center;
    border: 1px solid #c4c9cc;
    transition: 0.2s all cubic-bezier(0.4, 0.0, 0.2, 1);
    position: relative;
    margin-right: 10px;
    margin-top: 10px;
    cursor: pointer;
}

.tile:hover {
    box-shadow: 0px 7px 5px -6px rgba(0, 0, 0, 0.12);
}

.tile i {
    color: #00A8FF;
    height: 150px;
    font-size: 136px;
    display: block;
    cursor: pointer;
    margin-top: -40px;
}

.tile i.mdi-file-document {
    color: #8fd9ff;
}

.back {
    font-size: 20px;
    border-radius: 50px;
    background: #00a8ff;
    border: 0;
    color: white;
    width: 60px;
    height: 60px;
    margin: 20px 20px 0;
    outline: none;
    cursor: pointer;
}

/* Transitioning */
.folder-wrap {
    position: absolute;
    width: 100%;
    transition: .365s all cubic-bezier(.4, 0, .2, 1);
    pointer-events: none;
    opacity: 0;
    top: 0;
}

.folder-wrap.level-up {
    transform: scale(1.2);
}

.folder-wrap.level-current {
    transform: scale(1);
    pointer-events: all;
    opacity: 1;
    position: relative;
    height: auto;
    overflow: visible;
}

.folder-wrap.level-down {
    transform: scale(0.8);
}

.thumbnail {
    border-radius: 12px;
    margin-top: 10px;
}
</style>


<button class="back">
    <i class="mdi mdi-arrow-left"></i>
</button>


<div class="stage">

    <div class="folder-wrap level-current scrolling">

        @foreach($directories as $directory)
        <div class="tile folder" onclick="openFolder('{{$directory}}')">
            <i class="mdi mdi-folder"></i>
            <p>{{ $directory }}</p>
        </div>
        @endforeach

        @foreach($files as $file)
        <div class="tile form" onclick="openFile('{{base64_encode($file)}}')">
            <img class="thumbnail" src="{{url('/files/get_file_type_image_from_path?file_path='.base64_encode($file))}}" height="100px" width="100px" />
            <p>{{$file}}</p>
        </div>
        @endforeach

    </div>

</div>


<!-- <form enctype="multipart/form-data">
    <div class="col-md-8 row justify-content-center">
        @csrf

        <div class="custom-file col">
            <input type="file" class="custom-file-input" id="test_file" />
            <label class="custom-file-label" for="test_file">Choose file</label>
        </div>

        <div class="col">
            <input type="button" class="btn btn-outline-primary" id="upload_btn" onclick="uploadFile(this)"
                value="Upload file" />
        </div>

    </div>
</form>

<div class="col-md-8 row justify-content-center">
    <div id="file_path"></div>
    <div class="col-md-3">
        <a href="" class="btn btn-block btn-primary" id="view_file" style="display: none;" target="_blank"> View
            File</a>
    </div>
</div> -->

@push('pagescript')
<script type="text/javascript">
$(function() {

    $('.back').on("click", function() {
        if (
            $('.level-current').is(':first-child')) {} else {
            $('.level-down').removeClass('level-down')
            $('.level-current').addClass('level-down');
            $('.level-current').removeClass('level-current');

            $('.level-down').remove()
            $('.level-current').remove();
            $('.level-current').remove();

            $('.level-up').addClass('level-current');
            $('.level-up').removeClass('level-up').prev().addClass('level-up');
        }
    });

});


function openFolder(directory) {
    $.ajax({
        type: "get",
        url: "{{url('/files/open_folder')}}",
        data: {
            directory: directory
        },
        dataType: "json",
        success: function(response) {

            var newFolder = "";
            newFolder += "<div class='folder-wrap level-down'>";
            response.directories.forEach(element => {
                newFolder +=
                    '<div class="tile folder" onclick="openFolder(`' + element + '`)"> \
                    <i class="mdi mdi-folder"></i> \
                    <p>' + basename(element) + '</p> \
                    </div>';
            });

            response.files.forEach(element => {
                
                let filePath = window.btoa(element);

                newFolder +=
                    '<div class="tile form" onclick="openFile(`' + filePath + '`)"> \
                        <img class="thumbnail" src="{{url("/files/get_file_type_image_from_path")}}/' + "?file_path="+filePath + '" height="100px" width="100px" /> \
                        <p>' + basename(element) + '</p> \
                        </div>'
                    });
            newFolder += "</div>";
            $('.stage').append(newFolder);

            $('.level-up').removeClass('level-up');
            $('.level-current').addClass('level-up');
            $('.level-current').removeClass('level-current');
            $('.level-down').addClass('level-current');
            $('.level-down').removeClass('level-down').next().addClass('level-down');

        },
        error: function(jqXHR, error) {
            console.log(error);
            console.log(jqXHR);
        }
    });

}

function openFile(filePath) {
    var url = "{{url('/files/get_file_from_path')}}";
    var fileUrl = url + "?file_path=" + filePath;
    window.open(fileUrl, basename(filePath));
}

function basename(path) {
    return path.split('/').reverse()[0];
}

function uploadFile(btn) {

    var form_data = new FormData();

    var file = document.getElementById('test_file');

    var btn_id = btn.id;

    if (file.value) {
        var file_upload = file.files[0];
        var name = file_upload.name;
        form_data.append('file_upload', file_upload);
        form_data.append('name', name);
    }

    $.ajax({
        url: "{{ url('/files/file_helper_dashboard') }}",
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: form_data,
        dataType: 'json',
        processData: false,
        contentType: false,
        beforeSend: function() {
            $('#' + btn_id).html('<i class="fa fa-spinner fa-spin"></i>Please wait..');
        },

        success: function(result) {
            console.log(result);
            if (result.status) {
                Swal.fire({
                    text: 'File uploaded successfully.',
                    title: 'Filehelper',
                    icon: 'success'
                });

                $("#file_path").html("File Uploaded");
                $("#view_file").attr("href", result.url);
                $("#view_file").show();

            } else {
                Swal.fire({
                    text: 'Failed to upload',
                    title: 'Filehelper',
                    icon: 'error'
                });
            }
        },
        error: function(jqXHR, error) {
            console.log(jqXHR);
            console.log(error);
            Swal.fire({
                text: 'Server error occured',
                title: 'Filehelper',
                icon: 'error'
            });
        }
    });
}
</script>

@endpush
@endsection