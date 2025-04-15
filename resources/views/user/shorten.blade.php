@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Shorten URL</h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('shorten.store') }}" method="POST">
            @csrf
            <input type="text" name="original_url" placeholder="https://example.com" class="form-control mb-2">
            @error('original_url') <div class="text-danger">{{ $message }}</div> @enderror
            <button type="submit" class="btn btn-primary">Shorten</button>
        </form>

        <hr>

        <h4>Your Shorten URL</h4>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Shorten URL</th>
                <th>Original URL</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @if($urls->count() > 0)
                @foreach($urls as $url)
                    <tr>
                        <td>
                            <a href="{{ route('shorten.redirect', $url->short_code) }}" target="_blank">
                                {{ url($url->short_code) }}
                            </a>
                        </td>
                        <td>{{ $url->original_url }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary"
                                    onclick="copyToClipboard('{{ url($url->short_code) }}')">
                                คัดลอก Shorten URL
                            </button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3" class="text-center">ไม่มีข้อมูล</td>
                </tr>
            @endif
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $urls->links('pagination::bootstrap-4') }}
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function () {
                //
            }, function (err) {
                alert('ไม่สามารถคัดลอกได้');
                console.error('Error : ', err);
            });
        }
    </script>
@endsection
