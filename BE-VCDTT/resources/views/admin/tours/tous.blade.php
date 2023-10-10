@extend('admin.common.layout')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Tours management
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="/admin/cms/posts/add" class="btn btn-primary d-none d-sm-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Add new
                    </a>
                    <a href="/admin/cms/posts/add" class="btn btn-primary d-sm-none btn-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                    </a>
                </div>
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
                        <h3 class="card-title">Tour</h3>
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
                                        <label class="visually-hidden" for="autoSizingSelect">Language</label>
                                        <select class="form-select" name="lang_code">
                                            <option value="">Select language...</option>
                                            <option value="ja">Japanese</option>
                                            <option value="en">English</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <label class="visually-hidden" for="autoSizingInput">Keyword</label>
                                        <input type="text" name="keyword" value="keyword" class="form-control" placeholder="Keyword">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable">
                            <thead>
                                <tr>
                                    <th class="w-1">ID</th>
                                    <th>Language</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Feature</th>
                                    <th>Created</th>
                                    <th>Updated</th>
                                    <th class="text-center">Active</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($items) : ?>
                                    <?php foreach ($items as $item) : ?>
                                        <tr>
                                            <td><span class="text-muted"><?php echo $item->id; ?></span></td>
                                            <td>
                                                <?php echo $item->lang_code; ?>
                                            </td>
                                            <td class="text-wrap text-break">
                                                <a href="javascript: viewItem(<?php echo $item->id; ?>);"><?php echo $item->title; ?></a>
                                            </td>
                                            <td class="text-wrap text-break">
                                                <?php if ($item->lang_code == 'en') : ?>
                                                    <?php echo word_limiter(strip_tags($item->description), 6); ?>
                                                <?php else : ?>
                                                    <?php echo mb_substr($item->description, 0, 10) . "..."; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php echo ($item->feature_post == '0') ? 'Default' : 'Hot Post'; ?>
                                            </td>
                                            <td>
                                                <?php echo $item->created_at; ?>
                                            </td>
                                            <td>
                                                <?php echo $item->updated_at; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($item->active == 0) : ?>
                                                    <span class="badge bg-muted" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Not active"></span>
                                                <?php elseif ($item->active == 1) : ?>
                                                    <span class="badge bg-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Activated"></span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-end">
                                                <span class="dropdown">
                                                    <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="/admin/cms/posts/edit/<?php echo $item->id; ?>">Edit</a>
                                                        <a class="dropdown-item" href="javascript: removeItem(<?php echo $item->id; ?>);">Remove</a>
                                                    </div>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="9">
                                            <div>No data</div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer d-flex align-items-center">
                        <select id="rpp" class="form-select me-2" style="max-width: 75px;">
                            <option value="10" >10</option>
                            <option value="20" >20</option>
                            <option value="50" >50</option>
                            <option value="100">100</option>
                            <option value="250">250</option>
                            <option value="500">500</option>
                        </select>
                        <!-- phân trang ở đây -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="modalContainer" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content"></div>
    </div>
</div>

<script type="text/javascript">
    let modalContainer;
    $(document).ready(function() {
        modalContainer = new bootstrap.Modal('#modalContainer', {
            keyboard: true,
            backdrop: 'static'
        });

        if ($('#frmAdd').length) {
            $('#frmAdd').submit(function() {
                let options = {
                    beforeSubmit: function(formData, jqForm, options) {
                        $('#btnSubmitAdd').addClass('btn-loading');
                        $('#btnSubmitAdd').addClass("disabled");
                    },
                    success: function(response, statusText, xhr, $form) {
                        $('#btnSubmitAdd').removeClass('btn-loading');
                        $('#btnSubmitAdd').removeClass("disabled");
                        bs5Utils.Snack.show('success', 'Success', delay = 5000, dismissible = true);
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                        modalContainer.hide();
                    },
                    error: function() {
                        $('#btnSubmitAdd').removeClass('btn-loading');
                        $('#btnSubmitAdd').removeClass("disabled");
                        bs5Utils.Snack.show('danger', 'Error', delay = 5000, dismissible = true);
                    },
                    dataType: 'json',
                    clearForm: false,
                    resetForm: false
                };
                $(this).ajaxSubmit(options);
                return false;
            });
        }
    });

    let viewItem = function(id) {
        axios.get(`/admin/cms/posts/view/${id}`)
            .then(function(response) {
                // console.log(response);
                $('#modalContainer div.modal-content').html(response.data.html);
                modalContainer.show();
            })
            .catch(function(error) {
                bs5Utils.Snack.show('danger', 'Error', delay = 5000, dismissible = true);
            })
            .finally(function() {
                // always executed
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
                        let postData = new FormData();
                        postData.append('id', id);
                        axios.post(`/admin/cms/posts/remove`, postData).then(function(response) {
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