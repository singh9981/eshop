@extends('layouts.superadmin.app')
@section('content')
    <main class="nxl-container">
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Proposal</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item">Create</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                        <div class="d-flex d-md-none">
                            <a href="javascript:void(0)" class="page-header-right-close-toggle">
                                <i class="feather-arrow-left me-2"></i>
                                <span>Back</span>
                            </a>
                        </div>
                        <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                            <a href="javascript:void(0);" class="btn btn-light-brand" data-bs-toggle="offcanvas"
                                data-bs-target="#proposalSent">
                                <i class="feather-layers me-2"></i>
                                <span>Save & Send</span>
                            </a>
                            <a href="javascript:void(0);" class="btn btn-primary successAlertMessage">
                                <i class="feather-save me-2"></i>
                                <span>Save</span>
                            </a>
                        </div>
                    </div>
                    <div class="d-md-none d-flex align-items-center">
                        <a href="javascript:void(0)" class="page-header-right-open-toggle">
                            <i class="feather-align-right fs-20"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- [ page-header ] end -->
            <!-- [ Main Content ] start -->
            <div class="main-content">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label class="form-label">Category <span class="text-danger">*</span></label>
                                            <input type="text" name="category" class="form-control"
                                                placeholder="Category">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label class="form-label">Sub Categorys <span class="text-danger">*</span></label>
                                            <select class="form-control" data-select2-selector="icon" name="sub_category">
                                                <option value="lead" data-icon="feather-at-sign">Lead</option>
                                                <option value="coustomer" data-icon="feather-users">Coustomer</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Category <span class="text-danger">*</span></label>
                                    <select class="form-control" data-select2-selector="icon" name="sub_category">
                                                <option value="1" data-icon="feather-at-sign">Activate</option>
                                                <option value="0" data-icon="feather-users">Deactivate</option>
                                            </select>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Related <span class="text-danger">*</span></label>
                                    <select class="form-control" data-select2-selector="icon">
                                        <option value="lead" data-icon="feather-at-sign">Lead</option>
                                        <option value="coustomer" data-icon="feather-users">Coustomer</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Lead <span class="text-danger">*</span></label>
                                    <select class="form-select" data-select2-selector="user">
                                        <option value="1" data-user="1">Alexandra Della - Website design and development</option>
                                        <option value="2" data-user="2">Curtis Green - User experience (UX) and user interface (UI) design</option>
                                        <option value="3" data-user="3">Marianne Audrey - Responsive and mobile design </option>
                                        <option value="4" data-user="4">Holland Scott - E-commerce website design and development</option>
                                        <option value="5" data-user="5">Olive Delarosa - Custom graphics and icon design</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Discount </label>
                                    <select class="form-select" data-select2-selector="default">
                                        <option value="">No Discount</option>
                                        <option value="">Before Tax</option>
                                        <option value="">After Tax</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Visibility:</label>
                                    <select class="form-select form-control" data-select2-selector="visibility">
                                        <option value="public" data-icon="feather-globe">Public</option>
                                        <option value="private" data-icon="feather-lock">Private</option>
                                        <option value="private" data-icon="feather-user">Personal</option>
                                        <option value="customs" data-icon="feather-settings">Customs</option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 mb-4">
                                        <label class="form-label">Start <span class="text-danger">*</span></label>
                                        <input class="form-control" id="startDate" placeholder="Pick start date ">
                                    </div>
                                    <div class="col-lg-6 mb-4">
                                        <label class="form-label">Due <span class="text-danger">*</span></label>
                                        <input class="form-control" id="dueDate" placeholder="Pick due date">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Tags:</label>
                                    <select class="form-select form-control" data-select2-selector="tag" multiple>
                                        <option value="primary" data-bg="bg-primary">Team</option>
                                        <option value="teal" data-bg="bg-teal">Primary</option>
                                        <option value="success" data-bg="bg-success">Updates</option>
                                        <option value="warning" data-bg="bg-warning">Personal</option>
                                        <option value="danger" data-bg="bg-danger">Promotions</option>
                                        <option value="indigo" data-bg="bg-indigo">Customs</option>
                                    </select>
                                </div>
                                <div class="mb-0">
                                    <label class="form-label">Assignee:</label>
                                    <select class="form-select form-control" data-select2-selector="user" multiple>
                                        <option value="alex@outlook.com" data-user="1">alex@outlook.com</option>
                                        <option value="john.deo@outlook.com" data-user="2">john.deo@outlook.com</option>
                                        <option value="green.cutte@outlook.com" data-user="3">green.cutte@outlook.com
                                        </option>
                                        <option value="nancy.elliot@outlook.com" data-user="4">nancy.elliot@outlook.com
                                        </option>
                                        <option value="mar.audrey@gmail.com" data-user="5">mar.audrey@gmail.com</option>
                                        <option value="erna.serpa@outlook.com" data-user="6">erna.serpa@outlook.com
                                        </option>
                                        <option value="green.cutte@outlook.com" data-user="7">green.cutte@outlook.com
                                        </option>
                                        <option value="nancy.elliot@outlook.com" data-user="8">nancy.elliot@outlook.com
                                        </option>
                                        <option value="mar.audrey@gmail.com" data-user="9">mar.audrey@gmail.com</option>
                                        <option value="erna.serpa@outlook.com" data-user="10">erna.serpa@outlook.com
                                        </option>
                                        <option value="mar.audrey@gmail.com" data-user="11">mar.audrey@gmail.com</option>
                                        <option value="erna.serpa@outlook.com" data-user="12">erna.serpa@outlook.com
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
        <!-- [ Footer ] start -->
        <footer class="footer">
            <p class="fs-11 text-muted fw-medium text-uppercase mb-0 copyright">
                <span>Copyright ©</span>
                <script>
                    document.write(new Date().getFullYear());
                </script>
            </p>
            <p><span>By: <a target="_blank" href="https://wrapbootstrap.com/user/theme_ocean"
                        target="_blank">theme_ocean</a></span> • <span>Distributed by: <a target="_blank"
                        href="https://themewagon.com" target="_blank">ThemeWagon</a></span></p>
            <div class="d-flex align-items-center gap-4">
                <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Help</a>
                <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Terms</a>
                <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Privacy</a>
            </div>
        </footer>
        <!-- [ Footer ] end -->
    </main>
@endsection
