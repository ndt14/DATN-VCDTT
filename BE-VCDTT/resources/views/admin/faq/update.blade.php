@extends('admin.layouts.app')
@section('admin.layouts.content')
<div class="row">
        <div class="col-md-7">
        <h3 class="text-center">Cập nhật FAQ</h3>
                <form action="">
                <fieldset class="form-fieldset">
                <div class="mb-3">
                    <label class="form-label required">Câu hỏi</label>
                    <input type="text" class="form-control" autocomplete="off">
                </div>
                <div class="mb-3">
                    <label class="form-label required">Câu trả lời</label>
                    <input type="text" class="form-control" autocomplete="off">
                </div>
                <div class="mb-3 text-center">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
                
                </fieldset>
                </form>
        </div>

        <div class="col-md-5"></div>
</div>
@endsection