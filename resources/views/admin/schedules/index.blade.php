@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Jadwal Fasilitas</h3>
                        <button id="addScheduleBtn" class="btn btn-primary float-end">
                            <i class="mdi mdi-plus"></i> Tambah Jadwal
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah/Edit Jadwal -->
    <div class="modal fade" id="scheduleModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jadwal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="scheduleForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="scheduleId" name="id">
                        <div class="mb-3">
                            <label class="form-label">Fasilitas</label>
                            <select name="facility_id" class="form-select" required>
                                @foreach ($facilities as $facility)
                                    <option value="{{ $facility->id }}">{{ $facility->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jam Mulai</label>
                            <input type="time" name="start_time" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jam Selesai</label>
                            <input type="time" name="end_time" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" id="deleteScheduleBtn" class="btn btn-danger d-none">Hapus</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = $('meta[name=csrf_token]').attr('content')

            var calendarEl = document.getElementById('calendar');
            var scheduleModal = new bootstrap.Modal(document.getElementById('scheduleModal'));

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: {
                    url: '{{ route('schedules.list') }}',
                    failure: function(errorObj) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Memuat Jadwal',
                            text: 'Terjadi kesalahan saat memuat data jadwal.'
                        });
                    }
                },
                eventClick: function(info) {
                    // Edit existing event
                    $.ajax({
                        url: '/admin/schedules/' + info.event.id + '/edit',
                        method: 'GET',
                        success: function(response) {
                            $('#scheduleId').val(response.id);
                            $('select[name="facility_id"]').val(response.facility_id);
                            $('input[name="date"]').val(response.date);
                            $('input[name="start_time"]').val(response.start_time);
                            $('input[name="end_time"]').val(response.end_time);
                            $('input[name="title"]').val(response.title);
                            $('#deleteScheduleBtn').removeClass('d-none');
                            scheduleModal.show();
                        }
                    });
                },
                dateClick: function(info) {
                    // Reset form for new event
                    $('#scheduleForm')[0].reset();
                    $('input[name="date"]').val(info.dateStr);

                    scheduleModal.show();
                }
            });
            calendar.render();

            $('#deleteScheduleBtn').on('click', function() {
                var scheduleId = $('#scheduleId').val();

                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: 'Apakah Anda yakin ingin menghapus jadwal ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/admin/schedules/' + scheduleId,
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                calendar.refetchEvents();
                                scheduleModal.hide();
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: xhr.responseJSON.message ||
                                        'Terjadi kesalahan'
                                });
                            }
                        });
                    }
                });
            });


            // Tambah/Edit Jadwal
            $('#scheduleForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var url = $('#scheduleId').val() ?
                    '/admin/schedules/' + $('#scheduleId').val() :
                    '{{ route('schedules.store') }}';

                $.ajax({
                    url: url,
                    method: $('#scheduleId').val() ? 'PUT' : 'POST',
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });
                        calendar.refetchEvents();
                        scheduleModal.hide();
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        accept: 'application/json'
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: xhr.responseJSON.message || 'Terjadi kesalahan'
                        });
                    }
                });
            });

            // Tombol Tambah Jadwal
            $('#addScheduleBtn').on('click', function() {
                $('#scheduleForm')[0].reset();
                $('#scheduleId').val('');
                scheduleModal.show();
            });
        });
    </script>
@endpush
