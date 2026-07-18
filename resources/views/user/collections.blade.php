@extends('user.index')

@push('page-styles')

<style>

/* ==========================
   COLLECTION PAGE
========================== */

.collections-section{
    padding:60px 0;
    background:#f8f9fb;
}

.collection-wrapper{
    width:95%;
    max-width:1400px;
    margin:auto;
}

.section-header{
    text-align:center;
    margin-bottom:50px;
}

.section-title{
    font-size:40px;
    font-weight:700;
    color:#222;
    position:relative;
    display:inline-block;
}

.section-title::after{
    content:'';
    width:70px;
    height:4px;
    background:#e91e63;
    display:block;
    margin:15px auto 0;
    border-radius:10px;
}

.collection-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:30px;
}

.collection-card{
    background:#fff;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 8px 25px rgba(0,0,0,.08);
    transition:.4s;
    position:relative;
}

.collection-card:hover{
    transform:translateY(-10px);
    box-shadow:0 20px 35px rgba(0,0,0,.15);
}

.collection-card a{
    text-decoration:none;
    color:inherit;
    display:block;
}

.collection-card img{
    width:100%;
    height:330px;
    object-fit:contain;
    transition:.5s;
    background:#f8f9fa;
    padding:10px;
}

.collection-card:hover img{
    transform:scale(1.08);
}

.collection-overlay{
    padding:22px;
    text-align:center;
}

.collection-overlay h3{
    font-size:24px;
    font-weight:700;
    color:#222;
    margin-bottom:12px;
}

.collection-overlay p{
    font-size:15px;
    color:#666;
    line-height:1.7;
    height:48px;
    overflow:hidden;
}

.collection-card::before{
    content:"";
    position:absolute;
    top:0;
    left:-100%;
    width:100%;
    height:100%;
    background:linear-gradient(120deg,
    transparent,
    rgba(255,255,255,.35),
    transparent);
    transition:.7s;
}

.collection-card:hover::before{
    left:100%;
}

.no-items{
    grid-column:1/-1;
    text-align:center;
    padding:80px;
    font-size:24px;
    color:#777;
    background:#fff;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,.05);
}

/* Tablet */

@media(max-width:992px){

.collection-grid{
    grid-template-columns:repeat(2,1fr);
}

.section-title{
    font-size:34px;
}

.collection-card img{
    height:280px;
}

}

/* Mobile */

@media(max-width:768px){

.collections-section{
    padding:40px 15px;
}

.collection-grid{
    grid-template-columns:1fr;
    gap:25px;
}

.section-title{
    font-size:28px;
}

.collection-card img{
    height:260px;
}

.collection-overlay h3{
    font-size:22px;
}

.collection-overlay p{
    font-size:14px;
}

}

</style>

@endpush

@section('content')

<section class="collections-section">

    <div class="collection-wrapper">
        <div class="section-header">
            <h2 class="section-title">All Collections</h2>
        </div>

        <div class="collection-grid">

            @forelse($collections as $collection)

        <div class="collection-card">

            <a href="{{ route('collection.products',$collection->id) }}">

                @php
                    $collectionImage = $collection->image;
                    $collectionSlug = $collection->slug ?? Str::slug($collection->name);
                    $imgSrc = null;

                    if ($collectionImage && file_exists(public_path('uploads/collections/' . $collectionImage))) {
                        $imgSrc = asset('uploads/collections/' . $collectionImage);
                    } else {
                        foreach (['jpg', 'jpeg', 'png', 'webp', 'gif'] as $ext) {
                            $possiblePath = public_path("uploads/collections/{$collectionSlug}.{$ext}");
                            if (file_exists($possiblePath)) {
                                $imgSrc = asset("uploads/collections/{$collectionSlug}.{$ext}");
                                break;
                            }
                        }
                    }

                    if (! $imgSrc) {
                        $imgSrc = 'https://via.placeholder.com/300x300?text=Collection';
                    }
                @endphp
                <img src="{{ $imgSrc }}" alt="{{ $collection->name }}">

                <div class="collection-overlay">

                    <h3>{{ $collection->name }}</h3>

                    <p>{{ $collection->description }}</p>

                </div>

            </a>

        </div>

        @empty

            <div class="no-items">No Collections Found</div>

        @endforelse

        </div>
    </div>

</section>

@endsection