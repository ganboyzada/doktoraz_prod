@php
use Carbon\Carbon;

$groupedMedia = \App\Models\Media::select('id', 'created_at', 'name', 'type', 'extension', 'url')
    ->get()
    ->groupBy(function ($item) {
        $created_at = Carbon::parse($item->created_at);

        // Group as "Today"
        if ($created_at->isToday()) {
            return 'Today';
        }
        // Group as "Yesterday"
        elseif ($created_at->isYesterday()) {
            return 'Yesterday';
        }
        // Group as "Last Week"
        elseif ($created_at->greaterThanOrEqualTo(Carbon::now()->startOfWeek())) {
            return 'Last Week';
        }
        // Otherwise, group by year-month (e.g., "2024-07")
        else {
            return $created_at->format('Y-m');
        }
    })->reverse();
@endphp

@foreach ($groupedMedia as $time_period => $mediaItems)
<div class="timeline">
    <p>{{ $time_period }}</p>
    <div class="row row-cols-3 g-2">
    @foreach($mediaItems as $item)
    <div>
        <div class="border position-relative h-100 rounded media-item">
            <input type="radio" name="selected_media" value="{{ $item->id }}" class="d-none" required>
            @if($item->type=='photo')
            <img class="rounded w-100 h-100 object-fit-contain" src="{{ asset($item->url) }}" alt="">
            @else
            <div class="w-100 h-100 fs-1 text-warning py-4 d-flex justify-content-center align-items-center">
                @if($item->type=='doc')
                <i class="bi bi-file-earmark-pdf"></i>
                @else
                <i class="bi bi-file-earmark"></i>
                @endif
            </div>
            @endif
            <div class="media-info p-3 text-white fs-6 position-absolute 
                                        rounded top-0 start-0 w-100 
                                        h-100 bg-black opacity-0
                                        d-flex flex-column justify-content-end align-items-start">

                <a href="{{ asset($item->url) }}" target="_blank"
                    class="mb-auto btn btn-sm text-white border">{{ __('Open') }}</a>
                <span class="badge bg-primary">{{ $item->type }}</span>
                <span class="px-0 badge">Filename: {{ $item->name }}</span>
                <span class="px-0 badge">Uploaded: {{ $item->created_at }}</span>
            </div>
            <div class="selection-indicator p-3 text-white fs-2 position-absolute 
                                            rounded top-0 start-0 w-100 
                                            h-100 bg-primary opacity-0
                                            d-flex flex-column justify-content-center align-items-center">
                <i class="bi bi-check2-square"></i>
            </div>
        </div>
    </div>
    @endforeach
    </div>
</div>
@endforeach
