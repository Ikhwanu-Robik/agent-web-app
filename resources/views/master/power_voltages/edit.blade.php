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
    <label for="monthly_price">Monthly Price</label>
    <input type="number" name="monthly_price" id="monthly_price" value="{{ $power_voltage->monthly_price }}">

    <button type="submit">Save</button>
</form>
