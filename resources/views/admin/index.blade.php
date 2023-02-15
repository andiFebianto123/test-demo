@extends('../main')

@section('body')
    <div class="pt-2 pb-2">
        <h2>Data Mahasiswa</h2>
    </div>
    <a href="{{ url('mahasiswa/create') }}">
        <button type="button" class="btn btn-primary btn-sm">+ Add Data</button>
    </a>
    <div class="pt-4">
        <table id="table" class="table table-striped">
            <thead>
                <tr>
                    <th>Nim</th>
                    <th>Nama Lengkap</th>
                    <th>Jurusan</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Alamat Lengkap</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
               @if ($mahasiswas)
                @foreach ($mahasiswas as $mahasiswa)
                <tr>
                    <td>{{ $mahasiswa->nim }}</td>
                    <td>{{ $mahasiswa->nama }}</td>
                    <td>{{ $mahasiswa->jurusan->nama }}</td>
                    <td>{{ $mahasiswa->tempat_lahir }}</td>
                    <td>{{ $mahasiswa->tanggal_lahir }}</td>
                    <td>{{ $mahasiswa->alamat }}</td>
                    <td>
                        <a href="{{ url('/mahasiswa') }}/{{ $mahasiswa->id }}/edit" style="text-decoration:none;">
                            <button type="button" class="btn btn-warning btn-sm">Edit</button>
                        </a>
                        <button type="button" data-id="{{ $mahasiswa->id }}" class="btn btn-danger btn-sm btn-delete" data-bs-toggle="modal" data-bs-target="#modalDelete">Delete</button>
                    </td>
                </tr>
                @endforeach
               @endif
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete Mahasiswa</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure delete this data..
                <form action="{{ url('/mahasiswa') }}" id="form-delete">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" id="id" />
                </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger" id="submit-delete">Delete</button>
            </div>
        </div>
        </div>
    </div>
    <script>
        $(function(){
            $('.btn-delete').click(function(e){
                e.preventDefault();
                let id = $(this).attr('data-id');
                var url = "{{ url('/mahasiswa') }}/"+id;
                $('#form-delete').attr('action', url);
                $('#modalDelete #id').val(id);
            });

            $('#submit-delete').click(function(e){
                e.preventDefault();
                let id = $('#modalDelete #id').val();
                $.ajax({
                    url: $('#form-delete').attr('action'),
                    type: 'DELETE',
                    data:$("#form-delete").serialize(),//only input
                    success: function(result) {
                        if(result.status){
                            alert(result.message);
                            location.reload();
                        }
                    }
                });
            });
        });
    </script>
@endpush