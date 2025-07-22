<h1>Edit Power Voltage</h1>

@include("components.master.header")

@foreach ($errors->all() as $error)
    {{ $error }} <br />
@endforeach

<form action="{{ '/master/power/voltages/edit/' . $power_voltage->id }}" method="post">
    @csrf
    @method('PUT')
    <label for="volts">Volts</label>
    <input type="number" name="volts" id="volts" value="{{ $power_voltage->volts }}">
    <label for="price_per_kWh">price_per_kWh</label>
    <input type="number" name="price_per_kWh" id="price_per_kWh" value="{{ $power_voltage->price_per_kWh }}">

    <button type="submit">Save</button>
</form>
