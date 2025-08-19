@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Ebooks</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('ebooks.create') }}" class="btn btn-primary">+ Add New Ebooks</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Year</th>
                        <th>Category</th>
                        <th>PDF</th>
                        <th>Cover</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ebooks as $ebook)
                        <tr>
                            <td>{{ $ebook->id }}</td>
                            <td>{{ $ebook->title }}</td>
                            <td>{{ $ebook->author }}</td>
                            <td>{{ $ebook->publisher }}</td>
                            <td>{{ $ebook->copyrightyear }}</td>
                            <td>{{ $ebook->category }}</td>
                            <td>
                                @if($ebook->pdf)
                                    <a href="{{ asset('storage/' . $ebook->pdf) }}" target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                @else
                                    <span class="text-muted">No PDF</span>
                                @endif
                            </td>
                            <td>
                                @if($ebook->coverage)
                                    <img src="{{ asset('storage/' . $ebook->coverage) }}" alt="cover" width="50" height="60" style="object-fit: cover;">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('ebooks.edit', $ebook->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('ebooks.destroy', $ebook->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete this ebook?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center p-3">No ebooks found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
