function formPost(url, data, successCallback='default', errorCallback='default') {
    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        processData: false,
        contentType: false,
        beforeSend: function () {
            showLoader('Please Wait', 'Loading...')
        },
        success: function (response) {
            hideLoader();
            if (successCallback == 'default') {
                if (response.status == 200) {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            } else if(successCallback == 'redirect') {
                if (response.status == 200) {
                   /* toastr.success(response.message);*/
                    window.location.href = response.redirectUri;

                } else {
                    toastr.error(response.message);
                }
            } else if(successCallback == 'reload') {
                if (response.status == 200) {
                    window.location.reload();
                } else {
                    toastr.error(response.message);
                }
            } else if(successCallback == 'reloadAjaxGetData') {
                if (response.status == 200) {
                    toastr.success(response.message);
                    getData();
                } else {
                    toastr.error(response.message);
                }
            } else {
                successCallback(response);
            }
        },
        error: function(xhr, status, error) {
            hideLoader();
            if (errorCallback == 'default') {
                toastr.error(xhr.responseText);
            } else if(errorCallback == 'show_input_error') {
                if (xhr.status == 422) {
                    $.each(xhr.responseJSON.errors, function (key, value) {
                        $("." + key + "_error").text(value).show();
                        toastr.error(value);
                    });
                } else {
                    toastr.error(xhr.message);
                }
            } else {
                errorCallback(xhr);
            }
        },
        complete: function () {

        }
    });
}


function ajaxGet(url, data, successCallback='default', errorCallback='default') {
    $.ajax({
        url: url,
        type: 'GET',
        data: data,
        beforeSend: function (){
          showLoader('Please Wait', 'Loading...');
        },
        success: function (response) {
            console.log(response);
            hideLoader();
            if (successCallback == 'default') {
                if (response.status == 200) {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            } else if(successCallback == 'redirect') {
                if (response.status == 200) {
                    window.location.href = response.redirectUri;
                } else {
                    toastr.error(response.message);
                }
            } else if(successCallback == 'reload') {
                if (response.status == 200) {
                    window.location.reload();
                } else {
                    toastr.error(response.message);
                }
            } else if(successCallback == 'reloadAjaxGetData') {
                if (response.status == 200) {
                    toastr.success(response.message);
                    getData();
                } else {
                    toastr.error(response.message);
                }
            } else {
                successCallback(response);
            }
        },
        error: function(xhr, status, error) {
            hideLoader();
            if (errorCallback == 'default') {
                toastr.error(xhr.responseText);
            } else if(errorCallback == 'show_input_error') {
                if (xhr.status == 422) {
                    $.each(xhr.responseJSON.errors, function (key, value) {
                        $("." + key + "_error").text(value).show();
                        toastr.error(value);
                    });
                } else {
                    toastr.error(xhr.message);
                }
            } else {
                errorCallback(xhr);
            }
        }
    });
}

function getPaginatedListData(form_route, placement_area, extra_data={}, scrollTop = true) {
    let _token = $("meta[name=csrf-token]").attr('content');
    let req_data = extra_data;
    /*{
        _token : _token
    };*/
    req_data._token = _token;

    $.ajax({
        type: 'POST',
        url: form_route,
        data: req_data,
        beforeSend: function () {
            //let loader_html = "<div class='inner-div-loader'></div>";
            // let loader_html = ``;
            // $(placement_area).html(loader_html);
        },
        success: function (data) {
            if (data.status == 200) {
                $(placement_area).html(data.view);
                if(scrollTop==true){
                    window.scrollTo(0, 0);
                }

            }else {
                showErrorAlert('Error!',data.msg);
            }
        },
        error: function (xhr, status, error) {
            showErrorAlert('Error!',xhr.responseText.message);
        },
        complete: function () {

        }
    });
}


function deleteAjax(uri, successCallback='default', errorCallback='default', data={}) {
    Swal.fire({
        title: '',
        html: 'Are you sure to delete this?',
        showDenyButton: true,
        confirmButtonText: 'Yes',
        denyButtonText: `No`,
    }).then((result) => {
        if (result.isConfirmed) {
            ajaxGet(
                uri,
                data,
                successCallback,
                errorCallback
            );
        } else if (result.isDenied) {

        }
    })
}

function updateStatus(button, callbacka=null){
    let url = $(button).attr('data-href');
    console.log(callbacka);
    ajaxGet(url, {}, function (response) {
        if (response.status == 200) {
            showSuccessAlert('Success',response.message)
            if (callbacka !== null) {
                callbacka();
            }
        } else {
            toastr.error(response.message);
        }
    }, 'default');
}

function validateHtmlForm(form) {
    var tab1Fields = $(form).find(':input[required]');
    tab1Fields.each(function() {
        if (!$(this).val()) {
            let inputName = $(this).attr('name');
            inputName = inputName.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
            inputName = inputName.replace(" Id", '');
            showInfoAlert('Error',inputName+' is required');
        }
    });
}
