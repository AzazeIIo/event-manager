let eventToBeDeleted = null;

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

$(document).on('click', '.editEventBtn', function(e) {
    let eventCard = $('#'+e.target.id.substring(4));
    eventCard.css('display', 'none');
    eventCard.siblings().css('display', 'block');
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

    $.ajax({
        url : $(this).attr('href'),
        type: 'GET',
        dataType: 'html',
        success:function(result) {
            $('#results').html(result);
            $(window).scrollTop(0);
        }
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

            $('#newEventForm').css('display', 'none');
            $('#newEventBtn').css('display', 'block');
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

function editEvent(id) {
    let checkboxValue = [];
    $('.edit-event-checkbox' + id + ':checked').each(function(i, obj) {
        checkboxValue.push($(obj).val());
    });

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    });
    $.ajax({
        type: 'PATCH',
        url: $("#editroute" + id).val(),
        data: {
            'name': $('#name'+id).val(),
            'date_start': $('#date_start'+id).val(),
            'date_end': $('#date_end'+id).val(),
            'city': $('#city'+id).val(),
            'location': $('#location'+id).val(),
            'type': checkboxValue,
            'description': $('#description'+id).val(),
            'is_public': $("input[name=is_public" + id + "]:checked").val(),
            'owner_id': $("#owner_id").val(),
        },
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
