/*$(".alert").fadeTo(2000, 2000).slideUp(500, function(){
    $(".alert").slideUp(500);
});*/

/*--Text Editor Start---*/
//editor Option
var toolbarOptions = [
    ['bold', 'italic', 'underline'],        // toggled buttons
    [{'list': 'ordered'}, {'list': 'bullet'}],
    [{'align': []}],
    [{'size': ['small', false, 'large', 'huge']}]  // custom dropdown
];

var quill1 = new Quill('#editor1', {
    modules: {
        toolbar: toolbarOptions
    },
    theme: 'snow',
});
var quill2 = new Quill('#editor2', {
    modules: {
        toolbar: toolbarOptions
    },
    theme: 'snow'
});
var quill3 = new Quill('#editor3', {
    modules: {
        toolbar: toolbarOptions,
    },
    theme: 'snow'
});
var quill4 = new Quill('#editor4', {
    modules: {
        toolbar: toolbarOptions
    },
    theme: 'snow',
});

var incidenceDescriptionEditor = new Quill('#incidence_description_editor', {
    modules: {
        toolbar: toolbarOptions
    },
    theme: 'snow'
});

var incidenceDescriptionBnEditor = new Quill('#incidence_description_bn_editor', {
    modules: {
        toolbar: toolbarOptions
    },
    theme: 'snow'
});

function buttonShowClearTextAreaAndEditor() {
    $(".ql-toolbar").append('<span class="ql-formats bx-pull-right"><button type="button" style="width:50px;" class="clearDescription">Clear</button></span>');
}

$(document).ready(function () {
    buttonShowClearTextAreaAndEditor();
    jQueryValidateFileSizeValidator();
});

function replacePtagToBrTag(editor) {
    $('p').each(function () {
        editor = editor.replace("<p>", " ");
        editor = editor.replace("</p>", "<br>");
    });
    return editor;
}

/*Text Editor Start*/

function datePicker(selector) {
    var elem = $(selector);
    elem.datetimepicker({
        format: 'DD-MM-YYYY',
        ignoreReadonly: true,
        widgetPositioning: {
            horizontal: 'left',
            vertical: 'bottom'
        },
        icons: {
            time: 'bx bx-time',
            date: 'bx bxs-calendar',
            up: 'bx bx-up-arrow-alt',
            down: 'bx bx-down-arrow-alt',
            previous: 'bx bx-chevron-left',
            next: 'bx bx-chevron-right',
            today: 'bx bxs-calendar-check',
            clear: 'bx bx-trash',
            close: 'bx bx-window-close'
        }
    });
    let preDefinedDate = elem.attr('data-predefined-date');

    if (preDefinedDate) {
        let preDefinedDateMomentFormat = moment(preDefinedDate, "YYYY-MM-DD").format("YYYY-MM-DD");
        elem.datetimepicker('defaultDate', preDefinedDateMomentFormat);
    }
}

function districts(elem, container, url, decendentElem)
{
    $(elem).on('change', function() {
        let divisionId = $(this).val();
        if( ((divisionId !== undefined) || (divisionId != null)) && divisionId) {
            $.ajax({
                type: "GET",
                url: url+divisionId,
                success: function (data) {
                    $(container).html(data.html);
                    $(decendentElem).html('');
                },
                error: function (data) {
                    alert('error');
                }
            });
        } else {
            $(container).html('');
            $(decendentElem).html('');
        }
    });
}

function thanas(elem, url, container)
{
    $(elem).on('change', function() {
        let districtId = $(this).val();

        if( ((districtId !== undefined) || (districtId != null)) && districtId) {
            $.ajax({
                type: "GET",
                url: url+districtId,
                success: function (data) {
                    $(container).html(data.html);
                },
                error: function (data) {
                    alert('error');
                }
            });
        } else {
            $(container).html('');
        }
    });
}

