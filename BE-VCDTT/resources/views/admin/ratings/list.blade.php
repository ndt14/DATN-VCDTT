@extends('admin.common.layout')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Ratings management for: <a href="javascript: viewDetailT({{ $data->tour->id}});" title="Show Detail">{{ $data->tour->name}}</a>
                    </h2>
                </div>
                <!-- <div class="col-12 ">
                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" id="notiSuccess">
                            {{ Session::get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (Session::has('fail'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" id="notiError">
                            {{ Session::get('fail') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div> -->
                <div class="col-auto ms-auto d-print-none">
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Overall rating:
                                @php
                                $star = 0;
                                $count = $data->ratings;
                                foreach ($count as $c) {
                                    $star += $c->star;
                                }
                                @endphp
                                {{ $star }} <i class="fa-solid fa-star" style="color: #fffa75;"></i>
                        </div>
                        <div class="card-body border-bottom py-3">
                            <div class="d-flex">
                                <!--<div class="text-muted">
                                    Show
                                    <div class="mx-2 d-inline-block">
                                        <input type="text" class="form-control form-control-sm" value="8" size="3" aria-label="Invoices count">
                                    </div>
                                    entries
                                </div>-->
                                <div class="ms-auto text-muted">
                                    <form method="get" action="" class="row gy-2 gx-3 align-items-center">
                                        <div class="col-auto">
                                            <label class="visually-hidden" for="autoSizingSelect">Status</label>
                                            <select class="form-select" name="lang_code">
                                                <option value="">Select status...</option>
                                                <option value="ja">Active</option>
                                                <option value="en">Unactive</option>
                                            </select>
                                        </div>
                                        <div class="col-auto">
                                            <label class="visually-hidden" for="autoSizingInput">Keyword</label>
                                            <input type="text" name="keyword" value="keyword" class="form-control"
                                                placeholder="Keyword">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="table table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-1">ID</th>
                                        <th>User name</th>
                                        <th>Star gave</th>
                                        <th>Rating content</th>
                                        <th>Our answer</th>
                                        <th>Created at</th>
                                        <th>Updated at</th>
                                        <th></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data->ratings)
                                        @foreach ($data->ratings as $data)
                                            <tr>
                                                <td><span class="text-muted">{{ $data->id }}</span></td>
                                                <td>
                                                    <a href="javascript: viewDetailU({{$data->id}});" title="Show Detail">{{ $data->user_name }}</a>
                                                </td>
                                                <td>
                                                    {{ $data->star }}
                                                    <i class="fa-solid fa-star" style="color: #fffa75;"></i>
                                                </td>
                                                <td>
                                                <a href="javascript: viewDetail({{$data->id}});" title="Show Detail">{{ string_truncate($data->content, 70) }}</a>
                                                </td>
                                                <td>
                                                    {{ $data->admin_answer??'Null' }}
                                                </td>
                                                <td>
                                                    {{ time_format($data->created_at) }}
                                                </td>
                                                <td>
                                                    {{ time_format($data->updated_at) }}
                                                </td>
                                                <td class="text-end">
                                                    <span class="dropdown">
                                                        <button class="btn dropdown-toggle align-text-top"
                                                            data-bs-boundary="viewport"
                                                            data-bs-toggle="dropdown">Actions</button>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item" href="{{ route('rating.edit', ['id' => $data->id]) }}">Answer</a>
                                                            <a class="dropdown-item" href="javascript: removeItem({{ $data->id}})">Remove</a>
                                                        </div>
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9">
                                                <div>No data</div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center">
                            <select id="rpp" class="form-select me-2" style="max-width: 75px;">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="250">250</option>
                                <option value="500">500</option>
                            </select>

                            <p class="m-0 text-secondary">Hiển thị <span>1</span> trên <span>1</span> của <span>16</span>
                                bản ghi</p>
                            <ul class="pagination m-0 ms-auto">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M15 6l-6 6l6 6"></path>
                                        </svg>prev</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">4</a></li>
                                <li class="page-item"><a class="page-link" href="#">5</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M9 6l6 6l-6 6"></path>
                                        </svg>
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modalContainer" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>
@endSection
@section('page_js')
    <script type="text/javascript">
        let modalContainer;
        $(document).ready(function() {
            modalContainer = new bootstrap.Modal('#modalContainer', {
                keyboard: true,
                backdrop: 'static'
            });
        });

        let viewDetail = function(id) {
        axios.get(`/rating/detail/${id}`)
            .then(function(response) {
                $('#modalContainer div.modal-content').html(response.data.html);
                modalContainer.show();
            })
            .catch(function(error) {
                bs5Utils.Snack.show('danger', 'Error', delay = 5000, dismissible = true);
            })
            .finally(function() {
            });
        };

        let viewDetailT = function(id) {
        axios.get(`/tour/detail/${id}`)
            .then(function(response) {
                $('#modalContainer div.modal-content').html(response.data.html);
                modalContainer.show();
            })
            .catch(function(error) {
                bs5Utils.Snack.show('danger', 'Error', delay = 5000, dismissible = true);
            })
            .finally(function() {
            });
        };
        let viewDetailU = function(id) {
        axios.get(`/user/detail/${id}`)
            .then(function(response) {
                $('#modalContainer div.modal-content').html(response.data.html);
                modalContainer.show();
            })
            .catch(function(error) {
                bs5Utils.Snack.show('danger', 'Error', delay = 5000, dismissible = true);
            })
            .finally(function() {
            });
        };


        let removeItem = function(id) {
        $.confirm({
            theme: theme,
            title: 'Confirm',
            content: 'Are you sure to remove?',
            columnClass: 'col-md-3 col-sm-6',
            buttons: {
                removeButton: {
                    text: 'Yes',
                    btnClass: 'btn-danger',
                    action: function() {
                        axios.delete(`/api/rating-destroy/${id}`).then(function(response) {
                            bs5Utils.Snack.show('success', 'Success', delay = 5000, dismissible = true);
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        });
                    }
                },
                close: function() {}
            }
        });
    };
    </script>
@endSection
