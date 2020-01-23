<div class="ui small modal edit_berita">
    <div class="header">Edit Berita</div>
    <div class="content">


        <form id="form_edit" class="ui form" method="POST">
            @csrf
            <input type="hidden" id="edit_berita_id" value="0">
            <div class="field">
                <label for="judul">Judul</label>
                <input type="text" name="judul" placeholder="Judul" required>
            </div>

            <div class="field">
                <label for="foto">Foto</label>
                <input type="file" name="foto" accept="image/*" id="fileinput">
            </div>

            <div class="field">
                <label>Berita</label>
                <textarea name="berita" required></textarea>
            </div>

            <div class="actions">
                <div class="ui approve blue button" type="submit" id="btn_update">Update</div>
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