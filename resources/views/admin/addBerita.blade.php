<div class="ui small modal add_berita">
    <div class="header">Tambah Berita</div>
    <div class="content">

        <div class="ui error message" id="add_error_bag">
            <i class="close icon"></i>
            <div class="header">
                There were some errors with your submission
            </div>
            <ul class="list" id="add_error_task">
            </ul>
        </div>

        <form id="form_add" class="ui form" method="POST">
            @csrf
            <div class="field">
                <label for="judul">Judul</label>
                <input type="text" name="judul" placeholder="Judul">
            </div>

            <div class="field">
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" accept="image/*" id="fileinput">
            </div>

            <div class="field">
                <label>Berita</label>
                <textarea name="berita"></textarea>
            </div>

            {{-- <div class="field">
                    <button class="ui right floated primary button" name="submit" type="submit" id="btn_tambah">
                        Tambah
                    </button>
                </div> --}}

            <div class="actions">
                <div class="ui approve blue button" type="submit" id="btn_tambah">Tambah</div>
                <div class="ui cancel button">Cancel</div>
            </div>

        </form>
    </div>
</div>


<script>
    $('.message .close').on('click', function() {
        $(this)
            .closest('.message')
            .transition('fade')
    });

    


    
</script>