function selectCpaEmployees(selector, allEmployeesFilterUrl, selectedEmployeeUrl, callback)
{
    $(selector).select2({
        placeholder: "Select",
        allowClear: false,
        ajax: {
            url: allEmployeesFilterUrl, // '/ajax/employees'
            data: function (params) {
                if(params.term) {
                    if (params.term.trim().length  < 1) {
                        return false;
                    }
                } else {
                    return false;
                }

                return params;
            },
            dataType: 'json',
            processResults: function(data) {
                var formattedResults = $.map(data, function(obj, idx) {
                    obj.id = obj.emp_id;
                    obj.text = obj.emp_code+' ('+obj.emp_name+')';
                    return obj;
                });
                return {
                    results: formattedResults,
                };
            },
        }
    });

    if(
        ($(selector).attr('data-emp-id') !== undefined) && ($(selector).attr('data-emp-id') !== null) && ($(selector).attr('data-emp-id') !== '')
    ) {
        selectDefaultCpaEmployee($(selector), selectedEmployeeUrl, $(selector).attr('data-emp-id'));
    }

    $(selector).on('select2:select', function (e) {
        var selectedEmployee = e.params.data;
        var that = this;

        if(selectedEmployee.emp_code) {
            $.ajax({
                type: "GET",
                url: selectedEmployeeUrl+selectedEmployee.emp_id, // '/ajax/employee/'
                success: function (data) {
                    callback(that, data);
                },
                error: function (data) {
                    alert('error');
                }
            });
        }
    });
}



function selectDefaultCpaEmployee(selector, selectedEmployeeUrl, empId)
{
    $.ajax({
        type: 'GET',
        url: selectedEmployeeUrl+empId, //  '/ajax/employee/'
    }).then(function (data) {
        // create the option and append to Select2
        var option = new Option(data.emp_code+' ('+data.emp_name+')', data.emp_id, true, true);
        selector.append(option).trigger('change');

        // manually trigger the `select2:select` event
        selector.trigger({
            type: 'select2:select',
            params: {
                data: data
            }
        });
    });
}

    function datePickerUsingDiv(divSelector) { // divSelector is the targeted parent div of date input field
    var elem = $(divSelector);
    elem.datetimepicker({
        format: 'YYYY-MM-DD',
        ignoreReadonly: true,
        widgetPositioning: {
            horizontal: 'left',
            vertical: 'bottom'
        },
        icons: {
            time: 'bx bx-time',
            date: 'bx bxs-calendar',
            up: 'bx bx-up-arrow-alt',
            down: 'bx bx-down-arrow-alt',
            previous: 'bx bx-chevron-left',
            next: 'bx bx-chevron-right',
            today: 'bx bxs-calendar-check',
            clear: 'bx bx-trash',
            close: 'bx bx-window-close'
        }
    });
}

function branches(elem, url, container)
{
    $(elem).on('change', function() {
        let branchId = $(this).val();

        if( ((branchId !== undefined) || (branchId != null)) && branchId) {
            $.ajax({
                type: "GET",
                url: url+branchId,
                success: function (data) {
                    $(container).html(data.html);
                },
                error: function (data) {
                    alert('error');
                }
            });
        } else {
            $(container).html('');
        }
    });
}


function dateTimePicker(selector) {
    var elem = $(selector);
    elem.datetimepicker({
        format: 'hh:mm A',
        icons: {
            time: 'bx bx-time',
            date: 'bx bxs-calendar',
            up: 'bx bx-up-arrow-alt',
            down: 'bx bx-down-arrow-alt',
            previous: 'bx bx-chevron-left',
            next: 'bx bx-chevron-right',
            today: 'bx bxs-calendar-check',
            clear: 'bx bx-trash',
            close: 'bx bx-window-close'

        }
    });

    let preDefinedDate = elem.attr('data-predefined-date');

    if (preDefinedDate) {
        let preDefinedDateMomentFormat = moment(preDefinedDate, "YYYY-MM-DD HH:mm").format("YYYY-MM-DD HH:mm A");
        elem.datetimepicker('defaultDate', preDefinedDateMomentFormat);
    }
}

function selectBookings(selector, allBookingsFilterUrl, selectedBookingUrl, callback, excludesCallback)
{
    $(selector).select2({
        placeholder: "Select",
        allowClear: false,
        ajax: {
            url: allBookingsFilterUrl,
            data: function (params) {
                var query = {
                    term: params.term,
                    exclude: excludesCallback
                }

                return query;
            },
            dataType: 'json',
            processResults: function(data) {
                var formattedResults = $.map(data, function(obj, idx) {
                    obj.id = obj.booking_mst_id;
                    obj.text = obj.booking_no;
                    return obj;
                });
                return {
                    results: formattedResults,
                };
            },
        }
    });

    if(
        ($(selector).attr('data-booking-id') !== undefined) && ($(selector).attr('data-booking-id') !== null) && ($(selector).attr('data-booking-id') !== '')
    ) {
        selectDefaultBooking($(selector), selectedBookingUrl, $(selector).attr('data-booking-id'));
    }

    $(selector).on('select2:select', function (e) {
        var selectedBooking = e.params.data;
        var that = this;

        if(selectedBooking.booking_no) {
            $.ajax({
                type: "GET",
                url: selectedBookingUrl+selectedBooking.booking_mst_id,
                success: function (data) {
                    callback(that, data);
                },
                error: function (data) {
                    alert('error');
                }
            });
        }
    });
}

