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
        <div class="row">
            <tr>
                <div class="col-md-6">
                    <th>Commenter</th>
                    <th>Message</th>
                    <th>Created Date</th>
                </div>
            </tr>
        </div>
        <div class="row">
            @foreach($comments as $comment)
            <tr>
                <div class="col-md-6">
                    <td>{{ $comment->name }}</td>
                    <td>{{ $comment->description }}</td>
                    <td>{{ $comment->created_at }}</td>
                </div>
            </tr>
            @endforeach
        </div>
    </table>
</div>


