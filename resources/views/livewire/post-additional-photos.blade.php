<div>
    @if (count($additionalPhotos))
        @foreach ($additionalPhotos as $item)
            <img width="200px" src={{ url('storage/additional_photos/'. $item->filename)}} /> <br/><br/>
        @endforeach
    @else
        <p> No additional photos for this post </p>
    @endif
</div>