function selectDefaultBooking(selector, selectedBookingUrl, bookingId)
{
    $.ajax({
        type: 'GET',
        url: selectedBookingUrl+bookingId,
    }).then(function (data) {
        var info = data.booking;
        // create the option and append to Select2
        var option = new Option(info.booking_no, info.booking_mst_id, true, true);
        selector.append(option).trigger('change');

        // manually trigger the `select2:select` event
        selector.trigger({
            type: 'select2:select',
            params: {
                data: info
            }
        });
    });
}

function formSubmission(formElem, clickedElem, callback, message)
{
    $(clickedElem).click(function(e) {
        e.preventDefault();
        callback(formElem);
        var isValid = $(formElem).valid();

        if(isValid) {
            var confirmation = confirm(message);
            if(confirmation == true) {
                $(formElem).submit();
            }
        }
    });
}

$('.mobile-validation').on('keypress', function(e) {
    // e is event.
    var keyCode = e.which;
    /*
      8 - (backspace)
      32 - (space)
      48-57 - (0-9)Numbers
    */

    if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) {
        return false;
    }
});

function errorPlacement(error, element)
{
    if(element.attr('type') == 'radio') {
        error.insertAfter(element.parent().parent());
    } else if(element.hasClass('select2-hidden-accessible')) {
        error.insertAfter(element.next());
    } else {
        error.insertAfter(element);
    }
}

function jQueryValidateFileSizeValidator()
{
    $.validator.addMethod('filesize', function (value, element, param) {
        return this.optional(element) || (element.files[0].size <= param);
    }, 'File size must be less than {0}');
}

function setFileName()
{
    $('input[type="file"]').on('change', function(e) {
        var fieldVal = $(this).val();

        fieldVal = fieldVal.replace("C:\\fakepath\\", "");

        if (fieldVal != undefined || fieldVal != "") {
            $(this).siblings(".custom-file-label").attr('data-content', fieldVal);
            $(this).siblings(".custom-file-label").text(fieldVal);
        }
    });
}

function removeRow()
{
    $('form.remove-row button[type="submit"]').on('click', function(e) {
        var that = this;
        var shouldRemove = window.confirm('Are you sure you want to remove?');

        if(shouldRemove) {
            $(that).parent('form').submit();
        } else {
            e.preventDefault();
        }
    });
}

function getSysDate() {
    let now = new Date();
    let month = (now.getMonth() + 1);
    let day = now.getDate();
    if (month < 10)
        month = "0" + month;
    if (day < 10)
        day = "0" + day;//YYYY-MM-DD
    let today =  day+ '-'+ month+ '-'+ now.getFullYear();
    return today;
}

function getSysTime() {
    let now = new Date();
    let hours = now.getHours();
    let minutes = now.getMinutes();
    let ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0'+minutes : minutes;
    let strTime = hours + ':' + minutes + ' ' + ampm;
    return strTime;
}

function getSysTimeAdd() {
    let now = new Date();
    let hours = now.getHours();
    let minutes = now.getMinutes();
    let ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    hours = hours + 1;
    minutes = minutes < 10 ? '0'+minutes : minutes;
    let strTime = hours + ':' + minutes + ' ' + ampm;
    return strTime;
}

