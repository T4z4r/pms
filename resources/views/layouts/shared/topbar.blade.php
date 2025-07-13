{{-- Main navbar --}}
<div {{--  bg-black text-diana border-bottom border-bottom-diana  --}} class="navbar bg-main navbar-expand-lg navbar-static border-opacity-10">
    <div class="container-fluid">
        <div class="d-flex d-lg-none me-2">
            <button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
                <i class="ph-list text-brand-secondary"></i>
            </button>
        </div>

        <div class="navbar-brand flex-1 flex-lg-0">
            <a href="index.html" class="d-inline-flex align-items-center">
                {{-- <img src="{{ asset('img/business_panel_header_bg.png') }}" alt=""> --}}
                {{-- <img src="{{ asset('storage/brand_settings/company_logo.png') }}" class="d-none d-sm-inline-block h-16px ms-3" alt=""> --}}
            </a>
        </div>


        {{--  start of Top Searc bar --}}
        <div class="col ">
            <div class="searchable-dropdown float-end">
                <input type="text" class="search-input form-control" placeholder="Search page here...">
                <div class="dropdown-list d-none">

                    <ul class="list-group">
                        <li class="list-group-item"><a class="text-dark" href="{{ route('dashboard') }}"> <i
                                    class="ph-house"></i> Dashboard</a></li>
                    </ul>
                </div>
            </div>
            <script>
                // script.js
                document.addEventListener('DOMContentLoaded', function() {
                    const dropdownSelect = document.querySelector('.searchable-dropdown');
                    const input = dropdownSelect.querySelector('.search-input');
                    const dropdownList = dropdownSelect.querySelector('.dropdown-list');

                    input.addEventListener('input', function(event) {
                        const query = event.target.value.toLowerCase().trim();
                        const items = dropdownList.querySelectorAll('.list-group-item');

                        items.forEach(function(item) {
                            const text = item.textContent.toLowerCase();
                            if (text.includes(query) || query === '') {
                                item.style.display = 'block';
                            } else {
                                item.style.display = 'none';
                            }
                        });

                        // Show/hide the dropdown list based on search input
                        if (query === '') {
                            dropdownList.classList.add('d-none');
                        } else {
                            dropdownList.classList.remove('d-none');
                        }
                    });

                    // Hide the dropdown list when clicking outside
                    document.addEventListener('click', function(event) {
                        if (!dropdownSelect.contains(event.target)) {
                            dropdownList.classList.add('d-none');
                        }
                    });
                });
            </script>
        </div>
        {{-- ./ --}}


        <ul class="nav flex-row justify-content-end order-1 order-lg-2">
            <li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
                <a href="#" class="navbar-nav-link align-items-center rounded-pill p-1" data-bs-toggle="dropdown">
                    <div class="status-indicator-container">
                        @php
                            $profilePicturePath = 'storage/profile/' . Auth::user()->profile_picture;
                        @endphp

                        @if (Auth::user()->profile_picture && file_exists(public_path($profilePicturePath)))
                            <img src="{{ asset($profilePicturePath) }}" class="w-32px h-32px rounded-pill"
                                alt="Profile Picture">
                        @else
                            <img src="{{ asset('img/user.jpg') }}" class="w-32px h-32px rounded-pill"
                                alt="Default Image">
                        @endif

                        <span class="status-indicator bg-success"></span>
                    </div>
                    <span class="d-none d-lg-inline-block text-diana mx-lg-2">{{ Auth()->user()->name }}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-end">
                    <a href="{{ url('profile.index') }}" class="dropdown-item">
                        <i class="ph-user-circle me-2"></i>
                        My profile
                    </a>

                    <div class="dropdown-divider"></div>
                    {{-- <a href="#" class="dropdown-item">
                        <i class="ph-gear me-2"></i>
                        Account settings
                    </a> --}}

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <a href="{{ route('logout') }}" class="dropdown-item"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="ph-sign-out me-2"></i>
                            Logout
                        </a>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</div>
{{-- /main navbar --}}
