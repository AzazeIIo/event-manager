$('#newEventBtn').on('click', function(e) {
    e.preventDefault();
    addEvent();
});

$(".deleteEventBtn").each(function(index, obj) {
    obj.onclick = function(e) {
        e.preventDefault();
        removeEvent(obj);
    }
});

function addEvent() {
    let checkboxValue = [];
    $('.type-checkbox:checked').each(function(i, e) {
        checkboxValue.push($(e).val());
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
            console.log(err);
        },
        success:function(result) {
            console.log(result);
        }  
    });
}

function removeEvent(obj) {
    console.log($("#delroute" + obj.id.substring(3)).val());
    
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    });
    $.ajax({
        type: 'DELETE',
        url: $("#delroute" + obj.id.substring(3)).val(),
        data: {
            'event_id': obj.id.substring(3)
        },
        error:function(err) {
            console.log(err);
            
        },
        success:function(msg) {
            console.log(msg);
            
        }  
    });
}
