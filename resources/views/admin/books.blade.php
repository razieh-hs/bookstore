@extends('layouts.app')
@section('title', 'مدیریت کتاب‌ها | کتابستان')

@section('content')
<div class="container section">
    <nav class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">پنل ادمین</a><span>/</span>
        <span>کتاب‌ها</span>
    </nav>

    @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    <div class="section-head">
        <h2 class="section-title"><span class="dot"></span> 📚 مدیریت کتاب‌ها</h2>
        <button class="btn btn-primary" onclick="openModal('addBookModal')">➕ افزودن کتاب جدید</button>
    </div>

    <div class="filters-bar">
        <div class="genre-pills">
            <a href="{{ route('admin.books') }}" class="pill {{ !$currentGenre ? 'active' : '' }}">همه</a>
            @foreach($genres as $g)
                <a href="{{ route('admin.books') }}?genre={{ $g }}" class="pill {{ $currentGenre == $g ? 'active' : '' }}">{{ $g }}</a>
            @endforeach
        </div>
    </div>

    <div class="admin-table">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>جلد</th>
                    <th>عنوان</th>
                    <th>نویسنده</th>
                    <th>ژانر</th>
                    <th>قیمت</th>
                    <th>امتیاز</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $b)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="table-cover" style="background:url('{{ $b->cover ? asset($b->cover) : '' }}') center/cover, var(--grad-fresh)">
                                @if(!$b->cover)📖@endif
                            </div>
                        </td>
                        <td><strong>{{ Str::limit($b->title, 40) }}</strong></td>
                        <td>{{ $b->author->name ?? 'ناشناس' }}</td>
                        <td><span class="table-tag">{{ $b->genre }}</span></td>
                        <td class="table-price">{{ number_format($b->price) }} ت</td>
                        <td>⭐ {{ $b->rating }}</td>
                        <td>
                            <div class="table-actions">
                                <button type="button" class="btn btn-sm btn-ghost" onclick="editBook({{ $b }})">✏️</button>
                                <form action="{{ route('admin.books.destroy', $b->id) }}" method="POST" style="display:inline" onsubmit="return confirm('حذف شود؟')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-ghost" style="color:var(--coral)">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal-overlay" id="addBookModal" onclick="closeModal(event)">
    <div class="modal-box" onclick="event.stopPropagation()" style="max-width:600px">
        <div class="modal-header"><h3>➕ افزودن کتاب</h3><button class="close-btn" onclick="closeModal()">✕</button></div>
        <form action="{{ route('admin.books.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-grid">
                    <div class="form-group"><label>شناسه (مثلا b200)</label><input type="text" name="id" required></div>
                    <div class="form-group"><label>عنوان</label><input type="text" name="title" required></div>
                    <div class="form-group"><label>نویسنده</label>
                        <select name="author_id" required>
                            @foreach(\App\Models\Author::all() as $a) <option value="{{ $a->id }}">{{ $a->name }}</option> @endforeach
                        </select>
                    </div>
                    <div class="form-group"><label>ژانر</label><input type="text" name="genre" required></div>
                    <div class="form-group"><label>قیمت</label><input type="number" name="price" required></div>
                    <div class="form-group"><label>امتیاز</label><input type="number" step="0.1" name="rating" value="4.5" required></div>
                    <div class="form-group"><label>ناشر</label><input type="text" name="publisher" required></div>
                    <div class="form-group full"><label>توضیحات</label><textarea name="desc" required></textarea></div>
                    <input type="hidden" name="reviews" value="0">
                    <input type="hidden" name="year" value="1403">
                    <input type="hidden" name="pages" value="200">
                </div>
            </div>
            <div class="modal-footer"><button type="submit" class="btn btn-primary">💾 ذخیره</button></div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="editBookModal" onclick="closeModal(event)">
    <div class="modal-box" onclick="event.stopPropagation()" style="max-width:600px">
        <div class="modal-header"><h3>✏️ ویرایش کتاب</h3><button class="close-btn" onclick="closeModal()">✕</button></div>
        <form id="editBookForm" method="POST">
            @csrf @method('PUT')
            <div class="modal-body">
                <div class="form-grid">
                    <div class="form-group"><label>عنوان</label><input type="text" name="title" id="edit_title" required></div>
                    <div class="form-group"><label>نویسنده</label>
                        <select name="author_id" id="edit_author_id" required>
                            @foreach(\App\Models\Author::all() as $a) <option value="{{ $a->id }}">{{ $a->name }}</option> @endforeach
                        </select>
                    </div>
                    <div class="form-group"><label>ژانر</label><input type="text" name="genre" id="edit_genre" required></div>
                    <div class="form-group"><label>قیمت</label><input type="number" name="price" id="edit_price" required></div>
                    <div class="form-group"><label>امتیاز</label><input type="number" step="0.1" name="rating" id="edit_rating" required></div>
                    <div class="form-group"><label>ناشر</label><input type="text" name="publisher" id="edit_publisher" required></div>
                    <div class="form-group full"><label>توضیحات</label><textarea name="desc" id="edit_desc" required></textarea></div>
                    <input type="hidden" name="reviews" id="edit_reviews">
                    <input type="hidden" name="year" id="edit_year">
                    <input type="hidden" name="pages" id="edit_pages">
                </div>
            </div>
            <div class="modal-footer"><button type="submit" class="btn btn-primary">💾 به‌روزرسانی</button></div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openModal(id) { document.getElementById(id).classList.add('active'); document.body.style.overflow = 'hidden'; }
    function closeModal() { document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('active')); document.body.style.overflow = ''; }
    
    function editBook(book) {
        document.getElementById('editBookForm').action = '/admin/books/' + book.id;
        document.getElementById('edit_title').value = book.title;
        document.getElementById('edit_author_id').value = book.author_id;
        document.getElementById('edit_genre').value = book.genre;
        document.getElementById('edit_price').value = book.price;
        document.getElementById('edit_rating').value = book.rating;
        document.getElementById('edit_publisher').value = book.publisher;
        document.getElementById('edit_desc').value = book.desc;
        document.getElementById('edit_reviews').value = book.reviews;
        document.getElementById('edit_year').value = book.year;
        document.getElementById('edit_pages').value = book.pages;
        openModal('editBookModal');
    }
</script>
@endpush