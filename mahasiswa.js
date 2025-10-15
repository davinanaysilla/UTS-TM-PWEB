$(document).ready(function() {
    loadMahasiswa();

    $('#mahasiswaForm').on('submit', function(e) {
        e.preventDefault();
        saveMahasiswa();
    });

    $('#mahasiswaModal').on('hidden.bs.modal', function() {
        $('#mahasiswaForm')[0].reset();
        $('#id').val('');
        $('#modalTitle').text('Tambah Mahasiswa');
    });
});

function loadMahasiswa() {
    console.log("Loading mahasiswa data...");
    $.ajax({
        url: '../controllers/mahasiswa_controller.php',
        type: 'GET',
        data: { action: 'read' },
        dataType: 'json',
        success: function(data) {
            let tableBody = $('#mahasiswaTable tbody');
            tableBody.empty();
            
            data.forEach(function(mahasiswa) {
                let row = `
                    <tr>
                        <td>${mahasiswa.nim}</td>
                        <td>${mahasiswa.nama}</td>
                        <td>${mahasiswa.jurusan}</td>
                        <td>${mahasiswa.semester}</td>
                        <td>${mahasiswa.no_telp || '-'}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" onclick="editMahasiswa(${mahasiswa.id})">Edit</button>
                            <button class="btn btn-sm btn-danger" onclick="deleteMahasiswa(${mahasiswa.id})">Hapus</button>
                        </td>
                    </tr>
                `;
                tableBody.append(row);
            });
        }
    });
}

function saveMahasiswa() {
    const formData = $('#mahasiswaForm').serialize();
    const action = $('#id').val() ? 'update' : 'create';
    
    $.ajax({
        url: '../controllers/mahasiswa_controller.php',
        type: 'POST',
        data: formData + '&action=' + action,
        dataType: 'json',
        success: function(response) {
            alert(response.message);
            $('#mahasiswaModal').modal('hide');
            loadMahasiswa();
        }
    });
}

function editMahasiswa(id) {
    $.ajax({
        url: '../controllers/mahasiswa_controller.php',
        type: 'GET',
        data: { action: 'read_one', id: id },
        dataType: 'json',
        success: function(data) {
            $('#id').val(data.id);
            $('#nim').val(data.nim);
            $('#nama').val(data.nama);
            $('#jurusan').val(data.jurusan);
            $('#semester').val(data.semester);
            $('#no_telp').val(data.no_telp);
            $('#modalTitle').text('Edit Mahasiswa');
            $('#mahasiswaModal').modal('show');
        }
    });
}

function deleteMahasiswa(id) {
    if(confirm('Apakah Anda yakin ingin menghapus mahasiswa ini?')) {
        $.ajax({
            url: '../controllers/mahasiswa_controller.php',
            type: 'POST',
            data: { action: 'delete', id: id },
            dataType: 'json',
            success: function(response) {
                alert(response.message);
                loadMahasiswa();
            }
        });
    }
}