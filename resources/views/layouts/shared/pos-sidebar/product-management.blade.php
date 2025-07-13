   <li class="nav-item">
       <a class="nav-link {{ request()->routeIs('retails.*') ? 'active' : null }}"
           href="{{ route('retails.index') }}">
           Products
       </a>
   </li>

   <li class="nav-item">
       <a class="nav-link {{ request()->routeIs('retail-units.index') ? 'active' : null }}"
           href="{{ route('retail-units.index') }}">
           Product Units
       </a>
   </li>

   <li class="nav-item">
       <a class="nav-link {{ request()->routeIs('categories.index') ? 'active' : null }}"
           href="{{ route('categories.index') }}">
           Product Categories
       </a>
   </li>
