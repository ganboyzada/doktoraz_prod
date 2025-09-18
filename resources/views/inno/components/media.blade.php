<!-- Modal -->
<div class="modal media-modal fade" id="media_upload_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ __('Choose media') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex align-items-center mb-4">
                    <ul class="nav nav-pills" id="media_tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="browse-tab" data-bs-toggle="tab"
                                data-bs-target="#browse-tab-pane" type="button" role="tab"
                                aria-controls="browse-tab-pane" aria-selected="true">{{ __('Browse') }}</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="upload-tab" data-bs-toggle="tab"
                                data-bs-target="#upload-tab-pane" type="button" role="tab"
                                aria-controls="upload-tab-pane" aria-selected="false">{{ __('Upload') }}</button>
                        </li>
                    </ul>
                </div>

                
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="browse-tab-pane" role="tabpanel"
                            aria-labelledby="browse-tab" tabindex="0">
                            <form action="#" id="media-selector-form">
                            <div class="row row-cols-1 g-1" id="inno_media_list">
                                @include('inno.components.media_list')
                            </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="upload-tab-pane" role="tabpanel" aria-labelledby="upload-tab"
                            tabindex="0">
                            <form data-route="{{ route('media.store') }}" id="inno_media_form" class="dropzone"
                                enctype="multipart/form-data">
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
                                    <input type="text" class="form-control w-auto mb-2" name="compress"
                                        placeholder="example: 400px">

                                    <button class="btn px-5 btn-dark" type="submit">{{ __('Upload') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                <button type="button" data-bs-toggle="modal" data-bs-target="#" 
                    class="media-select-submit btn btn-primary">{{ __('Select') }}</button>
            </div>
        </div>
    </div>
</div>
