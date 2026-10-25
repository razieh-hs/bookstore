@foreach($authors as $a)
    @php
        $photoUrl = asset("images/authors/{$a->id}.jpg");
        $placeholder = asset('images/placeholder-author.svg');
    @endphp
    <a href="{{ route('authors.show', $a->id) }}" class="author-card">
        <div class="author-avatar">
            <img src="{{ $photoUrl }}" alt="{{ $a->name }}" loading="lazy" onerror="this.onerror=null;this.src='{{ $placeholder }}'">
        </div>
        <div class="author-name">{{ $a->name }}</div>
        <div class="author-role">{{ $a->role }}</div>
        <div class="author-mini-stats">
            <div><b>{{ $a->works }}</b> 📚 کتاب</div>
        </div>
    </a>
@endforeach