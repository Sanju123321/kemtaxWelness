@extends('frontend.layouts.member')

@section('title', 'My Dashboard')

@push('styles')
    <style>
                .sidebar-nav a.disabled, .sidebar-nav a.disabled:hover {
                    pointer-events: none;
                    color: #bbb !important;
                    background: #f8f9fa !important;
                    border-left-color: #eee !important;
                    opacity: 0.7;
                }
        .dashboard-header {
            background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
            padding: 20px 0;
            color: white;
            margin-bottom: 30px;
        }
.text-red {
    color: #dc3545; /* Bootstrap red */
}

.text-green {
    color: #28a745; /* Bootstrap green */
}

.text-grey {
    color: #6c757d;
}
        /* Genealogy Tree Styles */
        .genealogy-tree {
            display: flex;
            justify-content: center;
            padding: 30px 10px;
            overflow-x: auto;
        }

        .genealogy-tree ul {
            position: relative;
            padding: 20px 0;
            display: flex;
            justify-content: center;
        }

        .genealogy-tree li {
            list-style: none;
            text-align: center;
            position: relative;
            padding: 20px 15px 0;
        }

        .genealogy-tree li::before,
        .genealogy-tree li::after {
            content: '';
            position: absolute;
            top: 0;
            right: 50%;
            border-top: 2px solid #ccc;
            width: 50%;
            height: 20px;
        }

        .genealogy-tree li::after {
            right: auto;
            left: 50%;
            border-left: 2px solid #ccc;
        }

        .genealogy-tree li:only-child::after,
        .genealogy-tree li:only-child::before {
            display: none;
        }

        .genealogy-tree li:first-child::before,
        .genealogy-tree li:last-child::after {
            border: 0 none;
        }

        .genealogy-tree li:last-child::before {
            border-right: 2px solid #ccc;
            border-radius: 0 5px 0 0;
        }

        .genealogy-tree li:first-child::after {
            border-radius: 5px 0 0 0;
        }

        .genealogy-tree ul ul::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            border-left: 2px solid #ccc;
            width: 0;
            height: 20px;
        }

        .genealogy-tree .member-view-box {
            display: inline-block;
            position: relative;
            cursor: pointer;
        }

        .genealogy-tree .member-image {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            border: 4px solid #28a745;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            position: relative;
        }

        .genealogy-tree .member-image:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
        }

        .genealogy-tree .member-image img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        .genealogy-tree .member-image i {
            font-size: 2rem;
            color: white;
        }

        .genealogy-tree li.level-1 .member-image {
            border-color: #28a745;
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        }

        .genealogy-tree li.level-2 .member-image {
            border-color: #ffc107;
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        }

        .genealogy-tree li.level-3 .member-image {
            border-color: #17a2b8;
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        }

        .genealogy-tree .member-name {
            font-size: 13px;
            font-weight: 600;
            color: #333;
            margin-top: 8px;
        }

        .genealogy-tree .expand-icon {
            position: absolute;
            bottom: -5px;
            right: 5px;
            background: #28a745;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            border: 2px solid white;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .genealogy-tree .expand-icon:hover {
            background: #1e7e34;
            transform: rotate(90deg);
        }

        .genealogy-tree ul.hidden {
            display: none;
        }

        .genealogy-tree .no-children .expand-icon {
            display: none;
        }

                    {{-- Team Tree --}}
                    <div class="section-card">
                        <div class="section-card-header">
                            <i class="fas fa-sitemap mr-2 text-color"></i>My Team Genealogy
                        </div>
                        <div class="section-card-body">
                            <livewire:genealogy-tree />
                        </div>
                    </div>
            

   

@endsection


@push('scripts')

@endpush
