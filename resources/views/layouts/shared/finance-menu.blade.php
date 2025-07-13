{{-- This is Finance Menu blade --}}
@can('view-finance-management')
  {{-- start of Salary Advance Request --}}
  @can('view-finance-management')
  <li class="nav-item ">
      <a href="{{ route('advance_salary_requests.index') }}"
          class="text-color nav-link  {{ request()->routeIs('advance_salary_requests.*') ? 'active' : null }} ">
          <i class="ph-receipt text-color"></i>
          <span>Salary Advances</span>
      </a>
  </li>
  @endcan

  {{-- end of Salary Advance Request --}}
    {{-- For Balance Disbursement --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('flex.transfer-balance') ||
         request()->routeIs('flex.all-disbursed-balances') ||
         request()->routeIs('flex.show-balance')||
         request()->routeIs('flex.add-balance') ||
         request()->routeIs('flex.edit-balance')
            ? 'active'
            : null }}"
            href="{{ route('flex.all-disbursed-balances') }}">
            <i class="ph-wallet"></i>
            Balance Disbursement
        </a>
    </li>
    {{-- ./ --}}

    {{-- For Balance Disbursement --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('flex.all-employee-disbursed-balances')
            ? 'active'
            : null }}"
            href="{{ route('flex.all-employee-disbursed-balances') }}">
            <i class="ph-money"></i>
            Employee Retirements
        </a>

    </li>

    {{-- ./ --}}


    {{-- For Payroll Inputs --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('finance_payroll_input_ledgers.index') ? 'active' : null }}"
            href="{{ route('finance_payroll_input_ledgers.index') }}">
            <i class="ph-printer"></i>
            Payroll Expenses
        </a>
    </li>
    {{-- ./ --}}

    {{-- For Assets Values --}}
    @can('view-settings-menu')
        <li class="nav-item ">
            <a href="{{ route('flex.all-assets-data') }}"
                class="nav-link {{ request()->routeIs('flex.flex.payment_history') ? 'active' : null }}">
                <i class="ph-book me-2"></i>
                <span>Asset Values</span>
            </a>
        </li>
    @endcan
    {{-- ./ --}}

    {{-- Start of Administration Expense Requests --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admistration-expenses.create') ||
        request()->routeIs('admistration-expenses.edit') ||
        request()->routeIs('flex.admistration-show') ||
        request()->routeIs('admistration-expenses.index')
            ? 'active'
            : null }}"
            href="{{ route('admistration-expenses.index') }}">
            <i class="ph-credit-card"></i>
            <span>Administration </span>
        </a>
    </li>
    {{-- ./ --}}


    {{-- For Debtor Invoices --}}
    <li class="nav-item visually-hidden">
        <a href="{{ route('finance.debtor-invoice') }}"
            class="nav-link  {{ request()->routeIs('finance.debtor-invoice') || request()->routeIs('finance.create-debtor-invoice')
                ? 'active'
                : null }}">
            <i class="ph ph-files"></i>
            <span>Debtor Invoices </span>
        </a>
    </li>
    {{-- ./ --}}

    {{-- For Debtor Invoices --}}
    @can('view-debtor-payments')
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('flex.add-debtor-payments') ||
            // request()->routeIs('flex.all-debtor-payments') ||
            request()->routeIs('flex.initiated-show')
                ? 'active'
                : null }}"
                href="{{ route('finance.debtor-invoice') }}">
                <i class="ph-receipt"></i>
                Debtor Invoices
            </a>
        </li>
    @endcan
    {{-- ./ --}}

    {{-- For Debtors Payment --}}
    @can('view-debtor-payments')
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('flex.add-debtor-payments') ||
            request()->routeIs('flex.all-debtor-payments') ||
            request()->routeIs('flex.initiated-show')
                ? 'active'
                : null }}"
                href="{{ route('flex.all-debtor-payments') }}">
                <i class="ph-user"></i>
                Debtor Payment
            </a>

        </li>
    @endcan
    {{-- ./ --}}

    {{-- For Creditors Payment --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('flex.all-creditor-payments') || request()->routeIs('flex.add-creditor-payments')
            ? 'active'
            : null }}"
            href="{{ route('flex.all-creditor-payments') }}">
            <i class="ph-user"></i>
            Creditor Payment
        </a>

    </li>
    {{-- ./ --}}

    {{-- Start of Store Requests --}}
    @can('view-store-request-management')
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('flex.store-request') ||
            request()->routeIs('flex.store-request.create') ||
            request()->routeIs('flex.store-request.show') ||
            request()->routeIs('flex.store-request.show.single') ||
            request()->routeIs('flex.store-request.edit')
                ? 'active'
                : null }}"
                href="{{ route('flex.store-request') }}">
                <i class="ph-house-simple "></i>
                Procurement Request
            </a>
        </li>
    @endcan
    {{-- ./ --}}

    {{-- Start of Procurement Payments --}}
    @can('view-procurement-payments')
        <li class="nav-item" hidden>
            <a class="nav-link {{ request()->routeIs('flex.payment-index') || request()->routeIs('flex.payment-show') ? 'active' : null }}"
                href="{{ route('flex.payment-index') }}">
                <i class="ph-files"></i>
                Invoice Payments
            </a>
        </li>
    @endcan
    {{-- / --}}

    {{-- Start of Procurements Approvals --}}
    @can('view-procurement-approvals')
        <li class="nav-item">
            <a
            href="{{ route('flex.initiated-index') }}"
                class="nav-link {{ request()->routeIs('flex.initiated-index') || request()->routeIs('flex.initiated-show') ? 'active' : null }}">
                <i class="ph-files"></i>
                <span>Vendors Approval</span>
            </a>
        </li>
     
    @endcan
    {{-- / --}}

    {{-- Start of Currency Management --}}
    @can('view-currencies')
        <li class="nav-item ">
            <a href="{{ route('currencies.index') }}"
                class="nav-link {{ request()->routeIs('currencies.*') ? 'active' : null }} ">
                <i class="ph-coin"></i>
                <span>Currency </span>
            </a>
        </li>
    @endcan
    {{-- ./ --}}
@endcan
{{-- / --}}
