<div class="col-md-12">
    <form action="{{ route('attachment.store', ['id' => $ticket->id]) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div>
            <p>Select an attachment</p>
            <input name="attachment_img" type="file">
        </div>
        <hr>
        <div>
            <p>Leave a description</p>
            <input type="text" id="attachment_description" name="attachment_description">
            <input type="submit">
        </div>
    </form>
    
</div>