function maxDateOff($selector, format='DD-MM-YYYY') {
    $($selector).datetimepicker({
        ignoreReadonly: true,
        useCurrent: false,
        format: format,
        maxDate : moment(),
        widgetPositioning: {
            horizontal: 'left',
            vertical: 'bottom'
        },
        icons: {
            time: 'bx bx-time',
            date: 'bx bxs-calendar',
            up: 'bx bx-up-arrow-alt',
            down: 'bx bx-down-arrow-alt',
            previous: 'bx bx-chevron-left',
            next: 'bx bx-chevron-right',
            today: 'bx bxs-calendar-check',
            clear: 'bx bx-trash',
            close: 'bx bx-window-close'
        }
    });
    // For edit
    let preDefinedDateMax = $($selector).attr('data-predefined-date');
    console.log(preDefinedDateMax);

    if (preDefinedDateMax) {
        let preDefinedDateMomentFormat = moment(preDefinedDateMax, "DD-MM-YYYY").format("DD-MM-YYYY");
        $($selector).datetimepicker('defaultDate', preDefinedDateMomentFormat);
    }
}
function maxDateOff($selector, format='DD-MM-YYYY') {
    // moment(new Date(), "YYYY-MM-DD").format("YYYY-MM-DD")
    var preDefinedDateMax = $($selector).attr('data-predefined-date');
    //console.log(preDefinedDateMax);
    if (preDefinedDateMax){
        $($selector).datetimepicker({
            format: format,
            ignoreReadonly: true,
            useCurrent: false,
            // defaultDate:moment(new Date(), 'DD-MM-YYYY').format('DD-MM-YYYY'),
            // maxDate : dateMax,
            maxDate : moment(),
            widgetPositioning: {
                horizontal: 'left',
                vertical: 'bottom'
            },
            icons: {
                time: 'bx bx-time',
                date: 'bx bxs-calendar',
                up: 'bx bx-up-arrow-alt',
                down: 'bx bx-down-arrow-alt',
                previous: 'bx bx-chevron-left',
                next: 'bx bx-chevron-right',
                today: 'bx bxs-calendar-check',
                clear: 'bx bx-trash',
                close: 'bx bx-window-close'
            }
        });
        // For edit
        if (preDefinedDateMax) {
            let preDefinedDateMomentFormat = moment(preDefinedDateMax, "DD-MM-YYYY").format("DD-MM-YYYY");
            $($selector).datetimepicker('defaultDate', preDefinedDateMomentFormat);
        }
    }else{
        $($selector).datetimepicker({
            format: format,
            ignoreReadonly: true,
            widgetPositioning: {
                horizontal: 'left',
                vertical: 'bottom'
            },
            icons: {
                time: 'bx bx-time',
                date: 'bx bxs-calendar',
                up: 'bx bx-up-arrow-alt',
                down: 'bx bx-down-arrow-alt',
                previous: 'bx bx-chevron-left',
                next: 'bx bx-chevron-right',
                today: 'bx bxs-calendar-check',
                clear: 'bx bx-trash',
                close: 'bx bx-window-close'
            }
        });
        $($selector).on("change.datetimepicker", function (e) {
            // $($selector).datetimepicker('maxDate', e.date);
            $($selector).datetimepicker('maxDate', new Date());
        });
        // For edit
        if (preDefinedDateMax) {
            let preDefinedDateMomentFormat = moment(preDefinedDateMax, "DD-MM-YYYY").format("DD-MM-YYYY");
            $($selector).datetimepicker('defaultDate', preDefinedDateMomentFormat);
        }
    }

}
function minDateOff($selector, format='DD-MM-YYYY') {
    // moment(new Date(), "YYYY-MM-DD").format("YYYY-MM-DD")
    let preDefinedDateMin = $($selector).attr('data-predefined-date');
    //console.log(preDefinedDateMax);
    if (preDefinedDateMin){
        $($selector).datetimepicker({
            format: format,
            ignoreReadonly: true,
            useCurrent: false,
            // defaultDate:moment(new Date(), 'DD-MM-YYYY').format('DD-MM-YYYY'),
            //maxDate : dateMax,
            minDate : moment(),
            widgetPositioning: {
                horizontal: 'left',
                vertical: 'bottom'
            },
            icons: {
                time: 'bx bx-time',
                date: 'bx bxs-calendar',
                up: 'bx bx-up-arrow-alt',
                down: 'bx bx-down-arrow-alt',
                previous: 'bx bx-chevron-left',
                next: 'bx bx-chevron-right',
                today: 'bx bxs-calendar-check',
                clear: 'bx bx-trash',
                close: 'bx bx-window-close'
            }
        });
        // For edit
        if (preDefinedDateMin) {
            let preDefinedDateMomentFormat = moment(preDefinedDateMin, "DD-MM-YYYY").format("DD-MM-YYYY");
            $($selector).datetimepicker('defaultDate', preDefinedDateMomentFormat);
        }
    }else{
        $($selector).datetimepicker({
            format: format,
            ignoreReadonly: true,
            widgetPositioning: {
                horizontal: 'left',
                vertical: 'bottom'
            },
            icons: {
                time: 'bx bx-time',
                date: 'bx bxs-calendar',
                up: 'bx bx-up-arrow-alt',
                down: 'bx bx-down-arrow-alt',
                previous: 'bx bx-chevron-left',
                next: 'bx bx-chevron-right',
                today: 'bx bxs-calendar-check',
                clear: 'bx bx-trash',
                close: 'bx bx-window-close'
            }
        });
        $($selector).on("change.datetimepicker", function (e) {
            $($selector).datetimepicker('minDate', new Date());
        });
        // For edit
        if (preDefinedDateMin) {
            let preDefinedDateMomentFormat = moment(preDefinedDateMin, "DD-MM-YYYY").format("DD-MM-YYYY");
            $($selector).datetimepicker('defaultDate', preDefinedDateMomentFormat);
        }
    }
}
function dateRangePicker(Elem1, Elem2,minDate=null,maxDate=null){
    let minElem = $(Elem1);
    let maxElem = $(Elem2);

    minElem.datetimepicker({
        format: 'DD-MM-YYYY',
        ignoreReadonly: true,
        widgetPositioning: {
            horizontal: 'left',
            vertical: 'bottom'
        },
        icons: {
            time: 'bx bx-time',
            date: 'bx bxs-calendar',
            up: 'bx bx-up-arrow-alt',
            down: 'bx bx-down-arrow-alt',
            previous: 'bx bx-chevron-left',
            next: 'bx bx-chevron-right',
            today: 'bx bxs-calendar-check',
            clear: 'bx bx-trash',
            close: 'bx bx-window-close'
        }
    });
    maxElem.datetimepicker({
        useCurrent: false,
        format: 'DD-MM-YYYY',
        ignoreReadonly: true,
        widgetPositioning: {
            horizontal: 'left',
            vertical: 'bottom'
        },
        icons: {
            time: 'bx bx-time',
            date: 'bx bxs-calendar',
            up: 'bx bx-up-arrow-alt',
            down: 'bx bx-down-arrow-alt',
            previous: 'bx bx-chevron-left',
            next: 'bx bx-chevron-right',
            today: 'bx bxs-calendar-check',
            clear: 'bx bx-trash',
            close: 'bx bx-window-close'
        }
    });
    minElem.on("change.datetimepicker", function (e) {
        maxElem.datetimepicker('minDate', e.date);
    });
    maxElem.on("change.datetimepicker", function (e) {
        minElem.datetimepicker('maxDate', e.date);
    });

    let preDefinedDateMin = minElem.attr('data-predefined-date');
    let preDefinedDateMax = maxElem.attr('data-predefined-date');
    console.log(preDefinedDateMin);

    if (preDefinedDateMin) {
        let preDefinedDateMomentFormat = moment(preDefinedDateMin, "DD-MM-YYYY").format("DD-MM-YYYY");
        minElem.datetimepicker('defaultDate', preDefinedDateMomentFormat);
    }

    if (preDefinedDateMax) {
        let preDefinedDateMomentFormat = moment(preDefinedDateMax, "DD-MM-YYYY").format("DD-MM-YYYY");
        maxElem.datetimepicker('defaultDate', preDefinedDateMomentFormat);
    }

}
function dateRangePicker(Elem1, Elem2){
    let minElem = $(Elem1);
    let maxElem = $(Elem2);

    minElem.datetimepicker({
        format: 'DD-MM-YYYY',
        ignoreReadonly: true,
        widgetPositioning: {
            horizontal: 'left',
            vertical: 'bottom'
        },
        icons: {
            time: 'bx bx-time',
            date: 'bx bxs-calendar',
            up: 'bx bx-up-arrow-alt',
            down: 'bx bx-down-arrow-alt',
            previous: 'bx bx-chevron-left',
            next: 'bx bx-chevron-right',
            today: 'bx bxs-calendar-check',
            clear: 'bx bx-trash',
            close: 'bx bx-window-close'
        }
    });
    maxElem.datetimepicker({
        useCurrent: false,
        format: 'DD-MM-YYYY',
        ignoreReadonly: true,
        widgetPositioning: {
            horizontal: 'left',
            vertical: 'bottom'
        },
        icons: {
            time: 'bx bx-time',
            date: 'bx bxs-calendar',
            up: 'bx bx-up-arrow-alt',
            down: 'bx bx-down-arrow-alt',
            previous: 'bx bx-chevron-left',
            next: 'bx bx-chevron-right',
            today: 'bx bxs-calendar-check',
            clear: 'bx bx-trash',
            close: 'bx bx-window-close'
        }
    });
    minElem.on("change.datetimepicker", function (e) {
        maxElem.datetimepicker('minDate', e.date);
    });
    maxElem.on("change.datetimepicker", function (e) {
        minElem.datetimepicker('maxDate', e.date);
    });

    let preDefinedDateMin = minElem.attr('data-predefined-date');
    let preDefinedDateMax = maxElem.attr('data-predefined-date');

    if (preDefinedDateMin) {
        let preDefinedDateMomentFormat = moment(preDefinedDateMin, "DD-MM-YYYY").format("DD-MM-YYYY");
        minElem.datetimepicker('defaultDate', preDefinedDateMomentFormat);
    }

    if (preDefinedDateMax) {
        let preDefinedDateMomentFormat = moment(preDefinedDateMax, "DD-MM-YYYY").format("DD-MM-YYYY");
        maxElem.datetimepicker('defaultDate', preDefinedDateMomentFormat);
    }

}

