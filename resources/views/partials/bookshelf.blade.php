@php
$shelfBooks = $books;
$spineColors = [
  'linear-gradient(180deg,#8B4513,#5D2E0C)','linear-gradient(180deg,#2F4F4F,#1a2e2e)','linear-gradient(180deg,#800020,#4d0013)',
  'linear-gradient(180deg,#191970,#0f0f4a)','linear-gradient(180deg,#556B2F,#2F4F4F)','linear-gradient(180deg,#4A0E4E,#2E082F)',
  'linear-gradient(180deg,#A0522D,#6b3519)','linear-gradient(180deg,#2E4053,#1a252f)','linear-gradient(180deg,#7B241C,#4d160f)',
  'linear-gradient(180deg,#1E8449,#0e4d2a)','linear-gradient(180deg,#B7950B,#7d6507)','linear-gradient(180deg,#6C3483,#3d1d4a)',
];
$heights = [220, 200, 235, 210, 245, 195, 225, 215, 240, 205, 230, 220];
@endphp

<section class="bookshelf-section">
    <div class="container">
        <div class="section-head">
            <div>
                <h2 class="section-title"><span class="dot"></span> 📖 از قفسه‌ی ما</h2>
                <p class="section-sub">روی هر کتاب برو و ببین چه اسمی پشت جلدش پنهونه</p>
            </div>
        </div>

        <div class="shelf-wrap">
            <div class="shelf-books">
                @foreach($shelfBooks as $i => $b)
                    @php
                        $h = $heights[$i % count($heights)];
                        $color = $spineColors[$i % count($spineColors)];
                        $hasCover = !empty($b->cover);
                        $spine = $hasCover ? "linear-gradient(rgba(0,0,0,.3),rgba(0,0,0,.5)), url('".asset($b->cover)."') center/cover" : $color;
                        $authorName = $b->author ? $b->author->name : 'ناشناس';
                    @endphp
                    <a href="{{ route('books.show', $b->id) }}" class="shelf-book" style="--h:{{ $h }}px; --spine:{{ $spine }};">
                        <span class="book-spine-title">{{ $b->title }}</span>
                        <div class="book-tooltip">
                            <div class="tip-title">{{ $b->title }}</div>
                            <div class="tip-author">{{ $authorName }}</div>
                            <div class="tip-genre">{{ $b->genre }}</div>
                            <div class="tip-price">{{ number_format($b->price) }} تومان</div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="shelf-wood"></div>
        </div>
    </div>
</section>