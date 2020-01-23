@extends('layouts.dashboard')
@section('title', 'Pembayaran Hasil Investasi')

@section('nav', 'Belum Dibayar')
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
                url : '/admin/pembayaran/investasi/hasil/getStatus/1',
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
                {
                    data : function(data, type, row, meta){
                        if(data.nomor_rekening == null){
                            return "Not Completed";
                        }
                        else{
                            return data.nomor_rekening;
                        }
                    }
                },
                {
                    data : function(data, type, row, meta){
                        if(data.nama_rekening == null){
                            return "Not Completed";
                        }
                        else{
                            return data.nama_rekening;
                        }
                    }
                },
                {
                    data : function (data, type, row, meta){
                        if(data.status ==1){
                            return 'Belum Dibayarkan'
                        }
                        
                    }
                },
            ]
        });


    });


</script>
@endsection