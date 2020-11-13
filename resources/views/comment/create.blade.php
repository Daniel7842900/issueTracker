<p>Add a comment</p>
<form action="{{ route('comment.store', ['id' => $ticket->id]) }}" method="POST" id="create-comment-form">
    @csrf
    <input type="text" id="comment_message" name="comment_message" autocomplete="off" required data-parsley-pattern="[a-zA-Z0-9`~!@#$%^&*()-_+'={} ]+" minlength="5" maxlength="50" data-parsley-trigger="keyup">
    <button type="submit" class="btn btn-primary">Submit</button>
    @error('comment_message')
        <div><span style="color:red;">{{$message}}</span></div>
    @enderror
</form>
