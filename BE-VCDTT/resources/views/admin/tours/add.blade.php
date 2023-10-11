<div class="modal-header">
    <h1 class="modal-title fs-4" id="exampleModalFullscreenMdLabel">Tour Add</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form id="frmAdd" class="card" action="" method="post">
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" placeholder="Title" value="" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="text" name="image" class="form-control" placeholder="Image" value="">
            <small>You can upload and copy image url from Files management</small>
        </div>
        <div class="mb-3">
            <div class="form-label">Description</div>
            <textarea name="description" rows="6" class="form-control" placeholder="Description" required></textarea>
        </div>
        <div class="mb-3">
            <div class="form-label">Feature</div>
            <select name="feature_post" id="" class="form-select">
                <option value="">Choose post feature</option>
                <option value="0">Default</option>
                <option value="1">Hot post</option>
            </select>
        </div>
        <div class="row">
            <div class="mb-3 ">
                <div class="form-label">Choose Category</div>
                <select name="category" id="" class="form-select">
                    <option value="">Choose post category</option>

                        <option value="">category</option>
                </select>
            </div>
        </div>
        <div class="mb-3">
            <div class="form-label">Content</div>
            <textarea id="editor" rows="6" class="form-control text-editor" placeholder="Content" required></textarea>
        </div>
        <div class="mb-3">
            <div class="form-label">Active</div>
            <div class="custom-controls-stacked">
                <label class="custom-control custom-radio custom-control-inline me-2">
                    <input type="radio" class="custom-control-input" name="active" checked="" value="1" required>
                    <span class="custom-control-label">Yes</span>
                </label>
                <label class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" name="active" value="0" required>
                    <span class="custom-control-label">No</span>
                </label>
            </div>
        </div>
    </div>

</form>
<div class="modal-footer text-right">
        <button id="btnSubmitAdd" type="submit" class="btn btn-primary">Submit</button>
</div>