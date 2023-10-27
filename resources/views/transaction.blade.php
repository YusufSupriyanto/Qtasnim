<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Transaksi</title>
</head>

<body>
    <div id="token" data-token="{{ session('token') }}"></div>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <h5 class="nav-link">Filter</h5>
                        </li>
                        <li class="nav-item">
                            <select class="form-select" id="filter_select">
                                <option value="1">Terbanyak</option>
                                <option value="2">Terendah</option>
                            </select>
                        </li>
                        <li class="nav-item">
                            <label for="startDate" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="startDate" placeholder="Tanggal Awal">
                        </li>
                        <li class="nav-item">
                            <label for="endtDate" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="endDate" placeholder="Tanggal Akhir">
                            <button class="btn btn-primary w-100 mt-2" onclick="filter()">Filter</button>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Konten -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <input class="form-control me-2" id="search" name="search" type="search" placeholder="Cari..." aria-label="Search">
                        <button class="btn btn-outline-success" type="button" onclick="search()">Cari</button>
                </nav>

                <!-- Tabel Konten -->
                <div class="card">
                    <div class="w-10"><button type="button" class="btn btn-success" onclick="modal()">Add</div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Jumlah Terjual</th>
                                <th scope="col">Tanggal Transaksi</th>
                                <th scope="col">Jenis Barang</th>
                                <th scope="col">update</th>
                                 <th scope="col">delete</th>
                            </tr>
                        </thead>
                        <tbody id="body_table">
                            <!-- Isi tabel disini -->
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<div class="mb-3">
    <label for="nama_barang" class="form-label">Nama Barang</label>
    <select  class="form-control" name="good_name" id="good_name">
    </select>
  </div>
  <div class="mb-3">
    <label for="quantity_sold" class="form-label">Jumlah Terjual</label>
    <input type="text" class="form-control" id="quantity_sold">
    <input type="hidden" class="form-control" id="id_update">
  </div>
  <div class="mb-3">
    <label for="quantity_sold" class="form-label">Tanggal Transaksi</label>
    <input type="date" class="form-control" id="date_transaction">
  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button"  onclick="create()" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>

            var token = "{{ session('token') }}";
            getAllData();

            function getAllData() {
                $.ajax({
                    url: 'http://127.0.0.1/Qtasnim/public/api/transaction',
                    type: 'get', // Sesuaikan dengan metode logout Anda
                    headers: {
                        'Authorization': 'Bearer ' + token,
                    },
                    success: function(response) {
                        populateTable(response.data)
                        console.log(response.data)
                    },
                    error: function(error) {
                        // Tangani kesalahan logout di sini
                    }
                });
            }

            function populateTable(data) {
                var tableBody = document.getElementById("body_table");
                tableBody.innerHTML = ''; // Kosongkan isi tabel sebelum mengisi ulang

                for (var i = 0; i < data.length; i++) {
                    var rowData = data[i];
                    var row = document.createElement("tr");

                    // Kolom No
                    var cellNo = document.createElement("td");
                    cellNo.textContent = i + 1;
                    row.appendChild(cellNo);

                    // Kolom Nama Barang
                    var cellNamaBarang = document.createElement("td");
                    cellNamaBarang.textContent = rowData.good_name;
                    row.appendChild(cellNamaBarang);

                    // Kolom Terjual
                    var cellStok = document.createElement("td");
                    cellStok.textContent = rowData.quantity_sold;
                    row.appendChild(cellStok);


                    // Kolom Tanggal Transaksi
                    var cellTanggalTransaksi = document.createElement("td");
                    cellTanggalTransaksi.textContent = rowData.date_transaction;
                    row.appendChild(cellTanggalTransaksi);

                    // Kolom Jenis Barang
                    var cellJenisBarang = document.createElement("td");
                    cellJenisBarang.textContent = rowData.good_type;
                    row.appendChild(cellJenisBarang);

                    // button
                    var cellAddButton = document.createElement("td"); // Membuat elemen <td>
                    var button = document.createElement("button"); // Membuat elemen <button>
                    button.className = "btn btn-primary"; // Mengatur kelas button
                    button.textContent = 'Update'
                    button.setAttribute("onclick", "modal(" + rowData.id + ")");
                    button.setAttribute("data-button", rowData.id); // Menetapkan atribut data-button
                    cellAddButton.appendChild(button); // Menambahkan elemen button ke dalam elemen td
                    row.appendChild(cellAddButton);


                    var cellUpdateButton = document.createElement("td"); // Membuat elemen <td>
                    var buttonUp = document.createElement("button"); // Membuat elemen <button>
                    buttonUp.className = "btn btn-danger"; // Mengatur kelas button
                    buttonUp.textContent = 'delete'
                    buttonUp.setAttribute("onclick", "deleted(" + rowData.id + ")");
                    buttonUp.setAttribute("data-button", rowData.id); // Menetapkan atribut data-button
                    cellUpdateButton.appendChild(buttonUp); // Menambahkan elemen button ke dalam elemen td
                    row.appendChild(cellUpdateButton);


                    tableBody.appendChild(row);
                }
            }

            


        function modal(id = null)
        {
            var update = document.getElementById('id_update');
            update.value = id
                $.ajax({
                    url: 'http://127.0.0.1/Qtasnim/public/api/goods',
                    type: 'get',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                    },
                    success: function(response) {
                        generateOptions(response.data);
                         $('#exampleModal').modal('show');
                        // console.log(response.data)
                    },
                    error: function(error) {
                        // Tangani kesalahan logout di sini
                    }
                });
        }

    function generateOptions(data) {
    var select = document.getElementById('good_name'); // Dapatkan elemen select berdasarkan ID
    select.innerHTML = ""; // Kosongkan isi elemen select (jika ada)

    for (var i = 0; i < data.length; i++) {
        var rowData = data[i];
        var option = document.createElement("option"); // Buat elemen option
        option.text = rowData.good_name; // Atur teks opsi
        option.value = rowData.id; // Atur nilai opsi (opsional)
        select.appendChild(option); // Tambahkan opsi ke dalam elemen select
    }

    }

     function create()
        {
            var id_update = document.getElementById('id_update'); 
            var good_name = document.getElementById('good_name');
            var quantity_sold = document.getElementById('quantity_sold');
            var currentDate = document.getElementById('date_transaction');
               $.ajax({
                    url: 'http://127.0.0.1/Qtasnim/public/api/create_transaction',
                    type: 'post',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                    },
                    data:{
                        id:id_update.value,
                        goods_id:good_name.value,
                        quantity_sold:quantity_sold.value,
                        date_transaction:currentDate.value,
                    },
                    success: function(response) {
                      populateTable(response.data)
                    },
                    error: function(error) {
                        // Tangani kesalahan logout di sini
                    }
                });
        }

        function deleted(id){
             $.ajax({
                    url: 'http://127.0.0.1/Qtasnim/public/api/delete_transaction',
                    type: 'post',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                    },
                    data:{
                        id:id,
                    },
                    success: function(response) {
                      populateTable(response.data)
                    },
                    error: function(error) {
                        // Tangani kesalahan logout di sini
                    }
                });
        }

        function search()
        {
            var search = document.getElementById('search').value;
             $.ajax({
                    url: 'http://127.0.0.1/Qtasnim/public/api/searchTransaction',
                    type: 'post',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                    },
                    data:{
                        searchTerm:search,
                    },
                    success: function(response) {
                      populateTable(response.data)
                    },
                    error: function(error) {
                        // Tangani kesalahan logout di sini
                    }
                });
        }

         function filter()
        {
            var filter = document.getElementById('filter_select').value;
             var startDate = document.getElementById('startDate').value;
             var endDate = document.getElementById('endDate').value;
             $.ajax({
                    url: 'http://127.0.0.1/Qtasnim/public/api/filter',
                    type: 'post',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                    },
                    data:{
                        filter:filter,
                        startDate:startDate,
                        endDate:endDate
                    },
                    success: function(response) {
                      populateTable(response.data)
                    },
                    error: function(error) {
                        // Tangani kesalahan logout di sini
                    }
                });
        }
    </script>
</body>

</html>
