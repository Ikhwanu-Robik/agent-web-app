<h1>Add New Power Voltage</h1>

@include('components.master.header')

@foreach ($errors->all() as $error)
    {{ $error }} <br />
@endforeach

<form action="/master/power/voltages/create" method="post">
    @csrf
    <label for="volts">Volts</label>
    <input type="number" name="volts" id="volts">
    <label for="price_per_kWh">price_per_kWh</label>
    <input type="number" name="price_per_kWh" id="price_per_kWh">

    <button type="submit">Add</button>
</form>
