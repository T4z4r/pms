   {{-- Start of Trips Payments --}}
   @can('view-trip-payments')
       <li class="nav-item ">
           <a href="{{ route('finance.all-trips') }}"
               class="nav-link  {{ request()->routeIs('finance.view-invoice') || request()->routeIs('finance.create-invoice') || request()->routeIs('finance.edit-invoice') || request()->routeIs('finance.trip-detail') || request()->routeIs('finance.all-trips') ? 'active' : null }}">
               <i class="ph ph-files"></i>
               <span>Trips Invoices </span>
           </a>
       </li>
   @endcan
   {{-- / --}}


   {{-- Start of Trips Payments --}}
   @can('view-trip-payments')
       <li class="nav-item ">
           <a href="{{ route('finance.all-trip-invoices') }}"
               class="nav-link  {{ request()->routeIs('finance.single-trip-invoice') || request()->routeIs('finance.all-trip-invoices') ? 'active' : null }}">
               <i class="ph-receipt"></i>
               <span>Invoice Receipts </span>
           </a>
       </li>
   @endcan
   {{-- / --}}

   {{-- For Debit Note --}}
   <li class="nav-item">
       <a class="nav-link {{ request()->routeIs('flex.all-debit-notes', 'flex.create-debit-note', 'flex.view-debit-note', 'flex.edit-debit-note') ? 'active' : null }}"
           href="{{ route('flex.all-debit-notes') }}">
           <i class="ph-file-pdf"></i>
           Debit Notes
       </a>
   </li>
   {{-- ./  --}}

   {{-- For Credit Note --}}
   <li class="nav-item">
       <a class="nav-link {{ request()->routeIs('flex.all-credit-notes', 'flex.create-credit-note', 'flex.view-credit-note', 'flex.edit-debit-note') ? 'active' : null }}"
           href="{{ route('flex.all-credit-notes') }}">
           <i class="ph-file-pdf"></i>
           Credit Notes
       </a>
   </li>
   {{-- ./ --}}
