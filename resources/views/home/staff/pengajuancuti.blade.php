<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pengajuan Cuti</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
            margin: 0;
        }
        h1 {
            text-align: center;
            color: #333;
            margin: 20px 0;
        }
        .logo {
            display: block;
            margin: 0 auto 20px;
            width: 100px;
            height: auto;
        }
        form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        #autocomplete-results {
            border: 1px solid #ccc;
            background: #fff;
            max-height: 150px;
            overflow-y: auto;
            z-index: 1000;
            position: absolute;
            width: calc(100% - 22px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .autocomplete-item {
            padding: 8px;
            cursor: pointer;
        }
        .autocomplete-item:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <img src="{{ asset('../assets/img/dwimetal.png') }}" alt="Logo" class="logo">
    <h1>Formulir Pengajuan Cuti</h1>
    <form action="/submit-pengajuancuti" method="POST">
        @csrf
        <label for="nama_staff">Nama Staff (ID - Nama):</label>
        <input type="text" id="nama_staff" name="nama_staff" autocomplete="off" required>
        <input type="hidden" id="id_staff" name="id_staff" required>
        <div id="autocomplete-results" style="display: none; width: 600px;"></div>

        <br>
        <label for="sisa_cuti" style="display: inline-block; margin-right: 10px;">Sisa Cuti:</label>
        <span id="sisa_cuti" style="font-weight: bold; color: #333;"></span>

        <br>
        <label for="tgl_mulai">Tanggal Mulai:</label>
        <input type="date" id="tgl_mulai" name="tgl_mulai" required>

        <label for="tgl_selesai">Tanggal Selesai:</label>
        <input type="date" id="tgl_selesai" name="tgl_selesai" required>

        <label for="durasi">Durasi (hari):</label>
        <input type="text" id="durasi" name="durasi" readonly>

        <label for="alasan">Alasan Cuti:</label>
        <select id="alasan" name="alasan">
            <option value="">Pilih Alasan</option>
            <option value="Sakit">Cuti Sakit</option>
            <option value="Menikah">Cuti Menikah</option>p
            <option value="Menikahkan Anak">Cuti Menikahkan Anak</option>
            <option value="Mengkhitankan Anak">Cuti Mengkhitankan Anak</option>
            <option value="Membaptiskan Anak">Cuti Membaptiskan Anak</option>
            <option value="Melahirkan">Cuti Melahirkan</option>
            <option value="Kematian Keluarga Terdekat">Cuti Kematian Keluarga Terdekat</option>
        </select>

        <label for="alasan_lain">Alasan Lain:</label>
        <textarea id="alasan_lain" name="alasan_lain" rows="4"></textarea>

        <button type="submit">Ajukan Cuti</button>
    </form>

    <script>
        $(document).ready(function () {
            // Autocomplete untuk Nama Staff
            $('#nama_staff').on('input', function () {
                var query = $(this).val();
                if (query.length > 2) {
                    $.ajax({
                        url: "{{ route('staff.search') }}",
                        type: "GET",
                        data: { query: query },
                        success: function (data) {
                            var list = '';
                            data.forEach(function (staff) {
                                if ($('#autocomplete-results div[data-id="' + staff.id + '"]').length === 0) {
                                    list += '<div class="autocomplete-item" data-id="' + staff.id + '">' + staff.id + ' - ' + staff.nama + '</div>';
                                }
                            });
                            $('#autocomplete-results').html(list).show();
                        }
                    });
                } else {
                    $('#autocomplete-results').hide();
                }
            });

            // Pilih nama staff dari hasil autocomplete
            $(document).on('click', '.autocomplete-item', function () {
                var selectedText = $(this).text();
                $('#nama_staff').val(selectedText);
                $('#id_staff').val($(this).data('id'));
                $('#autocomplete-results').hide();

                // Ambil sisa cuti setelah memilih staff
                var staffId = $(this).data('id');
                $.ajax({
                    url: '/staff/sisa-cuti/' + staffId,
                    type: 'GET',
                    success: function (response) {
                        $('#sisa_cuti').text(response.sisa_cuti || 'Tidak ditemukan');
                    },
                    error: function () {
                        $('#sisa_cuti').text('Tidak ditemukan');
                    }
                });
            });

            // Hitung Durasi Cuti Otomatis
            $('#tgl_mulai, #tgl_selesai').on('change', function () {
                var tglMulai = new Date($('#tgl_mulai').val());
                var tglSelesai = new Date($('#tgl_selesai').val());
                if (tglMulai && tglSelesai && tglSelesai >= tglMulai) {
                    var durasi = (tglSelesai - tglMulai) / (1000 * 60 * 60 * 24) + 1;
                    $('#durasi').val(durasi);
                } else {
                    $('#durasi').val('');
                }
            });

            // Validasi sebelum pengajuan cuti
            $('form').on('submit', function (e) {
                var sisaCuti = parseInt($('#sisa_cuti').text()) || 0;
                var durasi = parseInt($('#durasi').val()) || 0;

                // Cek sisa cuti
                if (sisaCuti <= 0) {
                    alert("Kuota cuti telah habis.");
                    e.preventDefault();
                    return;
                }

                // Cek durasi cuti tidak melebihi sisa cuti
                if (durasi > sisaCuti) {
                    alert("Durasi cuti melebihi sisa cuti yang tersedia.");
                    e.preventDefault();
                    return;
                }

                // Validasi alasan cuti
                var alasan = $('#alasan').val();
                var alasanLain = $('#alasan_lain').val();
                if (!alasan && !alasanLain.trim()) {
                    alert('Silakan isi salah satu alasan cuti.');
                    e.preventDefault();
                }
            });
        });
    </script>

</body>
</html>
