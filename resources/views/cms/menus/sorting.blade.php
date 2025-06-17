@extends('layouts.cms')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">{{ $title }}</h4>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('menus.index') }}"><i class="bi bi-list"></i> Menu</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-info">
                        {{ __('Drag and drop menus to reorder them. You can move items between main menu and submenu.') }}
                    </div>
                    <ul id="sortable" class="list-group">
                        @foreach($menus as $menu)
                            <li class="list-group-item" data-id="{{ $menu->id }}">
                                <div class="d-flex align-items-center drag-handle" style="cursor: move;">
                                    <i class="bi bi-grip-vertical me-2"></i>
                                    <i class="{{ $menu->icon }} me-3"></i> {{ $menu->name }}
                                </div>
                                @if($menu->children->count() > 0)
                                    <ul class="list-group mt-2 submenu">
                                        @foreach($menu->children as $child)
                                            <li class="list-group-item" data-id="{{ $child->id }}" data-parent="{{ $menu->id }}">
                                                <div class="d-flex align-items-center drag-handle" style="cursor: move;">
                                                    <i class="bi bi-grip-vertical me-2"></i>
                                                    <i class="{{ $child->icon }} me-3"></i> {{ $child->name }}
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <ul class="list-group mt-2 submenu"></ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* #sortable { 
        list-style-type: none; 
        margin: 0; 
        padding: 0; 
    }
    #sortable li { 
        margin: 0 3px 3px 3px; 
        padding: 0.4em; 
        padding-left: 1.5em; 
        font-size: 1.4em; 
        height: 18px; 
        background: var(--card-bg);
        border: 1px solid var(--border-color);
    }
    #sortable li i { 
        margin-right: 10px; 
        color: var(--text-muted);
    }
    .ui-sortable-helper { 
        background: var(--card-bg) !important; 
        border: 1px solid var(--border-color) !important;
    }
    #sortable ul { 
        margin-left: 20px; 
    }
    #sortable ul li { 
        font-size: 1.2em; 
    }
    .drag-handle { 
        cursor: move;
        color: var(--text-muted);
    }
    .drag-handle:hover { 
        color: var(--text-color);
    }
    #sortable li { 
        cursor: default; 
    }
    .submenu { 
        min-height: 10px; 
    }
    .ui-sortable-placeholder { 
        border: 1px dashed var(--border-color);
        background: var(--card-bg);
        visibility: visible !important;
    }
    */
    .list-group-item{
        background-color: var(--card-bg) !important;
    } 
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
$(function() {
    function updateOrder() {
        let order = [];
        $('#sortable > li').each(function(index) {
            let parentId = $(this).data('id');
            order.push({
                id: parentId,
                order: index + 1,
                children: []
            });

            // Get children order
            $(this).find('.submenu > li').each(function(childIndex) {
                order[order.length - 1].children.push({
                    id: $(this).data('id'),
                    order: childIndex + 1
                });
            });
        });

        $.ajax({
            url: '{{ route("menus.update-order") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                order: order
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        width: '350px'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        width: '350px'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to update menu order',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    width: '350px'
                });
            }
        });
    }

    // Initialize main menu sortable
    $("#sortable").sortable({
        items: "> li",
        handle: ".drag-handle",
        connectWith: ".submenu",
        update: updateOrder,
        placeholder: "ui-sortable-placeholder"
    });

    // Initialize submenu sortable
    $(".submenu").sortable({
        connectWith: "#sortable, .submenu",
        handle: ".drag-handle",
        update: updateOrder,
        placeholder: "ui-sortable-placeholder"
    });
});
</script>
@endpush