function toggleEditForm(id) {
    for (let i = 0; i < 6; i++) {
        var form = document.getElementById('form-edit-' + i + id);
        if (form.style.display === 'none' || form.style.display === '') {
            form.style.display = 'table-cell';
        } else {
            form.style.display = 'none';
        }

        if (i > 0) {
            var data = document.getElementById('baris-' + i + id);
            if (data.style.display === 'none') {
                data.style.display = 'table-cell';
            } else {
                data.style.display = 'none';
            }
        }

    }
    var hps = document.getElementById('hps-' + id);
    if (hps.style.display === 'none') {
        hps.style.display = 'table-cell';
    } else {
        hps.style.display = 'none';
    }
}

