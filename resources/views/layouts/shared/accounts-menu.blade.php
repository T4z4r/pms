{{-- Accounts Menu --}}
<li class="nav-item nav-item-submenu {{
    request()->routeIs([
        'flex.account.*',
        'flex.general-ledger',
        'flex.all-ledgers',
        'flex.account.transaction',
        'flex.trial-balance',
        'flex.income-statement',
        'flex.balance-sheet',
        'flex.profit-loss',
        'flex.account.setting.*',
        'flex.account.group*',
        'flex.financial_statement',
        'flex.filter-report',
        'flex.common-costs',
        'flex.common-return-costs',
        'flex.fuel-costs',
        'flex.offbudgets',
        'flex.workshop.setting.breakdown.fund',
    ]) ? 'nav-item-expanded nav-item-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="ph-calculator"></i>
        <span>Accounts Menu</span>
    </a>

    <ul class="nav-group-sub collapse {{
        request()->routeIs([
            'flex.account.*',
            'flex.general-ledger',
            'flex.all-ledgers',
            'flex.account.transaction',
            'flex.trial-balance',
            'flex.income-statement',
            'flex.balance-sheet',
            'flex.profit-loss',
            'flex.account.setting.*',
            'flex.account.group*',
            'flex.financial_statement',
            'flex.filter-report',
            'flex.common-costs',
            'flex.common-return-costs',
            'flex.fuel-costs',
            'flex.offbudgets',
            'flex.workshop.setting.breakdown.fund',
        ]) ? 'show' : '' }}">

        @can('view-financial-accounts')
            <li class="nav-item nav-item-submenu {{
                request()->routeIs([
                    'flex.account.transaction*',
                    'flex.general-ledger',
                    'flex.all-ledgers',
                    'flex.trial-balance',
                    'flex.income-statement',
                    'flex.balance-sheet',
                    'flex.profit-loss',
                ]) ? 'nav-item-expanded nav-item-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="ph-books"></i>
                    <span>Accounting</span>
                </a>
                <ul class="nav-group-sub collapse {{
                    request()->routeIs([
                        'flex.account.transaction*',
                        'flex.general-ledger',
                        'flex.all-ledgers',
                        'flex.trial-balance',
                        'flex.income-statement',
                        'flex.balance-sheet',
                        'flex.profit-loss',
                    ]) ? 'show' : '' }}">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('flex.account.transaction') ? 'active' : '' }}"
                           href="{{ route('flex.account.transaction') }}">
                            Transactions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('flex.general-ledger') ? 'active' : '' }}"
                           href="{{ route('flex.general-ledger') }}">
                            General Ledger
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('flex.all-ledgers') ? 'active' : '' }}"
                           href="{{ route('flex.all-ledgers') }}">
                            Ledgers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('flex.trial-balance') ? 'active' : '' }}"
                           href="{{ route('flex.trial-balance') }}">
                            Trial Balance
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('flex.balance-sheet') ? 'active' : '' }}"
                           href="{{ route('flex.balance-sheet') }}">
                            Balance Sheet
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('flex.profit-loss') ? 'active' : '' }}"
                           href="{{ route('flex.profit-loss') }}">
                            Income Statement 1
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('flex.income-statement') ? 'active' : '' }}"
                           href="{{ route('flex.income-statement') }}">
                            Income Statement 2
                        </a>
                    </li>
                </ul>
            </li>
        @endcan

        @can('view-charts-accounts')
            <li class="nav-item nav-item-submenu {{
                request()->routeIs(['flex.account.group*', 'flex.account.setting.*']) ? 'nav-item-expanded nav-item-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="ph-calculator"></i>
                    <span>Charts of Accounts</span>
                </a>
                <ul class="nav-group-sub collapse {{
                    request()->routeIs(['flex.account.group*', 'flex.account.setting.*']) ? 'show' : '' }}">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('flex.account.group.sub.ledger.sub_ledger') ? 'active' : '' }}"
                           href="{{ route('flex.account.group.sub.ledger.sub_ledger') }}">
                            Sub Ledger Accounts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('flex.account.group.sub.ledger') ? 'active' : '' }}"
                           href="{{ route('flex.account.group.sub.ledger') }}">
                            Ledger Accounts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('flex.account.group.sub') ? 'active' : '' }}"
                           href="{{ route('flex.account.group.sub') }}">
                            Sub Accounts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('flex.account.group') ? 'active' : '' }}"
                           href="{{ route('flex.account.group') }}">
                            Accounts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('flex.account.setting.account_type') ? 'active' : '' }}"
                           href="{{ route('flex.account.setting.account_type') }}">
                            Account Types
                        </a>
                    </li>
                </ul>
            </li>
        @endcan

        @can('view-financial-statements')
            <li class="nav-item nav-item-submenu {{
                request()->routeIs(['flex.financial_statement', 'flex.filter-report']) ? 'nav-item-expanded nav-item-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="ph-books"></i>
                    <span>Accounts Reports</span>
                </a>
                <ul class="nav-group-sub collapse {{
                    request()->routeIs(['flex.financial_statement', 'flex.filter-report']) ? 'show' : '' }}">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('flex.financial_statement') ? 'active' : '' }}"
                           href="{{ route('flex.financial_statement') }}">
                            Financial Statements
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('flex.filter-report') ? 'active' : '' }}"
                           href="{{ route('flex.filter-report') }}">
                            All Statement Reports
                        </a>
                    </li>
                </ul>
            </li>
        @endcan

        @can('view-accounting-setting')
            <li class="nav-item nav-item-submenu {{
                request()->routeIs([
                    'flex.account.setting.*',
                    'licences.*',
                    'taxes.*',
                    'flex.common-costs',
                    'flex.common-return-costs',
                    'flex.fuel-costs',
                    'flex.offbudgets',
                    'flex.workshop.setting.breakdown.fund',
                ]) || in_array(request()->path(), [
                    'settings/common-admin-costs',
                    'settings/common-bulk-costs',
                    'accounts/all-incomes',
                    'accounts/all-methods',
                ]) ? 'nav-item-expanded nav-item-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="ph-gear"></i>
                    <span>Accounting Settings</span>
                </a>
                <ul class="nav-group-sub collapse {{
                    request()->routeIs([
                        'flex.account.setting.*',
                        'licences.*',
                        'taxes.*',
                        'flex.common-costs',
                        'flex.common-return-costs',
                        'flex.fuel-costs',
                        'flex.offbudgets',
                        'flex.workshop.setting.breakdown.fund',
                    ]) || in_array(request()->path(), [
                        'settings/common-admin-costs',
                        'settings/common-bulk-costs',
                        'accounts/all-incomes',
                        'accounts/all-methods',
                    ]) ? 'show' : '' }}">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('flex.account.setting.events') ? 'active' : '' }}"
                           href="{{ route('flex.account.setting.events.index') }}">
                            All Events
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('flex.account.setting.mapping') ? 'active' : '' }}"
                           href="{{ route('flex.account.setting.mapping') }}">
                            Event Mapping
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('licences.index') ? 'active' : '' }}"
                           href="{{ route('licences.index') }}">
                            Licences
                        </a>
                    </li>
                    @can('view-taxes')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('taxes.index') ? 'active' : '' }}"
                               href="{{ route('taxes.index') }}">
                                System Taxes
                            </a>
                        </li>
                    @endcan
                    @can('finance-trips')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('flex.common-costs') ? 'active' : '' }}"
                               href="{{ route('flex.common-costs') }}">
                                Common Route Expenses
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('flex.common-return-costs') ? 'active' : '' }}"
                               href="{{ route('flex.common-return-costs') }}">
                                Return Expenses
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('flex.fuel-costs') ? 'active' : '' }}"
                               href="{{ route('flex.fuel-costs') }}">
                                Trip Fuel Expenses
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('flex.offbudgets') ? 'active' : '' }}"
                               href="{{ route('flex.offbudgets') }}">
                                Out of Budget Expenses
                            </a>
                        </li>
                    @endcan
                    <li class="nav-item">
                        <a class="nav-link {{ request()->path() === 'settings/common-admin-costs' ? 'active' : '' }}"
                           href="{{ url('/settings/common-admin-costs') }}">
                            Administration Expenses
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->path() === 'settings/common-bulk-costs' ? 'active' : '' }}"
                           href="{{ url('/settings/common-bulk-costs') }}">
                            Bulk Expenses
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->path() === 'accounts/all-incomes' ? 'active' : '' }}"
                           href="{{ url('/accounts/all-incomes') }}">
                            Other Income
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->path() === 'accounts/all-methods' ? 'active' : '' }}"
                           href="{{ url('/accounts/all-methods') }}">
                            Payment Method
                        </a>
                    </li>
                    @can('finance-trips')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('flex.workshop.setting.breakdown.fund') ? 'active' : '' }}"
                               href="{{ route('flex.workshop.setting.breakdown.fund') }}">
                                Workshop Expenses
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
    </ul>
</li>