$(".dynamicModal").on("click", function () {

    var news_id=this.getAttribute('news_id');
    $.ajax(
        {
            type: 'GET',
            url: '/get-top-news',
            data: {news_id:news_id},
            dataType: "json",
            success: function (data) {
                $("#dynamicNewsModalContent").html(data.newsView);
                $('#dynamicNewsModal').modal('show');
            }
        }
    );

});

$('body').on('mouseenter mouseleave','.dropdown',function(e){
    var _d=$(e.target).closest('.dropdown');
    if (e.type === 'mouseenter')_d.addClass('show');
    setTimeout(function(){
        _d.toggleClass('show', _d.is(':hover'));
        $('[data-toggle="dropdown"]', _d).attr('aria-expanded',_d.is(':hover'));
    },300);
});
function hideNseek(formName, buttonName){
    $(buttonName).click(function() {
        $(formName).slideToggle('slow');
    });
}


$(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    var filename = fileName.substring(0, 10);
    if (fileName.length > 10) {
        $(this).siblings(".custom-file-label").addClass("selected").html(filename+'...');
    }
});


$(document).click(function(event){
    $("#suggesstion-box").hide();
});
$(document).on('keyup','#item_name_search',function(e){
    let url = $(this).attr('data-url');
    let category_id = $('#category_id').val();
    let rule = $('#rule').val();
    let department_id = 10;

    if (category_id){
        url = url + "?keyword="+$(this).val() +"&category_id=" + category_id+"&department_id=" + department_id+"&rule=" + rule;
    }else{
        url = url + "?keyword="+$(this).val()+"&department_id=" + department_id+"&rule=" + rule;
    }
    $.ajax({
        type: "GET",
        url: url,
        beforeSend: function(){
            $("#item_name_search").css("background","#FFF url({{asset('images/ajax-loader.gif')}}) no-repeat 165px");
        },
        success: function(data){
            $("#suggesstion-box").show();
            $("#suggesstion-box").html(data);
            $("#item_name_search").css("background","#FFF");
        }
    });
});
//To select country name
$(document).on('click','.itemDataShow',function () {
    let data_id = $(this).attr('data-id');
    let data_name = $(this).attr('data-name');
    let url = $(this).attr('data-url');
    console.log(data_id);
    $.ajax({
        type: "GET",
        url: url+"?item_id="+data_id,
        beforeSend: function(){
            $("#item_name_search").css("background","#FFF url({{asset('images/ajax-loader.gif')}}) no-repeat 165px");
        },
        success: function(result){
            $("#data_item_id").val(result.data.item_id);
            $("#variant_id").html(result.variantSelects);
            $("#brand_id").html(result.brandSelects);
            $(".unit_code").html(result.data.unit.unit_code);
            $("#unit_code_val").val(result.data.unit.unit_code);
            $('select').select2();
        }
    });
    $("#item_name_search").val(data_name);
    $("#suggesstion-box").hide();
});

