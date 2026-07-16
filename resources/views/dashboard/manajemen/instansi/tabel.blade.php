<div class="row">
    <div class="col-md-12">
        <div class="card">

            <div class="card-header">
                <a href="{{ route('create.Instansi') }}" class="btn btn-primary btn-round">
                    <i class="fa fa-plus me-1"></i>
                    Tambah Instansi
                </a>
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table id="dataInstansi" class="display table table-striped table-hover w-100">

                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Kode</th>
                                <th>Nama Instansi</th>
                                <th>Jenis Instansi</th>
                                <th>Telepon</th>
                                <th>Status</th>
                                <th width="12%">Aksi</th>
                            </tr>
                        </thead>

                    </table>

                </div>

            </div>

        </div>
    </div>
</div>

@push('myscript')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"></script>

    <script>
        $(document).ready(function() {

            $('#dataInstansi').DataTable({

                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,

                ajax: "{{ route('get.Instansi') }}",

                columns: [

                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: "text-center align-middle",
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },

                    {
                        data: 'kode_instansi',
                        name: 'kode_instansi',
                        className: "align-middle",
                        defaultContent: '-'
                    },

                    {
                        data: 'nama_instansi',
                        name: 'nama_instansi',
                        className: "align-middle"
                    },

                    {
                        data: 'jenis_instansi',
                        name: 'jenis_instansi',
                        className: "align-middle"
                    },

                    {
                        data: 'telepon',
                        name: 'telepon',
                        className: "align-middle",
                        defaultContent: '-'
                    },

                    {
                        data: 'status',
                        name: 'status',
                        className: "text-center align-middle",
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false,
                        className: "text-center align-middle"
                    }

                ],

                language: {
                    url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json"
                },

                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],

                ordering: true,
                searching: true,
                lengthChange: true,
                paging: true,
                info: true

            });

        });
    </script>

    <script>
        $(document).on('click', '.btn-delete', function() {

            let id = $(this).data('id');

            Swal.fire({

                title: 'Yakin ingin menghapus?',
                text: "Data instansi yang dihapus tidak dapat dikembalikan.",
                icon: 'warning',

                showCancelButton: true,

                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',

                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'

            }).then((result) => {

                if (result.isConfirmed) {

                    $('#form-delete-' + id).submit();

                }

            });

        });
    </script>
@endpush
