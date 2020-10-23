<div class="col-md-12">
    <form action="{{ route('attachment.store', ['id' => $ticket->id]) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div>
            <input name="attachment_img" type="file">
        </div>
        <hr>
        <div>
            <p>Leave a description</p>
            <input type="text" id="attachment_description" name="attachment_description">
            <button type="submit" class="btn btn-primary">Submit</button>
            @error('attachment_description')
                <div><span style="color:red;">{{$message}}</span></div>
            @enderror
        </div>
    </form>
    
</div>