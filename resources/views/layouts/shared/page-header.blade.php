<div class="page-header-content d-lg-flex border-top">
    <div class="d-flex">
        <div class="breadcrumb py-2">
            <a href="#" class="breadcrumb-item"><i class="ph-house"></i></a>

            @if(isset($parent))
            <a href="#" class="breadcrumb-item">{{ $parent }}</a>
            @endif

            @if ( isset($child) )
                <span class="breadcrumb-item active">{{ isset($child) ? $child : " " }}</span>
            @endif
        </div>

        <a href="#breadcrumb_elements"
            class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto"
            data-bs-toggle="collapse">
            <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
        </a>


    </div>
</div>
