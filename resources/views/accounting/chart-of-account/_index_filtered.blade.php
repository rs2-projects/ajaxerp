<div class="my-attendance-box-item flex-100 ">
    <div class="my-attendance-report-wrapper">


        <div class="erp-leave-tab-wrapper">
            <ul class="nav nav-tabs erp-nav-tabs justify-content-center" id="myTab" role="tablist">
                @if(!empty($coa_categories))
                    @foreach($coa_categories as $coa_category)
                        <li class="nav-item erp-nav-item" role="presentation">
                            {{--<button class="nav-link active erp-nav-link" id="all-assets" data-bs-toggle="tab" data-bs-target="#assets" type="button" role="tab" aria-controls="home" aria-selected="true">{{ $coa_category->name }}</button>--}}
                            <a class="nav-link {{ ($loop->first) ? 'active':'' }} erp-nav-link" data-bs-toggle="tab" href="#coa_cat2_{{ $coa_category->id }}">
                                {{ $coa_category->name }}
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>

            <div class="tab-content" id="myTabContent">
                @if(!empty($coa_categories))
                    @foreach($coa_categories as $coa_category)
                        <div class="tab-pane fade {{ ($loop->first)?' active show':'' }}" id="coa_cat2_{{ $coa_category->id }}" role="tabpanel" aria-labelledby="all-assets">
                            <div class="accounting-list-main-wrapper">
                                @if(!empty($coa_category->subcategories))
                                    @foreach($coa_category->subcategories as $coa_sub_category)
                                        <div class="accounting-list-wrapper">
                                            <div class="accounting-list-title">
                                                <h4>{{ $coa_sub_category->name }} <span class="erp-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $coa_sub_category->description }}"><i class="fa-duotone fa-exclamation"></i></span></h4>
                                            </div>
                                            <div class="accounting-list-item-wrapper">
                                                @if(count($coa_sub_category->accounts) > 0)
                                                    @foreach($coa_sub_category->accounts as $coa_account)
                                                        <div class="accounting-list-item d-flex flex-wrap align-items-center justify-content-start">
                                                            <div class="accounting-list-item-first-box">
                                                                <div class="accounting-list-item-title">
                                                                    <h5>{{ $coa_account->name }} <span data-bs-toggle="tooltip" title="Available Balance">{{ ($coa_account->available_balance != 0)?'( '.getCurrencySymbol().' '.showAmount($coa_account->available_balance).' )':'' }}</span></h5>
                                                                </div>
                                                                <div class="accounting-list-item-last-transction">
                                                                    <p>Last transaction on Jan 15, 2024</p>
                                                                </div>
                                                            </div>

                                                            <div class="accounting-list-item-description">
                                                                <p>
                                                                    {{ $coa_account->description }}
                                                                </p>
                                                            </div>
                                                            @if(hasPermission('manage-chart-of-accounts'))
                                                                @if($coa_account->can_edit == $coa_account::CAN_EDIT_YES)
                                                                    <div class="accounting-list-item-action">
                                                                        <a href="javascript:void(0)" class="btn erp-action-btn erp-action-btn-sm" onclick="editAccountItem({{$coa_account->id}})"><i class="fa-regular fa-edit"></i></a>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="coa-single-account2">
                                                        <p class="no-account-txt mb-0">
                                                            You haven't added any Other {{ $coa_sub_category->name }} accounts yet
                                                        </p>
                                                    </div>
                                                @endif
                                                @if(hasPermission('manage-chart-of-accounts'))
                                                    @if($coa_sub_category->can_create_account == $coa_sub_category::CAN_CREATE_ACCOUNT_YES)
                                                        <div class="accounting-list-item d-flex flex-wrap align-items-center justify-content-start">
                                                            <div class="accounting-new-account-wrapper">
                                                                <a href="javascript:void(0)" class="btn erp-action-btn erp-action-btn-sm" onclick="addNewAccount({{ $coa_sub_category->id }})"><i class="fa-regular fa-plus"></i> Add a New Account</a>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

        </div>


    </div>
</div>
