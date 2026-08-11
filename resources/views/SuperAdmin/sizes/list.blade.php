@extends('layouts.superadmin.app')
@section('content')

<main class="nxl-container">
    <div class="nxl-content">
        <!-- [ page-header ] start -->
       @include('layouts.superadmin.breadcrumbs')

        <!-- [ page-header ] end -->
        <!-- [ Main Content ] start -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        <div class="main-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card stretch stretch-full">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover" id="proposalList">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Brands Name</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($sizes as $key=>$list)
                                        <tr class="single-item">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <a href="javascript:void(0)" class="hstack gap-3">
                                                    <div class="avatar-image avatar-md">
                                                        <img src="{{ asset('storage/' . $list->logo) }}" alt=""
                                                            class="img-fluid">
                                                    </div>
                                                    <div>
                                                        <span
                                                            class="text-truncate-1-line">{{$list->brand_name}}</span>
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                @php
                                                if($list->status == 1){
                                                $activeOrDeactive = 'Active';
                                                $class = 'success';
                                                }else{
                                                $activeOrDeactive = 'Deactive';
                                                $class = 'danger';
                                                }
                                                @endphp
                                                <div class="badge bg-soft-{{ $class }} text-{{ $class }}">
                                                    {{$activeOrDeactive}}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2 text-end">
                                                    <div>
                                                        <button type="button"
                                                            class="avatar-text avatar-md bg-soft-warning text-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                            <i class="feather feather-eye"></i>
                                                        </button>
                                                    </div>
                                                    <div>
                                                        <a class="avatar-text avatar-md bg-soft-success text-success"
                                                            href="{{ route('super.admin.brand.edit',$list->id) }}">
                                                            <i class="feather feather-edit-3"></i>
                                                        </a>
                                                    </div>
                                                    <div>
                                                        <form action="{{ route('super.admin.brand.destroy',$list->id) }}"
                                                            method="POST"
                                                            class="d-inline"
                                                            onsubmit="return confirm('Are you sure you want to delete this Brand?');">

                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="border-0 bg-transparent p-0">
                                                                <span class="avatar-text avatar-md bg-soft-danger text-danger">
                                                                    <i class="feather feather-trash-2"></i>
                                                                </span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr> no data found </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Footer ] start -->
    <footer class="footer">
        <p class="fs-11 text-muted fw-medium text-uppercase mb-0 copyright">
            <span>Copyright ©</span>
            <script>
                document.write(new Date().getFullYear());
            </script>
        </p>
        <p>
            <span>By: <a target="_blank" href="https://wrapbootstrap.com/user/theme_ocean" target="_blank">theme_ocean</a></span> • <span>Distributed by: <a target="_blank" href="https://themewagon.com" target="_blank">Pushpendra Singh</a></span>
        </p>
        <div class="d-flex align-items-center gap-4">
            <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Help</a>
            <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Terms</a>
            <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Privacy</a>
        </div>
    </footer>
    <!-- [ Footer ] end -->
</main>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Brand Title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Comming soon.......
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection