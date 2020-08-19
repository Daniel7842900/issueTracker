<div class="row">
    @include('attachment.create', [$ticket->id])
</div>
<hr>
<div class="row">
    <div class="col-md-12">
        <table id="ticket-attachment-table" class="table-striped table-bordered compact">
            <thead>
                <tr>
                    <th>Uploader</th>
                    <th>Notes</th>
                    <th>Uploaded Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($attachments as $attachment)
                    <tr>
                        <td>{{ $attachment->name }}</td>
                        <td>{{ $attachment->description }}</td>
                        <td>{{ $attachment->created_at }}</td>
                        <td class="function-buttons">
                            <button><a href="{{ route('attachment.show', [$attachment->id]) }}">Details</a></button>
                            @if(auth()->user()->role_id == 1)
                                <form action="{{ route('attachment.destroy', [$attachment->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Are you sure?')" >Delete</button>
                                </form>
                            @elseif(auth()->user()->id == $attachment->attachment_commenter_id)
                                <form action="{{ route('attachment.destroy', [$attachment->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Are you sure?')" >Delete</button>
                                </form>
                            @else
                                <button disabled>Delete</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>

    $('#ticket-attachment-table').DataTable({
        "lengthMenu": [[2], [2]],
        "columns": [
            {"width": "25%"},
            {"width": "25%"},
            {"width": "25%"},
            {"width": "25%"}
        ]
    });

</script>
