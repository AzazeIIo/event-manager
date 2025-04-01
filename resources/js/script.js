import * as bootstrap from 'bootstrap';

let eventToBeDeleted = null;
let imageToBeDeleted = null;
const newEventToast = document.getElementById('newEventToast');
const editEventToast = document.getElementById('editEventToast');
const deleteEventToast = document.getElementById('deleteEventToast');
const deleteImageToast = document.getElementById('deleteImageToast');

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
    eventCard.siblings('.editEventForm').css('display', 'block');
});

$(document).on('click', '.editVisibilityBtn', function(e) {
    let eventCard = $('#'+e.target.id.substring(6));
    eventCard.css('display', 'none');
    eventCard.siblings('.editVisibilityForm').css('display', 'block');
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

$(document).on('click', '.inviteBtn', function(e) {
    e.preventDefault();
    let ids = e.target.id.split('-');
    sendInvitation(ids[0], ids[1]);
});

$(document).on('click', '.userPagination nav .pagination li a', function(e) {
    e.preventDefault();

    $('li').removeClass('active');
    $(this).parent('li').addClass('active');

    let url;
    if(window.location.search) {
        let searchParams = new URLSearchParams(window.location.search);
        if(searchParams.has('userPage')) {
            searchParams.set('userPage', $(e.target).text());
        } else {
            searchParams.append('userPage', $(e.target).text());
        }
        url = window.location.pathname + "?" + searchParams.toString();
    } else {
        url = window.location.pathname + '?userPage=' + $(e.target).text();
    }
    
    $.ajax({
        url : url,
        type: 'GET',
        dataType: 'html',
        cache:false,
        success:function(result) {
            $('.userResult').html(result);
            history.pushState(null, "", url);
        }
    });
});

$(document).on('click', '#eventPagination nav .pagination li a', function(e) {
    e.preventDefault();

    $('li').removeClass('active');
    $(this).parent('li').addClass('active');

    let url;
    if(window.location.search) {
        let searchParams = new URLSearchParams(window.location.search);
        if(searchParams.has('userPage')) {
            searchParams.delete('userPage');
        }
        if(searchParams.has('page')) {
            searchParams.set('page', $(e.target).text());
        } else {
            searchParams.append('page', $(e.target).text());
        }
        url = window.location.pathname + "?" + searchParams.toString();
    } else {
        url = window.location.pathname + '?page=' + $(e.target).text();
    }
    
    $.ajax({
        url : url,
        type: 'GET',
        dataType: 'html',
        cache:false,
        success:function(result) {
            $('#results').html(result);
            history.pushState(null, "", url);
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
    let checkboxValue = [];
    $('.search-checkbox:checked').each(function(i, obj) {
        checkboxValue.push($(obj).val());
    });

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    });
    $.ajax({
        type: 'GET',
        url: window.location.pathname,
        data: {
            'name': name,
            'date_start': date_start,
            'date_end': date_end,
            'city': city,
            'type': JSON.stringify(checkboxValue),
            'description': description,
        },
        success:function(result) {
            $('#results').html(result);
            history.pushState(null, "", window.location.pathname + `?name=${name}&date_start=${date_start}&date_end=${date_end}&city=${city}&description=${description}`);
            $(window).scrollTop(0);
        },
    });
    
});

function sendInvitation(userId, eventId) {
    console.log($("#inviteRoute" + userId + '-' + eventId).val());
    
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    });
    $.ajax({
        type: 'POST',
        url: $("#inviteRoute" + userId + '-' + eventId).val(),
        data: {
            'user_id': userId,
        },
        success:function(form) {
            console.log(form);
            
        },
    });
}

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
            
            $('#invalid-'+Object.keys(err.responseJSON.errors)[0]).prev()[0].focus();
            
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

            $('.invalid-feedback').each(function(i, obj) {
                $(obj).css('display', 'none');
            });
            new bootstrap.Collapse($('#collapse-form'));
            $(window).scrollTop(0);

            if($('#emptyPage')) {
                $('#emptyPage').remove();
            }

            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(newEventToast);
            toastBootstrap.show();
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
        success:function(msg) {
            $('#'+id).parent().remove();

            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(deleteEventToast);
            toastBootstrap.show();
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

            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(deleteImageToast);
            toastBootstrap.show();
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

            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(editEventToast);
            toastBootstrap.show();
        },
        error:function(err) {
            $('.invalid-feedback').each(function(i, obj) {
                $(obj).css('display', 'none');
            });
            for (let key in err.responseJSON.errors) {
                $('#invalid-'+key+id).css('display', 'block');
                $('#invalid-'+key+id).html(err.responseJSON.errors[key]);
            }
            
            $('#invalid-' + Object.keys(err.responseJSON.errors)[0] + id).prev()[0].focus();
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
        },
        success:function(form) {
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
        success:function(form) {
            $('#attendeeAmount'+id).html((Number)($('#attendeeAmount'+id).html())-1);
            $('#leave-form'+id).replaceWith(form);
        },
    });
}

window.addEventListener("popstate", function(e) {
    location.reload();
});
