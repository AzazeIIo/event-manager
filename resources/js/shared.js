$(document).on('click', '.joinEventBtn', function(e) {
    e.preventDefault();
    joinEvent(e.target.id.substring('4'));
});

$(document).on('click', '.leaveEventBtn', function(e) {
    e.preventDefault();
    leaveEvent(e.target.id.substring('5'));
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

window.addEventListener("popstate", function(e) {
    location.reload();
});

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
