<!-- Cart start -->
<div class="offcanvas offcanvas-end lead-offcanvas" tabindex="-1" id="cartDetailsCanvas" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header offcanvas-lead-header">
        <div class="ol-header d-flex align-items-center justify-content-between flex-100">
            <div class="olh-action d-flex align-items-center">
                <h4 class="olh-title mb-0">Product List </h4>
            </div>
            
            <button class="olh-btn olh-submit-btn" data-bs-dismiss="offcanvas" aria-label="Close">
                <span class="me-1">
                    <i class="la la-close"></i>
                </span>
                Close
            </button>
        </div>
     
      
    </div>
    <div class="offcanvas-body lead-offcanvas-body">
        
        <div class="cart-list-main">
            <div class="clm-list-item-wrapper" id="cart-contents">
            </div>
        </div>
        <div class="cart-list-checkout-wrapper">
            <form action="{{ route('inventory.product-material.submit-cart') }}" method="POST" id="cartSubmitForm">
                @csrf
                <div class="php-rate-wrapper">
                    <div class="align-items-center cart-php-rate-wrapper d-flex gap-2 justify-content-center item">
                        <div class="cprw-label">
                            <label>PHP Rate : </label>
                        </div>
                        <div class="cprw-input">
                            <input type="text" class="form-control" placeholder="PHP Rate" name="php_rate" id="cart_php_rate" required>
                        </div>
                    </div>
                </div>
                <button type="submit" class="clm-checkout-btn">Create Purchase Order</button>
            </form>
        </div>
    

    </div>
  </div>
<!-- lead Create End -->