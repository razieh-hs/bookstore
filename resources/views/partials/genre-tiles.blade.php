@php
$genres = [
  ['name'=>'رمان','emoji'=>'📖','grad'=>'linear-gradient(135deg,#b91c1c,#d97706)','count'=>21],
  ['name'=>'شعر','emoji'=>'🪶','grad'=>'linear-gradient(135deg,#6d28d9,#be185d)','count'=>6],
  ['name'=>'داستان کوتاه','emoji'=>'✍️','grad'=>'linear-gradient(135deg,#0d9488,#0284c7)','count'=>10],
  ['name'=>'روانشناسی','emoji'=>'🧠','grad'=>'linear-gradient(135deg,#0284c7,#6d28d9)','count'=>5],
  ['name'=>'توسعه فردی','emoji'=>'🚀','grad'=>'linear-gradient(135deg,#d97706,#b91c1c)','count'=>6],
  ['name'=>'تاریخ','emoji'=>'🏛️','grad'=>'linear-gradient(135deg,#78350f,#b45309)','count'=>5],
  ['name'=>'فلسفه','emoji'=>'💭','grad'=>'linear-gradient(135deg,#1c1917,#57534e)','count'=>5],
  ['name'=>'علمی-تخیلی','emoji'=>'🛸','grad'=>'linear-gradient(135deg,#0284c7,#1e3a8a)','count'=>5],
  ['name'=>'کودک و نوجوان','emoji'=>'🧸','grad'=>'linear-gradient(135deg,#d97706,#be185d)','count'=>8],
  ['name'=>'هنر','emoji'=>'🎨','grad'=>'linear-gradient(135deg,#be185d,#6d28d9)','count'=>5],
  ['name'=>'سفر','emoji'=>'🧭','grad'=>'linear-gradient(135deg,#0d9488,#d97706)','count'=>5],
  ['name'=>'آشپزی','emoji'=>'🍳','grad'=>'linear-gradient(135deg,#c2410c,#d97706)','count'=>5],
];
@endphp

@foreach($genres as $g)
    <a href="{{ route('books.index') }}?genre={{ $g['name'] }}" class="genre-tile" style="background:{{ $g['grad'] }}">
        <div class="emoji">{{ $g['emoji'] }}</div>
        <div>
            <div class="name">{{ $g['name'] }}</div>
            <div class="count">{{ $g['count'] }} کتاب</div>
        </div>
    </a>
@endforeach