$(document).on('change','.variant_select',function () {
    let variant_id = $(this).val();
    let data_item_id = $('#data_item_id').val();
    let url = $(this).attr('data-url');
    if ($(this).val() == ''){
        variant_id = 0;
    }
    console.log(variant_id);
    $.ajax({
        type: "GET",
        url: url+"?item_id="+data_item_id+"&variant_id="+variant_id,
        beforeSend: function(){
            $("#variant_id").css("background","#FFF url({{asset('images/ajax-loader.gif')}}) no-repeat 165px");
        },
        success: function(result){
            $("#variant_option").html(result.variantOptionSelects);
            $('select').select2();
        }
    });
});


function formEmpty() {
    $('#category_id').val('').trigger('change');
    $('#item_name_search').val('');
    $('#variant_id').val('').trigger('change');
    $('#variant_option').val('').trigger('change');
    $('#qty').val('');
    $('#remarks').val('');
    $('#brand_id').val('').trigger('change');
}

function delete_requisition_item(temp_req_id, requisition_no, data_url)
{
    let x = confirm("Are you want to delete this item from list");
    if(x == true)
    {
        $.ajax({
            type    : "POST",
            url     : data_url,
            dataType: "json",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                temp_req_id : temp_req_id,
                requisition_no: requisition_no
            },
            success: function(result){
                $('.loading_item').hide();
                $('.item-list').html(result.html);

            }
        })
    }

}

