function formPost(url, data, successCallback='default', errorCallback='default') {
    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        processData: false,
        contentType: false,
        success: function (response) {
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
            } else {
                successCallback(response);
            }
        },
        error: function(xhr, status, error) {
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


function ajaxGet(url, data, successCallback='default', errorCallback='default') {
    $.ajax({
        url: url,
        type: 'GET',
        data: data,
        success: function (response) {
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
            } else {
                successCallback(response);
            }
        },
        error: function(xhr, status, error) {
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
