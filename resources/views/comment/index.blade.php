<div class="row">
    <div class="col-md-12">
        <div class="content">
            @include('comment.create', [$ticket->id])
        </div>
    </div>
</div>
<hr>
<div class="row">
    <table id="ticket-comment-table" class="table-striped table-bordered compact">
        <thead>
            <tr>
                <th>Commenter</th>
                <th>Message</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($comments as $comment)
            <tr>
                <td>{{ $comment->name }}</td>
                <td>{{ $comment->description }}</td>
                <td>{{ date('n-j-Y g:i A', strtotime($comment->created_at)) }}</td>
            </tr>
            
            @endforeach
        </tbody>
    </table>
</div>

<script>
    $('#ticket-comment-table').DataTable({
        "lengthMenu": [[5], [5]],
        "columns": [
            {"width": "33%"},
            {"width": "33%"},
            {"width": "33%"}
        ]
    });
</script>
