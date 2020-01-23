@extends('layouts.dashboard')
@section('title', 'Home')

@section('content')
@section('nav', 'Home')

<h3 class="ui top attached header">
    Selamat datang,
</h3>


<div class="ui attached segment">
    <a href="#" onclick="event.preventDefault();addBeritaForm()">
        <button id="button_showForm" class="ui left teal button" type="submit">
            <i class="user plus icon"></i>
            Tambah Berita
        </button>
    </a>
    <br>
    <br>
    <br>
    <div class="ui four stackable cards">
        @foreach ($berita as $item)

        <div class="card">
            <div class="image">
                <img src="{{\Storage::disk('gcs')->url($item->foto)}}">
            </div>
            <a class="content" onclick="event.preventDefault();showDetails({{$item->id}})">
                <div class="header">{{$item->judul}}</div>
                <div class="meta">
                    <span>
                        {{$item->created_at->diffForHumans()}}
                    </span>
                </div>
                {{-- <div class="description">
                    p{{$item->foto}}
        </div> --}}
        </a>
        <div class="extra content">
            <a onclick="event.preventDefault();showDeleteForm({{$item->id}})">
                <span class="right floated like">
                    <i class="trash icon"></i>
                    Delete
                </span>

            </a>
            <a onclick="event.preventDefault();showEditForm({{$item->id}})">
                <span class="right floated star">
                    <i class="pencil alternate icon"></i>
                    Edit
                </span>
            </a>

        </div>
    </div>

    @endforeach
</div>

</div>

@include('admin.addBerita')
@include('admin.showDetails')
@include('admin.editBerita')
@include('admin.deleteBerita')



<style>
    .ui.top.attached.header {
        font-size: 1.8em;
        line-height: 1em;
        padding: 0.8em;
    }

    .ui.attached.segment {
        font-size: 1em;
        padding: 2.5em;
    }

    p {
        margin: 0 0 1em;
        font-size: 1.13rem;
        line-height: 1.8rem;
        font-kerning: 1rem;

    }
</style>



<script>
    $(document).on('click', '#btn_tambah', function(){
    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/admin/berita/addBerita',
            data: new FormData(document.getElementById("form_add")),
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('.ui.modal.add_berita').modal('hide');
                window.location.reload();                
            },
            error: function(data) {

            }
        });
    });

    $(document).on('click', '#btn_update', function(){
    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/admin/berita/edit/' + $('#edit_berita_id').val(),
            data: new FormData(document.getElementById("form_edit")),
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                window.location.reload();                
            },
            error: function(data) {

            }
        });
});

$(document).on('click', '#btn_delete', function(){
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'DELETE',
        url: '/admin/berita/delete/' + $('#delete_berita_id').val(),
        dataType:'JSON',
        success: function(data) {
            window.location.reload();                
        },
        error: function(data) {
        }
    });
});


function addBeritaForm(){
        $.ajax({
            type: 'GET',
            url : '/admin/berita/addBeritaForm',
            success : function(data){
                console.log(data);

                $('.ui.modal.add_berita').modal({
                    onShow: function(){
                        $('#add_error_bag').hide();   
                    },
                    onApprove: function (click) {
                        return false;
                    }
                }).modal('show');

            }
        })
    };

function showDetails(id){
    $.ajax({
        type: 'GET',
        url : '/admin/berita/showDetails/'+ id,
        success : function(data){
            console.log(data);

            $('.ui.modal.show_details').modal({
                onShow: function(){
                    $("#judul").text(data.berita.judul);
                    url = data.berita.foto;
                    x = $("#gambar").attr("src");
                    console.log(x.replace("dumm", url));
                    $("#gambar").attr("src",x.replace("dumm", url));
                    $("#berita").text(data.berita.berita);
                },
                onApprove: function (click) {
                    $("#gambar").attr("src","{{\Storage::disk('gcs')->url('dumm')}}");
                },
                closable : false
            }).modal('show');

        }
    })
};

function showEditForm(id){
    $.ajax({
        type: 'GET',
        url : '/admin/berita/editForm/'+ id,
        success : function(data){
            console.log(data);

            $('#edit_error_bag').hide();

            $('#edit_berita_id').val(data.berita.id);

            $('.ui.modal.edit_berita').modal({
                onShow: function(){
                    $("#form_edit input[name=judul]").val(data.berita.judul);
                    $("#form_edit textarea[name=berita]").val(data.berita.berita);

                }
            }).modal('show');

        }
    })
};

function showDeleteForm(id){
        $.ajax({
            type: 'GET',
            url : '/admin/berita/deleteForm/' + id,
            success : function(data){
                console.log(data.berita);
                $('#delete_berita_id').val(data.berita.id);
                $('.ui.modal.delete_berita').modal('show');
            }
        })
    };

</script>


@endsection