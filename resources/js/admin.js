import 'bootstrap';
// import { Dropdown } from 'bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

$(document).ready(function() {
  $('.editor').summernote();
});


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// LABEL TO INPUT CLICK BINDER
$('label').click(function() {
       let labelID = $(this).attr('for');
       $('#'+labelID).get(0).trigger('click');
});

// PREVIEW UPLOADED FILE
$(document).on('change', '#file_input', function(){
    let input = $(this)[0].files;

    $('#uploaded-file').append(`
        <div class="border rounded px-3 py-2"><i class="bi bi-file-earmark me-2"></i>${input[0].name}</div>
    `);
});

// OPEN MEDIA SELECTOR
$(document).on('click', 'button.media-selector', function(){
    let target_field = $(this).data('field');
    let multiple = $(this)[0].hasAttribute('data-multiple');

    $('.media-modal').attr('data-field', target_field);
    if(multiple){
        $('.media-modal').attr('data-multiple', multiple);
        $('.media-item input').attr('type', 'checkbox');
    } else{
        $('.media-item input').attr('type', 'radio');
    }

    $('.media-item').find('input').attr('checked', false);
    $('.media-select-submit').attr('data-bs-target', '#'+$(this).closest('.modal').attr('id'));
});

// CHECK MEDIA ITEM FOR SET
$(document).on('click', '.media-item', function(){
    let clicked_media = $(this).find('input');
    if(clicked_media.attr('type')=='radio'){
        $('.media-item').find('input').attr('checked', false);
        clicked_media.attr('checked', true);
    } else{
        if(clicked_media.attr('checked')){
            clicked_media.attr('checked', false);
        } else{
            clicked_media.attr('checked', true);
        }
    }
    
});

$(document).on('click', '.media-select-submit', function(){
    let modal = $(this).closest('.media-modal');
    let field = modal.attr('data-field');
    let multiple = modal.attr('data-multiple');
    
    let checked_media = $('#media-selector-form input[name=selected_media]:checked');

    let value = null;

    if(multiple){
        let values = [];
        checked_media.each(function(index) {
            values.push($(this).val());
        });
        value = JSON.stringify(values);
        console.log(value);
    } else{
        value = checked_media.val();
    }
    $(`form input[name=${field}]`).val(value);
});

// INNO MEDIA UPLOAD SUBMITTER

let media_form = document.querySelector('#inno_media_form');

$('#inno_media_form').submit(function(e) {
    e.preventDefault();

    // Send an AJAX request
    $.ajax({
        type: 'POST',
        url: '/admin/media',
        data: new FormData(this),
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            // Handle the response message
            $.notify(response.message, "success");
            $('#inno_media_list').html(response.html);
            $('button#browse-tab').click();
        },
        error: function(xhr, status, error) {
            // Handle errors if needed
            console.error(xhr.responseText);
        }
    });
});

// INNO OBJECT CREATION SUBMITTER

$('#inno_creator_form').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
        type: 'POST',
        data: new FormData(this),
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            $.notify(response.message, "success");
            $('#inno_list').html(response.html);
            $('button.modal_closer').trigger('click');
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });     
});

// INNO OBJECT CREATION SUBMITTER

$(document).on('submit', '#inno_editor_form', function(e) {
    e.preventDefault();

    let form = new FormData(this);
    form.append('_method', 'PATCH');

    console.log($(this).data('route'));

    $.ajax({
        url: $(this).data('route'),
        type: 'POST',
        data: form,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            $.notify(response.message, "success");
            $('#inno_list').html(response.html);
            $('button.modal_closer').trigger('click');
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
        
});

// INNO OBJECT DELETER

$(document).on('click', 'button[data-delete]', function(){
  if(confirm('Are you sure?')){
    $.ajax({
        type: 'POST',
        dataType: 'json',
        data: {
            id: $(this).data('delete'),
            _method: 'DELETE'
        },
        url: $('#inno_list').data('module')+'/'+$(this).data('delete'),
        success: function (response) {
            $.notify(response.message, "error");
            $('#inno_list').html(response.html);
        },
        error: function(xhr, status, error) {
              // Handle errors if needed
              console.error(xhr.responseText);
          }
    });
  }
});

// INNO MENU TOGGLER

$(document).on('click', 'button[data-toggle]', function(){
  let target = $(this).data('toggle');

  $(target).toggleClass('toggled');
});

// INNO EDITOR

// edit button click on item
$(document).on('click', 'button[data-edit]', function(){
    let object_id = $(this).data('edit');

    let editor_modal = $('#editor_modal').find('[data-reactive]');
    let route = $(this).closest('[data-module]').data('module');

    $.ajax({
        type: 'GET',
        url: `${route}/${object_id}/edit`,
        dataType: 'json',
        success: function(response) {
            $.notify(`${route}/${object_id}/edit`, "success");
            console.log(response.html);
            editor_modal.html(response.html);
            $('#editor_modal .editor').summernote();
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});

