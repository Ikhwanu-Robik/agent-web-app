<h1>Admin Bus Schedule</h1>

@include("components.master.header")

<a href="/master/bus/schedules/create">
    <button>Create</button>
</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Bus Name</th>
        <th>From</th>
        <th>To</th>
        <th>Departure Date</th>
        <th>Departure Time</th>
        <th>Remaining Seats</th>
        <th>Ticket Price</th>
        <th>Date Created</th>
        <th>Date Updated</th>
        <th>Actions</th>
    </tr>
    @foreach ($busSchedules as $schedule)
        <tr>
            <td>{{ $schedule->id }}</td>
            <td>{{ $schedule->bus->name }}</td>
            <td>{{ $schedule->originStation->name }}</td>
            <td>{{ $schedule->destinationStation->name }}</td>
            <td>{{ $schedule->departure_date }}</td>
            <td>{{ $schedule->departure_time }}</td>
            <td>{{ $schedule->seats }}</td>
            <td>{{ $schedule->ticket_price }}</td>
            <td>{{ $schedule->created_at }}</td>
            <td>{{ $schedule->updated_at }}</td>
            <td><a href="{{ '/master/bus/schedules/edit/' . $schedule->id }}"><button>Update</button></a><a
                    href="{{ '/master/bus/schedules/delete/' . $schedule->id }}"><button>Delete</button></a></td>
        </tr>
    @endforeach
</table>