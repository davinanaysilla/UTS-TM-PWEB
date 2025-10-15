$(document).ready(function() {
    loadPetugas();

    $('#petugasForm').on('submit', function(e) {
        e.preventDefault();
        savePetugas();
    });

    $('#petugasModal').on('hidden.bs.modal', function() {
        $('#petugasForm')[0].reset();
        $('#id').val('');
        $('#modalTitle').text('Tambah Petugas');
    });
});

function loadPetugas() {
    $.ajax({
        url: '../controllers/petugas_controller.php',
        type: 'GET',
        data: { action: 'read' },
        dataType: 'json',
        success: function(data) {
            let tableBody = $('#petugasTable tbody');
            tableBody.empty();
            
            data.forEach(function(petugas) {
                let row = `
                    <tr>
                        <td>${petugas.kode_petugas}</td>
                        <td>${petugas.nama}</td>
                        <td>${petugas.email}</td>
                        <td>${petugas.no_telp || '-'}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" onclick="editPetugas(${petugas.id})">Edit</button>
                            <button class="btn btn-sm btn-danger" onclick="deletePetugas(${petugas.id})">Hapus</button>
                        </td>
                    </tr>
                `;
                tableBody.append(row);
            });
        }
    });
}

function savePetugas() {
    const formData = $('#petugasForm').serialize();
    const action = $('#id').val() ? 'update' : 'create';
    
    $.ajax({
        url: '../controllers/petugas_controller.php',
        type: 'POST',
        data: formData + '&action=' + action,
        dataType: 'json',
        success: function(response) {
            alert(response.message);
            $('#petugasModal').modal('hide');
            loadPetugas();
        }
    });
}

function editPetugas(id) {
    $.ajax({
        url: '../controllers/petugas_controller.php',
        type: 'GET',
        data: { action: 'read_one', id: id },
        dataType: 'json',
        success: function(data) {
            $('#id').val(data.id);
            $('#kode_petugas').val(data.kode_petugas);
            $('#nama').val(data.nama);
            $('#email').val(data.email);
            $('#no_telp').val(data.no_telp);
            $('#modalTitle').text('Edit Petugas');
            $('#petugasModal').modal('show');
        }
    });
}

function deletePetugas(id) {
    if(confirm('Apakah Anda yakin ingin menghapus petugas ini?')) {
        $.ajax({
            url: '../controllers/petugas_controller.php',
            type: 'POST',
            data: { action: 'delete', id: id },
            dataType: 'json',
            success: function(response) {
                alert(response.message);
                loadPetugas();
            }
        });
    }
}