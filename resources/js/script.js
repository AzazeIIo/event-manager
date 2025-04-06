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
    let url = '/events/'+ e.target.id.substring(4) + '/edit';

    $.ajax({
        url : url,
        type: 'GET',
        dataType: 'html',
        cache: false,
        success:function(result) {
            $(eventCard).replaceWith(result);
        }
    });
});

$(document).on('click', '.editVisibilityBtn', function(e) {
    let eventId = e.target.id.substring(6);
    let eventCard = $('#'+eventId);
    
    let url = '/events/'+ eventId + '/invitations/create';

    $.ajax({
        url : url,
        type: 'GET',
        dataType: 'html',
        cache: false,
        success:function(result) {
            $(eventCard).replaceWith(result);
            history.pushState(null, '', window.location.pathname + '?userPage=1');
        }
    });
});

$(document).on('click', '.showAttendeesBtn', function(e) {
    let eventId = e.target.id.substring(6);
    let eventCard = $('#'+eventId);
    
    let url = '/events/'+ eventId + '/invitations/';

    $.ajax({
        url : url,
        type: 'GET',
        dataType: 'html',
        data: {
            'attendees': 1
        },
        cache: false,
        success:function(result) {
            $(eventCard).replaceWith(result);
            history.pushState(null, '', window.location.pathname + '?userPage=1');
        }
    });
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
    let eventId = e.target.id.substring(5);
    reset(eventId);
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
    sendInvitation(ids[0], ids[1], e.target);
});

$(document).on('click', '.uninviteBtn', function(e) {
    e.preventDefault();
    let ids = e.target.id.split('-');
    uninvite(ids[1], ids[2], e.target, 0);
});

$(document).on('click', '.uninviteAttendeeBtn', function(e) {
    e.preventDefault();
    let ids = e.target.id.split('-');
    uninvite(ids[1], ids[2], e.target, 1);
});

$(document).on('click', '.userPagination nav .pagination li a', function(e) {
    e.preventDefault();

    $('.userPagination nav .pagination li').removeClass('active');
    $(this).parent('li').addClass('active');

    let url;

    let searchParams = new URL(e.target.href).searchParams;
    let page = searchParams.get('userPage');
    console.log(page);
    console.log(searchParams);
    console.log(e.target.href.search);
    
    
    

    if($($(e.target).parents('.userPagination')).hasClass('sendingPagination')) {
        url = '/events/'+ $(e.target).parents('.sendingPagination')[0].id.substring('10') + '/invitations/create?userPage=' + page;
    } else if($($(e.target).parents('.userPagination')).hasClass('pendingPagination')) {
        url = '/events/'+ $(e.target).parents('.pendingPagination')[0].id.substring('10') + '/invitations?attendees=0&userPage=' + page;
    } else {
        url = '/events/'+ $(e.target).parents('.attendeesPagination')[0].id.substring('10') + '/invitations?attendees=1&userPage=' + page;
    }
    
    $.ajax({
        url : url,
        type: 'GET',
        dataType: 'html',
        cache:false,
        success:function(result) {
            $('#' + $(e.target).parents('.userPagination')[0].id.substring('10')).siblings('.editVisibilityForm').replaceWith(result);
            $('#' + $(e.target).parents('.userPagination')[0].id.substring('10')).siblings('.editVisibilityForm').css('display', 'block');
            if(window.location.search) {
                let searchParams = new URLSearchParams(window.location.search);
                if(searchParams.has('userPage')) {
                    searchParams.set('userPage', page);
                } else {
                    searchParams.append('userPage', page);
                }
                url = window.location.pathname + "?" + searchParams.toString();
            } else {
                url = window.location.pathname + '?userPage=' + page;
            }
            history.pushState(null, "", url);
            $($(e.target).parents('.editVisibilityForm')).replaceWith(result);
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
        if(searchParams.has('eventPage')) {
            searchParams.set('eventPage', $(e.target).text());
        } else {
            searchParams.append('eventPage', $(e.target).text());
        }
        url = window.location.pathname + "?" + searchParams.toString();
    } else {
        url = window.location.pathname + '?eventPage=' + $(e.target).text();
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
            $('#clearFilters').css('display', 'block');
        },
    });
    
});

$(document).on('click', '.invitations-nav', function(e) {
    let eventId = e.target.id.split('-')[1];
    $('.nav-'+eventId).removeAttr('aria-current');
    $('.nav-'+eventId).removeClass('active');
    $('#'+e.target.id).attr('aria-current', 'page');
    $('#'+e.target.id).addClass('active');

    let url;
    if($(e.target).hasClass('nav-send')) {
        url = '/events/'+ eventId + '/invitations/create?userPage=1';
    } else if ($(e.target).hasClass('nav-pending')) {
        url = '/events/'+ eventId + '/invitations?attendees=0&userPage=1';
    } else {
        url = '/events/'+ eventId + '/invitations?attendees=1&userPage=1';
    }

    $.ajax({
        url : url,
        type: 'GET',
        dataType: 'html',
        cache: false,
        success:function(result) {
            $($(e.target).parents('.editVisibilityForm')).replaceWith(result);
            history.pushState(null, '', '/myevents?userPage=1');
        }
    });
});

$(document).on('click', '.closeInvitationsBtn ', function(e) {
    let eventId = e.target.id.split('-')[1];
    reset(eventId);
});

function reset(eventId) {
    let eventCard = $('#' + eventId).parent();
    let url = '/events/'+ eventId;

    $.ajax({
        url : url,
        type: 'GET',
        dataType: 'html',
        data: {
            'card': 1
        },
        cache: false,
        success:function(result) {
            $(eventCard).replaceWith(result);
        }
    });
}

function uninvite(userId, eventId, target, isAttendee) {
    let userPage = 1;

    if(window.location.search) {
        let searchParams = new URLSearchParams(window.location.search);
        if(searchParams.has('userPage')) {
            userPage = searchParams.get('userPage');
        }
    }

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    });
    $.ajax({
        type: 'DELETE',
        url: $("#uninviteRoute" + userId + '-' + eventId).val(),
        data: {
            'is_attendee': isAttendee,
            'userPage': userPage
        },
        success:function(result) {
            $($(target).parents('.editVisibilityForm')).replaceWith(result);
        },
    });
}

function sendInvitation(userId, eventId, target) {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    });
    $.ajax({
        type: 'POST',
        url: $("#inviteRoute" + userId + '-' + eventId).val(),
        data: {
            'user_id': userId,
        },
        success:function() {
            $(target).replaceWith('<p class="fst-italic">Invitation sent</p>');
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
            $('#results').html(result);

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
