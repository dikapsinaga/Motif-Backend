@extends('layouts.dashboard')
@section('title', 'Pembayaran Hasil Investasi')

@section('nav', 'Belum Dikonfirmasi')
@section('content')


<div class="ui segment">

    <table id="investasi" class="ui striped celled teal table">
        <thead>
            <tr>
                <th>Nama Pelapak</th>
                <th>Investasi</th>
                <th>Nominal</th>
                <th>Nomor Rekening</th>
                <th>Nama Rekening</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr class="">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
        </tbody>
    </table>

</div>

<style>
    .ui.segment {
        padding: 2em;
    }

    #button_showForm {
        margin: 20px;
    }
</style>

<script>
    var table = "";

    $(document).ready(function(){
        table = $('#investasi').DataTable({
            processing : true,
            ajax : {
                url : '/admin/pembayaran/investasi/hasil/getStatus/2',
                method : 'GET', 
                dataSrc : 'data'
            }, 
            columns : [
                {data : 'pelapak.name'},
                {data : 'judul'},
                {data : function(data, type, row, meta){
                    return data.dana_dibutuhkan * (100+data.profit)/100;
                    }
                },
                {data : 'nomor_rekening'},
                {data : 'nama_rekening'},
                {
                    data : function (data, type, row, meta){
                        if(data.status==2){
                            return '<a onclick= "event.preventDefault();verify('+data.id+')" href="#"><button id="btn_confirmed" class="positive ui button">Verify</button></a>';

                            // return 'Belum Dikonfirmasi';
                        }
                        
                    }
                },
            ]
        });


    });

    function verify(id){
        $.ajax({
            type: 'GET',
            url : '/admin/pembayaran/investasi/hasil/confirmed/' + id,
            beforeSend: function(){
                $("#btn_confirmed").removeClass("positive ui button").addClass("ui loading button");
            },
            success : function(data){
                console.log(data);
                $("#btn_confirmed").removeClass("ui loading button").addClass("ui button").text("Confirmed");


            }
        })
    };


</script>
@endsection