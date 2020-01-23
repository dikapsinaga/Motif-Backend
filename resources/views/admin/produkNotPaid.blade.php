@extends('layouts.dashboard')
@section('title', 'Pembayaran Produk')

@section('nav', 'Belum Dibayar')
@section('content')


<div class="ui segment">

    <table id="produk" class="ui striped celled teal table">
        <thead>
            <tr>
                <th>Pembeli</th>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
                <th>Nomor Rekening</th>
                <th>Nama Rekening</th>
                <th>Status</th>
                {{-- <th>Action</th> --}}
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
                <td></td>
                <td></td>
                {{-- <td><button class="ui active button"><i class="check circle outline icon"></i>Confirm</button>
                    <a href=""><i class="eye icon"></i></a></td> --}}

                <!-- kalau button ditekan
                        <button class="positive ui button">Positive Button</button> -->
            </tr>

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
        table = $('#produk').DataTable({
            processing : true,
            ajax : {
                url : '/admin/pembayaran/barang/getList/0',
                method : 'GET', 
                dataSrc : 'data'
            }, 
            columns : [
                {data : 'pembeli.name'},
                {data : 'produk.nama'},
                {data : 'jumlah'},
                {data : 'produk.harga'},
                {data : 'total'},
                {data : 'nomor_rekening'},
                {data : 'nama_rekening'},
                {
                    data : function (data, type, row, meta){
                        if(data.status==0){
                            return 'Belum Dibayarkan';
                        }
                        // return '<a onclick= "event.preventDefault();showDetails('+data+')" href="#"><i class="external alternate icon"></i></a>';
                    }
                },
                // {
                //     data : "status",
                //     className : "center",
                //     render : function (data, type, row, meta){
                //         return '<a onclick= "event.preventDefault();showDetails('+data+')" href="#"><i class="external alternate icon"></i></a>';
                //     }
                // },
            ]
        });


    });


</script>
@endsection