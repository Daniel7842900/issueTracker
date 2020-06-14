<div class="row">
    <div class="col-md-6">
        <div class="content">
            @include('comment.create', [$ticket->id])
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <label for="">Ticket Comments</label>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-6">
        <span>Commenter</span>
        <span>Message</span>
        <span>Created Date</span>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-6">
        @foreach($comments as $comment)
        <span>{{ $comment->name }}</span>
        <span>{{ $comment->description }}</span>
        <span>{{ $comment->created_at }}</span>
        @endforeach
    </div>
</div>