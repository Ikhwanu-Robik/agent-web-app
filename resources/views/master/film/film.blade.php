<h1>Master Film</h1>

@include('components.master.header')

<a href="/master/films/create">
    <button>Create</button>
</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Poster</th>
        <th>Release date</th>
        <th>Duration</th>
        <th>Created at</th>
        <th>Updated at</th>
        <th>Actions</th>
    </tr>
    @foreach ($films as $film)
        <tr>
            <td>{{ $film->id }}</td>
            <td>{{ $film->title }}</td>
            <td><img src="{{ asset($film->poster_image_url) }}" width="150em"></td>
            <td>{{ $film->release_date }}</td>
            <td>{{ $film->duration }} minutes</td>
            <td>{{ $film->created_at }}</td>
            <td>{{ $film->updated_at }}</td>
            <td><a href="{{ '/master/films/edit/' . $film->id }}"><button>Update</button></a><a
                    href="{{ '/master/films/delete/' . $film->id }}"><button>Delete</button></a></td>
        </tr>
    @endforeach
</table>
