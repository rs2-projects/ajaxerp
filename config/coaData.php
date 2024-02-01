<?php
return [
    'chart_of_accounts' => [
        'assets' => [
            'name' => 'Assets',
            'description' => null,
            'sub_categories' => [
                'cash_and_bank' => [
                    'name' => 'Cash and Bank',
                    'slug' => 'cash-and-bank',
                    'type' => 'accounts',
                    'description' => "Use this to focus attention on the amount of money that is currently available for use. Bank accounts, register cash boxes, money boxes, and electronic accounts like PayPal are a few examples of this.",
                    'can_create_account' => 1,
                    'is_sales_tax' => 0,
                    'accounts' => [
                        [
                            'name' => 'Cash on Hand',
                            'slug' => 'cash-on-hand',
                            'description' => "Cash you haven’t deposited in the bank. Add your bank and credit card accounts to accurately categorize transactions that aren't cash.",
                            'is_default' => 1,
                            'can_edit' => 0
                        ]
                    ] //will be cash on hand
                ],
                'money_in_transit' => [
                    'name' => 'Money in Transit',
                    'slug' => 'money-in-transit',
                    'type' => 'non_accounts',
                    'description' => "Use this to monitor the amount of money that will be deposited, withdrawn from, or withdrawn into a Cash and Bank account at a future time, often within days. Examples include processing credit card sales that haven't yet been put into your bank or checks (made or received) that haven't been deposited into or withdrawn from your bank account.",
                    'can_create_account' => 1,
                    'is_sales_tax' => 0,
                    'accounts' => []
                ],
                'expected_payments_from_customers' => [
                    'name' => 'Expected Payments from Customers',
                    'slug' => 'expected-payments-from-customers',
                    'type' => 'non_accounts',
                    'description' =>  "Use this to keep track of the amount your clients owe you following a sale. Wave already tracks invoices under the Accounts Receivable category",
                    'can_create_account' => 1,
                    'is_sales_tax' => 0,
                    'accounts' => [
                        [
                            'name' => 'Accounts Receivable',
                            'slug' => 'accounts-receivable',
                            'description' => "",
                            'is_default' => 0,
                            'can_edit' => 0
                        ]
                    ]
                ],
                'inventory' => [
                    'name' => 'Inventory',
                    'slug' => 'inventory',
                    'type' => 'non_accounts',
                    'description' =>  "Use this to keep track of the cost of actual goods that you have in warehouse or a retail outlet and are awaiting sale or completion.",
                    'can_create_account' => 1,
                    'is_sales_tax' => 0,
                    'accounts' => []
                ],
                'property_plant_equipment' => [
                    'name' => 'Property, Plant, Equipment',
                    'slug' => 'property-plant-equipment',
                    'type' => 'non_accounts',
                    'description' =>  "Things that are part of your regular business operations but which you do not sell to clients.",
                    'can_create_account' => 1,
                    'is_sales_tax' => 0,
                    'accounts' => []
                ],
                'depreciation_and_amortization' => [
                    'name' => 'Depreciation and Amortization',
                    'slug' => 'depreciation-and-amortization',
                    'type' => 'non_accounts',
                    'description' =>  "Use this to monitor the inflation of your possessions. In fact, when you buy equipment for your firm, it depreciates over time. There is never a balance greater than 0 in these areas (negative).",
                    'can_create_account' => 1,
                    'is_sales_tax' => 0,
                    'accounts' => []
                ],
                'vendor_prepayments_and_vendor_credits' => [
                    'name' => 'Vendor Prepayments and Vendor Credits',
                    'slug' => 'vendor-prepayments-and-vendor-credits',
                    'type' => 'non_accounts',
                    'description' =>  "Use this to keep track of the amount of merchandise or services a vendor still owes you after receiving your upfront payments. Examples of this include paying upfront for insurance at the start of the year or for several years, as well as receiving a credit note from a vendor. Over time, as the vendor must offer you progressively fewer goods and services, the category's balance will decline.",
                    'can_create_account' => 1,
                    'is_sales_tax' => 0,
                    'accounts' => []
                ],
                'other_short_term_asset' => [
                    'name' => 'Other Short-Term Asset',
                    'slug' => 'other-short-term-asset',
                    'type' => 'non_accounts',
                    'description' =>  "When none of the other asset account types apply, use this to keep track of amounts that you are due this year. You are owed money beyond this year, and that money is tracked in other Long-Term Asset accounts. These accounts will be listed in the balance sheet's Other Current Assets column.",
                    'can_create_account' => 1,
                    'is_sales_tax' => 0,
                    'accounts' => []
                ],
                'other_long_term_asset' => [
                    'name' => 'Other Long-Term Asset',
                    'slug' => 'other-long-term-asset',
                    'type' => 'non_accounts',
                    'description' =>  "Use this to keep track of money you are owed after this year when none of the other types of asset accounts work. Other accounts for short-term assets are used to keep track of money you are owed this year. These accounts will be listed on the balance sheet under 'Long-term Assets.'",
                    'can_create_account' => 1,
                    'is_sales_tax' => 0,
                    'accounts' => []
                ]
                //end of assets
            ]
        ],
        'liabilities_and_credit_cards' => [
            'name' => 'Liabilities & Credit Cards',
            'description' => null,
            'sub_categories' => [
                'credit_card' => [
                    'name' => 'Credit Card',
                    'slug' => 'credit-cart',
                    'type' => 'accounts',
                    'description' =>  "Use this to keep track of what you've bought with your credit card. Set up a separate account for each credit card your business uses. Purchases made with your credit card and payments to your credit card should be put in the proper credit card category.",
                    'can_create_account' => 1,
                    'is_sales_tax' => 0,
                    'accounts' => []
                ],
                'loan_and_line_of_credit' => [
                    'name' => 'Loan and Line of Credit',
                    'slug' => 'loan-and-line-of-credit',
                    'type' => 'non_accounts',
                    'description' =>  "Use this to keep track of how much you still charge on loans or withdrawals made from a credit limit. When you get a credit line, the money you get is put into a section called Cash and Bank.",
                    'can_create_account' => 1,
                    'is_sales_tax' => 0,
                    'accounts' => []
                ],
                'expected_payments_to_vendors' => [
                    'name' => 'Expected Payments to Vendors',
                    'slug' => 'expected-payments-to-vendors',
                    'type' => 'non_accounts',
                    'description' =>  "Use this to keep track of the amount you still owe vendors (such as suppliers or digital subscription providers) for goods or services you received but have not yet paid for. Wave already tracks bills under the Accounts Payable category.",
                    'can_create_account' => 1,
                    'is_sales_tax' => 0,
                    'accounts' => [
                        [
                            'name' => 'Accounts Payable',
                            'slug' => 'accounts-payable',
                            'description' => "",
                            'is_default' => 0,
                            'can_edit' => 0
                        ]
                    ]
                ],
                'sales_taxes' => [
                    'name' => 'Sales Taxes',
                    'slug' => 'sales-taxes',
                    'type' => 'non_accounts',
                    'description' =>  "Use this to keep track of the sales taxes you've collected from customers during a transaction and the amount of sales taxes you've paid to the government. How much you owe the government is indicated by the balance of this category. In order to lower the amount of sales taxes you have to pay to the government, you may also use this category to track the sales taxes you have been charged on purchases. A category is automatically established for you here if you create a sales tax in Wave.",
                    'can_create_account' => 0,
                    'is_sales_tax' => 1,
                    'accounts' => []
                ],
                'due_for_payroll' => [
                    'name' => 'Due For Payroll',
                    'slug' => 'due-for-payroll',
                    'type' => 'non_accounts',
                    'description' =>  "Use this to keep track of all bills associated with paying employees and processing payroll. Along with salaries, wages, and reimbursements to employees, this also includes all payroll taxes that need to be paid to government organizations and other tax collectors (ie; insurance agencies and health savings providers).",
                    'can_create_account' => 1,
                    'is_sales_tax' => 0,
                    'accounts' => []
                ],
                'due_to_you_and_other_business_owners' => [
                    'name' => 'Due to You and Other Business Owners',
                    'slug' => 'due-to-you-and-other-business-owners',
                    'type' => 'non_accounts',
                    'description' =>  "Use this to keep track of the total amount of personal loans you (or your partners) have made to the company and anticipate to be reimbursed for. If you (or your partners) have received loans from the company, you can track them in the same category; in that case, the balance would be less than zero (negative).",
                    'can_create_account' => 1,
                    'is_sales_tax' => 0,
                    'accounts' => []
                ],
                'customer_prepayments_and_customer_credits' => [
                    'name' => 'Customer Prepayments and Customer Credits',
                    'slug' => 'customer-prepayments-and-customer-credits',
                    'type' => 'non_accounts',
                    'description' =>  "Use this to keep track of the cost of the good or service that you still owe a customer because they paid you in advance. As an illustration, consider receiving a deposit or retainer from a client or issuing a credit note to them. As you deliver the good or service to the customer, the category's balance will gradually decline.",
                    'can_create_account' => 1,
                    'is_sales_tax' => 0,
                    'accounts' => []
                ],
                'other_short_term_liability' => [
                    'name' => 'Other Short-Term Liability',
                    'slug' => 'other-short-term-liability',
                    'type' => 'non_accounts',
                    'description' =>  "When none of the other liability account types apply, use this to keep track of the payments you owe this year. You can keep track of the amount you owe after this year to use other Long-Term Liability accounts. These accounts will be listed in the balance sheet's Current Liabilities column.",
                    'can_create_account' => 1,
                    'is_sales_tax' => 0,
                    'accounts' => []
                ],
                'other_long_term_liability' => [
                    'name' => 'Other Long-Term Liability',
                    'slug' => 'other-long-term-liability',
                    'type' => 'non_accounts',
                    'description' =>  "When none of the other liability account types apply, use this to keep track of amounts that you owe beyond this year. You can keep track of the money you owe this year using other Short-Term Liability accounts. These accounts will be listed in the balance sheet's Long-term Liabilities section.",
                    'can_create_account' => 1,
                    'is_sales_tax' => 0,
                    'accounts' => []
                ],
            ]
        ],
        'income' => [
            'name' => 'Income',
            'description' => null,
            'sub_categories' => [
                'income' => [
                    'name' => 'Income',
                    'slug' => 'income',
                    'type' => 'non_accounts',
                    'description' =>  "Use this to keep track of all customer purchases, whether or not the buyer has paid. When you produce an invoice in Al-Hisab, these categories are used. Any sales taxes charged to customers will be reported using a Sales Taxes on Sales or Purchases category rather than a Sales category.",
                    'can_create_account' => 1,
                    'is_sales_tax' => 0,
                    'accounts' => [
                        [
                            'name' => 'Sales',
                            'slug' => 'sales',
                            'description' => "",
                            'is_default' => 0,
                            'can_edit' => 0
                        ]
                    ]
                ],
                'sale_return' => [
                    'name' => 'Sale Return',
                    'slug' => 'sale-return',
                    'type' => 'non_accounts',
                    'description' =>  "Use this to keep track of all customer sale return. When customer return some goods of an invoice in Al-Hisab, these categories are used.",
                    'can_create_account' => 0,
                    'is_sales_tax' => 0,
                    'accounts' => [
                        [
                            'name' => 'Sale Return',
                            'slug' => 'sale-return',
                            'description' => "",
                            'is_default' => 0,
                            'can_edit' => 0
                        ]
                    ]
                ],
                'discount' => [
                    'name' => 'Discount',
                    'slug' => 'discount',
                    'type' => 'non_accounts',
                    'description' =>  "Use this to keep track of the discounts you've offered to clients so you can review whether you're offering too many. Discounts decrease your income, therefore they'll appear as a loss on your profit and loss report.",
                    'can_create_account' => 1,
                    'is_sales_tax' => 0,
                    'accounts' => [
                        [
                            'name' => 'Sales Discounts',
                            'slug' => 'sales-discounts',
                            'description' => "Sales Discounts reduce the price of a product or service that is offered to customers. Discounts reduce your Sales, which is why it will be shown as a negative amount on the Profit & Loss report.",
                            'is_default' => 0,
                            'can_edit' => 0
                        ]
                    ]
                ],
                'other_income' => [
                    'name' => 'Other Income',
                    'slug' => 'other-income',
                    'type' => 'non_accounts',
                    'description' =>  "Use this to keep track of any additional revenue that comes in from sources other than the sales you make to clients on a regular basis. For instance, renting your camera to a friend for a one-time session while your primary line of work is photography could be considered additional revenue.",
                    'can_create_account' => 1,
                    'is_sales_tax' => 0,
                    'accounts' => []
                ],
                'uncategorized_income' => [
                    'name' => 'Uncategorized Income',
                    'slug' => 'uncategorized-income',
                    'type' => 'non_accounts',
                    'description' =>  "The default category for new deposit transactions is this account.",
                    'can_create_account' => 0,
                    'is_sales_tax' => 0,
                    'accounts' => [
                        [
                            'name' => 'Uncategorized Income',
                            'slug' => 'uncategorized-income',
                            'description' => "Income you haven't categorized yet. Categorize it now to keep your records accurate.",
                            'is_default' => 1,
                            'can_edit' => 0
                        ]
                    ]
                ],
                'gain_on_foreign_exchange' => [
                    'name' => 'Gain On Foreign Exchange',
                    'slug' => 'gain-on-foreign-exchange',
                    'type' => 'non_accounts',
                    'description' =>  "The benefits that result from various exchange rates on foreign currency invoices, bills, and transfers are tracked in this account.",
                    'can_create_account' => 0,
                    'is_sales_tax' => 0,
                    'accounts' => [
                        [
                            'name' => 'Gain on Foreign Exchange',
                            'slug' => 'gain-on-foreign-exchange',
                            'description' => "Foreign exchange gains happen when the exchange rate between your business's home currency and a foreign currency transaction changes and results in a gain. This can happen in the time between a transaction being entered in Wave and being settled, for example, between when you send an invoice and when your customer pays it. This can affect foreign currency invoice payments, bill payments, or foreign currency held in your bank account.",
                            'is_default' => 0,
                            'can_edit' => 0
                        ]
                    ]
                ],
            ]
        ],
        'expenses' => [
            'name' => 'Expenses',
            'description' => null,
            'sub_categories' => [
                'operating_expense' => [
                    'name' => 'Operating Expense',
                    'slug' => 'operating-expense',
                    'type' => 'non_accounts',
                    'description' =>  "Monitor the majority of your business expenses using this. There can be a category for each type of office, insurance, rent, utility, and subscription price.",
                    'can_create_account' => 1,
                    'is_sales_tax' => 0,
                    'accounts' => [
                        [
                            'name' => 'Rent & Bills',
                            'slug' => 'rent-and-bills',
                            'description' => "",
                            'is_default' => 0,
                            'can_edit' => 1
                        ],
                        [
                            'name' => 'Repair & Maintenance',
                            'slug' => 'repair-and-maintenance',
                            'description' => "",
                            'is_default' => 0,
                            'can_edit' => 1
                        ],
                        [
                            'name' => 'Other Utilities',
                            'slug' => 'other-utilities',
                            'description' => "",
                            'is_default' => 0,
                            'can_edit' => 1
                        ],
                        [
                            'name' => 'Office Accessories',
                            'slug' => 'office-accessories',
                            'description' => "",
                            'is_default' => 0,
                            'can_edit' => 1
                        ],
                        [
                            'name' => 'Office Stationery',
                            'slug' => 'office-stationery',
                            'description' => "",
                            'is_default' => 0,
                            'can_edit' => 1
                        ],
                        [
                            'name' => 'Meals & Snacks',
                            'slug' => 'meals-and-snacks',
                            'description' => "",
                            'is_default' => 0,
                            'can_edit' => 1
                        ],
                        [
                            'name' => 'Transportation',
                            'slug' => 'transportation',
                            'description' => "",
                            'is_default' => 0,
                            'can_edit' => 1
                        ],
                        [
                            'name' => 'Tours & Travels',
                            'slug' => 'tours-and-travels',
                            'description' => "",
                            'is_default' => 0,
                            'can_edit' => 1
                        ]
                    ]
                ],
                'cost_of_goods_sold' => [
                    'name' => 'Cost of Goods Sold',
                    'slug' => 'cost-of-goods-sold',
                    'type' => 'non_accounts',
                    'description' =>  "Apply this to keep track of spending that is directly related to the goods or services you are selling. You should instead construct an Operating Expense category if a certain expense can't be linked to sales.",
                    'can_create_account' => 1,
                    'is_sales_tax' => 0,
                    'accounts' => [
                        [
                            'name' => 'Purchase Products',
                            'slug' => 'purchase-products',
                            'description' => "",
                            'is_default' => 0,
                            'can_edit' => 0
                        ],
                        [
                            'name' => 'Goods manufactured: Raw materials',
                            'slug' => 'goods-manufactured-raw-materials',
                            'description' => "",
                            'is_default' => 0,
                            'can_edit' => 1
                        ],
                        [
                            'name' => 'Goods manufactured: Direct Labor',
                            'slug' => 'goods-manufactured-direct-labor',
                            'description' => "",
                            'is_default' => 0,
                            'can_edit' => 1
                        ],
                        [
                            'name' => 'Overhead',
                            'slug' => 'overhead',
                            'description' => "",
                            'is_default' => 0,
                            'can_edit' => 1
                        ],
                    ]
                ],
                'payment_processing_fee' => [
                    'name' => 'Payment Processing Fee',
                    'slug' => 'payment-processing-fee',
                    'type' => 'non_accounts',
                    'description' =>  "Apply this to keep track of the costs associated with credit card payments made by your customers. You should still report this kind of spending even if it is often subtracted from the transfer or deposit into your bank account.",
                    'can_create_account' => 1,
                    'is_sales_tax' => 0,
                    'accounts' => [
                        [
                            'name' => 'Online Transaction fees',
                            'slug' => 'online-transaction-fees',
                            'description' => "",
                            'is_default' => 0,
                            'can_edit' => 1
                        ],
                        [
                            'name' => 'Bank Transaction fees',
                            'slug' => 'bank-transaction-fees',
                            'description' => "",
                            'is_default' => 0,
                            'can_edit' => 1
                        ],
                        [
                            'name' => 'Paypal Transaction fees',
                            'slug' => 'paypal-transaction-fees',
                            'description' => "",
                            'is_default' => 0,
                            'can_edit' => 1
                        ],
                    ]
                ],
                'payroll_expense' => [
                    'name' => 'Payroll Expense',
                    'slug' => 'payroll-expense',
                    'type' => 'non_accounts',
                    'description' =>  "Use this to keep track of the costs associated with processing and authorizing payroll for both paid and hourly workers. Unless you are an employee of the company, avoid using these categories to track payments to yourself.",
                    'can_create_account' => 1,
                    'is_sales_tax' => 0,
                    'accounts' => []
                ],
                'uncategorized_expense' => [
                    'name' => 'Uncategorized Expense',
                    'slug' => 'uncategorized-expense',
                    'type' => 'non_accounts',
                    'description' =>  "For new withdrawal transactions, this account is considered as the default category.",
                    'can_create_account' => 0,
                    'is_sales_tax' => 0,
                    'accounts' => [
                        [
                            'name' => 'Uncategorized Expense',
                            'slug' => 'uncategorized-expense',
                            'description' => "A business cost you haven't categorized yet. Categorize it now to keep your records accurate.",
                            'is_default' => 1,
                            'can_edit' => 0
                        ]
                    ]
                ],
                'loss_on_foreign_exchange' => [
                    'name' => 'Loss On Foreign Exchange',
                    'slug' => 'loss-on-foreign-exchange',
                    'type' => 'non_accounts',
                    'description' =>  "This account is intended to track losses resulting from variations in exchange rates on payments made in foreign currencies.",
                    'can_create_account' => 0,
                    'is_sales_tax' => 0,
                    'accounts' => [
                        [
                            'name' => 'Loss on Foreign Exchange',
                            'slug' => 'loss-on-foreign-exchange',
                            'description' => "Foreign exchange losses happen when the exchange rate between your business's home currency and a foreign currency transaction changes and results in a loss. This can happen in the time between a transaction being entered in Wave and being settled, for example, between when you send an invoice and when your customer pays it. This can affect foreign currency invoice payments, bill payments, or foreign currency held in your bank account.",
                            'is_default' => 0,
                            'can_edit' => 0
                        ]
                    ]
                ],
            ]
        ],
        'equity' => [
            'name' => 'Equity',
            'description' => null,
            'sub_categories' => [
                'business_owner_contribution' => [
                    'name' => 'Business Owner Contribution',
                    'slug' => 'business-owner-contribution',
                    'type' => 'non_accounts',
                    'description' =>  "Use this to keep track of any investments that you or others have made in the company. For instance, you often spend start-up funds into a business when you first launch it.",
                    'can_create_account' => 1,
                    'is_sales_tax' => 0,
                    'accounts' => [
                        [
                            'name' => 'Owner Investment',
                            'slug' => 'owner-investment',
                            'description' => "Owner investment represents the amount of money or assets you put into your business, either to start the business or keep it running. An owner's draw is a direct withdrawal from business cash or assets for your personal use.",
                            'is_default' => 0,
                            'can_edit' => 0
                        ]
                    ]
                ],
                'drawing' => [
                    'name' => 'Drawing',
                    'slug' => 'drawing',
                    'type' => 'non_accounts',
                    'description' =>  "Use this to keep track of any investments that you or others have made in the company. For instance, you often spend start-up funds into a business when you first launch it.",
                    'can_create_account' => 1,
                    'is_sales_tax' => 0,
                    'accounts' => [
                        [
                            'name' => 'Drawings',
                            'slug' => 'drawings',
                            'description' => "An owner's draw is a direct withdrawal from business cash or assets for your personal use.",
                            'is_default' => 0,
                            'can_edit' => 0
                        ]
                    ]
                ],
                'retained_earnings' => [
                    'name' => 'Retained Earnings',
                    'slug' => 'retained-earnings',
                    'type' => 'non_accounts',
                    'description' =>  "Can use this to keep track of the funds you have taken from the company.",
                    'can_create_account' => 1,
                    'is_sales_tax' => 0,
                    'accounts' => [
                        [
                            'name' => 'Owner\'s Equity',
                            'slug' => 'owners-equity',
                            'description' => "Owner's equity is what remains after you subtract business liabilities from business assets. In other words, it's what's left over for you if you sell all your assets and pay all your debts.",
                            'is_default' => 0,
                            'can_edit' => 0
                        ]
                    ]
                ],
            ]
        ]
    ]
];
