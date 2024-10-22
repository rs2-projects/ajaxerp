let debounceUpdateQtyTimeout = null;

$(document).ready(function() {
    getCartContents();
});

function addToCart(id) {
    ajaxGet(
        ADD_TO_CART_ROUTE,
        {id: id}, 
        function(response) {
            
            if(response.status == 200) {
                showSuccessAlert('Success', response.message);
                getCartContents();
            } else {
                showErrorAlert('Error', response.message);
            }
        }
    );
}

function getCartContents() {
    ajaxGet(
        GET_CART_CONTENTS_ROUTE,
        {},
        function(response) {
            if(response.status == 200) {
                placeCartContents(response.data.carts.items);
            } else {
                showErrorAlert('Error', response.message);
            }
        }
    );
}

function placeCartContents(items) {
    let html = ``;
    let i = 1;
    items.forEach(item => {
        html += `
                <div class="clm-list-item">
                    <div class="clm-item-sl">
                        <span>${i++}</span>
                    </div>
                    <div class="clm-item-img">
                        <img src="${item.image}" alt="">
                    </div>
                    <div class="clm-item-content">
                        <h4 class="clm-item-title">${item.name}</h4>
                        <h4 class="clm-item-id">Product ID: <span>#${item.extra.code}</span></h4>
                        <div class="clm-item-qty-box">
                            <span>QTY:</span><input type="number" oninput="udpateCartQty(this, ${item.id})" class="form-control clm-item-qty-input" value="${item.qty}">
                        </div>
                    </div>
                    <div class="clm-item-action">
                        <a href="javascript:void(0)" onclick="removeCartItem(this, ${item.id})" class="clm-item-remove">
                            <i class="la la-trash"></i>
                        </a>
                    </div>
                </div>
        `;
    });

    $('#cart-contents').html(html);
    $(".cartItemCount").text(items.length);
}


function udpateCartQty(input, id) {   
    clearTimeout(debounceUpdateQtyTimeout);

    debounceUpdateQtyTimeout = setTimeout(function() {
        updateCartQtyAjax(input, id); // Call the actual function after the user stops input for a while
    }, 500); // Delay of 500ms (you can adjust the delay as needed)
}

function updateCartQtyAjax(input, id) {
    let qty = $(input).val();
    ajaxGet(
        UPDATE_CART_QTY_ROUTE,
        {id: id, qty: qty}, 
        function(response) {
            if(response.status == 200) {

            } else {
                showErrorAlert('Error', response.message);
            }
        },
        'default',
        false
    );
}

function removeCartItem(input, id) {
    ajaxGet(
        REMOVE_FROM_CART_ROUTE,
        {id: id}, 
        function(response) {
            if(response.status == 200) {
                showSuccessAlert('Success', response.message);
                getCartContents();
            } else {
                showErrorAlert('Error', response.message);
            }
        },
        'default',
        false
    );
}

$(document).on('submit', '#cartSubmitForm', function(e) {
    var self = this;
    e.preventDefault();
    var formData = new FormData($(self)[0]);
    $(".ie-span").text("").hide();
    var url = $(self).attr('action');

    formPost(url, formData, function (res) {
        if (res.status == 200) {
            showSuccessAlert('Success', res.message)
            window.location.href = res.redirect;
        } else {
            showErrorAlert('Error', res.message)
        }
    }, 'show_input_error');
});