function encodeImgtoBase64(element) {
    var img = element.files[0];
    console.log(img);
    $(element).parents('tr').find(".original_file_name").val(img.name);
    $(element).parents('tr').find(".attachment_type").val(img.type);
    var reader = new FileReader();

    reader.onloadend = function() {

        //$("#convertImg").attr("href",reader.result);
        // $(element).parents('tr').find(".original_file_name").val(img.name);
        // $(element).parents('tr').find(".file_paths").val(reader.result);
        // $("#displayImg").attr("src", reader.result);
    }
    reader.readAsDataURL(img);
}

var i=0;
window.variants = [];
window.variants_strings = '';
$(document).on('click','.addVariant',function(e){
    e.preventDefault();
    i++;
    let variant_name_val = $('.variant_id option:selected').val()
    let variant_name_text = $('.variant_id option:selected').text()
    // let options_val = $('.options option:selected').val()
    // let options_text = $('.options option:selected').text()
    var options_text = $(".variant_option option:selected").map(function () {
        return $(this).text();
    }).get().join(',');
    var options_val = $(".variant_option option:selected").map(function () {
        return $(this).val();
    }).get().join(',');

    let variant = {
        'variant_id' : variant_name_val,
        'variant_name' : variant_name_text,
        'variant_option_id' : options_val,
        'variant_option_name' : options_text,
    };

    if (variant_name_val == ''){
        $("#variant_id").notify(
            "Please variant select!",
            { position:"top" }
        );
        return false;
    }
    if (options_val == ''){
        $("#variant_option").notify(
            "Please variant option select!",
            { position:"top" }
        );
        return false;
    }

    if (variantOptionExists(variant_name_val)) {

        $("#variant_option").notify(
            "Variant Already Exists!",
            { position:"top" }
        );
        return false;
    }
    else{
        $('#variant_table tbody').append('<tr class="variant-cloned-row last-data">\n' +
            '                <td class="text-left">\n' +
            '                     <input  readonly class="form-control" type="hidden" value="' + variant_name_val + '" name="variant_name_val[]" id="variant_name_val"/>' +
            '                     <input  readonly class="form-control" type="text" value="' + variant_name_text + '" name="variant_name_text[]" id="variant_name_text"/>' +
            '                </td>\n' +
            '                <td>\n' +
            '                     <input readonly class="form-control" type="hidden" value="' + options_val + '" name="options_val[]" id="variant_options_val"/>\n' +
            '                     <input readonly class="form-control" type="text" value="' + options_text + '" name="options_text[]" id="variant_options_text"/>\n' +
            '                 </td>\n' +
            '                <td style="width: 20%">\n' +
            '                    <div class="toggle" style="display: inline-flex">\n' +
            '                        <a href="#" class="variant_remove" id="buttonless"\n' +
            '                           data-variant_id="' + variant_name_val + '">\n' +
            '                            <i class="bx bx-trash bx-md text-danger"></i>\n' +
            '                        </a>\n' +
            '                    </div>\n' +
            '                </td>\n' +
            '            </tr>');

        window.variants.push(variant);
    }
    console.log(window.variants);
    $('#variants').val(window.variants);
    $('#variant_id').val(null).trigger('change');
    $('#variant_option').val(null).trigger('change');

});

