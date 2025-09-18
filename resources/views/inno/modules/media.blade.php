<x-innolayout::master>
<div class="rounded shadow-md px-4 py-3 bg-white">
    <div class="d-flex align-items-center mb-4">
        <h2 class="fs-3 me-3 mb-0">{{ __('Media') }}</h2>
        <ul class="nav nav-pills" id="media_tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active"
                    id="browse-tab" data-bs-toggle="tab"
                    data-bs-target="#browse-tab-pane" type="button"
                    role="tab" aria-controls="browse-tab-pane"
                    aria-selected="true">{{ __('Browse') }}</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="upload-tab" data-bs-toggle="tab"
                        data-bs-target="#upload-tab-pane" type="button"
                        role="tab" aria-controls="upload-tab-pane"
                        aria-selected="false">{{ __('Upload') }}</button>
            </li>
        </ul>
    </div>
    
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="browse-tab-pane" role="tabpanel" aria-labelledby="browse-tab" tabindex="0">
            <div class="row row-cols-6">
                @foreach ($items as $item)
                <div>
                    <div class="border position-relative h-100 rounded media-item">
                        @if($item->type=='photo')
                        <img class="rounded w-100 h-100 object-fit-cover" src="{{ asset($item->url) }}" alt="">
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
                            
                            <a href="{{ asset($item->url) }}" target="_blank" class="mb-auto btn btn-sm text-white border">{{ __('Open') }}</a>
                            <span class="badge bg-primary">{{ $item->type }}</span>
                            <span class="px-0 badge">Filename: {{ $item->name }}</span>
                            <span class="px-0 badge">Uploaded: {{ $item->created_at }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
                
            </div>
        </div>
        <div class="tab-pane fade" id="upload-tab-pane" role="tabpanel" aria-labelledby="upload-tab" tabindex="0">
            <form action="{{ route('media.store') }}" id="file-uploader" class="dropzone" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="p-4 border inno-uploader">
                    
                    <input type="file" id="file_input" name="file" />
                    <label for="file_input" class="mb-4 d-flex align-items-center">
                        <i class="bi bi-cloud-arrow-up fs-2 me-3"></i>
                        <span class="fs-5">{{ __('Choose or drop files') }}</span>
                    </label>
                    <div id="uploaded-file"></div>
                    <br>
                    <p>{{ __('Compressed width:') }}</p>
                    <input type="text" class="form-control w-auto mb-2" name="compress" placeholder="example: 400px">
                    
                    <button class="btn px-5 btn-dark" type="submit">{{ __('Upload') }}</button>
                </div>
            </form>

        </div>
    </div>
    
</div>
</x-innolayout::master>
