import * as bootstrap from 'bootstrap';

let eventToBeDeleted = null;
let imageToBeDeleted = null;

$('#createEventBtn').on('click', function(e) {
    e.preventDefault();
    createEvent();
});

$(document).on('click', '.deleteEventBtn', function(e) {
    e.preventDefault();
    eventToBeDeleted = e.target.id.substring(3);
});

$('#confirmDeletion').on('click', function(e) {
    removeEvent(eventToBeDeleted);
});

$('#confirmImgDeletion').on('click', function(e) {
    removeImage(imageToBeDeleted);
});

$(document).on('click', '.editEventBtn', function(e) {
    let eventCard = $('#'+e.target.id.substring(4));
    eventCard.css('display', 'none');
    eventCard.siblings().css('display', 'block');
});

$(document).on('click', '.deleteImgBtn', function(e) {
    e.preventDefault();
    imageToBeDeleted = e.target.id.substring(9);
});

$(document).on('click', '.confirmEditEventBtn', function(e) {
    e.preventDefault();
    editEvent(e.target.id.substring(7));    
});

$(document).on('click', '.resetEditEventBtn', function(e) {
    let eventCard = $('#'+e.target.id.substring(5));
    eventCard.css('display', 'block');
    eventCard.siblings('.editEventForm').css('display', 'none');
});

$(document).on('click', '.joinEventBtn', function(e) {
    e.preventDefault();
    joinEvent(e.target.id.substring('4'));
});

$(document).on('click', '.leaveEventBtn', function(e) {
    e.preventDefault();
    leaveEvent(e.target.id.substring('5'));
});

$(document).on('click', '.pagination li a', function(e) {
    e.preventDefault();

    $('li').removeClass('active');
    $(this).parent('li').addClass('active');

    let url;
    if(window.location.search) {
        url = window.location.href + '&page=' + $(this).text();
    } else {
        url = window.location.href + '?page=' + $(this).text();
    }
    
    $.ajax({
        url : url,
        type: 'GET',
        dataType: 'html',
        success:function(result) {
            $('#results').html(result);
            $(window).scrollTop(0);
        }
    });
});

$('#searchBtn').on('click', function (e) {
    e.preventDefault();

    let name = $('#name-search').val();
    let date_start = $('#date_start-search').val();
    let date_end = $('#date_end-search').val();
    let city = $('#city-search').val();
    let description = $('#description-search').val();
    let owner_id = $('#owner_id').val();
    let checkboxValue = [];
    $('.search-checkbox:checked').each(function(i, obj) {
        checkboxValue.push($(obj).val());
    });

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    });
    $.ajax({
        type: 'GET',
        url: window.location.href,
        data: {
            'name': name,
            'date_start': date_start,
            'date_end': date_end,
            'city': city,
            'type': JSON.stringify(checkboxValue),
            'description': description,
            'owner_id': owner_id,
        },
        success:function(result) {
            $('#results').html(result);
            history.pushState(null, "", window.location.pathname + `?name=${name}&date_start=${date_start}&date_end=${date_end}&city=${city}&description=${description}&owner_id=${owner_id}`);
            $(window).scrollTop(0);
        },
    });
    
});

function createEvent() {
    let checkboxValue = [];
    $('.new-event-checkbox:checked').each(function(i, obj) {
        checkboxValue.push($(obj).val());
    });
    let imageData = $('#image')[0].files[0];

    let formData = new FormData();
    formData.append('name', $('#name').val());
    formData.append('date_start', $('#date_start').val());
    formData.append('date_end', $('#date_end').val());
    formData.append('city', $('#city').val());
    formData.append('location', $('#location').val());
    formData.append('type', JSON.stringify(checkboxValue));
    formData.append('description', $('#description').val());
    if(imageData != undefined) {
        formData.append('image', imageData);
    }
    formData.append('is_public', $("input[name=is_public]:checked").val());
    formData.append('owner_id', $('#owner_id').val());

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    });
    $.ajax({
        method: 'POST',
        data: formData,
        contentType : false,
        processData : false,
        url: '/events',
        error:function(err) {
            $('.invalid-feedback').each(function(i, obj) {
                $(obj).css('display', 'none');
            });
            for (let key in err.responseJSON.errors) {
                $('#invalid-'+key).css('display', 'block');
                $('#invalid-'+key).html(err.responseJSON.errors[key]);
            }
        },
        success:function(result) {
            $('#results').prepend(result);

            $('#name').val('');
            $('#date_start').val('');
            $('#date_end').val('');
            $('#city').val('');
            $('#location').val('');
            $('.new-event-checkbox:checked').each(function(i, obj) {
                $(obj).prop('checked', false)
            });
            $('#description').val('');
            $('#image').val('');
            $('#public').prop('checked', true);

            new bootstrap.Collapse($('#collapse-form'));
            $(window).scrollTop(0);
        }  
    });
}

