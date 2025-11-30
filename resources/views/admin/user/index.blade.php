@extends('admin.layout.master')

@section('title', 'Users')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Danh sách User</h1>

    <div class="card">
        <div class="card-header">
            <strong>Tất cả user</strong>
        </div>

        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead>
                    <tr>
                        <th width="60">ID</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th width="120">Level</th>
                        <th width="160">Ngày tạo</th>
                        <th width="150">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->level == \App\Models\User::LEVEL_ADMIN)
                            <span class="badge bg-danger text-white">Admin</span>
                            @else
                            <span class="badge bg-secondary text-white">Member</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at?->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                class="btn btn-sm btn-primary">
                                Sửa
                            </a>

                            @if(auth()->id() !== $user->id)
                            <form action="{{ route('admin.users.delete', $user->id) }}"
                                method="POST"
                                style="display:inline-block"
                                onsubmit="return confirm('Xóa user này?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    Xóa
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            Không có user nào.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer text-center">
            {{ $users->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection