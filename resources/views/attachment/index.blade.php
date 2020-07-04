<div class="row">
    <div class="col-md-6">
        <p>Ticket Attachment</p>
    </div>
</div>
<hr>
<div class="row">
    @include('attachment.create', [$ticket->id])
</div>
<div class="row">
    <div class="col-md-6">
        <label for="">Ticket Attachments</label>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12">
        <table>
            <div>
                <tr>
                    <th>Uploader</th>
                    <th>Notes</th>
                    <th>Uploaded Date</th>
                </tr>
            </div>
            <div>
                @foreach($attachments as $attachment)
                <tr>
                    <td>{{ $attachment->name }}</td>
                    <td>{{ $attachment->description }}</td>
                    <td>{{ $attachment->created_at }}</td>
                    <td><button><a href="{{ route('attachment.show', [$attachment->id]) }}">Details</a></button></td>
                </tr>
                @endforeach
            </div>
        </table>
    </div>
    
</div>