$(".add-row-equip-req").click(function () {
    let variants_url = $(this).attr('data-variants_url');
    var variants_strings = null;
    $.ajax({
        type    : "POST",
        url     : variants_url,
        dataType: "json",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            variants : window.variants,
        },
        success: function(result){
             console.log('in',result.data);
             variants_strings = result.data;
              itemRow(variants_strings);
              $("#variants_string").val(result.data)
         }
    })

});
function itemRow(variants_strings) {
    let tab_item_name = $("#item_name_search").val();
    let variants_string = $("#variants_string").val();
    let brand_id         = $('#brand_id').val();
    let brand_name = '';
    if (brand_id){
          brand_name   = $('#brand_id option:selected').text();
    }
    let tab_item_id = $("#data_item_id").val();
    let tab_description = $("#tab_description").val();
    // let tab_appx_price = $("#tab_appx_price").val();
    let tab_quantity = $("#tab_quantity").val();
    let tab_remarks = $("#tab_remarks").val();
    let tab_replacement_yn = $('input[name=replacement_yn]:checked').val();
    let status;
    console.log(brand_id);
    if(tab_replacement_yn=='Y'){
        status = 'Yes';
    }else{
        status = 'No';
    }
    if (tab_item_name == ''){
        scrollTop($('#item_name_search'),40);
        $("#item_name_search").notify(
            "Item is required",
            { position:"top" }
        );
        return;
    }
    if (tab_quantity == ''){
        scrollTop($('#qty'),40);
        $("#qty").notify(
            "Quantity is required",
            { position:"top" }
        );
        return;
    }
    console.log('out',variants_strings);
    if (tab_item_id != ''  && tab_quantity != '') {
        let markup = "<tr><td><input type='checkbox' name='record'>" +
            "<input type='hidden' name='tab_item_name[]' value='" + tab_item_name + "'>" +
            "<input type='hidden' name='tab_item_id[]' value='" + tab_item_id + "'>" +
            "<input type='hidden' name='brands_id[]' value='" + brand_id + "'>" +
            "<input type='hidden' name='brand_name[]' value='" + brand_name + "'>" +
            "<input type='hidden' name='variants_string[]' value='" + variants_strings + "'>" +
            "<input type='hidden' name='tab_description[]' value='" + tab_description + "'>" +
            // "<input type='hidden' name='tab_appx_price[]' value='" + tab_appx_price + "'>" +
            "<input type='hidden' name='tab_quantity[]' value='" + tab_quantity + "'>" +
            "<input type='hidden' name='tab_remarks[]' value='" + tab_remarks + "'>" +
            "<input type='hidden' name='tab_replacement_yn[]' value='" + tab_replacement_yn + "'>" +
            "</td><td>" + tab_item_name + "</td><td>" + brand_name + "</td><td>" + variants_strings + "</td><td>" + tab_description + "</td><td>" + tab_quantity + "</td><td>" + tab_remarks + "</td><td>" + status + "</td></tr>";
        $("#tab_item_name").val("");
        $("#brand_id").val("");
        $("#brand_name").val("");
        $("#variants_string").val("");
        $("#tab_description").val("");
        // $("#tab_appx_price").val("");
        $("#tab_quantity").val("");
        $("#tab_remarks").val("");
        $("#table-equip-req tbody").append(markup);
    } else {
        Swal.fire('Fill required value.');
    }
    $('#variant_table tbody .last-data').html('');
    window.variants = [];
    formEmpty();
}
function variantOptionExists(variant_id) {
    return variants.some(function(el) {
        return el.variant_id === variant_id;
    });
}


$(document).on('click', ".variant_remove", function (e) {
    e.preventDefault();
    var len_variant_cloned_row = $('.variant-cloned-row').length;
    if (len_variant_cloned_row > 1) {
        $(this).closest('.variant-cloned-row').remove();
        var deleted_variant_id = $(this).attr('data-variant_id');
        console.log(deleted_variant_id);
        variants.some(item => {
            if(item.variant_id === deleted_variant_id) // Case sensitive, will only remove first instance
                variants.splice(variants.indexOf(item),1)
        })
        console.log(variants);
    }
});

function scrollTop($target,position = 40) {
    $('html, body').stop().animate( {
        'scrollTop': $target.offset().bottom+position
    }, 900, 'swing', function () {
        window.location.hash = target;
    } );
}
