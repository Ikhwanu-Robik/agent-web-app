<h1>Add New Power Voltage</h1>

@include('components.master.header')

@foreach ($errors->all() as $error)
    {{ $error }} <br />
@endforeach

<form action="/master/power/voltages/create" method="post">
    @csrf
    <label for="volts">Volts</label>
    <input type="number" name="volts" id="volts">
    <label for="monthly_price">Monthly Price</label>
    <input type="number" name="monthly_price" id="monthly_price">

    <button type="submit">Add</button>
</form>
