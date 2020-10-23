<p>Add a comment</p>
<form action="{{ route('comment.store', ['id' => $ticket->id]) }}" method="POST">
    @csrf
    <input type="text" id="comment_message" name="comment_message">
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
