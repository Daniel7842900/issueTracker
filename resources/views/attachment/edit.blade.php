@extends('layouts.app')

@section('content')

<div class="container create-project">
    <div class="row">
        <div class="col-md-12">
            <h1>Edit Project</h1>
            <form action="{{ route('attachment.update', ['id' => $attachment->id]) }}" method="POST" enctype="multipart/form-data" id="edit-attachment-form">
                @csrf
                @method('PATCH')
                <div>
                    <p>Select an attachment</p>
                    <input name="attachment_img" type="file">
                </div>
                <hr>
                <label for="desc">Attachment description:</label>
                <input type="text" id="attachment_description" name="attachment_description" value="{{ $attachment->description }}" autocomplete="off" required data-parsley-pattern="[a-zA-Z0-9`~!@#$%^&*()-_+'={} ]+" minlength="5" maxlength="50" data-parsley-trigger="keyup">
                <input type="submit" value="Edit project">
            </form>
        </div>
    </div>
</div>

<script>

    $('#edit-attachment-form').parsley();

</script>

@endsection