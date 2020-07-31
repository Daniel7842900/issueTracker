<div class="row">
    <div class="col-md-12">
        <div class="content">
            @include('comment.create', [$ticket->id])
        </div>
    </div>
</div>
<hr>
<div class="row">
    <table>
        <div>
            <tr>
                <th>Commenter</th>
                <th>Message</th>
                <th>Created Date</th>
            </tr>
        </div>
        <div>
            @foreach($comments as $comment)
            <tr>
                <td>{{ $comment->name }}</td>
                <td>{{ $comment->description }}</td>
                <td>{{ $comment->created_at }}</td>
            </tr>
            @endforeach
        </div>
    </table>
</div>


