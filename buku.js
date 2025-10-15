$(document).ready(function() {
    loadBuku();

    $('#bukuForm').on('submit', function(e) {
        e.preventDefault();
        saveBuku();
    });

    $('#bukuModal').on('hidden.bs.modal', function() {
        $('#bukuForm')[0].reset();
        $('#id').val('');
        $('#modalTitle').text('Tambah Buku');
    });
});

function loadBuku() {
    $.ajax({
        url: '../controllers/buku_controller.php',
        type: 'GET',
        data: { action: 'read' },
        dataType: 'json',
        success: function(data) {
            let tableBody = $('#bukuTable tbody');
            tableBody.empty();
            
            data.forEach(function(buku) {
                let row = `
                    <tr>
                        <td>${buku.kode_buku}</td>
                        <td>${buku.judul}</td>
                        <td>${buku.pengarang}</td>
                        <td>${buku.penerbit}</td>
                        <td>${buku.tahun_terbit}</td>
                        <td>${buku.stok}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" onclick="editBuku(${buku.id})">Edit</button>
                            <button class="btn btn-sm btn-danger" onclick="deleteBuku(${buku.id})">Hapus</button>
                        </td>
                    </tr>
                `;
                tableBody.append(row);
            });
        }
    });
}

function saveBuku() {
    const formData = $('#bukuForm').serialize();
    const action = $('#id').val() ? 'update' : 'create';
    
    $.ajax({
        url: '../controllers/buku_controller.php',
        type: 'POST',
        data: formData + '&action=' + action,
        dataType: 'json',
        success: function(response) {
            alert(response.message);
            $('#bukuModal').modal('hide');
            loadBuku();
        }
    });
}

function editBuku(id) {
    $.ajax({
        url: '../controllers/buku_controller.php',
        type: 'GET',
        data: { action: 'read_one', id: id },
        dataType: 'json',
        success: function(data) {
            $('#id').val(data.id);
            $('#kode_buku').val(data.kode_buku);
            $('#judul').val(data.judul);
            $('#pengarang').val(data.pengarang);
            $('#penerbit').val(data.penerbit);
            $('#tahun_terbit').val(data.tahun_terbit);
            $('#stok').val(data.stok);
            $('#modalTitle').text('Edit Buku');
            $('#bukuModal').modal('show');
        }
    });
}

function deleteBuku(id) {
    if(confirm('Apakah Anda yakin ingin menghapus buku ini?')) {
        $.ajax({
            url: '../controllers/buku_controller.php',
            type: 'POST',
            data: { action: 'delete', id: id },
            dataType: 'json',
            success: function(response) {
                alert(response.message);
                loadBuku();
            }
        });
    }
}