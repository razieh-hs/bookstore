@extends('layouts.app')
@section('title', 'مدیریت نویسندگان | کتابستان')

@section('content')
<div class="container section">
    <nav class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">پنل ادمین</a><span>/</span>
        <span>نویسندگان</span>
    </nav>

    @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    <div class="section-head">
        <h2 class="section-title"><span class="dot"></span> ✍️ مدیریت نویسندگان</h2>
        <button class="btn btn-primary" onclick="openModal('addAuthorModal')">➕ افزودن نویسنده</button>
    </div>

    <div class="admin-table">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>عکس</th>
                    <th>نام</th>
                    <th>نقش</th>
                    <th>تعداد کتاب</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($authors as $a)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="table-avatar">
                                <img src="{{ asset('images/authors/' . $a->id . '.jpg') }}" onerror="this.parentElement.classList.add('no-img');this.remove()">
                            </div>
                        </td>
                        <td><strong>{{ $a->name }}</strong></td>
                        <td>{{ $a->role }}</td>
                        <td>{{ $a->works }} کتاب</td>
                        <td>
                            <div class="table-actions">
                                <button type="button" class="btn btn-sm btn-ghost" onclick="editAuthor({{ $a }})">✏️</button>
                                <form action="{{ route('admin.authors.destroy', $a->id) }}" method="POST" style="display:inline" onsubmit="return confirm('حذف شود؟')">
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

<div class="modal-overlay" id="addAuthorModal" onclick="closeModal(event)">
    <div class="modal-box" onclick="event.stopPropagation()" style="max-width:720px">
        <div class="modal-header"><h3>➕ افزودن نویسنده</h3><button class="close-btn" onclick="closeModal()">✕</button></div>
        <form action="{{ route('admin.authors.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-grid">
                    <div class="form-group"><label>شناسه *</label><input type="text" name="id" required></div>
                    <div class="form-group"><label>نام *</label><input type="text" name="name" required></div>
                    <div class="form-group"><label>نام کامل</label><input type="text" name="full_name"></div>
                    <div class="form-group"><label>لقب / تخلص</label><input type="text" name="pen_name"></div>
                    <div class="form-group"><label>نقش *</label><input type="text" name="role" required></div>
                    <div class="form-group"><label>تعداد کتاب *</label><input type="number" name="works" value="1" required></div>
                    <div class="form-group"><label>تاریخ تولد</label><input type="text" name="born_date" placeholder="مثلاً ۱۲۸۱"></div>
                    <div class="form-group"><label>شهر تولد</label><input type="text" name="born_city"></div>
                    <div class="form-group"><label>کشور تولد</label><input type="text" name="born_country"></div>
                    <div class="form-group"><label>تاریخ فوت</label><input type="text" name="died_date"></div>
                    <div class="form-group"><label>شهر فوت</label><input type="text" name="died_city"></div>
                    <div class="form-group"><label>کشور فوت</label><input type="text" name="died_country"></div>
                    <div class="form-group"><label>محل دفن</label><input type="text" name="burial_place"></div>
                    <div class="form-group"><label>ملیت</label><input type="text" name="nationality"></div>
                    <div class="form-group"><label>دوره</label><input type="text" name="era"></div>
                    <div class="form-group"><label>پیشه</label><input type="text" name="occupation"></div>
                    <div class="form-group"><label>ژانر اصلی</label><input type="text" name="genre"></div>
                    <div class="form-group"><label>تحصیلات</label><input type="text" name="education"></div>
                    <div class="form-group"><label>همسر</label><input type="text" name="spouse"></div>
                    <div class="form-group full"><label>بیوگرافی کوتاه</label><textarea name="short_bio"></textarea></div>
                    <div class="form-group full"><label>زندگی‌نامه (هر خط یک پاراگراف)</label><textarea name="biography" rows="4"></textarea></div>
                    <div class="form-group full"><label>جملات (هر خط یک جمله)</label><textarea name="quotes" rows="3"></textarea></div>
                    <div class="form-group full"><label>جوایز (هر خط یک جایزه)</label><textarea name="awards" rows="2"></textarea></div>
                    <div class="form-group full"><label>دانستنی‌ها (هر خط یک مورد)</label><textarea name="facts" rows="3"></textarea></div>
                </div>
            </div>
            <div class="modal-footer"><button type="submit" class="btn btn-primary">💾 ذخیره</button></div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="editAuthorModal" onclick="closeModal(event)">
    <div class="modal-box" onclick="event.stopPropagation()" style="max-width:720px">
        <div class="modal-header"><h3>✏️ ویرایش نویسنده</h3><button class="close-btn" onclick="closeModal()">✕</button></div>
        <form id="editAuthorForm" method="POST">
            @csrf @method('PUT')
            <div class="modal-body">
                <div class="form-grid">
                    <div class="form-group"><label>نام *</label><input type="text" name="name" id="edit_a_name" required></div>
                    <div class="form-group"><label>نام کامل</label><input type="text" name="full_name" id="edit_a_full_name"></div>
                    <div class="form-group"><label>لقب / تخلص</label><input type="text" name="pen_name" id="edit_a_pen_name"></div>
                    <div class="form-group"><label>نقش *</label><input type="text" name="role" id="edit_a_role" required></div>
                    <div class="form-group"><label>تعداد کتاب *</label><input type="number" name="works" id="edit_a_works" required></div>
                    <div class="form-group"><label>تاریخ تولد</label><input type="text" name="born_date" id="edit_a_born_date"></div>
                    <div class="form-group"><label>شهر تولد</label><input type="text" name="born_city" id="edit_a_born_city"></div>
                    <div class="form-group"><label>کشور تولد</label><input type="text" name="born_country" id="edit_a_born_country"></div>
                    <div class="form-group"><label>تاریخ فوت</label><input type="text" name="died_date" id="edit_a_died_date"></div>
                    <div class="form-group"><label>شهر فوت</label><input type="text" name="died_city" id="edit_a_died_city"></div>
                    <div class="form-group"><label>کشور فوت</label><input type="text" name="died_country" id="edit_a_died_country"></div>
                    <div class="form-group"><label>محل دفن</label><input type="text" name="burial_place" id="edit_a_burial_place"></div>
                    <div class="form-group"><label>ملیت</label><input type="text" name="nationality" id="edit_a_nationality"></div>
                    <div class="form-group"><label>دوره</label><input type="text" name="era" id="edit_a_era"></div>
                    <div class="form-group"><label>پیشه</label><input type="text" name="occupation" id="edit_a_occupation"></div>
                    <div class="form-group"><label>ژانر اصلی</label><input type="text" name="genre" id="edit_a_genre"></div>
                    <div class="form-group"><label>تحصیلات</label><input type="text" name="education" id="edit_a_education"></div>
                    <div class="form-group"><label>همسر</label><input type="text" name="spouse" id="edit_a_spouse"></div>
                    <div class="form-group full"><label>بیوگرافی کوتاه</label><textarea name="short_bio" id="edit_a_short_bio"></textarea></div>
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

    function editAuthor(author) {
        document.getElementById('editAuthorForm').action = '/admin/authors/' + author.id;
        const fields = ['name','full_name','pen_name','role','works','born_date','born_city','born_country','died_date','died_city','died_country','burial_place','nationality','era','occupation','genre','education','spouse','short_bio'];
        fields.forEach(f => {
            const el = document.getElementById('edit_a_' + f);
            if (el) el.value = author[f] ?? '';
        });
        openModal('editAuthorModal');
    }
</script>
@endpush