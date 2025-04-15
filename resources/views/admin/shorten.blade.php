@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h4>Shorten URL</h4>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Shorten URL</th>
                <th>Original URL</th>
                <th>Created By</th>
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
                            <td>{{ $url->user_full_name }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $url->id }}">
                                    แก้ไข
                                </button>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $url->id }}">
                                    ลบ
                                </button>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $url->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $url->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('shorten.update', $url->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $url->id }}">แก้ไข URL</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="ปิด"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Original URL</label>
                                                <input type="url" name="original_url" class="form-control" value="{{ $url->original_url }}" required>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="regenerateShortUrl{{ $url->id }}" name="regenerate_short_code">
                                                <label class="form-check-label" for="regenerateShortUrl{{ $url->id }}">
                                                    สร้าง Shorten URL ใหม่
                                                </label>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                            <button type="submit" class="btn btn-primary">บันทึก</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal{{ $url->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $url->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('shorten.destroy', $url->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $url->id }}">ยืนยันการลบ</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="ปิด"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>คุณแน่ใจหรือไม่ว่าต้องการลบ URL นี้?</p>
                                            <p><strong>{{ $url->original_url }}</strong></p>
                                            <p><small>Short: {{ url($url->short_code) }}</small></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                            <button type="submit" class="btn btn-danger">ลบ</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center">ไม่มีข้อมูล</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $urls->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