function removeEvent(id) {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    });
    $.ajax({
        type: 'DELETE',
        url: $("#delroute" + id).val(),
        data: {
            'event_id': id
        },
        success:function(msg) {
            $('#'+id).parent().remove();
        }  
    });
}

function removeImage(id) {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    });
    $.ajax({
        type: 'PATCH',
        url: $("#editroute" + id).val(),
        data: {
            'owner_id': $('#owner_id').val()
        },
        success:function() {
            $('#img'+id).html(`
                <div id="imgform${id}" class="row mb-3">
                    <label for="image" class="col-sm-4 col-form-label text-sm-end"><strong>Image</strong></label>

                    <div class="col-sm-6">
                        <input class="form-control" type="file" id="image${id}" name="image">

                        <span id="invalid-image${id}" class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                </div>
            `);
        }
    });
}

function editEvent(id) {
    let checkboxValue = [];
    let imageData;

    $('.edit-event-checkbox' + id + ':checked').each(function(i, obj) {
        checkboxValue.push($(obj).val());
    });
    
    if($('#image'+id)[0]) {
        imageData = $('#image'+id)[0].files[0];
    }

    let formData = new FormData();
    formData.append('_method', "PUT");
    formData.append('name', $('#name'+id).val());
    formData.append('date_start', $('#date_start'+id).val());
    formData.append('date_end', $('#date_end'+id).val());
    formData.append('city', $('#city'+id).val());
    formData.append('location', $('#location'+id).val());
    formData.append('type', JSON.stringify(checkboxValue));
    formData.append('description', $('#description'+id).val());
    if(imageData != undefined) {
        formData.append('image', imageData);
    }
    formData.append('is_public', $("input[name=is_public" + id + "]:checked").val());
    formData.append('owner_id', $('#owner_id').val());

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    });
    $.ajax({
        type: 'POST',
        url: $("#editroute" + id).val(),
        data: formData,
        contentType : false,
        processData : false,
        success:function(card) {
            $('#'+id).parent().replaceWith(card);
        },
        error:function(err) {
            $('.invalid-feedback').each(function(i, obj) {
                $(obj).css('display', 'none');
            });
            for (let key in err.responseJSON.errors) {
                $('#invalid-'+key+id).css('display', 'block');
                $('#invalid-'+key+id).html(err.responseJSON.errors[key]);
            }
        },
    });
}

function joinEvent(id) {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    });
    $.ajax({
        type: 'POST',
        url: $("#joinroute" + id).val(),
        data: {
            'user_id': $('#user_id'+id).val(),
            'event_id': $('#event_id'+id).val(),
        },
        success:function(form) {
            //$('#attendeeAmount'+id).html(msg + ' going');
            //$('#'+id).parent().replaceWith(msg);
            //$('#attendeeAmount'+id).html(event['all_attendees'].length + ' going');
            $('#attendeeAmount'+id).html((Number)($('#attendeeAmount'+id).html())+1);
            $('#join-form'+id).replaceWith(form);
        },
    });
}

function leaveEvent(id) {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    });
    $.ajax({
        type: 'DELETE',
        url: $("#leaveroute" + id).val(),
        data: {
            'user_id': $('#user_id'+id).val(),
            'event_id': $('#event_id'+id).val(),
            'attendee_id': $('#attendee_id'+id).val(),
        },
        success:function(form) {
            //$('#'+id).parent().replaceWith(msg);
            $('#attendeeAmount'+id).html((Number)($('#attendeeAmount'+id).html())-1);
            $('#leave-form'+id).replaceWith(form);
        },
    });
}
