<div class="row">
    @include('attachment.create', [$ticket->id])
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
                    
                    @if(auth()->user()->role_id == 1)
                    <td>
                        <form action="{{ route('attachment.destroy', [$attachment->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Are you sure?')" >Delete</button>
                        </form>
                    </td>
                    @elseif(auth()->user()->id == $attachment->attachment_commenter_id)
                    <td>
                        <form action="{{ route('attachment.destroy', [$attachment->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Are you sure?')" >Delete</button>
                        </form>
                    </td>
                    @else

                    @endif
                </tr>
                @endforeach
            </div>
        </table>
    </div>
    
</div>
