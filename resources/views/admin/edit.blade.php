@extends('../main')
@section('body')
<div class="pt-2 pb-2">
    <h2>Edit Mahasiswa</h2>
</div>
<div class="rows">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="list-unstyled">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ url('/mahasiswa') }}/{{ $data->id }}" method="POST" class="row g-3">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="id" value="{{ $data->id }}" />
                    <div class="col-12">
                        <label class="form-label">NIM</label>
                        <input type="text" class="form-control" name="nim" id="nim" value="{{ $data->nim }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama" value="{{ $data->nama }}" >
                    </div>
                    <div class="col-12">
                        <label for="nik" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="{{ $data->tanggal_lahir }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Jurusan</label>
                        <select class="form-select" id="jurusan" name="jurusan" aria-label="Default select example">
                            <option value=''>-</option>
                            @if (isset($jurusan_options))
                                @foreach ($jurusan_options as $option)
                                    @if (isset($option['status']))
                                    <option value="{{ $option['value'] }}" selected>{{ $option['text'] }}</option>
                                    @else
                                    <option value="{{ $option['value'] }}">{{ $option['text'] }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Tempat Lahir</label><br>
                        <label class="form-label">Pilih Provinsi</label>
                        <select class="form-select" id="provinsi" name="provinsi">
                            <option value=''>-</option>
                            @if (isset($province_options))
                                @foreach ($province_options as $option)
                                    @if (isset($option['status']))
                                    <option value="{{ $option['value'] }}" selected>{{ $option['text'] }}</option>
                                    @else
                                    <option value="{{ $option['value'] }}">{{ $option['text'] }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                        <label class="form-label">Pilih Kota</label>
                        <select class="form-select" id="kota" name="kota">
                            <option value=''>-</option>
                            @if (isset($cities_options))
                                @foreach ($cities_options as $option)
                                    @if (isset($option['status']))
                                    <option value="{{ $option['value'] }}" selected>{{ $option['text'] }}</option>
                                    @else
                                    <option value="{{ $option['value'] }}">{{ $option['text'] }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control" cols="30" rows="5">{{ $data->alamat }}</textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Save</button>
                      </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="mb-2"></div>
@endsection

@push('scripts')
    <script>
        $(function(){
            $('#provinsi').change(function(){
                var text = $(this).val();
                var url = "{{ url('/mahasiswa/kota') }}/" + text;
                let options = "<option value=''>-</option>";
                if(text != ''){
                    $.get(url, function(response){
                        if(response.status){
                            response.results.forEach(function(item, index){
                                options += `<option value="${item.value}">${item.text}</option>`;
                            });
                            $('#kota').html(options);
                        }
                    }); 
                }else{
                    $('#kota').html(options);
                }
            });
        });
    </script>
@endpush