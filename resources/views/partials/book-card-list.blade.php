@php
$grads = [
  'رمان'=>'linear-gradient(160deg,#b91c1c,#d97706)','شعر'=>'linear-gradient(160deg,#6d28d9,#be185d)','داستان کوتاه'=>'linear-gradient(160deg,#0d9488,#0284c7)',
  'روانشناسی'=>'linear-gradient(160deg,#0284c7,#6d28d9)','توسعه فردی'=>'linear-gradient(160deg,#d97706,#b91c1c)','تاریخ'=>'linear-gradient(160deg,#78350f,#b45309)',
  'فلسفه'=>'linear-gradient(160deg,#1c1917,#57534e)','علمی-تخیلی'=>'linear-gradient(160deg,#0284c7,#1e3a8a)','کودک و نوجوان'=>'linear-gradient(160deg,#d97706,#be185d)',
  'هنر'=>'linear-gradient(160deg,#be185d,#6d28d9)','سفر'=>'linear-gradient(160deg,#0d9488,#d97706)','آشپزی'=>'linear-gradient(160deg,#c2410c,#d97706)',
];
@endphp

@foreach($books as $book)
    @php
        $disc = ($book->old ?? 0) > 0 ? round((1 - $book->price / $book->old) * 100) : 0;
        $hasCover = !empty($book->cover);
        $grad = $grads[$book->genre] ?? 'linear-gradient(160deg,#0d9488,#0284c7)';
        $coverUrl = $hasCover ? asset($book->cover) : null;
        $bg = $hasCover ? "url('{$coverUrl}') center/cover no-repeat, {$grad}" : $grad;
        $authorName = $book->author ? $book->author->name : 'ناشناس';
    @endphp
    <a href="{{ route('books.show', $book->id) }}" class="book-card">
        <div class="book-cover {{ $hasCover ? 'has-image' : '' }}" style="background:{{ $bg }};">
            <span class="cover-tag">{{ $book->genre }}</span>
            @if($disc)<span class="cover-discount">{{ $disc }}٪</span>@endif
            <div style="margin-top:auto;">
                <div class="ct">{{ $book->title }}</div>
                <div class="ca">{{ $authorName }}</div>
            </div>
        </div>
        <div class="book-info">
            <div class="book-title">{{ $book->title }}</div>
            <div class="book-author">{{ $authorName }}</div>
            <div class="book-meta">
                <div class="rating"><span class="star">★</span>{{ $book->rating }}</div>
                <div class="price">
                    @if($book->old)
                        <span class="price-old">{{ number_format($book->old) }}</span>
                    @endif
                    {{ number_format($book->price) }}<small>ت</small>
                </div>
            </div>
        </div>
    </a>
@endforeach