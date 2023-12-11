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
            } else {
                errorCallback(xhr);
            }
        }
    });
}
