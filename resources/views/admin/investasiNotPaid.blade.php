@extends('layouts.dashboard')
@section('title', 'Pembayaran Investasi')

@section('nav', 'Belum Dibayar')
@section('content')


<div class="ui segment">

    <table id="investasi" class="ui striped celled teal table">
        <thead>
            <tr>
                <th>Nama Pembeli</th>
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
                url : '/admin/pembayaran/investasi/getList/0',
                method : 'GET', 
                dataSrc : 'data'
            }, 
            columns : [
                {data : 'pembeli.name'},
                {data : 'plan.judul'},
                {data : 'nominal'},
                {data : 'nomor_rekening'},
                {data : 'nama_rekening'},
                {
                    data : function (data, type, row, meta){
                        if(data.status == 0){
                            return 'Belum Dibayarkan';
                        }
                        
                    }
                },
            ]
        });


    });


</script>
@endsection