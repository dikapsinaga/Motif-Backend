@extends('layouts.dashboard')
@section('title', 'Pembayaran Produk')

@section('nav', 'Menampilkan Pembayaran Produk')
@section('content')


<div class="ui segment">

    <table id="produk" class="ui striped celled teal table">
        <thead>
            <tr>
                <th>Pembeli</th>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Nomor Rekening</th>
                <th>Nama Rekening</th>
                <th>Status</th>
                <th>Action</th>
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
                <td><button class="ui active button"><i class="check circle outline icon"></i>Confirm</button>
                    <a href=""><i class="eye icon"></i></a></td>

                <!-- kalau button ditekan
                        <button class="positive ui button">Positive Button</button> -->
            </tr>

        </tbody>
    </table>

</div>

@include('admin.showDetails')



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
                url : '/admin/pembayaran/barang/getList',
                method : 'GET', 
                dataSrc : 'pembelian'
            }, 
            columns : [
                {data : 'pembeli_id'},
                {data : 'produk_id'},
                {data : 'jumlah'},
                {data : 'total'},
                {data : 'nama_rekening'},
                {data : 'nomor_rekening'},
                {data : 'status'},
                {
                    data : "id",
                    className : "center",
                    render : function (data, type, row, meta){
                        return '<a onclick= "event.preventDefault();showDetails('+data+')" href="#"><i class="external alternate icon"></i></a>';
                    }
                },
            ]
        });


    });

    function showDetails(id){
        $.ajax({
            type: 'GET',
            url : '/admin/pasien/showDetails/' + id,
            success : function(data){
                console.log(data);
                $("#form_details input[name=nama_istri]").val(data.details.pasien.nama_istri);
                $("#form_details input[name=nama_suami]").val(data.details.pasien.nama_suami);
                $("#form_details input[name=alamat]").val(data.details.pasien.alamat);
                $("#form_details input[name=nomor_hp]").val(data.details.pasien.nomor_hp);
                $("#form_details input[name=umur]").val(data.details.pasien.umur);
                $("#form_details input[name=hamil]").val(data.details.hamil);
                $("#form_details input[name=berat_badan]").val(data.details.berat_badan);
                $("#form_details input[name=tinggi_badan]").val(data.details.tinggi_badan);
                $("#form_details input[name=lingkar_lengan]").val(data.details.lingkar_lengan);
                $("#form_details input[name=haemoglobin]").val(data.details.haemoglobin);
                $("#form_details input[name=sistole]").val(data.details.sistole);
                $("#form_details input[name=diastole]").val(data.details.diastole);
                $("#form_details input[name=jarak_kehamilan]").val(data.details.jarak_kehamilan);

                if(data.details.riwayat_melahirkan != null){
                    $.each(data.details.riwayat_melahirkan.split(","), function(i,e){
                        $('.ui.dropdown').dropdown('set selected', e);
                    });
                }

                $('#form_details input[name=gagal_hamil][value= '+data.details.gagal_hamil+']').prop("checked",true);
                $('#form_details input[name=operasi_sesar][value= '+data.details.operasi_sesar+']').prop("checked",true);

                if(data.kunjungans != null){
                    $('#kunjungan').find('tbody').empty();

                    data.kunjungans.forEach(element => {
                        $('#kunjungan > tbody:last-child').append(
                            '<tr><td>'+element.tanggal_kunjungan+'</td><td>'+ element.tempat_pelayanan+'</td><td>'+element.kode_pelayanan+'</td><td>'+element.penyakit+'</td></tr>');
                    });
                }

                $('.ui.modal.details').modal('show');
            }
        })
    };
</script>
@endsection